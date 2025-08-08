<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Book;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    public function index(?User $user): bool
    {
        return true;
    }

    public function show(?User $user, Book $book): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'author']);
    }

    public function update(User $user, Book $book): bool
    {
        return $user->role === 'admin' || ($user->role === 'author' && $user->id === $book->user_id);
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->role === 'admin' || ($user->role === 'author' && $user->id === $book->user_id);
    }
}
