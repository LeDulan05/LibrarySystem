<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    // TODO: matches "My Borrowed Books" screen
    public function index(Request $request)
    {
        $transactions = $request->user()->transactions()->with('book')->get();

        return view('user.borrowedPage', compact('transactions'));
    }

    // TODO: creates a transaction row with status "pending", does NOT
    // touch available_copies yet, that only happens once admin approves.
    // This is the "Borrow Request Sent" step in the flow diagram, matches
    // the "Book Borrow Confirmation" screen on success.
    public function store(Request $request, Book $book)
    {
        if (! $book->isAvailable()) {
            return response()->json(['stub' => 'borrow blocked, no copies left'], 422);
        }

        return response()->json(['stub' => 'borrow request created, status pending']);
    }
}
