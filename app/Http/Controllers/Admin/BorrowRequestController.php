<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class BorrowRequestController extends Controller
{
    // Matches "Borrow Book Request" list screen
    public function index()
    {
        return response()->json([
            'stub' => 'pending borrow requests',
            'requests' => Transaction::where('status', 'pending')->with(['user', 'book'])->get(),
        ]);
    }

    // Matches "Borrow Request Details" screen
    public function show(Transaction $transaction)
    {
        return response()->json(['stub' => 'borrow request detail', 'transaction' => $transaction->load('user', 'book')]);
    }

    // TODO: the core borrow logic. In order:
    // 1. Re-check $book->isAvailable() (could have changed since request was made)
    // 2. Re-check member is in good standing (no unpaid penalties, under borrow limit)
    // 3. If either check fails, treat as a soft reject with reason
    //    "Out of Stock" or "Maximum Borrow Limit" instead of approving
    // 4. Otherwise: decrement available_copies, set status to "active",
    //    set borrow_date to today, set due_date (+7 or +14 days),
    //    fire the "Borrow Request Approved" notification
    public function approve(Transaction $transaction)
    {
        return response()->json(['stub' => 'borrow request approved, transaction now active']);
    }

    // TODO: set status to "rejected", store $request->reason,
    // fire "Borrow Request Rejected" notification
    public function reject(Transaction $transaction)
    {
        return response()->json(['stub' => 'borrow request rejected']);
    }
}
