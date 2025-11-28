<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('username', 'password');

        // Coba Login sebagai Admin
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        // Coba Login sebagai Kasir
        if (Auth::guard('kasir')->attempt($credentials)) {
            return redirect()->intended('/kasir/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function logout() {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('kasir')->check()) {
            Auth::guard('kasir')->logout();
        }
        return redirect('/');
    }
}