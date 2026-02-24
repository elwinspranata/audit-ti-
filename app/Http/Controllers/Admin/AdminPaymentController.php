<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'package', 'coupon'])->latest()->get();
        return view('admin.payment.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        return view('admin.payment.show', compact('transaction'));
    }

    public function verify(Request $request, Transaction $transaction)
    {
        $request->validate([
            'admin_status' => 'required|in:approved,rejected,pending',
        ]);

        // Update status admin
        $transaction->admin_status = $request->admin_status;
        
        // Option: If it's a manual transfer, admin might want to mark as paid too
        // But for Midtrans, we usually wait for the actual status.
        // We'll keep a fallback or a way for admin to force it if needed.
        // For now, let's allow admin to set it to paid if they are sure.
        if ($request->admin_status === 'approved' && $transaction->payment_status !== 'paid') {
            // Log it but maybe don't force it if we want strict decoupling
            // However, typical user flow: Admin sees proof -> Admin approves -> System should treat as paid.
            $transaction->payment_status = 'paid';
        }
        
        $transaction->save();

        // Refresh and load relations
        $transaction->load(['user', 'package']);

        // Aktifkan subscription
        if ($transaction->admin_status === 'approved' && $transaction->payment_status === 'paid') {
            \Illuminate\Support\Facades\Log::info('Activating subscription for user via Admin Approval', [
                'user_id' => $transaction->user->id,
                'package' => $transaction->package->name,
            ]);
            $transaction->user->activateSubscription($transaction->package);
        }

        return redirect()->route('admin.payments.index')->with('success', 'Status verifikasi admin berhasil diperbarui.');
    }
}
