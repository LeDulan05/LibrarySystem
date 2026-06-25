<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of library reservation requests with analytic metrics.
     */
    public function index(Request $request)
    {
        // 1. Query reservations from database linked with user metrics and book schemas
        $query = DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('books', 'reservations.book_id', '=', 'books.id')
            ->select(
                'reservations.*',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'books.title as book_title'
            );

        // Optional filter capability
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('users.first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('users.last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('books.title', 'like', '%' . $request->search . '%');
            });
        }

        $reservations = $query->orderBy('reservations.created_at', 'desc')->paginate(10);

        // 2. Aggregate dashboard calculation blocks matching design metrics (image_213b45.png)
        $totalReservations = DB::table('reservations')->count();
        $pendingApproval = DB::table('reservations')->where('status', 'pending')->count();
        $approvedCount = DB::table('reservations')->where('status', 'approved')->count();

        return view('admin.reservationRequestPage', compact(
            'reservations', 
            'totalReservations', 
            'pendingApproval', 
            'approvedCount'
        ));
    }

    /**
     * Display detailed parameters for a single reservation row entity.
     */
    public function show($id)
    {
        $requestData = DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('books', 'reservations.book_id', '=', 'books.id')
            ->select(
                'reservations.*',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'users.student_number',
                'books.title as book_title',
                'books.isbn',
                'books.available_copies'
            )
            ->where('reservations.id', $id)
            ->first();

        if (!$requestData) {
            abort(404, 'Reservation request not found.');
        }

        return view('admin.viewReservationRequestPage', compact('requestData'));
    }

    /**
     * Approve a reservation request.
     */
    public function approve($id)
    {
        $reservation = DB::table('reservations')->where('id', $id)->first();
        if (!$reservation || $reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Reservation cannot be processed.');
        }

        // Set hold date window parameters dynamically (Standard library hold window is 3 days)
        DB::table('reservations')->where('id', $id)->update([
            'status' => 'approved',
            'hold_expires_at' => Carbon::now()->addDays(3),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('admin.reservationRequest')->with('success', 'Reservation request approved.');
    }

    /**
     * Reject a reservation request.
     */
    public function reject($id)
    {
        $reservation = DB::table('reservations')->where('id', $id)->first();
        if (!$reservation || $reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Reservation cannot be processed.');
        }

        DB::table('reservations')->where('id', $id)->update([
            'status' => 'rejected',
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('admin.reservationRequest')->with('success', 'Reservation request rejected.');
    }
}
