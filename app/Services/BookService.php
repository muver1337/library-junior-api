<?php

namespace App\Services;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookService
{
    public function destroy(int $bookId, User $user): void
    {
        $book = Book::find($bookId);

        if (!$book) {
            abort(404, 'Книга не найдена');
        }

        if ($user->role !== 'admin' && $book->user_id !== $user->id) {
            throw new AuthorizationException('Нет доступа к удалению этой книги');
        }

        $book->delete();
    }

    public function index(array $filters = [], int $perPage = 10, bool $withGenres = true)
    {
        $query = Book::with('user');

        if ($withGenres) {
            $query->with('genre');
        }

        $query->filterTitle($filters['title'] ?? null)
            ->filterAuthor($filters['user_id'] ?? null)
            ->filterGenre($filters['genre_id'] ?? null)
            ->filterCreatedFrom($filters['created_from'] ?? null)
            ->filterCreatedTo($filters['created_to'] ?? null)
            ->sortTitle($filters['sort_by'] ?? null);

        $books = $query->paginate($perPage);

        $books->getCollection()->transform(function ($book) use ($withGenres) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'user_id' => $book->user->name,
                'genre_id' => $withGenres && $book->genre ? $book->genre->id : null,
                'created_at' => $book->created_at->toDateTimeString(),
            ];
        });

        return $books;
    }

    public function show(int $id)
    {
        $book = Book::with(['user:id,name', 'genre:id,name', 'bookType:id,name'])
            ->findOrFail($id);

        return [
            'id' => $book->id,
            'title' => $book->title,
            'description' => $book->description,
            'created_at' => $book->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $book->updated_at->format('Y-m-d H:i:s'),
            'author' => $book->user->name,
            'genre' => $book->genre ? $book->genre->name : null,
            'book_type' => $book->bookType ? $book->bookType->name : null,
        ];
    }
    public function storeBook(array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|unique:books|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'genre_id' => 'required|exists:genres,id',
            'book_type_id' => 'required|exists:book_types,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $book = Book::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'user_id' => $data['user_id'],
            'genre_id' => $data['genre_id'] ?? null,
            'book_type_id' => $data['book_type_id'] ?? null,
        ]);

        return $book;
    }

    public function updateBook(int $id, array $data, $user)
    {
        $book = Book::findOrFail($id);

        $role = $user->role ?? 'user';
        if ($role !== 'admin' && $book->user_id !== $user->id) {
            throw new AuthorizationException('Нет доступа к обновлению этой книги');
        }

        $validator = Validator::make($data, [
            'title' => 'required|string|max:255|unique:books,title,' . $id,
            'description' => 'nullable|string',
            'genre_id' => 'nullable|exists:genres,id',
            'book_type_id' => 'nullable|exists:book_types,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $book->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? $book->description,
            'genre_id' => $data['genre_id'] ?? $book->genre_id,
            'book_type_id' => $data['book_type_id'] ?? $book->book_type_id,
        ]);

        return $book;
    }
}
