<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        // Fetch and return guest viewable properties
        $properties = Property::all();
        return view('guest.properties.index', compact('properties'));
    }

    public function show($id)
    {
        // Show a specific property to a guest
        $property = Property::findOrFail($id);
        return view('guest.properties.show', compact('property'));
    }
}
