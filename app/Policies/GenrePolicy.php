<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Genre;
use Illuminate\Auth\Access\HandlesAuthorization;

class GenrePolicy
{
    use HandlesAuthorization;

    public function index(?User $user): bool
    {
        return true;
    }

    public function show(?User $user, Genre $genre): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Genre $genre): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Genre $genre): bool
    {
        return $user->role === 'admin';
    }
}
