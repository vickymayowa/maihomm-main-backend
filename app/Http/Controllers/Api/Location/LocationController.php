<?php

namespace App\Http\Controllers\Api\Location;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Location\CountryResource;
use App\Models\Country;
use Exception;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCountries(){
        try {
            $countries = Country::get();
            $data = CountryResource::collection($countries);
            return ApiHelper::validResponse("Countries retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
