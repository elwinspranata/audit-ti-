<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan autentikasi yang masuk.
     * Di sinilah kita menambahkan logika custom.
     */
    // app/Http/Controllers/Auth/AuthenticatedSessionController.php

public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $user = $request->user();


    // Kode di bawah ini tidak akan dieksekusi untuk sementara
    if (!$user->is_approved) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->withErrors([
            'email' => 'Akun Anda belum disetujui oleh admin. Mohon tunggu.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    if ($user->role == 'admin') {
        return redirect()->intended('/admin/dashboard');
    }

    return redirect()->intended(RouteServiceProvider::HOME);
}

    /**
     * Menghancurkan sesi autentikasi (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
