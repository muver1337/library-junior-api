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

    public function index(array $filters = [], int $perPage = 10, bool $withGenres = true)
    {
        $query = Book::with('author');

        if ($withGenres) {
            $query->with('genre');
        }

        $query->filterTitle($filters['title'] ?? null)
            ->filterAuthor($filters['author_id'] ?? null)
            ->filterGenre($filters['genre_id'] ?? null)
            ->filterCreatedFrom($filters['created_from'] ?? null)
            ->filterCreatedTo($filters['created_to'] ?? null)
            ->sortTitle($filters['sort_by'] ?? null);

        $books = $query->paginate($perPage);

        $books->getCollection()->transform(function ($book) use ($withGenres) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'user_id' => $book->author ? $book->author->id : null,
                'genre_id' => $withGenres && $book->genre ? $book->genre->id : null,
                'created_at' => $book->created_at->toDateTimeString(),
            ];
        });

        return $books;
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
