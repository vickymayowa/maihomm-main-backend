<?php

namespace App\Http\Controllers\Api\Profile;

use App\Constants\ApiConstants;
use App\Exceptions\UserException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\LanguageResource;
use App\Models\Currency;
use App\Models\Language;
use App\Models\User;
use App\Services\Api\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    public function currencies()
    {
        try {
            $currencies  = Currency::get();
            $data = CurrencyResource::collection($currencies);
            return ApiHelper::validResponse("Currencies retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function languages()
    {
        try {
            $languages  = Language::get();
            $data = LanguageResource::collection($languages);
            return ApiHelper::validResponse("Languages retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function changePassword(Request $request)
    {
        DB::beginTransaction();
        try {
            AuthService::changePassword($request);
            DB::commit();
            return ApiHelper::validResponse("Password changed successfully!");
        } catch (ValidationException $th) {
            DB::rollBack();
            return ApiHelper::inputErrorResponse("The given data is invalid", ApiConstants::VALIDATION_ERR_CODE, null, $th);
        } catch (UserException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function updateField(Request $request)
    {
        try {

            // removed from fields - two_factor_auth
            $fields = [
                "hide_balance", "receive_email_notifications", "receive_text_notifications"
            ];
            $request->validate([
                "field" => "required|".Rule::in($fields),
                "enabled" => "required|in:0,1"
            ] , [
                "field.in" => "Available fields are: ".implode("," , $fields)
            ]);
            
            auth()->user()->update([
                $request->field => $request->enabled
            ]);
            return ApiHelper::validResponse("Ssetting updated successfully!");
        } catch (ValidationException $th) {
            return ApiHelper::inputErrorResponse("The given data is invalid", ApiConstants::VALIDATION_ERR_CODE, null, $th);
        } catch (UserException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
