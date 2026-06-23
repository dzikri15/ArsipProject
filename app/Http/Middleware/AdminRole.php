<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Akses ditolak. Hanya admin yang dapat mengakses resource ini.'], 403);
        }

        return $next($request);
    }
}
