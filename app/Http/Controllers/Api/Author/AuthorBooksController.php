<?php

namespace App\Http\Controllers\Api\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::with('authors')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Book::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $book = Book::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $book->update($request->validated());

        return response()->json([
            'message' => 'Книга успешно обновлена',
            'book' => $book,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, BookService $bookService)
    {
        $user = Auth::user();
        $bookId = $id;

        try {
            $bookService->destroy($bookId, $user->id, $user->role);

            return response()->json([
                'message' => 'Книга успешно удалена'
            ]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

}
