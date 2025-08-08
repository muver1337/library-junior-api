<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthorsController extends Controller
{
    public function index()
    {
        return User::where('role', 'author')
            ->withCount('books')
            ->paginate(10);
    }

    public function show(int $id)
    {
        return User::with('books')->where('role', 'author')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'bio' => 'nullable|string',
        ]);

        $author = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'author',
            'bio' => $data['bio'] ?? null,
        ]);

        return response()->json($author, 201);
    }

    public function update(Request $request, int $id)
    {
        $author = User::where('role', 'author')->findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($author->id)],
            'password' => 'sometimes|nullable|string|min:6',
            'bio' => 'nullable|string',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $author->update($data);

        return response()->json($author);
    }

    public function destroy(int $id)
    {
        $author = User::where('role', 'author')->findOrFail($id);
        $author->delete();

        return response()->json(['message' => 'Автор успешно удален']);
    }
}
