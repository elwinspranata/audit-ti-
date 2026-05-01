<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewUserForApproval;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    Log::info('--- Proses Registrasi Dimulai ---');

    $validatedData = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'string', 'in:admin,user'],
    ]);
    Log::info('Validasi berhasil untuk email: ' . $validatedData['email']);

    $isApproved = ($request->email === 'admin@example.com');

    $newUser = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'is_approved' => $isApproved,
    ]);
    Log::info('User baru berhasil dibuat dengan ID: ' . $newUser->id . ' dan Role: ' . $newUser->role . ' | is_approved: ' . ($isApproved ? 'true' : 'false'));

    if (!$isApproved) {
        Log::info('User memerlukan persetujuan, mencoba mengirim email notifikasi ke admin.');

        // Kirim notifikasi ke admin utama atau semua admin yang sudah disetujui
        $admins = User::where('role', 'admin')->where('is_approved', true)->get();
        Log::info('Menemukan ' . $admins->count() . ' admin untuk dikirimi notifikasi.');

        if ($admins->isNotEmpty()) {
            foreach ($admins as $admin) {
                Log::info('Mengirim email ke admin: ' . $admin->email);
                try {
                    Mail::to($admin->email)->send(new NewUserForApproval($newUser));
                    Log::info('Email berhasil dimasukkan ke antrian untuk dikirim ke ' . $admin->email);
                } catch (\Exception $e) {
                    Log::error('GAGAL mengirim email ke ' . $admin->email . '. Error: ' . $e->getMessage());
                }
            }
        } else {
            Log::warning('Tidak ada admin yang ditemukan, email tidak dikirim.');
        }
    }

    Log::info('--- Proses Registrasi Selesai, mengarahkan ke halaman pending ---');
    return redirect()->route('registration.pending');
}
}
