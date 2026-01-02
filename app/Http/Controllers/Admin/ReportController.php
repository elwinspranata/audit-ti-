<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CobitItem;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CapabilityReportExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Logic from ProgressController
        $totalQuestions = \App\Models\Quisioner::count();
        // Use pagination like in ProgressController, or get all if preferred. 
        // Showing all might be better for the dropdown, but for the list we might want pagination?
        // Let's keep it simple: fetch all users for the dropdown, AND paginate for the table if no user selected.
        
        $usersForTable = User::where('role', '!=', 'admin')->paginate(10);
        foreach ($usersForTable as $u) {
            if ($totalQuestions > 0) {
                $answeredQuestions = \App\Models\Jawaban::where('user_id', $u->id)->count();
                $u->progress = ($answeredQuestions / $totalQuestions) * 100;
            } else {
                $u->progress = 0;
            }
        }

        // Existing Report Logic
        $users = User::where('role', 'user')->get(); // For the dropdown
        $selectedUserId = $request->input('user_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $selectedUser = null;
        $chartData = null;
        $reportData = [];

        if ($selectedUserId) {
            $selectedUser = User::find($selectedUserId);
            
            if ($selectedUser) {
                // ... (rest of the existing logic)
                $cobitItems = CobitItem::all();
                
                $labels = [];
                $data = [];
                $backgroundColors = [];

                foreach ($cobitItems as $item) {
                    $level = $this->calculateCapabilityLevel($selectedUser, $item, $startDate, $endDate);
                    
                    $reportData[] = [
                        'process' => $item->nama_item . ' - ' . $item->deskripsi,
                        'level' => $level
                    ];

                    $labels[] = $item->nama_item;
                    $data[] = $level;
                     // Dynamic color based on level
                    $color = match($level) {
                        0 => 'rgba(255, 99, 132, 0.6)',   // Red
                        1 => 'rgba(255, 159, 64, 0.6)',   // Orange
                        2 => 'rgba(255, 205, 86, 0.6)',   // Yellow
                        3 => 'rgba(75, 192, 192, 0.6)',   // Green
                        4 => 'rgba(54, 162, 235, 0.6)',   // Blue
                        5 => 'rgba(153, 102, 255, 0.6)',  // Purple
                        default => 'rgba(201, 203, 207, 0.6)'
                    };
                    $backgroundColors[] = $color;
                }

                $chartData = [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => 'Capability Level',
                            'data' => $data,
                            'backgroundColor' => $backgroundColors,
                            'borderColor' => str_replace('0.6', '1', $backgroundColors), // Make border opaque
                            'borderWidth' => 1
                        ]
                    ]
                ];
            }
        }

        return view('admin.report.index', compact('users', 'usersForTable', 'totalQuestions', 'selectedUser', 'chartData', 'reportData', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        $selectedUserId = $request->input('user_id');
        $type = $request->input('type'); // pdf, excel
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!$selectedUserId) {
            return redirect()->back()->with('error', 'Please select a user first.');
        }

        $user = User::findOrFail($selectedUserId);
        $cobitItems = CobitItem::all();
        $reportData = [];

        foreach ($cobitItems as $item) {
            $level = $this->calculateCapabilityLevel($user, $item, $startDate, $endDate);
            $reportData[] = [
                'process' => $item->nama_item,
                'description' => $item->deskripsi,
                'level' => $level
            ];
        }

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.report.pdf', compact('user', 'reportData', 'startDate', 'endDate'));
            return $pdf->download('capability_report_' . $user->name . '.pdf');
        } elseif ($type === 'excel') {
             return Excel::download(new CapabilityReportExport($user, $reportData), 'capability_report_' . $user->name . '.xlsx');
        } elseif ($type === 'csv') {
             return Excel::download(new CapabilityReportExport($user, $reportData), 'capability_report_' . $user->name . '.csv', \Maatwebsite\Excel\Excel::CSV);
        }

        return redirect()->back();
    }

    private function calculateCapabilityLevel($user, $cobitItem, $startDate = null, $endDate = null)
    {
        // Get all levels for this CobitItem grouped by level_number
        $allLevels = Level::whereHas('kategori', function($q) use ($cobitItem) {
            $q->where('cobit_item_id', $cobitItem->id);
        })->get()->groupBy('level_number');

        $achieved = 0;
        
        // Check levels 1 to 5 sequentially
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($allLevels[$i]) || $allLevels[$i]->isEmpty()) {
                break; 
            }
            
            $levelsAtThisNumber = $allLevels[$i];
            $isLevelAchieved = true;
            
            foreach ($levelsAtThisNumber as $lvl) {
                // Pass date range to model method
                if (!$lvl->isFullyAchievedByUser($user, $startDate, $endDate)) {
                    $isLevelAchieved = false;
                    break;
                }
            }
            
            if ($isLevelAchieved) {
                $achieved = $i;
            } else {
                break;
            }
        }
        
        return $achieved;
    }
}
