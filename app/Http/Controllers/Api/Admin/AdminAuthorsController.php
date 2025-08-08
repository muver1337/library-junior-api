<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class AdminAuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|unique:books,title',
            'author_id' => 'required|integer|exists:authors,id',
            'description' => 'nullable|string',

        ]);

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Книга успешно создана',
            'data' => $book,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
