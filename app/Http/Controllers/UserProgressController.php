<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\UserProgressService; // Import Service
use App\Models\Assessment;
use App\Models\CobitItem;
use App\Models\JawabanDraft;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

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
    public function index(Request $request): View
    {
        $user = Auth::user();
        
        // Get assessment from request or use latest one
        $assessmentId = $request->input('assessment_id');
        $assessment = null;
        
        if ($assessmentId) {
            $assessment = Assessment::where('user_id', $user->id)->find($assessmentId);
        }
        
        if (!$assessment) {
            $assessment = Assessment::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        // Panggil service untuk mendapatkan data progres.
        $progressData = $this->progressService->getProgressData($user, $assessment ? $assessment->id : null);

        // Ambil draft untuk assessment ini
        $incompleteDraftsQuery = JawabanDraft::with(['level.kategori.cobitItem'])
            ->where('user_id', $user->id);
            
        if ($assessment) {
            $incompleteDraftsQuery->where('assessment_id', $assessment->id);
        }
        
        $incompleteDrafts = $incompleteDraftsQuery->get();

        return view('user.progress.index', compact('user', 'progressData', 'incompleteDrafts', 'assessment'));
    }

    /**
     * Menangani download PDF untuk user yang sedang login.
     */
    public function downloadPDF(Request $request)
    {
        $user = Auth::user();
        
        $assessmentId = $request->input('assessment_id');
        $assessment = null;
        
        if ($assessmentId) {
            $assessment = Assessment::where('user_id', $user->id)->find($assessmentId);
        }
        
        if (!$assessment) {
            $assessment = Assessment::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        $progressData = $this->progressService->getProgressData($user, $assessment ? $assessment->id : null);

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
