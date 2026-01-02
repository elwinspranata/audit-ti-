<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Show the list of users awaiting approval
    public function showApprovals()
    {
        // Get all users who are not approved yet (approved == 0)
        $users = User::where('approved', 0)->get();

        // Return the approvals view with the users data
        return view('admin.approvals', compact('users'));
    }

    // Approve a user
    public function approveUser($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Set the approved field to 1 (approved)
        $user->approved = 1;
        $user->save();

        // Redirect back with a success message
        return redirect()->route('admin.approvals')->with('status', 'User approved successfully!');
    }
}
