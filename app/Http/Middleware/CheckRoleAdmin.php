<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()?->role !== 'admin') {
            return response()->json([
                'message' => 'Access denied. Admins only.'
            ], 403);
        }

        return $next($request);
    }
}
