<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\CobitItem;
use Illuminate\Http\Request;

class KategoriController extends Controller
{

    public function index(Request $request)
    {
        // Ambil semua Cobit Item untuk pilihan filter dropdown
        $cobitItems = CobitItem::orderBy('nama_item')->get();

        // Ambil ID Cobit Item yang dipilih dari request
        $selectedCobitItemId = $request->query('cobit_item_id');

        // Query dasar untuk mengambil kategori
        $kategorisQuery = Kategori::with('cobitItem');

        // Jika ada filter Cobit Item, terapkan
        if ($selectedCobitItemId) {
            $kategorisQuery->where('cobit_item_id', $selectedCobitItemId);
        }

        // Urutkan berdasarkan nama item, lalu nama kategori
        $kategorisQuery->orderBy(
            CobitItem::select('nama_item')
                ->whereColumn('cobit_items.id', 'kategoris.cobit_item_id')
        )->orderBy('kategoris.nama', 'asc');

        // --- PERBAIKAN DI SINI ---
        // Mengubah jumlah item per halaman menjadi 10 untuk menampilkan paginasi.
        $kategoris = $kategorisQuery->paginate(10)->appends($request->query());

        // Kirim data ke view
        return view('kategori.index', [
            'kategoris' => $kategoris,
            'cobitItems' => $cobitItems,
            'selectedCobitItemId' => $selectedCobitItemId,
        ]);
    }

    // ... (method create, store, edit, update, destroy tetap sama) ...

    public function create()
    {
        $cobitItems = CobitItem::all();
        return view('kategori.create', compact('cobitItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'cobit_item_id' => 'required|exists:cobit_items,id',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori) // Menggunakan Route Model Binding
    {
        $cobitItems = CobitItem::all();
        return view('kategori.edit', compact('kategori', 'cobitItems'));
    }

    public function update(Request $request, Kategori $kategori) // Menggunakan Route Model Binding
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'cobit_item_id' => 'required|exists:cobit_items,id',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori) // Menggunakan Route Model Binding
    {
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
