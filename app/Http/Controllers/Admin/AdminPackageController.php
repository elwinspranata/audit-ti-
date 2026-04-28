<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminPackageController extends Controller
{
    /**
     * Display a listing of packages.
     */
    public function index()
    {
        $packages = Package::withCount(['features', 'transactions'])
            ->orderBy('level')
            ->get();

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new package.
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created package.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'level' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'features' => 'nullable|array',
            'features.*.name' => 'required|string|max:255',
            'features.*.is_included' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $package = Package::create([
                'name' => $request->name,
                'price' => $request->price,
                'level' => $request->level,
                'description' => $request->description,
                'duration_days' => $request->duration_days,
                'is_active' => $request->boolean('is_active', true),
                'is_popular' => $request->boolean('is_popular', false),
            ]);

            // Store features
            if ($request->has('features')) {
                foreach ($request->features as $index => $feature) {
                    PackageFeature::create([
                        'package_id' => $package->id,
                        'feature_name' => $feature['name'],
                        'is_included' => isset($feature['is_included']) ? (bool) $feature['is_included'] : true,
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.packages.index')
                ->with('success', 'Paket layanan berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create package', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal membuat paket: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified package.
     */
    public function edit(Package $package)
    {
        $package->load('features');
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified package.
     */
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'level' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'features' => 'nullable|array',
            'features.*.name' => 'required|string|max:255',
            'features.*.is_included' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $package->update([
                'name' => $request->name,
                'price' => $request->price,
                'level' => $request->level,
                'description' => $request->description,
                'duration_days' => $request->duration_days,
                'is_active' => $request->boolean('is_active', true),
                'is_popular' => $request->boolean('is_popular', false),
            ]);

            // Delete old features and re-create
            $package->features()->delete();

            if ($request->has('features')) {
                foreach ($request->features as $index => $feature) {
                    PackageFeature::create([
                        'package_id' => $package->id,
                        'feature_name' => $feature['name'],
                        'is_included' => isset($feature['is_included']) ? (bool) $feature['is_included'] : true,
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.packages.index')
                ->with('success', 'Paket layanan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update package', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal memperbarui paket: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified package.
     */
    public function destroy(Package $package)
    {
        // Check if package has active transactions
        $activeTransactions = $package->transactions()
            ->whereIn('payment_status', ['pending', 'paid'])
            ->count();

        if ($activeTransactions > 0) {
            return back()->with('error', 'Paket tidak dapat dihapus karena masih memiliki ' . $activeTransactions . ' transaksi aktif.');
        }

        try {
            $package->delete();
            return redirect()->route('admin.packages.index')
                ->with('success', 'Paket layanan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Failed to delete package', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menghapus paket: ' . $e->getMessage());
        }
    }

    /**
     * Toggle package active status.
     */
    public function toggleActive(Package $package)
    {
        $package->update(['is_active' => !$package->is_active]);

        $status = $package->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Paket \"{$package->name}\" berhasil {$status}.");
    }

    /**
     * Toggle package popular/featured status.
     */
    public function togglePopular(Package $package)
    {
        $package->update(['is_popular' => !$package->is_popular]);

        $status = $package->is_popular ? 'ditandai sebagai populer' : 'dihapus dari populer';
        return back()->with('success', "Paket \"{$package->name}\" berhasil {$status}.");
    }
}
