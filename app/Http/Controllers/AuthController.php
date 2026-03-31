<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //login form
    public function login(){
        return view('auth.login');
    }

    //register form
    public function register(){
        return view('auth.register');
    }

    //proses register
    public function registerProcess(Request $request){
        $request->validate([
            'name' => 'required|min:3|max:40',
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'nomor_hp' => ['required', 'starts_with:08'],
            'password' => 'required|min:6|max:12'
        ]);
        
        //validasi register
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'nomor_hp' => $request->nomor_hp,
        'password' => Hash::make($request->password)
    ]);
    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    //proses login
    public function loginProcess(Request $request){
        $credendials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credendials)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!'
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

}
