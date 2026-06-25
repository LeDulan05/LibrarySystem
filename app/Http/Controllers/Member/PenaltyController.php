<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    // TODO: read-only, matches the member-facing "Penalties" screen
    public function index(Request $request)
    {
        $penalties = $request->user()->transactions()->with('penalty')->whereHas('penalty')->get();

        return view('user.penaltiesPage', compact('penalties'));
    }
}
