<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TolakUserBiasa
{
    public function handle(Request $request, Closure $next)
    {
        // cek dulu usernya udah login belom
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login dulu ya!');
        }

        // kalo udah login, cek rolenya admin atau bukan
        if (Auth::user()->role !== 'admin') {
            // kalo bukan admin, tendang balik ke halaman katalog
            return redirect('/')->with('error', 'Akses ditolak! Kamu bukan Admin.');
        }

        // kalo admin, lanjut aja
        return $next($request);
    }
}