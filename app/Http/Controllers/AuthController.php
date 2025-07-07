<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman form login
     */
    public function showLoginForm()
    {
        return view('sesi.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Regenerate session untuk mencegah session fixation
            $request->session()->regenerate();

            // Redirect ke dashboard, atau ke intended URL jika ada
            return redirect()->intended('/home/dashboard');
        }

        // Kembali ke form login dengan error
        return back()->withErrors([
            'email' => 'Email atau Password salah',
        ])->withInput();
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidasi session dan token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
