<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // Cek 1: User login?
        // Cek 2: User punya secret 2FA? (Sudah mengaktifkan?)
        if ($user && $user->google2fa_secret) {

            // Cek 3: Apakah sesi ini sudah terverifikasi?
            if (!session()->has('2fa_verified')) {
                // Jika belum, lempar ke halaman verifikasi
                return redirect()->route('2fa.verify');
            }
        }

        return $next($request);
    }
}
