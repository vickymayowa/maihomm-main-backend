<?php

namespace App\Http\Controllers\Dashboard\Admin\Property;

use App\Constants\NotificationConstants;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertySpecification;
use App\Services\Property\PropertySpecificationService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PropertySpecController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Property $property)
    {
        try {
            PropertySpecificationService::save($request->all());
            return redirect()->back()->with(NotificationConstants::SUCCESS_MSG, "Property specification added successfully");
        } catch (ValidationException $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with(NotificationConstants::ERROR_MSG, "An error ocurred while trying to process you request");
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property, $id)
    {
        try {
            PropertySpecificationService::save($request->all(), $id);
            return redirect()->back()->with(NotificationConstants::SUCCESS_MSG, "Property specification updated successfully");
        } catch (ValidationException $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with(NotificationConstants::ERROR_MSG, "An error ocurred while trying to process you request");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property, $id)
    {
        $property_spec = PropertySpecification::findOrFail($id);
        $property_spec->delete();
        return redirect()->back()->with(NotificationConstants::SUCCESS_MSG, "Property specification deleted successfully");
    }
}
