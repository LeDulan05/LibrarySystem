<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenaltyController extends Controller
{
    /**
     * Display a listing of penalties with search filtering and analytical data cards.
     */
    public function index(Request $request)
    {
        $query = DB::table('penalties')
            ->join('transactions', 'penalties.transaction_id', '=', 'transactions.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->select(
                'penalties.*',
                'users.id as user_id',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'users.student_id as student_number',
                'books.title as book_title'
            );

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('users.first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('users.last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('books.title', 'like', '%' . $request->search . '%')
                  ->orWhere('penalties.penalty_code', 'like', '%' . $request->search . '%');
            });
        }

        $penalties = $query->orderBy('penalties.created_at', 'desc')->paginate(10);

        // Compute analytical dashboard metric summary cards with unambiguous column qualifiers
        $totalOutstanding = DB::table('penalties')->where('status', 'unpaid')->sum('amount');
        $collectedThisMonth = DB::table('penalties')
            ->where('status', 'paid')
            ->where('updated_at', '>=', now()->startOfMonth())
            ->sum('amount');
        $activePenaltiesCount = DB::table('penalties')->where('status', 'unpaid')->count();

        return view('admin.penaltyManagementPage', compact(
            'penalties',
            'totalOutstanding',
            'collectedThisMonth',
            'activePenaltiesCount'
        ));
    }

    /**
     * Display detailed penalty history breakdown for a single student profile.
     */
    public function show($userId)
    {
        $member = DB::table('users')->where('id', $userId)->first();
        if (!$member) {
            abort(404, 'Member student profile not found.');
        }

        $penaltyHistory = DB::table('penalties')
            ->join('transactions', 'penalties.transaction_id', '=', 'transactions.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->select(
                'penalties.*',
                'books.title as book_title'
            )
            ->where('transactions.user_id', $userId)
            ->orderBy('penalties.created_at', 'desc')
            ->get();

        $outstanding = $penaltyHistory->where('status', 'unpaid')->sum('amount');
        $totalPaid = $penaltyHistory->where('status', 'paid')->sum('amount');
        $grandTotal = $outstanding + $totalPaid;

        return view('admin.viewPenaltyPage', compact(
            'member',
            'penaltyHistory',
            'outstanding',
            'totalPaid',
            'grandTotal'
        ));
    }

    public function calculatePenalty($transaction)
    {
        $dailyRate = 10.00; 
        $daysLate = Carbon::parse($transaction->return_date)->diffInDays($transaction->due_date);
        return $daysLate * $dailyRate;
    }
}