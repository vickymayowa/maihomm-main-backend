<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Booking;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function viewApartments()
    {
        $apartments = Apartment::where('available', true)->get();
        return response()->json($apartments);
    }

    public function bookApartment(Request $request)
    {
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'apartment_id' => $request->apartment_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json(['message' => 'Booking successful', 'booking' => $booking]);
    }
}
