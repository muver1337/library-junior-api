<?php

use App\Http\Controllers\Api\Admin\AdminBooksController;
use App\Http\Controllers\Api\Author\AuthorBooksController;
use App\Http\Controllers\Api\Public\AuthController;
use App\Http\Controllers\Api\Public\GenresController;
use App\Http\Controllers\Api\Public\AuthorsController;
use App\Http\Controllers\Api\Public\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/books', [BooksController::class, 'index']);
Route::get('/authors', [AuthorsController::class, 'index']);
Route::get('/genres', [GenresController::class, 'index']);
Route::get('/authors/{id}', [AuthorsController::class, 'show']);
Route::get('/books/{id}', [BooksController::class, 'show']);

Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
Route::post('/author/login', [AuthController::class, 'loginAuthor']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'show']);
    Route::patch('/profile', [AuthController::class, 'update']);
    Route::patch('/books/{id}', [AuthorBooksController::class, 'update'])->middleware('author');
    Route::delete('/books/{id}', [AuthorBooksController::class, 'destroy'])->middleware('author');
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/admin/create', [AdminBooksController::class, 'store']);
    Route::get('/admin/books', [AdminBooksController::class, 'index']);
    Route::patch('/admin/update/{id}', [AdminBooksController::class, 'update']);
    Route::delete('/admin/delete/{id}', [AdminBooksController::class, 'destroy']);
    Route::get('/admin/books/{id}', [BooksController::class, 'show']);
});

