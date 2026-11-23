<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.index', ['users' => User::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['receptionist', 'admin'])],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = User::create($data + ['is_active' => true]);
        ActivityLog::record('staff_created', "Created {$user->role} account for {$user->email}");

        return back()->with('status', "Account created for {$user->name}.");
    }

    public function toggle(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['staff' => 'You cannot deactivate your own account.']);
        }

        $user->update(['is_active' => ! $user->is_active]);
        ActivityLog::record('staff_toggled', ($user->is_active ? 'Activated' : 'Deactivated')." account {$user->email}");

        return back()->with('status', 'Account updated.');
    }
}
