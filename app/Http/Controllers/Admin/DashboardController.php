<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    // TODO: matches admin "Dashboard" screen, counts + recent transactions table
    public function index()
    {
        return response()->json([
            'stub' => 'admin dashboard',
            'pending_requests' => Transaction::where('status', 'pending')->count(),
        ]);
    }
}
