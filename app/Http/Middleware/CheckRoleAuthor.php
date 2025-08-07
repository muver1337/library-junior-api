<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleAuthor
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()?->role !== 'author') {
            return response()->json([
                'message' => 'Access denied. Not an author.'
            ], 403);
        }

        return $next($request);
    }
}
