<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class GuestPropertyController extends Controller
{
    public function addCoOwner(Request $request, $id)
    {
        // Get the authenticated guest
        $guest = Auth::user();

        // Check if the guest has completed KYC successfully
        if ($guest->kyc_status !== 'completed') {
            return redirect()->back()->withErrors(['message' => 'KYC not completed.']);
        }

        // Find the property by ID
        $property = Property::findOrFail($id);

        // Attach the guest as a co-owner of the property
        $property->coOwners()->attach($guest->id);

        // Redirect back to the property page with a success message
        return redirect()->route('guest.properties.show', $id)->with('status', 'You have been added as a co-owner.');
    }
}
