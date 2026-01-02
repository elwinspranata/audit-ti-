<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CobitItem;
use App\Models\Jawaban;
use App\Models\Transaction;
use App\Models\JawabanDraft;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminReportController extends Controller
{
    /**
     * Menampilkan halaman report dengan grafik capability level
     */
    public function index(Request $request)
    {
        // Get all users for dropdown filter
        $users = User::where('role', 'user')
            ->where('is_approved', true)
            ->orderBy('name')
            ->get();
        
        $selectedUser = null;
        $capabilityData = [];
        $summaryStats = [];
        
        if ($request->user_id) {
            $selectedUser = User::find($request->user_id);
            
            if ($selectedUser) {
                $capabilityData = $this->calculateCapabilityLevels($selectedUser);
                $summaryStats = $this->calculateSummaryStats($selectedUser, $capabilityData);
            }
        }
        
        // Overall statistics
        $overallStats = [
            'totalUsers' => User::where('role', 'user')->count(),
            'activeSubscriptions' => User::where('subscription_status', 'active')->count(),
            'totalProsesTI' => CobitItem::where('is_visible', true)->count(),
            'pendingDrafts' => JawabanDraft::count(),
        ];
        
        return view('admin.reports.index', compact(
            'users', 
            'selectedUser', 
            'capabilityData', 
            'summaryStats',
            'overallStats'
        ));
    }
    
    /**
     * Menghitung capability level untuk setiap Proses TI (CobitItem)
     */
    private function calculateCapabilityLevels(User $user)
    {
        $cobitItems = CobitItem::with(['kategoris.levels.quisioners'])
            ->where('is_visible', true)
            ->get();
        
        $result = [];
        
        foreach ($cobitItems as $cobitItem) {
            $capabilityLevel = $this->getCapabilityLevelForItem($user, $cobitItem);
            
            $result[] = [
                'id' => $cobitItem->id,
                'nama_item' => $cobitItem->nama_item,
                'capability_level' => $capabilityLevel,
                'details' => $this->getLevelDetails($user, $cobitItem),
            ];
        }
        
        return $result;
    }
    
    /**
     * Mendapatkan capability level tertinggi yang fully achieved untuk satu CobitItem
     */
    private function getCapabilityLevelForItem(User $user, CobitItem $cobitItem)
    {
        $highestLevel = 0;
        
        foreach ($cobitItem->kategoris as $kategori) {
            // Sort levels by level_number
            $levels = $kategori->levels->sortBy('level_number');
            
            foreach ($levels as $level) {
                $quisionerIds = $level->quisioners->pluck('id');
                
                if ($quisionerIds->isEmpty()) {
                    continue;
                }
                
                // Get user's answers for this level
                $userAnswers = Jawaban::where('user_id', $user->id)
                    ->where('level_id', $level->id)
                    ->whereIn('quisioner_id', $quisionerIds)
                    ->get();
                
                // Check if all questions are answered with 'F'
                $allQuestionsAnswered = $userAnswers->count() >= $quisionerIds->count();
                $allAnswersF = $userAnswers->every(fn($a) => $a->jawaban === 'F');
                
                if ($allQuestionsAnswered && $allAnswersF) {
                    // This level is fully achieved
                    if ($level->level_number > $highestLevel) {
                        $highestLevel = $level->level_number;
                    }
                } else {
                    // If current level is not achieved, stop checking higher levels
                    break;
                }
            }
        }
        
        return $highestLevel;
    }
    
    /**
     * Mendapatkan detail per level untuk satu CobitItem
     */
    private function getLevelDetails(User $user, CobitItem $cobitItem)
    {
        $details = [];
        
        foreach ($cobitItem->kategoris as $kategori) {
            foreach ($kategori->levels as $level) {
                $quisionerIds = $level->quisioners->pluck('id');
                $totalQuestions = $quisionerIds->count();
                
                $userAnswers = Jawaban::where('user_id', $user->id)
                    ->where('level_id', $level->id)
                    ->whereIn('quisioner_id', $quisionerIds)
                    ->get();
                
                $answeredCount = $userAnswers->count();
                $fCount = $userAnswers->where('jawaban', 'F')->count();
                
                $status = 'not_started';
                if ($answeredCount > 0) {
                    if ($answeredCount >= $totalQuestions && $fCount >= $totalQuestions) {
                        $status = 'fully_achieved';
                    } elseif ($answeredCount >= $totalQuestions) {
                        $status = 'completed';
                    } else {
                        $status = 'in_progress';
                    }
                }
                
                $details[] = [
                    'level_number' => $level->level_number,
                    'nama_level' => $level->nama_level,
                    'kategori' => $kategori->nama,
                    'total_questions' => $totalQuestions,
                    'answered' => $answeredCount,
                    'f_count' => $fCount,
                    'status' => $status,
                ];
            }
        }
        
        return $details;
    }
    
    /**
     * Menghitung summary statistics untuk user
     */
    private function calculateSummaryStats(User $user, array $capabilityData)
    {
        $totalProses = count($capabilityData);
        $completedProses = collect($capabilityData)->where('capability_level', '>', 0)->count();
        $avgCapability = $totalProses > 0 
            ? round(collect($capabilityData)->avg('capability_level'), 2) 
            : 0;
        
        return [
            'totalProses' => $totalProses,
            'completedProses' => $completedProses,
            'avgCapability' => $avgCapability,
            'registrationDate' => $user->created_at->format('d M Y'),
            'subscriptionEnd' => $user->subscription_end ? $user->subscription_end->format('d M Y') : '-',
        ];
    }
    
    /**
     * Export report ke PDF
     */
    public function exportPdf(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $capabilityData = $this->calculateCapabilityLevels($user);
        $summaryStats = $this->calculateSummaryStats($user, $capabilityData);
        
        $data = [
            'user' => $user,
            'capabilityData' => $capabilityData,
            'summaryStats' => $summaryStats,
            'tanggalCetak' => now()->translatedFormat('d F Y'),
        ];
        
        $pdf = Pdf::loadView('admin.reports.pdf', $data);
        $fileName = 'Capability_Report_' . str_replace(' ', '_', $user->name) . '.pdf';
        
        return $pdf->download($fileName);
    }
    
    /**
     * Export report ke Excel
     */
    public function exportExcel(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $capabilityData = $this->calculateCapabilityLevels($user);
        
        $fileName = 'Capability_Report_' . str_replace(' ', '_', $user->name) . '.xlsx';
        
        return response()->streamDownload(function() use ($user, $capabilityData) {
            $this->generateExcel($user, $capabilityData);
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
    
    /**
     * Export report ke CSV
     */
    public function exportCsv(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $capabilityData = $this->calculateCapabilityLevels($user);
        
        $fileName = 'Capability_Report_' . str_replace(' ', '_', $user->name) . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];
        
        $callback = function() use ($user, $capabilityData) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Capability Level Report']);
            fputcsv($file, ['User: ' . $user->name]);
            fputcsv($file, ['Email: ' . $user->email]);
            fputcsv($file, ['Generated: ' . now()->format('d M Y H:i')]);
            fputcsv($file, []);
            
            // Data header
            fputcsv($file, ['No', 'Proses TI', 'Capability Level']);
            
            // Data rows
            foreach ($capabilityData as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item['nama_item'],
                    'Level ' . $item['capability_level'],
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Generate Excel file using simple HTML table (no external library needed)
     */
    private function generateExcel(User $user, array $capabilityData)
    {
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="UTF-8"></head>';
        echo '<body>';
        echo '<table border="1">';
        echo '<tr><th colspan="3">Capability Level Report</th></tr>';
        echo '<tr><td colspan="3">User: ' . $user->name . '</td></tr>';
        echo '<tr><td colspan="3">Email: ' . $user->email . '</td></tr>';
        echo '<tr><td colspan="3">Generated: ' . now()->format('d M Y H:i') . '</td></tr>';
        echo '<tr><td colspan="3"></td></tr>';
        echo '<tr><th>No</th><th>Proses TI</th><th>Capability Level</th></tr>';
        
        foreach ($capabilityData as $index => $item) {
            echo '<tr>';
            echo '<td>' . ($index + 1) . '</td>';
            echo '<td>' . $item['nama_item'] . '</td>';
            echo '<td>Level ' . $item['capability_level'] . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        echo '</body></html>';
    }
}
