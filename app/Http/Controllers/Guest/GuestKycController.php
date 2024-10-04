<?php
namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestKycController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'identification_number' => 'required|string|max:255',
            'proof_of_address' => 'required|file|mimes:jpeg,png,pdf',
        ]);

        // Get the authenticated user (guest)
        $guest = Auth::user();  // Make sure this is returning a valid user model instance

        // Perform operations on the user model (guest)
        $guest->kyc_status = 'completed';  // Example of setting a field
        $guest->save();  // This should work if $guest is an Eloquent model

        return redirect()->route('guest.profile')->with('status', 'KYC completed successfully.');
    }
}