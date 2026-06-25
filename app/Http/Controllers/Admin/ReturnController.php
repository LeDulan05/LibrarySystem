<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReturnController extends Controller
{
    /**
     * Display a listing of book return logs with calculation counts.
     */
    public function index(Request $request)
    {
        // 1. Fetch transaction logs that represent completed returns
        $query = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->leftJoin('penalties', 'transactions.id', '=', 'penalties.transaction_id')
            ->select(
                'transactions.*',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'books.title as book_title',
                DB::raw('COALESCE(penalties.amount, 0.00) as penalty_amount')
            )
            ->whereNotNull('transactions.return_date');

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('users.first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('users.last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('books.title', 'like', '%' . $request->search . '%')
                  ->orWhere('transactions.transaction_code', 'like', '%' . $request->search . '%');
            });
        }

        $returns = $query->orderBy('transactions.return_date', 'desc')->paginate(10);

        // 2. Fetch layout metrics matching summary panels card blocks (image_2214ff.png)
        $pendingReturns = DB::table('transactions')
            ->where('status', 'active')
            ->whereNull('return_date')
            ->count();

        $returnedToday = DB::table('transactions')
            ->whereNotNull('return_date')
            ->whereDate('return_date', Carbon::today())
            ->count();

        $overdueCount = DB::table('transactions')
            ->where('status', 'active')
            ->whereNull('return_date')
            ->where('due_date', '<', Carbon::now())
            ->count();

        return view('admin.bookReturnsPage', compact(
            'returns',
            'pendingReturns',
            'returnedToday',
            'overdueCount'
        ));
    }
}