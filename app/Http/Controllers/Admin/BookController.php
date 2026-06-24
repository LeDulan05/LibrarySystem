<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(['books' => Book::with('category')->get()]);
    }

    public function create()
    {
        return response()->json(['stub' => 'add new book form']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn|max:255',
            'category_id' => 'required|exists:categories,id',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0',
        ]);

        $book = Book::create($validated);

        return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
    }

    public function show(Book $book)
    {
        return response()->json(['book' => $book->load('category')]);
    }

    public function edit(Book $book)
    {
        return response()->json(['stub' => 'edit book form', 'book' => $book]);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|required|string|max:255|unique:books,isbn,' . $book->id,
            'category_id' => 'sometimes|required|exists:categories,id',
            'total_copies' => 'sometimes|required|integer|min:1',
            'available_copies' => 'sometimes|required|integer|min:0',
        ]);

        $book->update($validated);

        return response()->json(['message' => 'Book updated successfully', 'book' => $book]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
