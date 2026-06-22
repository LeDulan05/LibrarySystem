<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class ReturnController extends Controller
{
    // Matches "Return Book Request" list screen
    public function index()
    {
        return response()->json([
            'stub' => 'active loans pending return',
            'transactions' => Transaction::where('status', 'active')->with(['user', 'book'])->get(),
        ]);
    }

    // TODO: the core return logic, matches "Book Condition Verification" screen. In order:
    // 1. Set return_date to today, status to "returned"
    // 2. Compare return_date to due_date
    //    - on time: skip to step 4
    //    - late: calculate days_late, create a Penalty record
    //      (days_late * rate_per_day), flag member account if needed
    // 3. Restore stock: $book->increment('available_copies')
    // 4. Check the reservation queue for this book, if anyone is
    //    pending, flip their reservation to "fulfilled" and start
    //    the hold window, fire the "Reservation Approved" notification
    public function store(Transaction $transaction)
    {
        return response()->json(['stub' => 'return processed']);
    }
}
