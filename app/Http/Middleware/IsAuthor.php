<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Book;

class IsAuthor
{
    public function handle(Request $request, Closure $next)
    {
        $bookId = $request->route('id');
        $user = auth()->user();

        $isAuthor = Book::where('id', $bookId)
            ->where('author_id', $user->id)
            ->exists();

        if (!$isAuthor) {
            return response()->json([
                'message' => 'Access Denied. You are not the author of this book.'
            ], 403);
        }

        return $next($request);
    }
}
