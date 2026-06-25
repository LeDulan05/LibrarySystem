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

    public function store(Transaction $transaction)
    {
        return response()->json(['stub' => 'return processed']);
    }
}
