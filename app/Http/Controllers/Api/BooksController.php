<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;

        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $filters = $request->only(['title', 'author_id', 'genre_id', 'created_from', 'created_to', 'sort_by']);
        $perPage = $request->get('per_page', 10);

        if ($user && $user->role === 'author') {
            $filters['author_id'] = $user->id;
        } elseif (!$user) {

        }

        $books = $this->bookService->index($filters, $perPage);

        return response()->json($books);
    }

    public function store(StoreBookRequest $request)
    {
        $this->authorize('create', Book::class);

        $data = $request->validated();

        if (Auth::user()->role === 'author') {
            $data['user_id'] = Auth::id();
        }

        $book = $this->bookService->create($data);

        return response()->json([
            'message' => 'Книга успешно создана',
            'data' => $book,
        ], 201);
    }

    public function show(int $id)
    {
        $book = $this->bookService->show($id);

        return response()->json($book);
    }

    public function update(UpdateBookRequest $request, int $id)
    {
        $book = Book::findOrFail($id);

        $this->authorize('update', $book);

        $updatedBook = $this->bookService->update($book, $request->validated());

        return response()->json([
            'message' => 'Книга успешно обновлена',
            'data' => $updatedBook,
        ]);
    }

    public function destroy(int $id)
    {
        $book = Book::findOrFail($id);

        $this->authorize('delete', $book);

        $this->bookService->destroy($id, Auth::id(), Auth::user()->role);

        return response()->json(['message' => 'Книга успешно удалена']);
    }
}
