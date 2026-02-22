<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CobitItem;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
{
    $usersCount = User::count();
    $pendingApprovals = User::where('is_approved', false)->count();
    $cobitItemsCount = CobitItem::count();


    return view('admin.dashboard', compact('usersCount', 'pendingApprovals', 'cobitItemsCount'));
}

}
