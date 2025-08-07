<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorsController;
use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\GenresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/books', [BooksController::class, 'index']);
Route::get('/authors', [AuthorsController::class, 'index']);
Route::get('/genres', [GenresController::class, 'index']);
Route::get('/authors/{id}', [AuthorsController::class, 'show']);
Route::get('/books/{id}', [BooksController::class, 'show']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'author'])->group(function () {
    Route::patch('/books/{id}', [BooksController::class, 'update']);
    Route::delete('/books/{id}', [BooksController::class, 'destroy']);
});
