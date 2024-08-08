<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // If successful, return a success message
            return response()->json(['message' => 'Login successful']);
        }

        // If authentication fails, return an error message
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function getUsername()
    {
        if (auth()->check()) {
            $username = auth()->user()->username;
            \Log::info('Fetched Username: ' . $username);
            return response()->json(['username' => $username]);
        } else {
            \Log::info('Username not found, user not authenticated.');
            return response()->json(['username' => null]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout successful']);
    }
}
