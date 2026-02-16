<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Jawaban;
use App\Models\JawabanDraft;
use App\Models\Kategori;
use App\Models\CobitItem;
use Illuminate\Http\Request;
use App\Models\ResubmissionRequest;
use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    public function index(Assessment $assessment)
    {
        return redirect()->route('user.assessments.show', $assessment);
    }

    public function showCategories(Assessment $assessment, CobitItem $cobitItem)
    {
        // Mengambil kategori berdasarkan cobit_item_id
        $kategoris = Kategori::where('cobit_item_id', $cobitItem->id)->get();
        return view('audit.categories', compact('kategoris', 'cobitItem', 'assessment'));
    }

    public function showLevels(Assessment $assessment, CobitItem $cobitItem, Kategori $kategori)
    {
        $userId = Auth::id();
        $levels = Level::where('kategori_id', $kategori->id)
            ->orderBy('level_number', 'asc')
            ->get();

        // Ambil semua jawaban untuk assessment ini untuk optimasi
        $answers = Jawaban::where('user_id', $userId)
            ->where('assessment_id', $assessment->id)
            ->get()
            ->groupBy('level_id');

        // Ambil semua request pengajuan ulang
        $requests = ResubmissionRequest::where('user_id', $userId)
            ->whereIn('level_id', $levels->pluck('id'))
            ->whereIn('status', ['pending', 'approved'])
            ->get()
            ->groupBy('level_id');

        $prevLevelHasF = true; // Level 1 selalu terbuka
        foreach ($levels as $level) {
            $levelAnswers = $answers->get($level->id, collect());
            $levelRequests = $requests->get($level->id, collect());

            // Cek apakah user sudah isi jawaban apapun
            $hasAnyAnswer = $levelAnswers->isNotEmpty();

            // Cek apakah jawaban user mengandung "F"
            $hasFAnswer = $levelAnswers->contains('jawaban', 'F');

            // Cek apakah ada jawaban yang butuh revisi
            $needsRevision = $levelAnswers->contains('verification_status', 'needs_revision');

            $activeRequest = $levelRequests->first();
            $isApprovedForResubmission = optional($activeRequest)->status === 'approved';

            // Set flags untuk view
            $level->hasAnswers = $hasAnyAnswer;
            $level->hasFAnswer = $hasFAnswer;
            $level->needsRevision = $needsRevision;
            $level->isApprovedForResubmission = $isApprovedForResubmission;
            $level->pendingRequest = optional($activeRequest)->status === 'pending';
            $level->canRequestResubmission = $hasAnyAnswer && !$activeRequest && !$needsRevision;
            
            // Level terbuka jika: ini level 1, atau level sebelumnya sukses (F), atau sudah disetujui isi ulang, atau butuh revisi
            $level->isUnlocked = $prevLevelHasF || $isApprovedForResubmission || $needsRevision;

            // Flag untuk level berikutnya
            $prevLevelHasF = $hasFAnswer || $isApprovedForResubmission;
        }

        return view('audit.levels', [
            'cobitItem' => $cobitItem,
            'kategori' => $kategori,
            'levels' => $levels,
            'assessment' => $assessment,
        ]);
    }

    public function showQuisioner(Assessment $assessment, CobitItem $cobitItem, Kategori $kategori, Level $level)
    {
        $userId = Auth::id();
        $hasAnswers = Jawaban::where('user_id', $userId)
            ->where('assessment_id', $assessment->id)
            ->where('level_id', $level->id)
            ->exists();

        if ($hasAnswers) {
            $approvedRequest = ResubmissionRequest::where('user_id', $userId)
                ->where('level_id', $level->id)
                ->where('status', 'approved')
                ->exists();

            $needsRevision = Jawaban::where('user_id', $userId)
                ->where('assessment_id', $assessment->id)
                ->where('level_id', $level->id)
                ->where('verification_status', 'needs_revision')
                ->exists();

            if (!$approvedRequest && !$needsRevision) {
                return redirect()->route('audit.showLevels', ['assessment' => $assessment->id, 'cobitItem' => $cobitItem->id, 'kategori' => $kategori->id])
                    ->with('error', 'Anda sudah mengisi kuesioner untuk level ini. Ajukan pengisian ulang jika ingin mengubah.');
            }
        }

        $quisioners = $level->quisioners()->get();

        // Load existing draft if any
        $draft = JawabanDraft::where('user_id', $userId)
            ->where('assessment_id', $assessment->id)
            ->where('level_id', $level->id)
            ->first();
        $draftAnswers = $draft ? $draft->answers : [];

        // Load existing submitted answers
        $existingAnswers = Jawaban::where('user_id', $userId)
            ->where('assessment_id', $assessment->id)
            ->where('level_id', $level->id)
            ->get()
            ->keyBy('quisioner_id');

        return view('audit.quisioner', [
            'cobitItem' => $cobitItem,
            'kategori' => $kategori,
            'level' => $level,
            'quisioners' => $quisioners,
            'draftAnswers' => $draftAnswers,
            'existingAnswers' => $existingAnswers,
            'assessment' => $assessment,
        ]);
    }
}
