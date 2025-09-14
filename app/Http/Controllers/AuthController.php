<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // dd($request->all()); // Debugging line to check the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'remember' => 'boolean',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            if (Auth::user()->role == 'nasabah') {
                return redirect()->intended('/NasabahDashboard'); // Redirect to dashboard for nasabah
            } else {
                return redirect()->intended('/AdminDashboard'); // Redirect to dashboard for other roles
            }
            //dd($request->all());
        }
        // If login fails, redirect back with an error message
        return back()->with('failed', 'email atau password salah');
    }
    public function logout(Request $request)
    {
         Auth::logout(); // logout user

        $request->session()->invalidate(); // hapus semua data session
        $request->session()->regenerateToken();
        return redirect('/login'); // Redirect to login page
    }
    //
}
