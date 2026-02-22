<?php

namespace App\Http\Controllers;

use App\Mail\NewUserForApproval;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'approved' => 0,
            'role'     => $data['role'],      // ← tambahkan ini
        ]);
    }

    public function register(Request $request)
    {
        // Validate form, termasuk role
        $validated = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','string','email','max:255','unique:users'],
            'password' => ['required','string','min:8','confirmed'],
            'role'     => ['required','in:admin,user'],  // ← tambahkan ini
        ]);

        // Buat user baru
        $user = $this->create($validated);

        try {
            Mail::to(env('ADMIN_EMAIL_ADDRESS'))
                ->send(new NewUserForApproval($user));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email approval: '.$e->getMessage());
        }

        return redirect()->route('registration.pending');
    }
}
