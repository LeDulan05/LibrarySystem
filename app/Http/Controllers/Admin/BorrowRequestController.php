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

    public function approve(Transaction $transaction)
    {
        return response()->json(['stub' => 'borrow request approved, transaction now active']);
    }

    public function reject(Transaction $transaction)
    {
        return response()->json(['stub' => 'borrow request rejected']);
    }
}
