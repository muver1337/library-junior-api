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

    public function login(LoginRequest $request)
    {
        return response()->json(
            $this->auth->login($request->validated())
        );
    }


    public function index()
    {
        return response()->json(
            $this->authorService->getAuthorsList()
        );
    }

    public function show(int $id)
    {
        return response()->json(
            $this->authorService->getAuthorById($id)
        );
    }

    public function store(StoreAuthorRequest $request)
    {
        return response()->json(
            $this->authorService->createAuthor($request->validated()),
            201
        );
    }

    public function update(UpdateAuthorRequest $request, int $id)
    {
        return response()->json(
            $this->authorService->updateAuthor($id, $request->validated())
        );
    }

    public function destroy(int $id)
    {
        $this->authorService->deleteAuthor($id);
        return response()->json(['message' => 'Автор успешно удален']);
    }
}
