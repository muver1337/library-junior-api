<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Services\AuthorService;

class AuthorsController extends Controller
{
    protected AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    // Получение всех авторов
    public function index()
    {
        return response()->json(
            $this->authorService->getAuthorsList()
        );
    }

    // Получение автора по ID
    public function show(int $id)
    {
        return response()->json(
            $this->authorService->getAuthorById($id)
        );
    }

    // Регистрация автора
    public function store(StoreAuthorRequest $request)
    {
        return response()->json(
            $this->authorService->createAuthor($request->validated()),
            201
        );
    }

    // Обновление автора
    public function update(UpdateAuthorRequest $request, int $id)
    {
        return response()->json(
            $this->authorService->updateAuthor($id, $request->validated())
        );
    }

    // Удаление автора
    public function destroy(int $id)
    {
        $this->authorService->deleteAuthor($id);
        return response()->json(['message' => 'Автор успешно удален']);
    }
}
