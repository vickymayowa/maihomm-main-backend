<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;

class CoOwnerController extends Controller
{
    public function manageProperties()
    {
        $properties = Property::where('owner_id', auth()->id())->get();
        return response()->json($properties);
    }

    public function addProperty(Request $request)
    {
        $property = Property::create([
            'owner_id' => auth()->id(),
            'name' => $request->name,
            'location' => $request->location,
            'price' => $request->price,
        ]);

        return response()->json(['message' => 'Property added successfully', 'property' => $property]);
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
