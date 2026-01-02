<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Midtrans config
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized');
        Config::$is3ds = (bool) config('services.midtrans.is_3ds');
    }

    // 1. Halaman daftar paket
    public function index()
    {
        $packages = Package::all();
        return view('payment.pricing', compact('packages'));
    }

    // 2. Proses checkout
    public function checkout(Package $package)
    {
        $user = auth()->user();

        // Cek apakah user masih aktif (Dinonaktifkan agar bisa test berkali-kali)
        /*
        if ($user->subscription_status === 'active' && $user->subscription_end && $user->subscription_end->isFuture()) {
            return redirect()->route('audit.index')
                ->with('info', 'Anda masih memiliki subscription aktif hingga ' . $user->subscription_end->format('d M Y'));
        }
        */

        // Cari transaksi pending untuk paket ini
        $pending = Transaction::where('user_id', $user->id)
            ->where('package_id', $package->id)
            ->where('payment_status', 'pending')
            ->first();

        if ($pending) {
            // Pastikan relasi dimuat
            $pending->loadMissing(['user', 'package']);

            if (empty($pending->snap_token)) {
                try {
                    $this->generateSnapToken($pending, $package, $user);
                } catch (\Exception $e) {
                    Log::error('Failed to regenerate snap token', [
                        'transaction_id' => $pending->id,
                        'error' => $e->getMessage()
                    ]);
                    // Jika gagal, hapus transaksi pending agar user bisa coba lagi
                    $pending->delete();
                    return back()->with('error', 'Gagal memproses ulang pembayaran. Silakan coba lagi.');
                }
            }

            return redirect()->route('payment.show', $pending);
        }

        // Buat transaksi baru (gunakan DB transaction untuk safety)
        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                // lebih unik daripada time()
                'transaction_code' => 'TRX-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6)),
                'amount' => $package->price,
                'payment_status' => 'pending',
                'admin_status' => 'pending',
            ]);

            // generate snap token
            $this->generateSnapToken($transaction, $package, $user);

            DB::commit();

            return redirect()->route('payment.show', $transaction);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create transaction', [
                'user_id' => $user->id,
                'package_id' => $package->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    // Generate Snap Token Midtrans (mengembalikan token)
    private function generateSnapToken(Transaction $transaction, Package $package, $user)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->transaction_code,
                'gross_amount' => (int) $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $package->id,
                    'price' => (int) $package->price,
                    'quantity' => 1,
                    'name' => $package->name,
                ],
            ],
            'enabled_payments' => ['credit_card', 'bca_va', 'bni_va', 'bri_va', 'permata_va', 'gopay', 'qris'],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Snap token generation failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    // 3. Halaman pembayaran (show)
    public function show(Transaction $transaction)
    {
        // Pastikan pemilik
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        // Load relasi penting
        $transaction->loadMissing(['package', 'user']);

        if ($transaction->payment_status === 'pending' && empty($transaction->snap_token)) {
            try {
                $this->generateSnapToken($transaction, $transaction->package, $transaction->user);
            } catch (\Exception $e) {
                Log::error('Failed to regenerate snap token in show', [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage()
                ]);
                return redirect()->route('pricing.index')
                    ->with('error', 'Terjadi kesalahan pada transaksi ini.');
            }
        }

        return view('payment.show', compact('transaction'));
    }

    // 4. Callback Midtrans (webhook)
    public function callback(Request $request)
    {
        Log::info('Midtrans Callback Received', $request->all());

        // Jika production, periksa IP Midtrans (optional)
        if (config('services.midtrans.is_production')) {
            $allowedIPs = [
                '103.127.16.0/23',
                '103.127.18.0/23',
                '103.208.23.0/24',
                '103.208.23.6',
            ];

            $clientIP = $request->ip();
            $isAllowed = false;

            foreach ($allowedIPs as $range) {
                if ($this->ipInRange($clientIP, $range)) {
                    $isAllowed = true;
                    break;
                }
            }

            if (!$isAllowed) {
                Log::warning('Unauthorized callback attempt', ['ip' => $clientIP]);
                // Kembalikan 200 agar Midtrans tidak terus retry, namun log/alert untuk investigasi
                return response()->json(['message' => 'Unauthorized'], 200);
            }
        }

        $serverKey = config('services.midtrans.server_key');

        // Pastikan fields ada
        if (! $request->has(['order_id', 'status_code', 'gross_amount', 'signature_key'])) {
            Log::warning('Midtrans callback missing fields', $request->all());
            return response()->json(['message' => 'Bad Request'], 200);
        }

        // Validasi signature
        $signature = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signature !== (string) $request->signature_key) {
            Log::warning('Invalid signature', [
                'order_id' => $request->order_id,
                'expected' => $signature,
                'received' => $request->signature_key
            ]);
            // jangan beri 4xx agar Midtrans tidak retry terus-menerus
            return response()->json(['message' => 'Invalid signature'], 200);
        }

        // Cari transaksi
        $transaction = Transaction::where('transaction_code', $request->order_id)->first();

        if (! $transaction) {
            Log::error('Transaction not found', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Transaction not found'], 200);
        }

        $oldStatus = $transaction->payment_status;

        // Tangani status
        switch ($request->transaction_status) {
            case 'capture':
                // CC capture (periksa fraud)
                $fraudStatus = $request->fraud_status ?? 'accept';
                if ($fraudStatus === 'accept') {
                    $transaction->payment_status = 'paid';
                    // $this->activateSubscription($transaction); // Removed: Must be verified by Admin first
                } elseif ($fraudStatus === 'challenge') {
                    $transaction->payment_status = 'challenge';
                    // jangan aktifkan subscription sebelum manual verify
                } else {
                    $transaction->payment_status = 'cancelled';
                }
                break;

            case 'settlement':
                $transaction->payment_status = 'paid';
                // $this->activateSubscription($transaction); // Removed: Must be verified by Admin first
                break;

            case 'pending':
                $transaction->payment_status = 'pending';
                break;

            case 'deny':
                $transaction->payment_status = 'denied';
                break;

            case 'cancel':
                $transaction->payment_status = 'cancelled';
                break;

            case 'expire':
                $transaction->payment_status = 'expired';
                break;

            default:
                Log::warning('Unknown transaction status', [
                    'status' => $request->transaction_status,
                    'order_id' => $request->order_id
                ]);
        }

        $transaction->save();

        Log::info('Transaction status updated', [
            'order_id' => $request->order_id,
            'old_status' => $oldStatus,
            'new_status' => $transaction->payment_status
        ]);

        return response()->json(['message' => 'Callback processed'], 200);
    }

    // Aktivasi Subscription (Removed: Moved to User model)
    // private function activateSubscription(Transaction $transaction) { ... }

    // Helper: Check IP in range (CIDR support)
    private function ipInRange($ip, $range)
    {
        if (strpos($range, '/') === false) {
            return $ip === $range;
        }

        list($subnet, $mask) = explode('/', $range);
        $ipLong = ip2long($ip);
        $subnetLong = ip2long($subnet);

        if ($ipLong === false || $subnetLong === false) {
            return false;
        }

        $mask = (int) $mask;
        $maskLong = (~((1 << (32 - $mask)) - 1)) & 0xFFFFFFFF;

        return (($ipLong & $maskLong) === ($subnetLong & $maskLong));
    }

    // 5. History transaksi user
    public function history()
    {
        $transactions = Transaction::with('package')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('payment.history', compact('transactions'));
    }

    // 6. Verifikasi Admin (manual)
    public function verifyByAdmin($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->payment_status !== 'paid') {
            $transaction->payment_status = 'paid';
        }

        if ($transaction->admin_status === 'verified') {
            return back()->with('info', 'Transaksi sudah diverifikasi sebelumnya.');
        }

        $transaction->admin_status = 'verified';
        $transaction->save();

        // Aktifkan subscription jika belum aktif
        if ($transaction->user->subscription_status !== 'active') {
            $transaction->user->activateSubscription($transaction->package);
        }

        return back()->with('success', 'Transaksi berhasil diverifikasi dan subscription diaktifkan.');
    }

    // Tambahan: endpoint pay() agar AJAX frontend dapat meminta snap token
    public function pay($id)
    {
        $transaction = Transaction::with(['package', 'user'])->findOrFail($id);

        if ($transaction->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($transaction->payment_status !== 'pending') {
            return response()->json(['message' => 'Transaksi tidak dalam status pending'], 400);
        }

        if (empty($transaction->snap_token)) {
            try {
                $snap = $this->generateSnapToken($transaction, $transaction->package, $transaction->user);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Gagal membuat snap token', 'error' => $e->getMessage()], 500);
            }
        } else {
            $snap = $transaction->snap_token;
        }

        return response()->json(['snap_token' => $snap]);
    }
}
