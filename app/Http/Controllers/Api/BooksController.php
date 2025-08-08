<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Services\BookService;
use Illuminate\Http\Request;

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
        return response()->json(
            $this->bookService->index($request->all())
        );
    }

    public function store(StoreBookRequest $request)
    {
        return response()->json(
            $this->bookService->storeBook($request->validated()),
            201
        );
    }

    public function show(int $id)
    {
        return response()->json(
            $this->bookService->show($id)
        );
    }

    public function update(UpdateBookRequest $request, int $id)
    {
        return response()->json(
            $this->bookService->updateBook($id, $request->validated(), $request->user())
        );
    }


    public function destroy(int $id, Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $this->bookService->destroy($id, $user);
        return response()->json(['message' => 'Книга успешно удалена']);
    }
}
