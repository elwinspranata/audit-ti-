<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAssessmentController extends Controller
{
    /**
     * Display user's assessments list
     */
    public function index()
    {
        $assessments = Assessment::where('user_id', Auth::id())
            ->with(['cobitItems', 'items'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.assessments.index', compact('assessments'));
    }

    /**
     * Show specific assessment detail
     */
    public function show(Assessment $assessment)
    {
        // Ensure user can only see their own assessments
        if ($assessment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $assessment->load(['items.cobitItem', 'cobitItems', 'approver']);

        return view('user.assessments.show', compact('assessment'));
    }

    /**
     * Submit assessment for approval
     */
    public function submit(Assessment $assessment)
    {
        // Ensure user can only submit their own assessments
        if ($assessment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Only allow submission if status is pending_submission
        if ($assessment->status !== Assessment::STATUS_PENDING_SUBMISSION) {
            return back()->with('error', 'Assessment ini tidak bisa disubmit.');
        }

        $assessment->update([
            'status' => Assessment::STATUS_PENDING_APPROVAL,
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Assessment berhasil disubmit untuk persetujuan admin.');
    }

    /**
     * Start working on approved assessment (change status to in_progress)
     */
    public function start(Assessment $assessment)
    {
        if ($assessment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        if ($assessment->status !== Assessment::STATUS_APPROVED) {
            return back()->with('error', 'Assessment belum disetujui admin.');
        }

        $assessment->update([
            'status' => Assessment::STATUS_IN_PROGRESS,
        ]);

        return redirect()->route('user.assessments.show', $assessment)
            ->with('success', 'Assessment dimulai! Silakan isi kuesioner.');
    }

    /**
     * Mark assessment as completed
     */
    public function complete(Assessment $assessment)
    {
        if ($assessment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        if ($assessment->status !== Assessment::STATUS_IN_PROGRESS) {
            return back()->with('error', 'Assessment tidak dalam status pengerjaan.');
        }

        // Check if all items have some progress
        $allItemsComplete = $assessment->items->every(function ($item) {
            return $item->progress >= 100;
        });

        if (!$allItemsComplete) {
            return back()->with('error', 'Semua proses TI harus diselesaikan sebelum submit.');
        }

        $assessment->update([
            'status' => Assessment::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Assessment berhasil diselesaikan dan dikirim untuk verifikasi.');
    }
}
