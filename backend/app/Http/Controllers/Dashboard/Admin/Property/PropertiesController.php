<?php

namespace App\Http\Controllers\Dashboard\Admin\Property;

use App\Constants\AppConstants;
use App\Constants\NotificationConstants;
use App\Constants\PropertyConstants;
use App\Constants\StatusConstants;
use App\Exceptions\Property\PropertyException;
use App\Http\Controllers\Controller;
use App\Imports\PropertyImport;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\QueryBuilders\General\PropertyQueryBuilder;
use App\Services\Property\PropertyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $properties = PropertyQueryBuilder::filterIndex($request)
            ->latest()
            ->paginate(AppConstants::ADMIN_PAGINATION_SIZE)
            ->appends($request->query());
        return view("dashboards.admin.property.property-list", [
            "properties" => $properties,
            "sn" => $properties->firstItem()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboards.admin.property.create", [
            "statusOptions" => PropertyConstants::STATUS_OPTIONS,
            "categories" => PropertyCategory::get(),
            "currencies" => Currency::get(),
            "countries" => Country::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request["created_by"] = auth()->id();
            $property = PropertyService::create($request->all());
            DB::commit();
            return redirect()->route("dashboard.admin.properties.show", $property->id)
                ->with(NotificationConstants::SUCCESS_MSG, "Property created successfully");
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
            Log::info($e->getMessage(), $request->all());
            DB::rollBack();
            return back()->withInput($request->query())
                ->with(NotificationConstants::ERROR_MSG, "Something went wrong while processing your request");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $property = Property::with(["category", "files"])->findOrFail($id);
        return view("dashboards.admin.property.show", [
            "property" => $property,
            "specGroups" => PropertyConstants::SPEC_GROUPS,
            "iconGroups"=> PropertyConstants::ICON_OPTIONS,
            "boolOptions" => StatusConstants::BOOL_OPTIONS,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view("dashboards.admin.property.create", [
            "property" => Property::find($id),
            "currencies" => Currency::get(),
            "countries" => Country::get(),
            "statusOptions" => PropertyConstants::STATUS_OPTIONS,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         DB::beginTransaction();
        try {
            $request["created_by"] = auth()->id();
            $property = PropertyService::update($request->all(), $id);
            DB::commit();
            return redirect()->route("dashboard.admin.properties.show", $property->id)
                ->with(NotificationConstants::SUCCESS_MSG, "Property updated successfully");
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage(), $request->all());
            return back()->withInput($request->query())
                ->with(NotificationConstants::ERROR_MSG, "Something went wrong while processing your request");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PropertyService::delete($id);
        return back()->with(NotificationConstants::ERROR_MSG, "Property deleted successfully");
    }

    public function uploadFiles(Request $request, $property_id)
    {
        try {
            PropertyService::uploadPropertyFiles($request->all(), $property_id);
            return back()->with(NotificationConstants::SUCCESS_MSG, "Files uploaded successfully");
        } catch (ValidationException $e) {
            return back()->with(NotificationConstants::ERROR_MSG, $e->getMessage());
        } catch (Exception $e) {
            return back()->with(NotificationConstants::ERROR_MSG, "Something went wrong while processing your request");
        }
    }

    public function changeSingleFile(Request $request, $image_id)
    {
        try {
            PropertyService::changeSinglePropertyFile($request->all(), $image_id);
            return back()->with(NotificationConstants::SUCCESS_MSG, "Files updated successfully");
        } catch (ValidationException $e) {
            return back()->with(NotificationConstants::ERROR_MSG, $e->getMessage());
        } catch (PropertyException $e) {
            return back()->with(NotificationConstants::ERROR_MSG, $e->getMessage());
        } catch (Exception $e) {
            throw $e;
            return back()->with(NotificationConstants::ERROR_MSG, "Something went wrong while processing your request");
        }
    }
    public function deleteSingleFile($file_id)
    {
        try {
            PropertyService::deleteSinglePropertyFile($file_id);
            return back()->with(NotificationConstants::SUCCESS_MSG, "File deleted successfully");
        } catch (ValidationException $e) {
            return back()->with(NotificationConstants::ERROR_MSG, $e->getMessage());
        } catch (Exception $e) {
            throw $e;
            return back()->with(NotificationConstants::ERROR_MSG, "Something went wrong while processing your request");
        }
    }
    public function upload(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'property_file' => 'nullable||mimes:xls,xlsx,csv,mimetypes:text/csv,text/plain,application/csv,text/comma-separated-values'
            ]);

            Excel::import(new PropertyImport, $request->file("property_file")->store('App/public'));
            DB::commit();

            return redirect()->back()->with(NotificationConstants::SUCCESS_MSG, "Properties uploaded sucessfully");
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
            return redirect()->back()->with(NotificationConstants::ERROR_MSG, "An error occurred");
        }
    }
}
