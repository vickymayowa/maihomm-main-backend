<?php

namespace App\Http\Controllers\Api\Profile;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;
use App\Services\Auth\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            $data = new UserResource($user);
            return ApiHelper::validResponse("Profile retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                "avatar" => "required|image"
            ]);
            $user = UserService::uplaodPicture([
                "avatar_id" => $request->avatar
            ], auth()->id());
            $data = new UserResource($user);
            return ApiHelper::validResponse("Profile updated successfully!", $data);
        } catch (ValidationException $th) {
            return ApiHelper::inputErrorResponse("The given data is invalid", ApiConstants::VALIDATION_ERR_CODE, null, $th);
        } catch (\Throwable $th) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
