<?php

namespace App\Http\Controllers;

use App\Mail\AssessmentStatusChanged;
use App\Models\Assessment;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuditorController extends Controller
{
    /**
     * Auditor dashboard - show assessments ready for verification
     */
    public function index()
    {
        // Get assessments that are completed and waiting for verification
        $pendingVerification = Assessment::with(['user', 'cobitItems'])
            ->where('status', Assessment::STATUS_COMPLETED)
            ->orderBy('completed_at', 'asc')
            ->paginate(10, ['*'], 'pending');

        // Get recently verified assessments
        $verified = Assessment::with(['user', 'cobitItems', 'verifier'])
            ->where('status', Assessment::STATUS_VERIFIED)
            ->where('verified_by', Auth::id())
            ->orderBy('verified_at', 'desc')
            ->take(5)
            ->get();

        // Stats
        $stats = [
            'pending' => Assessment::where('status', Assessment::STATUS_COMPLETED)->count(),
            'verified_today' => Assessment::where('status', Assessment::STATUS_VERIFIED)
                ->where('verified_by', Auth::id())
                ->whereDate('verified_at', today())
                ->count(),
            'verified_total' => Assessment::where('status', Assessment::STATUS_VERIFIED)
                ->where('verified_by', Auth::id())
                ->count(),
        ];

        return view('auditor.index', compact('pendingVerification', 'verified', 'stats'));
    }

    /**
     * Show assessment details for verification
     */
    public function show(Assessment $assessment)
    {
        if (!in_array($assessment->status, [Assessment::STATUS_COMPLETED, Assessment::STATUS_VERIFIED])) {
            return back()->with('error', 'Assessment ini belum siap untuk diverifikasi.');
        }

        $assessment->load([
            'user',
            'cobitItems.kategoris.levels.quisioners',
            'items',
            'jawabans.quisioner',
            'jawabans.level',
            'jawabans.verifier',
        ]);

        // Group jawabans by CobitItem -> Kategori -> Level
        $groupedJawabans = [];
        foreach ($assessment->cobitItems as $cobitItem) {
            $groupedJawabans[$cobitItem->id] = [
                'cobitItem' => $cobitItem,
                'kategoris' => [],
            ];

            foreach ($cobitItem->kategoris as $kategori) {
                $groupedJawabans[$cobitItem->id]['kategoris'][$kategori->id] = [
                    'kategori' => $kategori,
                    'levels' => [],
                ];

                foreach ($kategori->levels as $level) {
                    $levelJawabans = $assessment->jawabans
                        ->where('level_id', $level->id);

                    $groupedJawabans[$cobitItem->id]['kategoris'][$kategori->id]['levels'][$level->id] = [
                        'level' => $level,
                        'jawabans' => $levelJawabans,
                    ];
                }
            }
        }

        // Verification stats
        $verificationStats = [
            'total' => $assessment->jawabans->count(),
            'verified' => $assessment->jawabans->where('verification_status', Jawaban::VERIFICATION_VERIFIED)->count(),
            'pending' => $assessment->jawabans->where('verification_status', Jawaban::VERIFICATION_PENDING)->count(),
            'needs_revision' => $assessment->jawabans->where('verification_status', Jawaban::VERIFICATION_NEEDS_REVISION)->count(),
        ];

        return view('auditor.show', compact('assessment', 'groupedJawabans', 'verificationStats'));
    }

    /**
     * Verify a single jawaban
     */
    public function verify(Request $request, Jawaban $jawaban)
    {
        $request->validate([
            'verification_status' => 'required|in:verified,needs_revision',
            'auditor_notes' => 'nullable|string|max:1000',
        ]);

        $jawaban->update([
            'verification_status' => $request->verification_status,
            'auditor_notes' => $request->auditor_notes,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Jawaban berhasil diverifikasi.');
    }

    /**
     * Bulk verify multiple jawabans
     */
    public function bulkVerify(Request $request, Assessment $assessment)
    {
        $request->validate([
            'jawaban_ids' => 'required|array',
            'jawaban_ids.*' => 'exists:jawabans,id',
            'verification_status' => 'required|in:verified,needs_revision',
            'auditor_notes' => 'nullable|string|max:1000',
        ]);

        Jawaban::whereIn('id', $request->jawaban_ids)
            ->where('assessment_id', $assessment->id)
            ->update([
                'verification_status' => $request->verification_status,
                'auditor_notes' => $request->auditor_notes,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

        return back()->with('success', count($request->jawaban_ids) . ' jawaban berhasil diverifikasi.');
    }

    /**
     * Mark entire assessment as verified
     */
    public function markComplete(Request $request, Assessment $assessment)
    {
        if ($assessment->status !== Assessment::STATUS_COMPLETED) {
            return back()->with('error', 'Assessment ini tidak dalam status menunggu verifikasi.');
        }

        // Check if there are any pending verifications
        $pendingCount = $assessment->jawabans()
            ->where('verification_status', Jawaban::VERIFICATION_PENDING)
            ->count();

        if ($pendingCount > 0) {
            return back()->with('error', "Masih ada {$pendingCount} jawaban yang belum diverifikasi.");
        }

        // Check if there are any needing revision
        $revisionCount = $assessment->jawabans()
            ->where('verification_status', Jawaban::VERIFICATION_NEEDS_REVISION)
            ->count();

        if ($revisionCount > 0) {
            return back()->with('warning', "Ada {$revisionCount} jawaban yang perlu direvisi oleh user.");
        }

        $previousStatus = $assessment->status;

        $assessment->update([
            'status' => Assessment::STATUS_VERIFIED,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        // Send email notification to user
        try {
            Mail::to($assessment->user->email)->send(new AssessmentStatusChanged($assessment, $previousStatus));
        } catch (\Exception $e) {
            \Log::error('Failed to send assessment verification email: ' . $e->getMessage());
        }

        return redirect()->route('auditor.dashboard')
            ->with('success', 'Assessment berhasil diverifikasi sepenuhnya!');
    }

    /**
     * View evidence file/link
     */
    public function viewEvidence(Jawaban $jawaban)
    {
        if (!$jawaban->hasEvidence()) {
            return back()->with('error', 'Tidak ada bukti untuk jawaban ini.');
        }

        if ($jawaban->evidence_type === Jawaban::EVIDENCE_TYPE_LINK) {
            return redirect()->away($jawaban->evidence_path);
        }

        // For file type, return file download
        if (Storage::disk('public')->exists($jawaban->evidence_path)) {
            return Storage::disk('public')->download(
                $jawaban->evidence_path,
                $jawaban->evidence_original_name
            );
        }

        return back()->with('error', 'File bukti tidak ditemukan.');
    }
}
