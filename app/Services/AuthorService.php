<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthorService
{
    public function getAuthorsList()
    {
        return User::where('role', 'author')
            ->withCount('books')
            ->paginate(10);
    }

    public function getAuthorById(int $id)
    {
        return User::where('role', 'author')
            ->with('books')
            ->findOrFail($id);
    }

    public function createAuthor(array $data)
    {
        $data['role'] = 'author';
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function updateAuthor(int $id, array $data)
    {
        $author = User::where('role', 'author')->findOrFail($id);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $author->update($data);
        return $author;
    }

    public function deleteAuthor(int $id)
    {
        $author = User::where('role', 'author')->findOrFail($id);
        $author->delete();
    }
}
