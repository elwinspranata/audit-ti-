<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentItem;
use App\Models\CobitItem;
use App\Models\User;
use App\Mail\AssessmentStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminAssessmentController extends Controller
{
    /**
     * Display a listing of all assessments
     */
    public function index(Request $request)
    {
        $query = Assessment::with(['user', 'cobitItems'])
            ->orderBy('created_at', 'desc');

        // Filter by user
        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $assessments = $query->paginate(12);
        $users = User::where('role', 'user')->get();

        return view('admin.assessments.index', compact('assessments', 'users'));
    }

    /**
     * Show the form for creating a new assessment
     */
    public function create()
    {
        $cobitItems = CobitItem::where('is_visible', true)
            ->with('kategoris.levels')
            ->orderBy('nama_item')
            ->get();
            
        $users = User::where('role', 'user')->get();

        return view('admin.assessments.create', compact('cobitItems', 'users'));
    }

    /**
     * Store a newly created assessment
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'nullable|string|max:255',
            'cobit_items' => 'required|array|min:1',
            'cobit_items.*' => 'exists:cobit_items,id',
        ], [
            'cobit_items.required' => 'Pilih minimal satu proses TI.',
            'cobit_items.min' => 'Pilih minimal satu proses TI.',
        ]);

        // Create assessment
        $assessment = Assessment::create([
            'user_id' => $request->user_id,
            'name' => $request->name ?? 'Assessment ' . now()->format('d M Y'),
            'status' => Assessment::STATUS_APPROVED, // Auto-approved because admin created it
            'submitted_at' => now(),
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        // Attach selected CobitItems
        foreach ($request->cobit_items as $cobitItemId) {
            AssessmentItem::create([
                'assessment_id' => $assessment->id,
                'cobit_item_id' => $cobitItemId,
            ]);
        }

        return redirect()->route('admin.assessments.index')
            ->with('success', 'Assessment berhasil dibuat untuk user.');
    }

    /**
     * Display the specified assessment
     */
    public function show(Assessment $assessment)
    {
        $assessment->load([
            'user',
            'cobitItems.kategoris.levels.quisioners',
            'items',
            'jawabans',
            'approver',
            'verifier'
        ]);

        // Calculate progress per item
        foreach ($assessment->items as $item) {
            $item->progress = $item->calculateProgress();
        }

        return view('admin.assessments.show', compact('assessment'));
    }

    /**
     * Show the form for editing the assessment
     */
    public function edit(Assessment $assessment)
    {
        $cobitItems = CobitItem::where('is_visible', true)
            ->orderBy('nama_item')
            ->get();

        $selectedItemIds = $assessment->items->pluck('cobit_item_id')->toArray();
        $users = User::where('role', 'user')->get();

        return view('admin.assessments.edit', compact('assessment', 'cobitItems', 'selectedItemIds', 'users'));
    }

    /**
     * Update the assessment
     */
    public function update(Request $request, Assessment $assessment)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'cobit_items' => 'required|array|min:1',
            'cobit_items.*' => 'exists:cobit_items,id',
        ]);

        $assessment->update([
            'name' => $request->name,
        ]);

        // Sync CobitItems
        $assessment->items()->delete();
        foreach ($request->cobit_items as $cobitItemId) {
            AssessmentItem::create([
                'assessment_id' => $assessment->id,
                'cobit_item_id' => $cobitItemId,
            ]);
        }

        return redirect()->route('admin.assessments.show', $assessment)
            ->with('success', 'Assessment berhasil diperbarui.');
    }

    /**
     * Approve an assessment (for user submissions if still exists)
     */
    public function approve(Request $request, Assessment $assessment)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($assessment->status !== Assessment::STATUS_PENDING_APPROVAL) {
            return back()->with('error', 'Assessment ini tidak dalam status menunggu persetujuan.');
        }

        $previousStatus = $assessment->status;

        $assessment->update([
            'status' => Assessment::STATUS_APPROVED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        // Send email notification
        try {
            Mail::to($assessment->user->email)->send(new AssessmentStatusChanged($assessment, $previousStatus));
        } catch (\Exception $e) {
            \Log::error('Failed to send assessment approval email: ' . $e->getMessage());
        }

        return redirect()->route('admin.assessments.index')
            ->with('success', 'Assessment berhasil disetujui.');
    }

    /**
     * Reject an assessment
     */
    public function reject(Request $request, Assessment $assessment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        if ($assessment->status !== Assessment::STATUS_PENDING_APPROVAL) {
            return back()->with('error', 'Assessment ini tidak dalam status menunggu persetujuan.');
        }

        $previousStatus = $assessment->status;

        $assessment->update([
            'status' => Assessment::STATUS_REJECTED,
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Send email notification
        try {
            Mail::to($assessment->user->email)->send(new AssessmentStatusChanged($assessment, $previousStatus));
        } catch (\Exception $e) {
            \Log::error('Failed to send assessment rejection email: ' . $e->getMessage());
        }

        return redirect()->route('admin.assessments.index')
            ->with('success', 'Assessment berhasil ditolak.');
    }

    /**
     * Remove the assessment
     */
    public function destroy(Assessment $assessment)
    {
        $assessment->delete();

        return redirect()->route('admin.assessments.index')
            ->with('success', 'Assessment berhasil dihapus.');
    }
}
