<?php

// app/Http/Controllers/ResubmissionRequestController.php
namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\ResubmissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResubmissionRequestController extends Controller
{
    // Method yang sudah ada untuk user mengajukan request
    public function store(Request $request, Level $level)
    {
        $userId = Auth::id();
        $existingRequest = ResubmissionRequest::where('user_id', $userId)
            ->where('level_id', $level->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'Anda sudah memiliki permintaan aktif untuk mengisi ulang level ini.');
        }

        try {
            ResubmissionRequest::create([
                'user_id' => $userId,
                'level_id' => $level->id,
                'status' => 'pending',
            ]);
            return back()->with('success', 'Permintaan pengisian ulang telah diajukan dan menunggu persetujuan admin.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                 return back()->with('error', 'Gagal mengajukan permintaan. Anda mungkin sudah memiliki permintaan serupa.');
            }
            return back()->with('error', 'Gagal mengajukan permintaan. Silakan coba lagi.');
        }
    }

    // --- METHOD BARU UNTUK ADMIN ---

    /**
     * Menampilkan daftar permintaan pengisian ulang untuk admin.
     */
    public function adminIndex(Request $request)
    {
        // Pastikan hanya admin yang bisa mengakses - tambahkan middleware atau gate di route
        // if (!Auth::user()->isAdmin()) { // Ganti isAdmin() dengan cara Anda mengecek role admin
        //     abort(403, 'Unauthorized action.');
        // }

        $filterStatus = $request->input('status', 'pending'); // Default filter adalah 'pending'

        $query = ResubmissionRequest::with(['user', 'level', 'level.kategori', 'level.kategori.cobitItem'])
                                    ->orderBy('requested_at', 'desc');

        if ($filterStatus && $filterStatus !== 'all') {
            $query->where('status', $filterStatus);
        }

        $requests = $query->paginate(15); // Paginasi

        return view('admin.resubmissions.index', [
            'requests' => $requests,
            'currentStatus' => $filterStatus
        ]);
    }

    /**
     * Menyetujui permintaan pengisian ulang.
     */
    public function approve(ResubmissionRequest $resubmissionRequest)
    {
        // Pastikan hanya admin yang bisa mengakses
        // if (!Auth::user()->isAdmin()) {
        //     abort(403, 'Unauthorized action.');
        // }

        if ($resubmissionRequest->status === 'pending') {
            $resubmissionRequest->update([
                'status' => 'approved',
                'approved_by' => Auth::id(), // ID admin yang menyetujui
                'action_at' => now(),
            ]);
            return back()->with('success', 'Permintaan berhasil disetujui.');
        }
        return back()->with('error', 'Permintaan ini tidak bisa disetujui (mungkin statusnya bukan pending).');
    }

    /**
     * Menolak permintaan pengisian ulang.
     */
    public function reject(Request $requestValidation, ResubmissionRequest $resubmissionRequest)
    {
        // Pastikan hanya admin yang bisa mengakses (gunakan middleware atau gate)
        // if (!Auth::user()->isAdmin()) {
        //     abort(403, 'Unauthorized action.');
        // }

        // Log untuk debugging
        \Illuminate\Support\Facades\Log::info('Reject request initiated for ID: ' . $resubmissionRequest->id, [
            'request_data' => $requestValidation->all(),
            'resubmission_request_status_before' => $resubmissionRequest->status
        ]);

        $requestValidation->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        if ($resubmissionRequest->status === 'pending') {
            $resubmissionRequest->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
                'action_at' => now(),
                'admin_notes' => $requestValidation->input('admin_notes'),
            ]);
            \Illuminate\Support\Facades\Log::info('Reject request successful for ID: ' . $resubmissionRequest->id);
            return back()->with('success', 'Permintaan berhasil ditolak.');
        }

        \Illuminate\Support\Facades\Log::warning('Reject request failed for ID: ' . $resubmissionRequest->id . '. Status was not pending.', [
            'current_status' => $resubmissionRequest->status
        ]);
        return back()->with('error', 'Permintaan ini tidak bisa ditolak (mungkin statusnya bukan pending).');
    }
}