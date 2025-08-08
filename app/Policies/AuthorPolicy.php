<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
{
    use HandlesAuthorization;

    public function index(?User $user): bool
    {
        return true;
    }

    public function show(?User $user, User $author): bool
    {
        return $author->role === 'author';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, User $author): bool
    {
        return $user->role === 'admin' || $user->id === $author->id;
    }

    public function delete(User $user, User $author): bool
    {
        return $user->role === 'admin';
    }
}
