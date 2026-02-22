<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Kategori;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    // Menampilkan semua level
    public function index(Request $request)
    {
        // Ambil semua kategori untuk pilihan filter dropdown
        $kategoris = Kategori::orderBy('nama')->get();

        // Ambil ID kategori yang dipilih dari request (jika ada)
        $selectedKategoriId = $request->query('kategori_id');

        // Query dasar untuk mengambil level, beserta relasi kategori (untuk sorting atau info tambahan)
        $levelsQuery = Level::with('kategori');

        // Jika ada kategori yang dipilih, filter berdasarkan itu
        if ($selectedKategoriId) {
            $levelsQuery->where('kategori_id', $selectedKategoriId);
        }

        // Anda bisa menambahkan orderBy di sini jika perlu, misalnya berdasarkan nama level atau ID kategori
        $levelsQuery->orderBy(
            Kategori::select('nama')
                ->whereColumn('kategoris.id', 'levels.kategori_id')
        )->orderBy('levels.nama_level', 'asc');


        // Ambil data level dengan paginasi
        $levels = $levelsQuery->paginate(10)->appends($request->query()); // appends() untuk menjaga filter saat paginasi

        // Kirim data ke view
        // Pastikan nama view 'admin.levels.index' sesuai dengan lokasi file Blade Anda
        return view('level.index', [
            'levels' => $levels,
            'kategoris' => $kategoris, // Untuk mengisi dropdown filter
            'selectedKategoriId' => $selectedKategoriId, // Untuk menandai opsi yang dipilih
        ]);
    }

    // Menampilkan form untuk membuat level baru
    public function create()
{
    $kategoris = Kategori::all(); // Ambil semua data Kategori
    return view('level.create', compact('kategoris'));
}

    // Menyimpan level baru ke database
    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_level' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategoris,id',
        'level_number' => 'required|integer', // Validasi level_number
    ]);

    Level::create([
        'nama_level' => $validated['nama_level'],
        'kategori_id' => $validated['kategori_id'],
        'level_number' => $validated['level_number'],  // Menambahkan level_number
    ]);

    return redirect()->route('level.index')->with('success', 'Level berhasil ditambahkan!');
}


    // Menampilkan form untuk mengedit level
    public function edit($id)
{
    $level = Level::findOrFail($id);
    $kategoris = Kategori::all(); // Ambil semua data Kategori
    return view('level.edit', compact('level', 'kategoris'));
}

    // Mengupdate level yang ada di database
    public function update(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'nama_level' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategoris,id',
        'level_number' => 'required|integer|min:1',
    ]);

    // Temukan level berdasarkan ID
    $level = Level::findOrFail($id);

    // Update level
    $level->update([
        'nama_level' => $validated['nama_level'],
        'kategori_id' => $validated['kategori_id'],
        'level_number' => $validated['level_number'],
    ]);

    // Redirect ke halaman level atau halaman yang sesuai
    return redirect()->route('level.index')->with('success', 'Level berhasil diperbarui!');
}


    // Menghapus level dari database
    public function destroy($id)
    {
        $level = Level::findOrFail($id);
        $level->delete();

        return redirect()->route('level.index')->with('success', 'Level berhasil dihapus!');
    }
}
