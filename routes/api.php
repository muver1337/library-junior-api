<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\GenresController;
use App\Http\Controllers\Api\AuthorsController;

// Получение списка кинг
Route::get('/books', [BooksController::class, 'index']);
// Получение информации о книге по ID
Route::get('/books/{id}', [BooksController::class, 'show']);
// Получение списка жанров с количеством книг в каждом жанре
Route::get('/genres', [GenresController::class, 'index']);
// Получение детальной информации о жанре и связанных книгах
Route::get('/genres/{id}', [GenresController::class, 'show']);
// Получение списка авторов с количеством их книг
Route::get('/authors', [AuthorsController::class, 'index']);
// Получение детальной информации об авторе и его книгах
Route::get('/authors/{id}', [AuthorsController::class, 'show']);

// Авторизация
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Группа только для авторизованных пользователей
Route::middleware('auth:sanctum')->group(function () {
    // Обновление книги по ID
    Route::patch('/books/{id}', [BooksController::class, 'update']);
    // Удаление книги по ID
    Route::delete('/books/{id}', [BooksController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Добавление книги
    Route::post('/books', [BooksController::class, 'store']);
    // Добавление автора
    Route::post('/authors', [AuthorsController::class, 'store']);
    // Удаление автора
    Route::delete('/authors/{id}', [AuthorsController::class, 'destroy']);
    // Обновление автора
    Route::patch('/authors/{id}', [AuthorsController::class, 'update']);
    // Создание жанра
    Route::post('/genres', [GenresController::class, 'store']);
    // Обновление жанра по ID
    Route::patch('/genres/{id}', [GenresController::class, 'update']);
    // Удаление жанра по ID
    Route::delete('/genres/{id}', [GenresController::class, 'destroy']);
});

