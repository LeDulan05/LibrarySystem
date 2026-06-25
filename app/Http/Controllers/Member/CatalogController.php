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
        $query = Book::with('category');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort')) {
            $sort = $request->input('sort') === 'desc' ? 'desc' : 'asc';
            $query->orderBy('title', $sort);
        } else {
            // default order
            $query->orderBy('created_at', 'desc');
        }

        $books = $query->get();

        return view('user.libraryPage', compact('books'));
    }

    public function show(Book $book)
    {
        return view('user.bookCatalogCard', compact('book'));
    }

    public function details(Book $book)
    {
        return view('user.bookDetails', compact('book'));
    }
}
