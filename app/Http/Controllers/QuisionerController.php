<?php

namespace App\Http\Controllers;

use App\Models\Quisioner;
use App\Models\Level;
use Illuminate\Http\Request;

class QuisionerController extends Controller // Ganti nama controller jika berbeda
{
    public function index(Request $request)
    {
        // Ambil semua Level untuk pilihan filter dropdown
        // Eager load relasi kategori untuk bisa ditampilkan atau diurutkan berdasarkan nama kategori
        $levelsForFilter = Level::with('kategori')->orderBy('kategori_id')->orderBy('nama_level')->get();

        // Ambil ID Level yang dipilih dari request (jika ada)
        $selectedLevelId = $request->query('level_id');

        // Query dasar untuk mengambil quisioner, beserta relasi level dan kategori (untuk sorting atau info tambahan)
        $quisionersQuery = Quisioner::with(['level.kategori']); // Eager load level dan kategori dari level

        // Jika ada Level yang dipilih, filter berdasarkan itu
        if ($selectedLevelId) {
            $quisionersQuery->where('level_id', $selectedLevelId);
        }

        // Anda bisa menambahkan orderBy di sini jika perlu
        // Contoh: Urutkan berdasarkan ID Level, lalu ID Quisioner
        $quisionersQuery->orderBy('level_id', 'asc')->orderBy('id', 'asc');


        // Ambil data quisioner dengan paginasi
        // Ganti '15' dengan jumlah item per halaman yang Anda inginkan
        $quisioners = $quisionersQuery->paginate(10)->appends($request->query());

        // Kirim data ke view
        // Pastikan nama view 'admin.quisioners.index' atau yang sesuai dengan lokasi file Blade Anda
        return view('quisioner.index', [ // Ganti dengan path view Anda yang benar
            'quisioners' => $quisioners,
            'levelsForFilter' => $levelsForFilter, // Untuk mengisi dropdown filter
            'selectedLevelId' => $selectedLevelId, // Untuk menandai opsi yang dipilih
        ]);
    }

    // Menampilkan form untuk membuat quisioner baru
    public function create()
    {
        $levels = Level::all(); // Ambil semua data Level untuk dropdown
        return view('quisioner.create', compact('levels'));
    }

    // Menyimpan quisioner baru ke database
    public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'pertanyaan' => 'required|string|max:255',
        'level_id' => 'required|exists:levels,id',
    ]);

    // Menyimpan quisioner baru
    Quisioner::create([
        'pertanyaan' => $validated['pertanyaan'],
        'level_id' => $validated['level_id'],
    ]);

    return redirect()->route('quisioner.index')->with('success', 'Quisioner berhasil ditambahkan!');
}


    // Menampilkan form untuk mengedit quisioner
    public function edit($id)
    {
        $quisioner = Quisioner::findOrFail($id);
        $levels = Level::all(); // Ambil semua data Level untuk dropdown
        return view('quisioner.edit', compact('quisioner', 'levels'));
    }

    // Mengupdate quisioner yang ada di database
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'level_id' => 'required|exists:levels,id',
        ]);

        $quisioner = Quisioner::findOrFail($id); // Mencari data berdasarkan ID

        // Mengupdate data quisioner
        $quisioner->update([
            'pertanyaan' => $validated['pertanyaan'],
            'level_id' => $validated['level_id'],
        ]);

        return redirect()->route('quisioner.index')->with('success', 'Quisioner berhasil diperbarui!');
    }

    // Menghapus quisioner dari database
    public function destroy($id)
    {
        $quisioner = Quisioner::findOrFail($id);
        $quisioner->delete();

        return redirect()->route('quisioner.index')->with('success', 'Quisioner berhasil dihapus!');
    }
}
