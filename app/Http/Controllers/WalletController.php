<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function showBalance(Request $request)
    {
        $wallet = $request->user()->wallet;
        return response()->json(['balance' => $wallet->balance], 200);
    }

    public function addFunds(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);

        $wallet = $request->user()->wallet;
        $wallet->addFunds($request->amount);

        return response()->json(['message' => 'Funds added successfully', 'balance' => $wallet->balance], 200);
    }

    public function withdrawFunds(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);

        $wallet = $request->user()->wallet;
        if ($wallet->deductFunds($request->amount)) {
            return response()->json(['message' => 'Funds withdrawn successfully', 'balance' => $wallet->balance], 200);
        }

        return response()->json(['message' => 'Insufficient balance'], 400);
    }
}
