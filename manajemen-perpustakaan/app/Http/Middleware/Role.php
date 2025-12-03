<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            return match ($user->role) {
                'admin'     => redirect('/admin/dashboard'),
                'pegawai'   => redirect('/pegawai/dashboard'),
                'mahasiswa' => redirect('/mahasiswa/dashboard'),
                default     => abort(403, 'Akses ditolak!')
            };
        }

        return $next($request);
    }
}
