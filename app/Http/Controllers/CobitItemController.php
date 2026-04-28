<?php

namespace App\Http\Controllers;

use App\Models\CobitItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CobitItemController extends Controller
{
    /**
     * Menampilkan daftar semua Cobit Item untuk admin dengan opsi filter visibilitas.
     */
    public function index(Request $request)
    {
        $query = CobitItem::query();

        // 1) Search
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('nama_item', 'LIKE', "%{$term}%")
                ->orWhere('deskripsi',  'LIKE', "%{$term}%");
            });
        }

        // 2) Visibility filter: hanya filter kalau benar-benar 'true' atau 'false'
        $filter = $request->get('is_visible');
        if ($filter === 'true') {
            $query->where('is_visible', true);
        } elseif ($filter === 'false') {
            $query->where('is_visible', false);
        }
        // kalau $filter == 'all' atau null, kita skip filter sama sekali

        // 3) Order & paginate
        $cobitItems = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->only(['search','is_visible']));

        return view('cobititem.index', compact('cobitItems'));
    }


    /**
     * ALTERNATIVE METHOD: Jika masih error, gunakan method ini
     */
    public function indexAlternative(Request $request)
    {
        // Approach 1: Menggunakan when() untuk conditional query
        $cobitItems = CobitItem::when($request->filled('is_visible'), function ($query) use ($request) {
            $isVisible = filter_var($request->input('is_visible'), FILTER_VALIDATE_BOOLEAN);
            return $query->where('is_visible', $isVisible);
        })
        ->latest()
        ->paginate(10);

        return view('cobititem.index', compact('cobitItems'));
    }

    /**
     * ALTERNATIVE METHOD 2: Manual pagination untuk Collection
     */
    public function indexManualPagination(Request $request)
    {
        // Jika Anda HARUS menggunakan Collection, gunakan manual pagination
        $perPage = 10;
        $page = $request->get('page', 1);

        // Get all items first
        $allItems = CobitItem::latest();

        if ($request->has('is_visible')) {
            $isVisible = filter_var($request->input('is_visible'), FILTER_VALIDATE_BOOLEAN);
            $allItems->where('is_visible', $isVisible);
        }

        $allItems = $allItems->get();

        // Manual pagination
        $currentPageItems = $allItems->forPage($page, $perPage);

        // Create paginator
        $cobitItems = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $allItems->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'pageName' => 'page',
            ]
        );

        return view('cobititem.index', compact('cobitItems'));
    }

    /**
     * Menampilkan form untuk membuat Cobit Item baru.
     */
    public function create()
    {
        return view('cobititem.create');
    }

    /**
     * Menyimpan Cobit Item baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_item' => 'required|string|max:255|unique:cobit_items',
            'deskripsi' => 'required|string',
            'is_visible' => 'boolean',
        ]);

        CobitItem::create([
            'nama_item' => $validated['nama_item'],
            'deskripsi' => $validated['deskripsi'],
            'is_visible' => $request->input('is_visible', false),
        ]);

        return redirect()->route('cobititem.index')->with('success', 'Cobit Item berhasil dibuat!');
    }

    /**
     * Menampilkan form untuk mengedit Cobit Item.
     */
    public function edit($id)
    {
        $item = CobitItem::findOrFail($id);
        return view('cobititem.edit', compact('item'));
    }

    /**
     * Mengupdate Cobit Item yang ada di database.
     */
    public function update(Request $request, $id)
    {
        $cobititem = CobitItem::findOrFail($id);

        $request->validate([
            'nama_item' => 'required|string|max:255|unique:cobit_items,nama_item,' . $cobititem->id,
            'deskripsi' => 'required|string',
            'is_visible' => 'boolean',
        ]);

        $cobititem->update([
            'nama_item' => $request->nama_item,
            'deskripsi' => $request->deskripsi,
            'is_visible' => $request->input('is_visible', false),
        ]);

        return redirect()->route('cobititem.index')->with('success', 'Cobit Item berhasil diperbarui.');
    }

    /**
     * Menghapus Cobit Item dari database.
     */
    public function destroy($id)
    {
        try {
            $cobititem = CobitItem::findOrFail($id);

            // Log untuk debugging
            Log::info('Mencoba menghapus CobitItem dengan ID: ' . $id);

            // Cek apakah ada kategori yang terkait
            $hasKategoris = $cobititem->kategoris()->count() > 0;

            if ($hasKategoris) {
                Log::warning('CobitItem memiliki kategori terkait, ID: ' . $id);
                return redirect()->route('cobititem.index')
                    ->with('error', 'Tidak dapat menghapus item ini karena masih memiliki kategori terkait!');
            }

            $deleted = $cobititem->delete();

            if ($deleted) {
                Log::info('CobitItem berhasil dihapus dengan ID: ' . $id);
                return redirect()->route('cobititem.index')->with('success', 'Cobit Item berhasil dihapus!');
            } else {
                Log::error('Gagal menghapus CobitItem dengan ID: ' . $id);
                return redirect()->route('cobititem.index')->with('error', 'Gagal menghapus item!');
            }

        } catch (\Exception $e) {
            Log::error('Error saat menghapus CobitItem ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('cobititem.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
