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

        $lateReturnsQuery = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->join('penalties', 'transactions.id', '=', 'penalties.transaction_id')
            ->select(
                'transactions.*',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'books.title as book_title',
                'penalties.days_late',
                'penalties.amount as penalty_amount',
                'penalties.status as penalty_status'
            )
            ->whereBetween('transactions.return_date', [$fromDate, $toDate]);

        $lateReturns = $lateReturnsQuery->orderBy('transactions.return_date', 'desc')->get();

        $totalLateReturns = $lateReturns->count();
        $totalPenalties = $lateReturns->sum('penalty_amount');
        $paidPenalties = $lateReturns->where('penalty_status', 'paid')->sum('penalty_amount');
        $outstandingPenalties = $lateReturns->where('penalty_status', 'unpaid')->sum('penalty_amount');

        $monthlyActivity = DB::table('transactions')
            ->select(DB::raw('MONTH(borrow_date) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('borrow_date', Carbon::parse($toDate)->year)
            ->groupBy(DB::raw('MONTH(borrow_date)'))
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
            'chartData',
            'fromDate',
            'toDate'
        ));
    }
}
