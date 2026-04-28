<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CapabilityReportExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $user;
    protected $reportData;

    public function __construct($user, $reportData)
    {
        $this->user = $user;
        $this->reportData = $reportData;
    }

    public function view(): View
    {
        return view('admin.report.pdf', [
            'user' => $this->user,
            'reportData' => $this->reportData
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 16]],
            2    => ['font' => ['bold' => true]],
        ];
    }
}
