<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // TODO: searchable, filterable by category, matches "Book Catalog" screen
    public function index(Request $request)
    {
        $books = Book::with('category')->get();

        return response()->json(['stub' => 'catalog index', 'books' => $books]);
    }

    // TODO: matches "Book Details" screen, this is where the
    // borrow-vs-reserve button decision happens: $book->isAvailable()
    public function show(Book $book)
    {
        return response()->json([
            'stub' => 'book details',
            'book' => $book,
            'available' => $book->isAvailable(),
        ]);
    }
}
