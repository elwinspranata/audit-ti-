<?php

namespace App\Http\Controllers;

use App\Imports\QuisionerImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Kategori; // <-- Tambahkan ini

class ExcelController extends Controller
{
    public function index()
    {
        // Ambil semua kategori untuk ditampilkan di dropdown
        $kategoris = Kategori::with('cobitItem')->orderBy('cobit_item_id')->get();
        return view("import.index", compact('kategoris'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'kategori_id' => 'required|exists:kategoris,id', // <-- Validasi input kategori
        ]);

        try {
            // Teruskan kategori_id ke kelas Import
            Excel::import(new QuisionerImport($request->kategori_id), $request->file('file'));

            return back()->with('success', 'Data kuesioner berhasil diimpor!');
        } catch (\Exception $e) {
            // Berikan pesan error yang lebih spesifik
            return back()->with('error', 'Terjadi kesalahan saat impor: ' . $e->getMessage());
        }
    }
}
