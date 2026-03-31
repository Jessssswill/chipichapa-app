<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TolakUserBiasa
{
    public function handle(Request $request, Closure $next){
        if (Auth::check()) {
            return redirect('/')->with('error', 'Akses ditolak! Anda bukan Admin.');
        }

        return $next($request);
    }
}