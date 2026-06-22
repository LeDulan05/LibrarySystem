<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class ReservationController extends Controller
{
    // Matches "Reservation Request" + "Reservations" admin screens
    public function index()
    {
        return response()->json(['stub' => 'reservation queue', 'reservations' => Reservation::with(['user', 'book'])->get()]);
    }

    // TODO: only relevant if reservations need a separate manual approval
    // step beyond what ReturnController already triggers automatically,
    // worth confirming with the team whether this is needed at all
    public function approve(Reservation $reservation)
    {
        return response()->json(['stub' => 'reservation approved']);
    }
}
