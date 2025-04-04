<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller

    {
        public function updatePassword(Request $request)
        {
            // Check if user is logged in
            if (!Auth::check()) {
                return redirect()->route('login')->withErrors(['error' => 'You must be logged in to change your password.']);
            }
    
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);
    
            $user = Auth::user(); // Get the logged-in user
    
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
    
            // Update password in users table
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            return back()->with('success', 'Password updated successfully.');
        }
    }
    


