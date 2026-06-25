<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationController extends Controller
{
    
public function index(Request $request)
{
    $query = DB::table('reservations')
        ->join('users', 'reservations.user_id', '=', 'users.id')
        ->join('books', 'reservations.book_id', '=', 'books.id')
        ->select(
            'reservations.*',
            'reservations.created_at as request_date',
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

    $reservations = $query->orderBy('reservations.created_at', 'desc')
                          ->paginate(10)
                          ->appends($request->all());

    // Calculate metrics matching what reservationRequestPage.blade.php expects
    $totalReservations = DB::table('reservations')->count();
    $pendingApproval = DB::table('reservations')->where('status', 'pending')->count(); // Changed to match your Blade variable name
    $approvedCount = DB::table('reservations')->where('status', 'approved')->count();
    $rejectedCount = DB::table('reservations')->where('status', 'rejected')->count();

    return view('admin.reservationRequestPage', compact(
        'reservations',
        'totalReservations',
        'pendingApproval', // Pass the correct variable name to your view
        'approvedCount',
        'rejectedCount'
    ));
}

    public function show($id)
    {
        $requestData = DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('books', 'reservations.book_id', '=', 'books.id')
            ->select(
                'reservations.*',
                'reservations.created_at as request_date',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'users.student_id as student_number',
                'users.email as member_email',
                'books.title as book_title',
                'books.isbn',
                'books.author'
            )
            ->where('reservations.id', $id)
            ->first();

        if (!$requestData) {
            abort(404, 'Reservation request not found.');
        }

        return view('admin.viewReservationReqPage', compact('requestData'));
    }

    public function approve($id)
    {
        $reservation = DB::table('reservations')->where('id', $id)->first();
        if (!$reservation || $reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Reservation cannot be processed.');
        }

        DB::table('reservations')->where('id', $id)->update([
            'status' => 'fulfilled',  
            'hold_expires_at' => Carbon::now()->addDays(3),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('admin.reservation.receipt', $id)->with('success', 'Reservation request approved.');
    }

    public function reject(Request $request, $id)
    {
        $reservation = DB::table('reservations')->where('id', $id)->first();
        if (!$reservation || $reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Reservation cannot be processed.');
        }

        $reason = $request->input('rejection_reason', 'Unspecified administrative reason');

        DB::table('reservations')->where('id', $id)->update([
            'status' => 'cancelled', 
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('admin.reservation.receipt', $id)->with('success', 'Reservation request rejected.');
    }

    public function receipt($id)
    {
        $slip = DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('books', 'reservations.book_id', '=', 'books.id')
            ->select(
                'reservations.id',
                'reservations.created_at as request_date',
                'reservations.hold_expires_at',
                'reservations.status',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as member_name"),
                'users.student_id',
                'books.title as book_title',
                'books.isbn'
            )
            ->where('reservations.id', $id)
            ->first();

        return view('admin.reservationReqSlip', compact('slip'));
    }
}