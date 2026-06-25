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
        $query = DB::table('categories')
            ->leftJoin('books', 'categories.id', '=', 'books.category_id')
            ->select(
                'categories.id',
                'categories.name',
                'categories.description',
                DB::raw('COUNT(books.id) as books_count')
            )
            ->groupBy('categories.id', 'categories.name', 'categories.description');

        if ($request->has('search') && $request->search != '') {
            $query->where('categories.name', 'like', '%' . $request->search . '%')
                  ->orWhere('categories.description', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('categories.name', 'asc')->get();

        return view('admin.categoriesPage', compact('categories'));
    }

    /**
     * Show books within a specific category.
     */
    public function show(Request $request, $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            abort(404, 'Category not found.');
        }

        $booksQuery = DB::table('books')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select('books.*', 'categories.name as category_name')
            ->where('books.category_id', $id);

        if ($request->has('search') && $request->search != '') {
            $booksQuery->where(function($q) use ($request) {
                $q->where('books.title', 'like', '%' . $request->search . '%')
                  ->orWhere('books.author', 'like', '%' . $request->search . '%');
            });
        }

        $books = $booksQuery->orderBy('books.title', 'asc')
                            ->paginate(8)
                            ->appends($request->all());

        return view('admin.viewCategoryPage', compact('category', 'books'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Request $request, $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            abort(404, 'Category not found.');
        }

        // Build books query with pagination support for the category edit panel
        $booksQuery = DB::table('books')
            ->where('category_id', $id);

        if ($request->has('search') && $request->search != '') {
            $booksQuery->where(function($q) use ($request) {
                $q->where('books.title', 'like', '%' . $request->search . '%')
                  ->orWhere('books.author', 'like', '%' . $request->search . '%');
            });
        }

        $books = $booksQuery->orderBy('books.title', 'asc')->paginate(10);

        return view('admin.editCategoriesPage', compact('category', 'books'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category = DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            abort(404, 'Category not found.');
        }

        DB::table('categories')->where('id', $id)->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.bookCategories')->with('success', 'Category details updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            abort(404, 'Category not found.');
        }

        DB::table('categories')->where('id', $id)->delete();

        return redirect()->route('admin.bookCategories')->with('success', 'Category deleted successfully.');
    }
}