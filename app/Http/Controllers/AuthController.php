<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form or process login
     */
    public function login(Request $request)
    {
        // If POST request - process login
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Attempt login
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // If GET request - show login form
        return view('auth.login');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}