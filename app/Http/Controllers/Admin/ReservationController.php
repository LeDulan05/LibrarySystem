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

    public function approve(Reservation $reservation)
    {
        return response()->json(['stub' => 'reservation approved']);
    }
}
