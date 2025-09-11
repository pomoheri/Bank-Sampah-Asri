<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    } //

    // public function redirectToDashboard()
    // {
    //     $user = Auth::user();

    //     if ($user->hasRole('admin')) {
    //         return redirect()->route('admin.dashboard');
    //     } 

    //     if ($user->hasRole('nasabah')) {
    //         return redirect()->route('nasabah.dashboard');
    //     }

    //     // Fallback untuk user tanpa role yang dikenali
    //     Auth::logout();
    //     return redirect('/login')->with('error', 'Role tidak dikenali. Silahkan login kembali.');
    // }
}
