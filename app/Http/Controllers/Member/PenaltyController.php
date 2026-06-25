<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    public function index(Request $request)
    {
        $penalties = $request->user()->transactions()->with(['penalty', 'book', 'book.category'])->whereHas('penalty')->get();

        return view('user.penaltiesPage', compact('penalties'));
    }
}
