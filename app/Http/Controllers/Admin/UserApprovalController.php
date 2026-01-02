<?php
// app/Http/Controllers/Admin/UserApprovalController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('is_approved', false)->get();
        return view('admin.approvals.index', compact('pendingUsers'));
    }

    public function approve(User $user)
    {
        if (!$user->is_approved) {
            $user->is_approved = true;
            $user->email_verified_at = now();
            $user->save();
        }
        return redirect()->route('admin.approvals.index')->with('success', 'User ' . $user->name . ' has been approved.');
    }

    /**
     * Reject and delete a pending user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(User $user)
    {
        $userName = $user->name;
        $user->delete(); // <-- INTI LOGIKA: HAPUS USER DARI DATABASE

        return redirect()->route('admin.approvals.index')->with('success', 'User ' . $userName . ' has been rejected.');
    }
}
