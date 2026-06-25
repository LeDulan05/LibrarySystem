<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of book categories with dynamic book counting and searching.
     */
    public function index(Request $request)
    {
        // 1. Build base query aggregating books count per category
        $query = DB::table('categories')
            ->leftJoin('books', 'categories.id', '=', 'books.category_id')
            ->select(
                'categories.id',
                'categories.name',
                'categories.description',
                DB::raw('COUNT(books.id) as books_count')
            )
            ->groupBy('categories.id', 'categories.name', 'categories.description');

        // 2. Apply search filter if a keyword is actively input
        if ($request->has('search') && $request->search != '') {
            $query->where('categories.name', 'like', '%' . $request->search . '%')
                  ->orWhere('categories.description', 'like', '%' . $request->search . '%');
        }

        // 3. Finalize execution sorted by category names alphabetically
        $categories = $query->orderBy('categories.name', 'asc')->get();

        return view('admin.categoriesPage', compact('categories'));
    }

    /**
     * Show books within a specific category.
     */
    public function show(Request $request, $id)
    {
        // 1. Fetch category or throw 404
        $category = DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            abort(404, 'Category not found.');
        }

        // 2. Query books matching this category sequence
        $booksQuery = DB::table('books')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select('books.*', 'categories.name as category_name')
            ->where('books.category_id', $id);

        // 3. Search text filters
        if ($request->has('search') && $request->search != '') {
            $booksQuery->where(function($q) use ($request) {
                $q->where('books.title', 'like', '%' . $request->search . '%')
                  ->orWhere('books.author', 'like', '%' . $request->search . '%');
            });
        }

        // 4. Paginate and append queries
        $books = $booksQuery->orderBy('books.title', 'asc')
                            ->paginate(8)
                            ->appends($request->all());

        return view('admin.viewCategoryPage', compact('category', 'books'));
    }
}