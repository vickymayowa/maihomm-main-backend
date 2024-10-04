<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;

class HomeController extends Controller
{
    public function index()
    {
        return view("auth.login");
    }

    public function read_file($path)
    {
        return getFileFromPrivateStorage(readFileUrl("decrypt", $path));
    }

    public function getState($country_id)
    {
        $states = State::where("country_id", $country_id)->pluck("name", "id");
        return response()->json([
            'states' => $states,
        ]);
    }
    public function getCity($state_id)
    {
        $cities = City::where("state_id", $state_id)->pluck('name', "id");
        return response()->json([
            'cities' => $cities
        ]);
    }
}
