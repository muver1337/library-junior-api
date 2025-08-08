<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Auth\Access\AuthorizationException;

class BookService
{
    public function destroy(int $bookId, int $userId, string $role): void
    {
        $book = Book::find($bookId);

        if (!$book) {
            abort(404, 'Книга не найдена');
        }

        if ($role !== 'admin' && $book->user_id !== $userId) {
            throw new AuthorizationException('Нет доступа к удалению этой книги');
        }

        $book->delete();
    }

    public function index($withGenres = false, $perPage = 10)
    {
        $query = Book::with(['author:id,name']);

        if ($withGenres) {
            $query->with(['genre:id,name']);
        }

        return $query
            ->orderBy('title', 'desc')
            ->paginate($perPage)
            ->through(function ($book) use ($withGenres) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author ? $book->author->name : null,
                    'genre' => $withGenres && $book->genre ? $book->genre->name : null,
                    'created_at' => $book->created_at->format('Y-m-d H:i:s'),
                ];
            });
    }

    public function show(int $id)
    {
        $book = Book::with(['author:id,name', 'genre:id,name', 'bookType:id,name'])
            ->findOrFail($id);

        return [
            'id' => $book->id,
            'title' => $book->title,
            'description' => $book->description,
            'created_at' => $book->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $book->updated_at->format('Y-m-d H:i:s'),
            'author' => $book->author ? $book->author->name : null,
            'genre' => $book->genre ? $book->genre->name : null,
            'book_type' => $book->bookType ? $book->bookType->name : null,
        ];
    }
}
