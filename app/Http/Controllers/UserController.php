<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('orders')->latest()->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount('orders');
        $orders = $user->orders()->latest()->paginate(5);

        return view('pages.users.show', compact('user', 'orders'));
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $action = $user->is_active ? 'unsuspended' : 'suspended';

        return back()->with('success', "User {$action} successfully.");
    }
}
