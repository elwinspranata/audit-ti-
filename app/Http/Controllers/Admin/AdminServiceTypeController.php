<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminServiceTypeController extends Controller
{
    public function index()
    {
        $serviceTypes = ServiceType::orderBy('sort_order')->get();
        return view('admin.service-types.index', compact('serviceTypes'));
    }

    public function create()
    {
        return view('admin.service-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'description2' => 'nullable|string',
            'closing_note' => 'nullable|string',
            'icon' => 'required|string|max:50',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'features' => 'nullable|array',
            'features.*.name' => 'required|string|max:255',
            'features.*.detail' => 'required|string',
        ]);

        try {
            ServiceType::create([
                'label' => $request->label,
                'title' => $request->title,
                'description' => $request->description,
                'description2' => $request->description2,
                'closing_note' => $request->closing_note,
                'icon' => $request->icon,
                'sort_order' => $request->sort_order,
                'is_active' => $request->boolean('is_active', true),
                'features' => $request->features ?? [],
            ]);

            return redirect()->route('admin.service-types.index')
                ->with('success', 'Jenis layanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Failed to create service type', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal menambahkan jenis layanan: ' . $e->getMessage());
        }
    }

    public function edit(ServiceType $serviceType)
    {
        return view('admin.service-types.edit', compact('serviceType'));
    }

    public function update(Request $request, ServiceType $serviceType)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'description2' => 'nullable|string',
            'closing_note' => 'nullable|string',
            'icon' => 'required|string|max:50',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'features' => 'nullable|array',
            'features.*.name' => 'required|string|max:255',
            'features.*.detail' => 'required|string',
        ]);

        try {
            $serviceType->update([
                'label' => $request->label,
                'title' => $request->title,
                'description' => $request->description,
                'description2' => $request->description2,
                'closing_note' => $request->closing_note,
                'icon' => $request->icon,
                'sort_order' => $request->sort_order,
                'is_active' => $request->boolean('is_active', true),
                'features' => $request->features ?? [],
            ]);

            return redirect()->route('admin.service-types.index')
                ->with('success', 'Jenis layanan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Failed to update service type', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal memperbarui jenis layanan: ' . $e->getMessage());
        }
    }

    public function destroy(ServiceType $serviceType)
    {
        try {
            $serviceType->delete();
            return redirect()->route('admin.service-types.index')
                ->with('success', 'Jenis layanan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Failed to delete service type', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menghapus jenis layanan: ' . $e->getMessage());
        }
    }

    public function toggleActive(ServiceType $serviceType)
    {
        $serviceType->update(['is_active' => !$serviceType->is_active]);
        $status = $serviceType->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Layanan \"{$serviceType->title}\" berhasil {$status}.");
    }
}
