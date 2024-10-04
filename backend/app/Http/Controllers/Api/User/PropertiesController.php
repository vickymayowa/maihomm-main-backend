<?php

namespace App\Http\Controllers\Api\User;

use App\Constants\ApiConstants;
use App\Constants\PropertyConstants;
use App\Constants\StatusConstants;
use App\Exceptions\Property\PropertyException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Properties\PropertyResource;
use App\Models\Property;
use App\QueryBuilders\General\PropertyQueryBuilder;
use App\Services\Property\PropertyService;
use Exception;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    public function list(Request $request)
    {
        try {
            $properties = PropertyQueryBuilder::filterIndex($request)
            ->with(["defaultImage", "specifications"])->latest()->paginate();
            $data = ApiHelper::collect_pagination($properties);
            $data["data"] =  PropertyResource::collection($data["data"]);
            return ApiHelper::validResponse("Properties retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function sell(Request $request)
    {
        try {
            $data = $request->all();
            PropertyService::sell($data);
            return ApiHelper::validResponse("Request sent succesfully!");
        } catch (Exception $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function show(Request $request, $property_id)
    {
        try {
            $property = Property::with(["defaultImage", "files", "specifications"])
            ->findOrFail($property_id);
            $data = PropertyResource::make($property);
            return ApiHelper::validResponse("Property retrieved successfully!", $data);
        } catch (PropertyException $e) {
            return ApiHelper::problemResponse("No property found", ApiConstants::BAD_REQ_ERR_CODE, null,  $e);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function relatedProperties(Request $request, $property_id)
    {
        try {
            $related_properties = PropertyService::getRelatedProperties($request, $property_id);
            $data = ApiHelper::collect_pagination($related_properties);
            $data["data"] = PropertyResource::collection($data["data"]);
            return ApiHelper::validResponse("Related properties retrieved!", $data);
        } catch (PropertyException $e) {
            return ApiHelper::problemResponse("No property found", ApiConstants::BAD_REQ_ERR_CODE, null,  $e);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function addToFavorites($property_id)
    {
        try {
            PropertyService::addToFavorites($property_id);
            return ApiHelper::validResponse("Property added to favorite");
        } catch (Exception $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
