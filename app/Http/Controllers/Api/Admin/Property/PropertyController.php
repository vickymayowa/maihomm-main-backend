<?php

namespace App\Http\Controllers\Api\Admin\Property;

use App\Constants\ApiConstants;
use App\Exceptions\Property\PropertyException;
use App\Exports\SamplePropertyExport;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Properties\PropertyResource;
use App\Imports\PropertyImport;
use App\Models\Property;
use App\QueryBuilders\General\PropertyQueryBuilder;
use App\Services\Property\PropertyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class PropertyController extends Controller
{
    public function list(Request $request)
    {
        try {
            $properties = PropertyQueryBuilder::filterIndex($request)->with(["defaultImage", "specifications"])->latest()->paginate();
            $data = ApiHelper::collect_pagination($properties);
            $data["data"] = PropertyResource::collection($data["data"]);
            return ApiHelper::validResponse("Properties retrieved", $data);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $data["created_by"] = auth()->id();
            $property = PropertyService::create($data);
            $property->load("defaultImage");
            $data = PropertyResource::make($property);
            return ApiHelper::validResponse("Properties added successfully", $data);
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function show($property_id)
    {
        try {
            $property = Property::with(["defaultImage","files", "specifications" , "amenities"])->findOrFail($property_id);
            $data = PropertyResource::make($property);
            return ApiHelper::validResponse("Property retrieved successfully!", $data);
        } catch (PropertyException $e) {
            return ApiHelper::problemResponse("No property found", ApiConstants::BAD_REQ_ERR_CODE, null,  $e);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $property = PropertyService::update($data, $id);
            $property->load("defaultImage");
            $data = PropertyResource::make($property);
            return ApiHelper::validResponse("Properties updated successfully", $data);
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (PropertyException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function exportSample(Request $request)
    {
        try {
            $filename = "sample-property.xlsx";
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            $export = new SamplePropertyExport();
            return Excel::download($export, 'sample-property.xlsx', null, $headers);
            // return ApiHelper::validResponse("Properties sample exported successfully");
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (PropertyException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required||mimes:xls,xlsx,csv,mimetypes:text/csv,text/plain,application/csv,text/comma-separated-values'
            ]);
            Excel::import(new PropertyImport($request), $request->file('file')->store('App/public'));
            return ApiHelper::validResponse("Properties imported successfully");
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (PropertyException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function addFiles(Request $request, $property_id)
    {
        try {
            $data = $request->all();
            $property = PropertyService::uploadPropertyFiles($data, $property_id);
            $data = PropertyResource::make($property);
            return ApiHelper::validResponse("File added successfully", $data);
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (PropertyException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function removeFiles(Request $request, $property_id)
    {
        try {
            $data = $request->validate([
                "file_ids" => "required|array"
            ]);
            PropertyService::deleteFiles($property_id , $data["file_ids"]);
            return ApiHelper::validResponse("Files deleted successfully");
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (PropertyException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function destroy($id)
    {
        try {
            PropertyService::delete($id , false);
            return ApiHelper::validResponse("Property deleted successfully");
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (PropertyException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
}
