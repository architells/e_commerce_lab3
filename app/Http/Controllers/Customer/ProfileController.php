<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('customer.profile.dashboard', compact('user'));
    }

    public function update(Request $request, string $user_id)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user_id . ',user_id', // Corrected validation rule
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($user_id);
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('customer.profile.dashboard', $user_id)->with('success', 'Profile updated successfully.');
    }
}
