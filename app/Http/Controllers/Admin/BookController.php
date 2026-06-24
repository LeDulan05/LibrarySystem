<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookController extends Controller
{
    /**
     * Display the Book Catalog Page with all books and categories.
     */
    public function index(Request $request)
{
    // 1. Start a base query joining books and categories
    $query = DB::table('books')
        ->join('categories', 'books.category_id', '=', 'categories.id')
        ->select('books.*', 'categories.name as category_name');

    // 2. Filter by Search input if a keyword is typed
    if ($request->has('search') && $request->search != '') {
        $query->where(function($q) use ($request) {
            $q->where('books.title', 'like', '%' . $request->search . '%')
              ->orWhere('books.author', 'like', '%' . $request->search . '%')
              ->orWhere('books.isbn', 'like', '%' . $request->search . '%');
        });
    }

    // 3. Filter by Category dropdown choice selection
    if ($request->has('category') && $request->category != 'all' && $request->category != '') {
        $query->where('books.category_id', $request->category);
    }

    // 4. Filter by Status dropdown choice selection
    if ($request->has('status') && $request->status != 'all' && $request->status != '') {
        if ($request->status == 'available') {
            $query->where('books.available_copies', '>', 0); // Copies are in stock
        } elseif ($request->status == 'unavailable') {
            $query->where('books.available_copies', '=', 0); // Out of stock
        }
    }

    // 5. Finalize execution with sorting and pagination
    // appends() keeps active filters preserved across pagination links
    $books = $query->orderBy('books.created_at', 'desc')
                   ->paginate(8)
                   ->appends($request->all());

    // Fetch master categories list for dropdown options loop
    $categories = DB::table('categories')->get();

    return view('admin.bookCatalogPage', compact('books', 'categories'));
}

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        // Fetch categories to populate the category selection dropdown
        $categories = DB::table('categories')->get();

        return view('admin.addBookPage', compact('categories'));
    }

    /**
     * Store a newly created book in the database.
     */
    public function store(Request $request)
    {
        // Validate incoming request fields matching your form structures
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'isbn'             => 'required|string|max:255',
            'category_id'      => 'required|integer|exists:categories,id',
            'publisher'        => 'required|string|max:255',
            'year_published'   => 'required|integer|min:1000|max:' . (Carbon::now()->year + 1),
            'total_copies'     => 'required|integer|min:1',
            'description'      => 'nullable|string',
            'book_cover'       => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Handle cover file upload if provided
        $coverPath = null;
        if ($request->hasFile('book_cover')) {
            $coverPath = $request->file('book_cover')->store('book_covers', 'public');
        }

        // Insert row into 'books' table matching ERD attributes
        DB::table('books')->insert([
            'title'            => $validated['title'],
            'author'           => $validated['author'],
            'isbn'             => $validated['isbn'],
            'category_id'      => $validated['category_id'],
            'total_copies'     => $validated['total_copies'],
            // available_copies initially equals total_copies on a new addition
            'available_copies' => $validated['total_copies'], 
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now(),
        ]);

        return redirect()->route('admin.bookCatalog')->with('success', 'Book added successfully!');
    }

    /**
     * Show the form for editing an existing book.
     */
    public function edit($id)
    {
        // Find the single book entry or fail
        $book = DB::table('books')->where('id', $id)->first();
        if (!$book) {
            abort(404, 'Book not found.');
        }

        // Fetch categories for the dropdown selections
        $categories = DB::table('categories')->get();

        return view('admin.editBookPage', compact('book', 'categories'));
    }

    /**
     * Update the specified book details in the database.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'required|string|max:255',
            'category_id'    => 'required|integer|exists:categories,id',
            'total_copies'   => 'required|integer|min:0',
        ]);

        // Fetch current copies to recalculate available inventory metrics safely
        $currentBook = DB::table('books')->where('id', $id)->first();
        if (!$currentBook) {
            abort(404);
        }

        // Calculate discrepancy differences to update available capacity numbers 
        $copiesDifference = $validated['total_copies'] - $currentBook->total_copies;
        $newAvailableCopies = $currentBook->available_copies + $copiesDifference;

        DB::table('books')
            ->where('id', $id)
            ->update([
                'title'            => $validated['title'],
                'author'           => $validated['author'],
                'isbn'             => $validated['isbn'],
                'category_id'      => $validated['category_id'],
                'total_copies'     => $validated['total_copies'],
                'available_copies' => max(0, $newAvailableCopies),
                'updated_at'       => Carbon::now(),
            ]);

        return redirect()->route('admin.bookCatalog')->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified book from the catalog database.
     */
    public function destroy($id)
    {
        DB::table('books')->where('id', $id)->delete();

        return redirect()->route('admin.bookCatalog')->with('success', 'Book removed from catalog.');
    }
}