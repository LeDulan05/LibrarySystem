<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // TODO: matches "My Reservations" screen
    public function index(Request $request)
    {
        $reservations = $request->user()->reservations()->with('book')->get();

        return view('user.reservationsPage', compact('reservations'));
    }

    public function store(Request $request, Book $book)
    {
        if ($book->isAvailable()) {
            return response()->json(['stub' => 'reserve blocked, copies are available, borrow instead'], 422);
        }

        // Calculate queue position
        $queuePosition = \App\Models\Reservation::where('book_id', $book->id)
            ->where('status', 'pending')
            ->count() + 1;

        // Create reservation
        $request->user()->reservations()->create([
            'book_id' => $book->id,
            'status' => 'pending',
            'reservation_date' => now(),
            'queue_position' => $queuePosition,
        ]);

        return response()->json(['success' => true]);
    }
}
