<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Dapatkan pengguna yang sedang login
        $user = Auth::user();

        // 2. Periksa apakah peran pengguna ada di dalam daftar peran yang diizinkan
        if ($user && in_array($user->role, $roles)) {
            // 3. Jika diizinkan, lanjutkan ke halaman berikutnya
            return $next($request);
        }

        // 4. Jika tidak diizinkan, logout paksa dan kembalikan ke halaman login dengan pesan error
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('error', 'Anda tidak memiliki hak akses untuk halaman ini.');
    }
}