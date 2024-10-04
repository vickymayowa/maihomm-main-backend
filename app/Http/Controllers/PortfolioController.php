<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    public function show(Request $request)
    {
        $portfolio = $request->user()->portfolio;
        
        return response()->json($portfolio, 200);
    }

    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'description' => 'required|string',
        ]);
        $portfolio = $request->user()->portfolio;
        $portfolio->description = $request->input('description');
        $portfolio->save();

        return response()->json(['message' => 'Portfolio updated successfully', 'portfolio' => $portfolio], 200);
    }
}
