<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date', Carbon::now()->startOfYear()->toDateString());
        $toDate = $request->input('to_date', Carbon::now()->endOfYear()->toDateString());

        // Baseline Query Object
        $lateReturnsQuery = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->join('penalties', 'transactions.id', '=', 'penalties.transaction_id')
            ->select(
                'transactions.*',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'users.student_id as student_number',
                'books.title as book_title',
                'penalties.days_late',
                'penalties.amount as penalty_amount',
                'penalties.status as penalty_status'
            )
            ->whereBetween('transactions.return_date', [$fromDate, $toDate]);

        // Optional Keyword Filter
        if ($request->has('search') && $request->search != '') {
            $lateReturnsQuery->where(function($q) use ($request) {
                $q->where('users.first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('users.last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('books.title', 'like', '%' . $request->search . '%');
            });
        }

        // Paginate collection records
        $lateReturns = $lateReturnsQuery->orderBy('transactions.return_date', 'desc')->paginate(10)->appends($request->all());

        // Analytical Summary Aggregates (Unfiltered total context overview counters)
        $totalLateReturns = DB::table('transactions')
            ->whereRaw('return_date > due_date')
            ->whereBetween('return_date', [$fromDate, $toDate])
            ->count();

        $totalPenalties = DB::table('penalties')
            ->join('transactions', 'penalties.transaction_id', '=', 'transactions.id')
            ->whereBetween('transactions.return_date', [$fromDate, $toDate])
            ->sum('penalties.amount');

        $paidPenalties = DB::table('penalties')
            ->join('transactions', 'penalties.transaction_id', '=', 'transactions.id')
            ->where('penalties.status', 'paid')
            ->whereBetween('transactions.return_date', [$fromDate, $toDate])
            ->sum('penalties.amount');

        $outstandingPenalties = DB::table('penalties')
            ->join('transactions', 'penalties.transaction_id', '=', 'transactions.id')
            ->where('penalties.status', 'unpaid')
            ->whereBetween('transactions.return_date', [$fromDate, $toDate])
            ->sum('penalties.amount');

        // Render 12 Months Chronological Array Distributions
        $monthlyActivity = DB::table('transactions')
            ->select(DB::raw('MONTH(return_date) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('return_date', Carbon::parse($toDate)->year)
            ->whereRaw('return_date > due_date')
            ->groupBy(DB::raw('MONTH(return_date)'))
            ->pluck('count', 'month')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyActivity[$i] ?? 0;
        }

        return view('admin.reportsPage', compact(
            'lateReturns',
            'totalLateReturns',
            'totalPenalties',
            'paidPenalties',
            'outstandingPenalties',
            'chartData'
        ));
    }
}