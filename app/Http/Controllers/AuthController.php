<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/dashboard'); // Ubah '/dashboard' sesuai dengan halaman setelah login
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak cocok..'
        ]);

    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}