<?php

namespace App\Http\Controllers;

use App\Models\CobitItem;
use App\Models\User;
use App\Models\Level;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF; // Assuming dompdf is installed or will be aliased
use Maatwebsite\Excel\Facades\Excel; // If maatwebsite/excel is installed

class ReportController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get(); // Filter admins if necessary
        return view('report.index', compact('users'));
    }

    public function getData(Request $request)
    {
        $userId = $request->user_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if (!$userId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }

        $user = User::find($userId);
        $cobitItems = CobitItem::with(['kategoris.levels.quisioners'])->get();

        $labels = [];
        $data = [];

        foreach ($cobitItems as $item) {
            $level = $this->calculateCapabilityLevel($user, $item, $startDate, $endDate);
            $labels[] = $item->nama_item; // Or code/initials if name is too long
            $data[] = $level;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    private function calculateCapabilityLevel($user, $cobitItem, $startDate, $endDate)
    {
        $currentLevel = 0;

        // Iterate levels 1 to 5
        for ($i = 1; $i <= 5; $i++) {
            // Get all Level IDs for this CobitItem that match the level number $i
            // CobitItem -> Kategoris -> Levels (where level_number = $i)
            
            // Collect all relevant Level IDs for this specific level (e.g. Level 1) across all categories of this Cobit Item
            $levelIds = [];
            foreach ($cobitItem->kategoris as $kategori) {
                foreach ($kategori->levels as $level) {
                   // Assuming 'level_number' exists on Level model as seen in previous view_file
                   // But wait, in the view_file of Level.php I saw `level_number` in fillable.
                   // Let's assume standard normalization: 'Level 1' might be stored as integer 1 or string '1'.
                   // If level_number is not explicitly 1-5, we might need to parse 'nama_level' or rely on an assumption.
                   // Let's rely on 'nama_level' containing the number if 'level_number' is not reliable, 
                   // BUT checking the Level model content earlier, it has `level_number`.
                   if ($level->level_number == $i) {
                       $levelIds[] = $level->id;
                   }
                }
            }

            if (empty($levelIds)) {
                // If there are no levels defined for this step, what do we do?
                // For COBIT, usually levels exist. If missing, maybe we skip or stop?
                // Let's assume if no definitions for Level X, we cannot complete Level X.
                // Or maybe it simply doesn't exist so it's not a barrier? 
                // Let's treat it as: if no questions/levels defined, we can't achieve it.
                break; 
            }

            // Get total questions for these levels
            // We need to count quisioners for these level IDs
            $totalQuestions = 0;
            $levelIdsWithQuestions = [];
            foreach ($levelIds as $lid) {
                // We need to fetch count. To avoid N+1, we might want to eager load properly or query directly.
                // $level->quisioners_count if loaded, or query.
                // For simplicity and correctness without over-optimizing yet:
                $count = \App\Models\Quisioner::where('level_id', $lid)->count();
                $totalQuestions += $count;
                if ($count > 0) {
                    $levelIdsWithQuestions[] = $lid;
                }
            }

            if ($totalQuestions == 0) {
                // No questions for this level? Pass it? Or Fail?
                // Usually implies config error, but let's assume if NO questions, it's auto-achieved? 
                // No, adhering to "Full Answer" logic -> No answers = Leve 0.
                 break;
            }

            // Count 'F' answers for these questions by this user
            $query = Jawaban::whereIn('level_id', $levelIdsWithQuestions)
                            ->where('user_id', $user->id)
                            ->where('jawaban', 'F');

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $achievedCount = $query->count();

            // Logic: All questions must be 'F'
            if ($achievedCount == $totalQuestions) {
                $currentLevel = $i;
            } else {
                // If Level 1 is not fully achieved, we stop. Level 2 cannot be achieved.
                break; 
            }
        }

        return $currentLevel;
    }

    public function export(Request $request)
    {
        $type = $request->type;
        $userId = $request->user_id;
        // Logic for export...
        
        $data = $this->getData($request)->original;
        
        if ($type == 'csv') {
             return $this->exportCsv($data);
        }
        
        if ($type == 'excel') {
             return $this->exportExcel($data);
        }

        if ($type == 'pdf') {
             // For PDF, we'll try to use a print-friendly view or simple DOMPDF if available.
             // If not available, we return a simple HTML view that triggers print.
             return view('report.print', [
                 'labels' => $data['labels'],
                 'data' => $data['data'],
                 'user' => User::find($userId)
             ]);
        }
        
        return response()->json(['message' => 'Export type not supported'], 400);
    }
    
    private function exportCsv($data) {
        $fileName = 'capability-report.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Process', 'Capability Level');

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $labels = $data['labels'];
            $levels = $data['data'];
            
            foreach ($labels as $key => $label) {
                fputcsv($file, array($label, $levels[$key]));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportExcel($data) {
        $fileName = 'capability-report.xls';
        $headers = array(
            "Content-type"        => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        // Simple HTML Table for Excel
        $callback = function() use($data) {
            $file = fopen('php://output', 'w');
            
            $labels = $data['labels'];
            $levels = $data['data'];
            
            $content = "<html><head><meta charset='UTF-8'></head><body>";
            $content .= "<table border='1'>";
            $content .= "<thead><tr><th style='background-color:#4e73df; color:white;'>Process</th><th style='background-color:#4e73df; color:white;'>Capability Level</th></tr></thead>";
            $content .= "<tbody>";
            
            foreach ($labels as $key => $label) {
                $content .= "<tr><td>{$label}</td><td style='text-align:center;'>{$levels[$key]}</td></tr>";
            }
            
            $content .= "</tbody></table></body></html>";
            
            fwrite($file, $content);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
