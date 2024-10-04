<?php

namespace App\Http\Controllers\Api\User;

use App\Constants\ApiConstants;
use App\Exceptions\Property\PropertyException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Properties\PropertyResource;
use App\Http\Resources\Properties\SavedProperties\SavedPropertiesResourcceCollection;
use App\Models\Property;
use App\Models\SavedProperty;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SavedPropertyController extends Controller
{
    public function list(Request $request)
    {
        try {
            $saved_properties = SavedProperty::where([
                "user_id" => auth()->id(),
            ])->get();
            $data = new SavedPropertiesResourcceCollection($saved_properties);
            return ApiHelper::validResponse("Saved properties returned successfully!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("No saved property at the momment", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function save(Request $request)
    {
        try {
            $data = $request->validate([
                "property_id" => "required|exists:properties,id",
            ]);

            $saved_property = SavedProperty::firstOrCreate([
                "user_id" => auth()->id(),
                "property_id" => $data["property_id"]
            ]);

            $data = PropertyResource::make($saved_property->property);
            return ApiHelper::validResponse("Property saved successfully", $data, $request);
        } catch (ValidationException $th) {
            return ApiHelper::problemResponse("The given data is invalid", ApiConstants::BAD_REQ_ERR_CODE, $request, $th);
        } catch (Exception $th) {
            return ApiHelper::problemResponse("An error occured while trying to process your request", ApiConstants::SERVER_ERR_CODE, $request, $th);
        }
    }

    public function remove(Request $request, $saved_property_id)
    {
        try {
            $saved_property = SavedProperty::find($saved_property_id);
            if (empty($saved_property)) {
                throw new PropertyException("Saved property not found");
            }
            $saved_property->delete();
            return ApiHelper::validResponse("Property removed successfully", null, $request);
        } catch (PropertyException $th) {
            return ApiHelper::problemResponse($th->getMessage(), ApiConstants::NOT_FOUND_ERR_CODE, $request, $th);
        } catch (Exception $th) {
            return ApiHelper::problemResponse("An error occured while trying to process your request", ApiConstants::SERVER_ERR_CODE, $request, $th);
        }
    }
}
