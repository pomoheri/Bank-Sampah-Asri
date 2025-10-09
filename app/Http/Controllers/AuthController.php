<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Session\Session;

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
                return redirect()->intended('/dashboard'); // Redirect to dashboard for nasabah
            } else {
                return redirect()->intended('/dashboard'); // Redirect to dashboard for other roles
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
    
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role'     => 'nasabah',
            'status'   => 'active'
        ]);

        Nasabah::create([
            'nama_nasabah' => $request->name,
            'no_hp'        => $request->phone,
            'user_id'      => $user->id
        ]);
        
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
