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
    $query = DB::table('transactions')
        ->join('users', 'transactions.user_id', '=', 'users.id')
        ->join('books', 'transactions.book_id', '=', 'books.id')
        ->select(
            'transactions.*',
            'transactions.created_at as request_date', 
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
            'books.title as book_title'
        );

    if ($request->has('search') && $request->search != '') {
        $query->where(function($q) use ($request) {
            $q->where('users.first_name', 'like', '%' . $request->search . '%')
              ->orWhere('users.last_name', 'like', '%' . $request->search . '%')
              ->orWhere('books.title', 'like', '%' . $request->search . '%');
        });
    }

    $borrowRequests = $query->orderBy('transactions.created_at', 'desc')
                            ->paginate(10)
                            ->appends($request->all());

    $pendingCount = DB::table('transactions')->where('status', 'pending')->count();
    $approvedCount = DB::table('transactions')->whereIn('status', ['approved', 'active'])->count();
    $rejectedCount = DB::table('transactions')->where('status', 'rejected')->count();
    $returnedCount = DB::table('transactions')->where('status', 'returned')->count();

    return view('admin.borrowRequestPage', compact(
        'borrowRequests',
        'pendingCount',
        'approvedCount',
        'rejectedCount',
        'returnedCount',
    ));
}


public function show($id)
{
    $requestData = DB::table('transactions')
        ->join('users', 'transactions.user_id', '=', 'users.id')
        ->join('books', 'transactions.book_id', '=', 'books.id')
        ->select(
            'transactions.id',
            'transactions.status', 
            'transactions.borrow_date',
            'transactions.due_date',
            'transactions.return_date',
            'transactions.rejection_reason',
            'transactions.created_at as request_date',
            
            // User Details
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
            'users.student_id as student_number',

            // Book Details
            'books.title as book_title',
            'books.isbn',
            'books.available_copies'
        )
        ->where('transactions.id', $id)
        ->first();

    if (!$requestData) {
        abort(404, 'Transaction record not found.');
    }

    return view('admin.viewBorrowReqPage', compact('requestData'));
}

    /**
     * Handle verification approval transition logic patterns.
     */
    public function approve(Request $request, $id)
{
    $transaction = DB::table('transactions')->where('id', $id)->first();
    if (!$transaction) {
        abort(404);
    }

    DB::table('transactions')
        ->where('id', $id)
        ->update([
            'status' => 'active', 
            'borrow_date' => Carbon::now()->toDateString(),
            'due_date' => Carbon::now()->addDays(14)->toDateString(), 
            'updated_at' => Carbon::now(),
        ]);

    return redirect()->route('admin.borrow.receipt', $id)->with('success', 'Borrow transaction has been logged successfully.');
}

    /**
     * Handle denial operations routing parameters.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:255'
        ]);

        $transaction = DB::table('transactions')->where('id', $id)->first();

        if (!$transaction) {
            abort(404);
        }

        DB::table('transactions')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'rejection_reason' => $request->input('reason', 'Administrative decision/unspecified'),
                'updated_at' => Carbon::now(),
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
                'transactions.id', 
                'transactions.borrow_date',
                'transactions.due_date',
                'transactions.status',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'users.student_id',
                'books.title as book_title',
                'books.isbn'
            )
            ->where('transactions.id', $id)
            ->first();

        return view('admin.borrowTransactionSlip', compact('slip'));
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
                'users.student_id',
                'books.title as book_title',
                'books.isbn'
            )
            ->where('transactions.id', $id)
            ->first();

        return view('admin.borrowTransactionSlip', compact('rejection'));
    }
}