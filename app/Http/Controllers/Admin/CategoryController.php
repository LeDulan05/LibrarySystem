<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Matches "Categories" admin screen
    public function index()
    {
        return response()->json(['stub' => 'category list', 'categories' => Category::all()]);
    }

    public function store(Request $request)
    {
        return response()->json(['stub' => 'category created']);
    }

    public function update(Request $request, Category $category)
    {
        return response()->json(['stub' => 'category updated']);
    }

    public function destroy(Category $category)
    {
        return response()->json(['stub' => 'category deleted']);
    }
}
