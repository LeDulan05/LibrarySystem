<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BorrowRequestController extends Controller
{
    /**
     * Display a listing of transaction queues filtering by pending/active states.
     */
    public function index(Request $request)
    {
        // ERD FIX: Switched base table from 'borrow_requests' to 'transactions'
        $query = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->select(
                'transactions.*',
                // Using created_at or borrow_date as the request date indicator
                'transactions.created_at as request_date', 
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'books.title as book_title'
            );

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('users.first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('users.last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('books.title', 'like', '%' . $request->search . '%')
                  ->orWhere('transactions.transaction_code', 'like', '%' . $request->search . '%');
            });
        }

        $requests = $query->orderBy('transactions.created_at', 'desc')->paginate(10);

        // ERD FIX: Re-mapped metric indicators directly to the transaction status properties
        $pendingCount = DB::table('transactions')->where('status', 'pending')->count();
        $approvedToday = DB::table('transactions')
            ->where('status', 'approved')
            ->whereDate('updated_at', Carbon::today())
            ->count();
        $rejectedToday = DB::table('transactions')
            ->where('status', 'rejected')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        return view('admin.borrowRequestPage', compact('requests', 'pendingCount', 'approvedToday', 'rejectedToday'));
    }

    /**
     * Display contextual details from a single transaction entity row.
     */
    public function show($id)
    {
        // ERD FIX: Changed targeted lookup reference parameters to 'transactions'
        $requestData = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->select(
                'transactions.*',
                'transactions.created_at as request_date',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'users.student_number',
                'books.title as book_title',
                'books.isbn',
                'books.available_copies'
            )
            ->where('transactions.id', $id)
            ->first();

        if (!$requestData) {
            abort(404, 'Transaction log data point not found.');
        }

        return view('admin.viewBorrowRequestPage', compact('requestData'));
    }

    /**
     * Approve the request row directly within the table records block.
     */
    public function approve($id)
    {
        $transaction = DB::table('transactions')->where('id', $id)->first();
        if (!$transaction || $transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Request cannot be processed.');
        }

        $book = DB::table('books')->where('id', $transaction->book_id)->first();
        if ($book->available_copies <= 0) {
            return redirect()->back()->with('error', 'No available copies left on shelf stacks.');
        }

        DB::transaction(function () use ($transaction, $id) {
            // ERD FIX: Transition the single row state and allocate parameters right here
            DB::table('transactions')->where('id', $id)->update([
                'transaction_code' => 'TXN-' . Carbon::now()->year . '-' . str_pad($id, 3, '0', STR_PAD_LEFT),
                'status' => 'approved',
                'borrow_date' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(14),
                'updated_at' => Carbon::now()
            ]);

            DB::table('books')->where('id', $transaction->book_id)->decrement('available_copies');
        });

        return redirect()->route('admin.borrow.receipt', $id);
    }

    /**
     * Terminate transaction execution and attach rejection messages.
     */
    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        $transaction = DB::table('transactions')->where('id', $id)->first();
        if (!$transaction || $transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Request cannot be processed.');
        }

        // ERD FIX: Updates the rejection_reason field explicitly present on your schema mapping
        DB::table('transactions')->where('id', $id)->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('admin.borrow.rejection', $id);
    }

    /**
     * Render slip invoice.
     */
    public function receipt($id)
    {
        $slip = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->select(
                'transactions.*',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'users.student_number',
                'books.title as book_title',
                'books.isbn'
            )
            ->where('transactions.id', $id)
            ->first();

        return view('admin.borrowTransactionSlipPage', compact('slip'));
    }

    /**
     * Render denial summary message sheet template window.
     */
    public function rejectionNotice($id)
    {
        $rejection = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->select(
                'transactions.*',
                'transactions.created_at as request_date',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'users.student_number',
                'books.title as book_title'
            )
            ->where('transactions.id', $id)
            ->first();

        return view('admin.borrowRejectionPage', compact('rejection'));
    }
}