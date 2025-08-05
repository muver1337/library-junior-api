<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAuthor
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || $request->user()->role !== 'author') {
            return response()->json(['message' => 'Access Denied. Authors and admins only.'], 403);
        }

        return $next($request);
    }
}
