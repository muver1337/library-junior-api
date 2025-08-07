<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Auth\Access\AuthorizationException;

class BookService
{
    public function deleteBook(int $bookId, int $userId): void
    {
        $book = Book::find($bookId);

        if (!$book) {
            abort(404, 'Книга не найдена');
        }

        if ($book->user_id !== $userId) {
            throw new AuthorizationException('Нет доступа к удалению этой книги');
        }

        $book->delete();
    }
}
