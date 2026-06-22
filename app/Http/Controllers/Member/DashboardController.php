<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // TODO: counts of currently borrowed books, upcoming due dates,
    // and unpaid penalties for the "Welcome back" screen.
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'stub' => 'member dashboard',
            'currently_borrowed' => $user->transactions()->where('status', 'active')->count(),
        ]);
    }
}
