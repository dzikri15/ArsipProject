<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');
        if (!$user || $user['role'] !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk Admin.');
        }
        return $next($request);
    }
}
