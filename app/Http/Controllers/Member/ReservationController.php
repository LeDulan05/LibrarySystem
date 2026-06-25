<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
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

    public function destroy(Request $request, \App\Models\Reservation $reservation)
    {
        // Ensure user owns this reservation
        if ($reservation->user_id !== $request->user()->id) {
            abort(403);
        }

        // Only allow canceling if pending
        if ($reservation->status === 'pending') {
            $reservation->delete();
            
            // Re-sequence queue positions for remaining reservations of this book
            $pendingReservations = \App\Models\Reservation::where('book_id', $reservation->book_id)
                ->where('status', 'pending')
                ->orderBy('created_at')
                ->get();
                
            $pos = 1;
            foreach ($pendingReservations as $r) {
                $r->update(['queue_position' => $pos++]);
            }
        }

        return redirect()->back();
    }
}
