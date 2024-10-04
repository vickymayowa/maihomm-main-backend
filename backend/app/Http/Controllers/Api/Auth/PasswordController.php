<?php

namespace App\Http\Controllers\Api\Auth;

use App\Constants\ApiConstants;
use App\Exceptions\UserException;
use App\Helpers\ApiHelper;
use App\Services\Api\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordController
{
    public function sendResetEmail(Request $request)
    {
        try {
            AuthService::sendPasswordResetPin($request);
            return ApiHelper::validResponse("Password email sent!");
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse("Invalid data", ApiConstants::VALIDATION_ERR_CODE, null, $e);
        } catch (UserException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::BAD_REQ_ERR_CODE, null,  $e);
        }
    }

    public function passwordReset(Request $request)
    {
        try {
            AuthService::passwordReset($request->all());
            return ApiHelper::validResponse("Password reset successfull!");
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse("Invalid data", ApiConstants::VALIDATION_ERR_CODE, null, $e);
        } catch (UserException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::BAD_REQ_ERR_CODE, null,  $e);
        }
    }

    public function changePassword(Request $request)
    {
        DB::beginTransaction();
        try {
            AuthService::changePassword($request);
            DB::commit();
            return ApiHelper::validResponse("Password changed successfully!");
        } catch (UserException $e) {
            return ApiHelper::problemResponse("Invalid data", ApiConstants::VALIDATION_ERR_CODE, null, $e);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::BAD_REQ_ERR_CODE, null,  $e);
        }
    }
}
