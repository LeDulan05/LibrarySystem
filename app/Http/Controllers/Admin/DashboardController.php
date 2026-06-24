<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = DB::table('books')->sum('total_copies'); 
        
        $totalMembers = DB::table('users')
            ->where('role', 'member')
            ->count(); 
            
        $totalPenalties = DB::table('penalties')->sum('amount'); 
        
        $borrowedToday = DB::table('transactions')
            ->whereDate('borrow_date', Carbon::today())
            ->where('status', 'Borrowed')
            ->count();
            
        $pendingReturns = DB::table('transactions')
            ->where('status', 'Borrowed')
            ->whereNull('return_date')
            ->count();
            
        $bookReservations = DB::table('reservations')->count(); 

        $recentTransactions = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->select(
                'transactions.*', 
                'users.first_name', 
                'users.last_name', 
                'books.title as book_title'
            )
            ->orderBy('transactions.created_at', 'desc')
            ->take(5)
            ->get();

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = DB::table('transactions')
                ->whereYear('borrow_date', Carbon::now()->year)
                ->whereMonth('borrow_date', $i)
                ->where('status', 'Borrowed')
                ->count();
        }

        return view('admin.overviewPage', compact(
            'totalBooks', 
            'totalMembers', 
            'totalPenalties', 
            'borrowedToday', 
            'pendingReturns', 
            'bookReservations',
            'recentTransactions',
            'monthlyData'
        ));
    }
}