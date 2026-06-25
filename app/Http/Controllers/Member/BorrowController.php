<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $transactions = $request->user()->transactions()->with('book')->get();

        return view('user.borrowedPage', compact('transactions'));
    }

    public function store(Request $request, Book $book)
    {
        if (! $book->isAvailable()) {
            return response()->json(['stub' => 'borrow blocked, no copies left'], 422);
        }

        // Create transaction
        $request->user()->transactions()->create([
            'book_id' => $book->id,
            'status' => 'pending',
            // borrow_date and due_date will be set by admin upon approval
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, \App\Models\Transaction $transaction)
    {
        // Ensure user owns this transaction
        if ($transaction->user_id !== $request->user()->id) {
            abort(403);
        }

        // Only allow canceling if pending
        if ($transaction->status === 'pending') {
            $transaction->delete();
        }

        return redirect()->back();
    }
}
