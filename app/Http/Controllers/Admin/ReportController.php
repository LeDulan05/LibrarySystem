<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class ReportController extends Controller
{
    // Matches "Late Return Reports" screen, depends entirely on penalty data existing
    public function lateReturns()
    {
        return response()->json([
            'stub' => 'late return report',
            'overdue' => Transaction::where('status', 'active')->where('due_date', '<', now())->with(['user', 'book'])->get(),
        ]);
    }
}
