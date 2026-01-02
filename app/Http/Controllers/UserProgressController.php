<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\UserProgressService; // Import Service
use App\Models\CobitItem;
use App\Models\JawabanDraft;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use PDF;

class UserProgressController extends Controller
{
    protected $progressService;

    // Suntikkan service melalui constructor (Dependency Injection)
    public function __construct(UserProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Menampilkan halaman progres untuk user yang sedang login.
     */
    public function index(): View
    {
        $user = Auth::user();

        // --- PERBAIKAN DI SINI ---
        // Logika gerbang yang mengharuskan semua audit selesai telah dihapus.
        // Sekarang, halaman progres bisa diakses kapan saja.

        // Panggil service untuk mendapatkan data progres, apa pun statusnya.
        $progressData = $this->progressService->getProgressData($user);

        // Ambil draft yang belum diselesaikan untuk notifikasi
        $incompleteDrafts = JawabanDraft::with(['level.kategori.cobitItem'])
            ->where('user_id', $user->id)
            ->get();

        return view('user.progress.index', compact('user', 'progressData', 'incompleteDrafts'));
    }

    /**
     * Menangani download PDF untuk user yang sedang login.
     */
    public function downloadPDF()
    {
        $user = Auth::user();

        // Logika di sini tidak perlu diubah, karena ia akan mencetak
        // progres saat ini, baik sudah selesai maupun belum.
        $progressData = $this->progressService->getProgressData($user);

        $data = [
            'user' => $user,
            'progressData' => $progressData,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ];

        $pdf = FacadePdf::loadView('user.progress.download.downloadPDF', $data);
        $fileName = 'Laporan Progres - ' . $user->name . '.pdf';

        return $pdf->stream($fileName);
    }
}
