<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Full CRUD, matches "Book Catalog" + "Add New Book Form" admin screens
    public function index()
    {
        return response()->json(['stub' => 'admin book list', 'books' => Book::with('category')->get()]);
    }

    public function create()
    {
        return response()->json(['stub' => 'add new book form']);
    }

    public function store(Request $request)
    {
        return response()->json(['stub' => 'book created']);
    }

    public function show(Book $book)
    {
        return response()->json(['stub' => 'book detail view', 'book' => $book]);
    }

    public function edit(Book $book)
    {
        return response()->json(['stub' => 'edit book form', 'book' => $book]);
    }

    public function update(Request $request, Book $book)
    {
        return response()->json(['stub' => 'book updated']);
    }

    public function destroy(Book $book)
    {
        return response()->json(['stub' => 'book deleted']);
    }
}
