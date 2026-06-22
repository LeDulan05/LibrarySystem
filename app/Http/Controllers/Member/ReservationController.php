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

        return response()->json(['stub' => 'my reservations', 'reservations' => $reservations]);
    }

    // TODO: only reachable when $book->isAvailable() is false, matches
    // "Book Reserve Confirmation" screen on success. Should set
    // queue_position based on how many pending reservations already
    // exist for this book.
    public function store(Request $request, Book $book)
    {
        if ($book->isAvailable()) {
            return response()->json(['stub' => 'reserve blocked, copies are available, borrow instead'], 422);
        }

        return response()->json(['stub' => 'reservation created, added to queue']);
    }
}
