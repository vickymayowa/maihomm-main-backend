<?php

namespace App\Http\Controllers\Api\Admin\Amenities;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Amenities\AmenitiesResource;
use App\Models\Amenity;
use App\Services\Media\FileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AmenitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $amenities = Amenity::get();
            return ApiHelper::validResponse("Amenities retrieved", AmenitiesResource::collection($amenities));
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function validateData($request , $id = null)
    {
        return $request->validate([
            "name" => "required|string|unique:amenities,name,$id",
            "icon" => "nullable|image"
        ]);
    }
    public function store(Request $request)
    {
        try {
            $data = $this->validateData($request);
            if(!empty($file = $data["icon"] ?? null)){
                $fileService = new FileService;
                $savedFile = $fileService->saveFromFile($file, "amenities", null, auth()->id());
                $data["icon_id"] = $savedFile->id;
                unset($data["icon"]);
            }
            $amenity = Amenity::create($data);
            $data = AmenitiesResource::make($amenity);
            return ApiHelper::validResponse("Amenity created successfully!", $data);
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $this->validateData($request , $id);
            $amenity = Amenity::find($id);
            if (!empty($file = $data["icon"] ?? null)) {
                $fileService = new FileService;
                $savedFile = $fileService->saveFromFile($file, "amenities", $amenity->icon_id, auth()->id());
                $data["icon_id"] = $savedFile->id;
                unset($data["icon"]);
            }
            $amenity->update($data);
            $data = AmenitiesResource::make($amenity);
            return ApiHelper::validResponse("Amenity updated successfully!", $data);
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $amenity = Amenity::find($id);
            $amenity->delete();
            return ApiHelper::validResponse("Amenities deleted successfully!");
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
}
