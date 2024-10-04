<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\SavedProperty;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SavedPropertyController extends Controller
{
    public function index()
    {
        $property_ids = SavedProperty::where("user_id", auth()->id())->get()
            ->pluck("property_id")->toArray();

        $properties = Property::whereIn("id", $property_ids)->get();
        return view("dashboards.user.saved_properties.index", [
            "properties" => $properties
        ]);
    }

    public function store(Request $request, Property $property)
    {
        try {
            $request["property_id"] = $property->id;
            $data = $request->validate([
                "property_id" => "required|exists:properties,id"
            ]);

            $data["user_id"] = auth()->id();
            $is_saved = SavedProperty::where([
                "user_id" => $data["user_id"],
                "property_id" => $data["property_id"]
            ])->first();

            if (empty($is_saved)) {
                SavedProperty::create([
                    "user_id" => $data["user_id"],
                    "property_id" => $data["property_id"]
                ]);
            } else {
                SavedProperty::where([
                    "user_id" => $data["user_id"],
                    "property_id" => $data["property_id"]
                ])->delete();
            }
            $in_saved_property = (empty($is_saved)) ? true : false;

            $is_saved = (empty($is_saved)) ? "Added to saved properties" : "Removed from saved properties";
            return ApiHelper::validResponse("Saved properties list updated successfully", [
                "display_text" => $is_saved,
                "in_saved" => $in_saved_property
            ], $request);
        } catch (ValidationException $th) {
            ApiHelper::inputErrorResponse("The given data is invalid", ApiConstants::VALIDATION_ERR_CODE, $request, $th);
        } catch (\Throwable $th) {
            return ApiHelper::problemResponse("An error occured", ApiConstants::SERVER_ERR_CODE, $request, $th);
        }
    }
}
