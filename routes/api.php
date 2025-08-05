<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('public')->group(function () {
//    Route::get('/books', [BooksController::class, 'index']);
//    Route::get('/authors', [AuthorsController::class, 'index']);
//    Route::get('/genre', [GenreController::class, 'index']);
//    Route::get('/authors/{id}', [AuthorsController::class, 'show']);
//    Route::get('/books/{id}', [BooksController::class, 'show']);
});
