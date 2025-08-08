<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BookService $service)
    {
        $filters = $request->only(['title', 'user_id', 'genre_id', 'created_from', 'created_to', 'sort_by']);
        $perPage = $request->get('per_page', 10);
        $books = $service->index($filters, $perPage, true);

        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        return response()->json([
            'message' => 'Книга успешно создана',
            'data' => $book,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, BookService $service)
    {
        return $service->show((int)$id);
    }

    /**
     * Update the specified resour ce in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $book = Book::findOrFail($id);

        $book->update($request->validated());

        return response()->json([
            'message' => 'Книга успешно обновлена',
            'book' => $book,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        return response()->json([
            'message' => 'Книга успешно удалена',
        ]);
    }
}
