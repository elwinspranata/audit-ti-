<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'package'])->latest()->get();
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
        
        // Jika Admin menyetujui secara manual, kita anggap pembayaran sudah 'paid' 
        // Ini berguna jika callback Midtrans tidak masuk (misal di localhost)
        if ($request->admin_status === 'approved') {
            $transaction->payment_status = 'paid';
        }
        
        $transaction->save();

        // Refresh to get updated values
        $transaction->refresh();
        $transaction->loadMissing(['user', 'package']);

        // Aktifkan subscription
        if ($transaction->admin_status === 'approved' && $transaction->payment_status === 'paid') {
            \Illuminate\Support\Facades\Log::info('Activating subscription for user via Admin Approval', [
                'user_id' => $transaction->user->id,
                'package' => $transaction->package->name,
            ]);
            $transaction->user->activateSubscription($transaction->package);
        }

        return redirect()->route('admin.payments.index')->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
