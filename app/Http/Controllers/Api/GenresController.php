<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenresController extends Controller
{
    // Получение всех жанров
    public function index()
    {
        return Genre::withCount('books')->paginate(10);
    }

    // Добавление жанра
    public function store(Request $request)
    {
        $this->authorize('create', Genre::class);
        $data = $request->validate([
            'name' => 'required|string|unique:genres,name',
        ]);
        $genre = Genre::create($data);
        return response()->json([
            'message' => 'Жанр успешно создан',
            'data' => $genre,
        ], 201);
    }

    // Получение жанра по ID
    public function show(int $id)
    {
        $genre = Genre::with('books')->findOrFail($id);
        return response()->json($genre);
    }

    // Обновление жанра
    public function update(Request $request, int $id)
    {
        $genre = Genre::findOrFail($id);
        $this->authorize('update', $genre);
        $data = $request->validate([
            'name' => 'required|string|unique:genres,name,' . $id,
        ]);
        $genre->update($data);
        return response()->json([
            'message' => 'Жанр успешно обновлен',
            'data' => $genre,
        ]);
    }

    // Удаление жанра
    public function destroy(int $id)
    {
        $genre = Genre::findOrFail($id);
        $this->authorize('delete', $genre);
        $genre->delete();
        return response()->json(['message' => 'Жанр успешно удален']);
    }
}
