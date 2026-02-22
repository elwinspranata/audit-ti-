<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // search
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('name', 'LIKE', "%{$term}%")
                  ->orWhere('email','LIKE', "%{$term}%");
            });
        }

        // filter by role (optional)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at','desc')
                       ->paginate(10)
                       ->appends($request->only(['search','role']));

        return view('admin.users.index', compact('users'));
    }

    // public function create()
    // {
    //     // kalau mau dropdown role, kirim list role
    //     $roles = ['admin','user'];
    //     return view('admin.users.create', compact('roles'));
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'role'     => 'required|in:admin,user',
        ]);

        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return redirect()->route('users.index')
                         ->with('success','User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $roles = ['admin','user'];
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|confirmed|min:8',
            'role'     => 'required|in:admin,user',
        ]);

        if ($data['password'] ?? false) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')
                         ->with('success','User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        // misal kita pakai soft delete, atau jika tidak:
        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('success','User berhasil dihapus.');
    }
}
