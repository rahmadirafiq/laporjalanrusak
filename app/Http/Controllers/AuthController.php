<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function showLogin() {
        if (Auth::check()) return redirect()->route('landing');
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('landing')->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function showRegister() {
        if (Auth::check()) return redirect()->route('landing');
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users',
            'phone'                 => 'required|string|max:20',
            'kelurahan'             => 'required|string',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'kelurahan' => $request->kelurahan,
            'password'  => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('landing')->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '!');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil keluar.');
    }
}