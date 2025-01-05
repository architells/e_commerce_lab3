<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminProfileController extends Controller
{


    public function edit()
    {
        $admin = Auth::user(); // Assuming the admin is authenticated
        return view('admin.profile.dashboard', compact('admin'));
    }

    /**
     * Update the admin profile.
     */
    public function update(Request $request, $user_id)
    {
        // Validate that the user exists
        $user = User::findOrFail($user_id);

        // Validate the incoming data
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user_id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user profile
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;

        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Redirect back with a success message
        return redirect()->route('admin.profile.dashboard')->with('success', 'Profile updated successfully.');
    }
}
