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
        $guest = Auth::user(); 
        $guest->kyc_status = 'completed';  
        $guest->save();

        return redirect()->route('guest.profile')->with('status', 'KYC completed successfully.');
    }
}