<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jawaban;
use App\Models\Quisioner; // 1. PASTIKAN MODEL INI DI-IMPORT
use App\Services\UserProgressService;
use PDF;

class ProgressController extends Controller
{
    protected $progressService;

    public function __construct(UserProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Menampilkan daftar semua user untuk admin.
     * VERSI YANG SUDAH DIPERBAIKI.
     */
    public function index()
    {
        // 2. Hitung total pertanyaan/kuesioner yang ada
        $totalQuestions = Quisioner::count();

        // 3. Gunakan ->paginate() untuk pagination
        $users = User::where('role', '!=', 'admin')->paginate(10);

        // 4. Hitung progress sederhana untuk setiap user (untuk ditampilkan di progress bar)
        // Ini tidak memanggil service yang berat agar halaman list tetap cepat.
        foreach ($users as $user) {
            if ($totalQuestions > 0) {
                $answeredQuestions = Jawaban::where('user_id', $user->id)->count();
                $user->progress = ($answeredQuestions / $totalQuestions) * 100;
            } else {
                $user->progress = 0;
            }
        }

        // 5. Kirim SEMUA variabel yang dibutuhkan oleh view ('users' dan 'totalQuestions')
        return view('admin.progress.index', compact('users', 'totalQuestions'));
    }

    /**
     * Menampilkan detail progress untuk satu user yang dipilih admin.
     */
    public function show(User $user)
    {
        // Panggil service yang sama untuk mendapatkan data user yang dipilih
        $progressData = $this->progressService->getProgressData($user);
        return view('admin.progress.show', compact('user', 'progressData'));
    }

    /**
     * Menangani download PDF untuk user yang dipilih admin.
     */
    public function downloadPDF(User $user)
    {
        $progressData = $this->progressService->getProgressData($user);

        $data = [
            'user' => $user,
            'progressData' => $progressData,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ];

        $pdf = PDF::loadView('user.progress.download.downloadPDF', $data);
        $fileName = 'Laporan Progres - ' . $user->name . '.pdf';

        return $pdf->stream($fileName);
    }
}
