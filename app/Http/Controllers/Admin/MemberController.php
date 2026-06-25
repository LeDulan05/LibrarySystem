<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberController extends Controller
{
    /* Display a listing of library members */
    public function index(Request $request)
    {
        $query = DB::table('users')
            ->where('role', 'member') // Filter applied here
            ->leftJoin('transactions', function($join) {
                $join->on('users.id', '=', 'transactions.user_id')
                    ->where('transactions.status', '=', 'active');
            })
            ->select(
                'users.*',
                DB::raw('COUNT(transactions.id) as borrowed_count')
            )
            ->groupBy('users.id');

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('users.first_name', 'like', '%' . $request->search . '%')
                ->orWhere('users.last_name', 'like', '%' . $request->search . '%')
                ->orWhere('users.student_id', 'like', '%' . $request->search . '%')
                ->orWhere('users.email', 'like', '%' . $request->search . '%');
            });
        }

        $members = $query->orderBy('users.created_at', 'desc')
                        ->paginate(10)
                        ->appends($request->all());

        $totalMembersCount = DB::table('users')->where('role', 'member')->count();
        $activeCount = DB::table('users')->where('role', 'member')->where('status', 'active')->count();
        $suspendedCount = DB::table('users')->where('role', 'member')->where('status', 'suspended')->count();
        $newThisMonthCount = DB::table('users')
            ->where('role', 'member')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        return view('admin.membersPage', compact(
            'members', 
            'totalMembersCount', 
            'activeCount', 
            'suspendedCount', 
            'newThisMonthCount'
        ));
    }

    /* Display a single member's dashboard with logs. */
    public function show(Request $request, $id)
    {
        $member = DB::table('users')->where('id', $id)->first();
        if (!$member) {
            abort(404, 'Member student profile not found.');
        }

        // Fetch logs
        $borrowHistory = DB::table('transactions')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->select('books.title', 'transactions.borrow_date', 'transactions.return_date', 'transactions.status')
            ->where('transactions.user_id', $id)
            ->orderBy('transactions.borrow_date', 'desc')
            ->get();

        $penaltyHistory = DB::table('penalties')
            ->join('transactions', 'penalties.transaction_id', '=', 'transactions.id')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->select('books.title', 'penalties.amount', 'penalties.created_at as date', 'penalties.status')
            ->where('transactions.user_id', $id)
            ->orderBy('penalties.created_at', 'desc')
            ->get();

        $currentBorrowed = DB::table('transactions')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->where('transactions.user_id', $id)
            ->where('transactions.status', 'active')
            ->select('books.title')
            ->get();

        return view('admin.viewMemberPage', compact('member', 'borrowHistory', 'penaltyHistory', 'currentBorrowed'));
    }

    /* Suspend a member's account */
    public function suspend(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            abort(404);
        }

        DB::table('users')
            ->where('id', $id)
            ->update([
                'status' => 'suspended',
                'updated_at' => Carbon::now(),
            ]);

        return redirect()->route('admin.memberManagement')->with('success', 'Account suspended successfully.');
    }

    public function edit($id)
{
    $member = DB::table('users')->where('id', $id)->first();
    
    $currentBorrowed = DB::table('transactions')
        ->join('books', 'transactions.book_id', '=', 'books.id')
        ->where('transactions.user_id', $id)
        ->where('transactions.status', 'active')
        ->select('books.title')
        ->get();

    $penaltyHistory = DB::table('penalties')
        ->join('transactions', 'penalties.transaction_id', '=', 'transactions.id')
        ->join('books', 'transactions.book_id', '=', 'books.id')
        ->select('books.title', 'penalties.amount', 'penalties.created_at as date', 'penalties.status')
        ->where('transactions.user_id', $id)
        ->get();

    return view('admin.editMemberPage', compact('member', 'currentBorrowed', 'penaltyHistory'));
}
}

