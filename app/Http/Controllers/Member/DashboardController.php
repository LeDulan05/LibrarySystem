<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'stub' => 'member dashboard',
            'currently_borrowed' => $user->transactions()->where('status', 'active')->count(),
        ]);
    }
}
