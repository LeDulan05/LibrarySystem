<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penalty;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    // Matches "Penalty Logs" screen, includes the configurable
    // "Penalty Per Day" rate shown in the wireframe
    public function index()
    {
        return response()->json(['stub' => 'penalty logs', 'penalties' => Penalty::with('transaction.user', 'transaction.book')->get()]);
    }

    public function markPaid(Penalty $penalty)
    {
        return response()->json(['stub' => 'penalty marked as paid']);
    }
}
