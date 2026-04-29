<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // tampilin halaman login
    public function login()
    {
        return view('auth.login');
    }

    // tampilin halaman register
    public function register()
    {
        return view('auth.register');
    }

    // proses register user baru
    public function registerProcess(Request $request)
    {
        // validasi input dari form register
        $request->validate([
            'name' => 'required|min:3|max:40',
            'email' => ['required', 'email', 'unique:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'nomor_hp' => ['required', 'regex:/^08[0-9]+$/'],
            'password' => 'required|min:6|max:12'
        ], [
            // pesan error custom biar lebih jelas
            'name.min' => 'Nama minimal 3 huruf ya!',
            'name.max' => 'Nama maksimal 40 huruf ya!',
            'email.regex' => 'Email harus pakai @gmail.com!',
            'email.unique' => 'Email ini sudah terdaftar!',
            'nomor_hp.regex' => 'Nomor HP harus diawali dengan 08!',
            'password.min' => 'Password minimal 6 huruf!',
            'password.max' => 'Password maksimal 12 huruf!',
        ]);

        // simpan user baru ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'role' => 'user', // default role user biasa
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // proses login
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // coba login pake email dan password
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // cek rolenya, kalo admin arahkan ke dashboard admin
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            // kalo user biasa, arahkan ke katalog
            return redirect('/');
        }

        // kalo gagal login, kasih pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah!'
        ])->withInput($request->only('email'));
    }

    // proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
