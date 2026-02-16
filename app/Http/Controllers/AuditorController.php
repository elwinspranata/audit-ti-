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
        $auditorId = Auth::id();

        // Get assessments that are completed, and either unassigned or assigned to this auditor
        $pendingVerification = Assessment::with(['user', 'cobitItems', 'auditReport'])
            ->where('status', Assessment::STATUS_COMPLETED)
            ->where(function($query) use ($auditorId) {
                $query->where('assigned_auditor_id', $auditorId)
                      ->orWhereNull('assigned_auditor_id');
            })
            ->orderByRaw('COALESCE(assigned_at, created_at) DESC')
            ->paginate(10, ['*'], 'pending');

        // Get recently verified assessments by this auditor
        $verified = Assessment::with(['user', 'cobitItems', 'verifier', 'auditReport'])
            ->where('status', Assessment::STATUS_VERIFIED)
            ->where('verified_by', $auditorId)
            ->orderBy('verified_at', 'desc')
            ->take(5)
            ->get();

        // Stats - unassigned completed or those assigned to this auditor
        $stats = [
            'pending' => Assessment::where('status', Assessment::STATUS_COMPLETED)
                ->where(function($query) use ($auditorId) {
                    $query->where('assigned_auditor_id', $auditorId)
                          ->orWhereNull('assigned_auditor_id');
                })
                ->count(),
            'verified_today' => Assessment::where('status', Assessment::STATUS_VERIFIED)
                ->where('verified_by', $auditorId)
                ->whereDate('verified_at', today())
                ->count(),
            'verified_total' => Assessment::where('status', Assessment::STATUS_VERIFIED)
                ->where('verified_by', $auditorId)
                ->count(),
        ];

        return view('auditor.index', compact('pendingVerification', 'verified', 'stats'));
    }

    /**
     * Show assessment details for verification
     */
    public function show(Assessment $assessment)
    {
        // Auto-assign if unassigned and someone tries to verify it
        if ($assessment->status === Assessment::STATUS_COMPLETED && is_null($assessment->assigned_auditor_id)) {
            $assessment->update([
                'assigned_auditor_id' => Auth::id(),
                'assigned_at' => now(),
            ]);
        }

        // Verify this auditor is assigned to this assessment
        if ($assessment->assigned_auditor_id !== Auth::id()) {
            return redirect()->route('auditor.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke assessment ini.');
        }

        if (!in_array($assessment->status, [Assessment::STATUS_COMPLETED, Assessment::STATUS_VERIFIED])) {
            return back()->with('error', 'Assessment ini belum siap untuk diverifikasi.');
        }

        $assessment->load([
            'user',
            'cobitItems.kategoris.levels.quisioners',
            'jawabans.quisioner.level.kategori.cobitItem',
            'jawabans.level',
            'jawabans.verifier',
            'auditReport',
        ]);

        // Verification stats
        $verificationStats = [
            'total' => $assessment->jawabans->count(),
            'verified' => $assessment->jawabans->where('verification_status', 'verified')->count(),
            'pending' => $assessment->jawabans->where('verification_status', 'pending')->count(),
            'needs_revision' => $assessment->jawabans->where('verification_status', 'needs_revision')->count(),
        ];

        // Group jawabans by CobitItem -> Kategori -> Level
        $groupedJawabans = [];
        foreach ($assessment->jawabans as $jawaban) {
            $quisioner = $jawaban->quisioner;
            if (!$quisioner) continue;
            
            $level = $quisioner->level;
            $kategori = $level->kategori;
            $cobitItem = $kategori->cobitItem;

            $cobitId = $cobitItem->id;
            $kategoriId = $kategori->id;
            $levelId = $level->id;

            if (!isset($groupedJawabans[$cobitId])) {
                $groupedJawabans[$cobitId] = [
                    'cobitItem' => $cobitItem,
                    'kategoris' => []
                ];
            }

            if (!isset($groupedJawabans[$cobitId]['kategoris'][$kategoriId])) {
                $groupedJawabans[$cobitId]['kategoris'][$kategoriId] = [
                    'kategori' => $kategori,
                    'levels' => []
                ];
            }

            if (!isset($groupedJawabans[$cobitId]['kategoris'][$kategoriId]['levels'][$levelId])) {
                $groupedJawabans[$cobitId]['kategoris'][$kategoriId]['levels'][$levelId] = [
                    'level' => $level,
                    'jawabans' => collect()
                ];
            }

            $groupedJawabans[$cobitId]['kategoris'][$kategoriId]['levels'][$levelId]['jawabans']->push($jawaban);
        }

        return view('auditor.show', compact('assessment', 'verificationStats', 'groupedJawabans'));
    }

    /**
     * Verify a single jawaban
     */
    public function verify(Request $request, Jawaban $jawaban)
    {
        // Check for row-specific jawaban name (jawaban_{id}) or generic 'jawaban'
        $jawabanKey = 'jawaban_' . $jawaban->id;
        $jawabanValue = $request->input($jawabanKey) ?? $request->input('jawaban');

        $request->validate([
            'verification_status' => 'required|in:verified,needs_revision,pending',
            'auditor_evidence' => 'nullable|string|max:1000',
        ]);

        // Validate the extracted jawaban value if it exists
        if ($jawabanValue && !in_array($jawabanValue, ['N', 'P', 'L', 'F'])) {
            return back()->with('error', 'Pilihan jawaban tidak valid.');
        }

        $updateData = [
            'verification_status' => $request->verification_status,
            'auditor_evidence' => $request->auditor_evidence,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ];

        if ($jawabanValue) {
            $updateData['jawaban'] = $jawabanValue;
        }

        $jawaban->update($updateData);

        return back()->with('success', 'Data berhasil diperbarui.');
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
