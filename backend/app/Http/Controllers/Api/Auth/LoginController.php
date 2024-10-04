<?php

namespace App\Http\Controllers\Api\Auth;

use Exception;
use App\Models\Pin;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Constants\ApiConstants;
use App\Exceptions\UserException;
use App\Services\Api\AuthService;
use App\Services\Auth\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Auth\VerifyEmailService;
use App\Http\Resources\Users\UserResource;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = AuthService::action($request->all());
            $data =  UserResource::make($user)->toArray($request);
            if (!$user->two_factor_auth) {
                $data["token"] = $user->createToken('AuthToken')->plainTextToken;
            } else {
                $pin =  AuthService::send2FACode($user);
                $data["2fa_token"] = encrypt($pin->id);
            }

            if($data['email_verified'] == 'no'){
                VerifyEmailService::sendOtp($user);
            }

            return ApiHelper::validResponse("User Logged In successfully", $data);
        } catch (ValidationException $e) {
            $message = "Input validation errors";
            return ApiHelper::inputErrorResponse("Input Error", ApiConstants::VALIDATION_ERR_CODE, null, $e);
        } catch (UserException $e) {
            $message = '';
            return ApiHelper::problemResponse("Error", ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, null, $e);
        }
    }

    public function me(Request $request)
    {
        try {
            $data =  UserResource::make($request->user())->toArray($request);
            return ApiHelper::validResponse("User retrieved successfully", $data);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, null, $e);
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout successful']);
    }

    public function resendTwoFactorCode(Request $request)
    {
        try {
            $request->validate([
                "2fa_token" => "required|string"
            ]);

            $pin_id = decrypt($request["2fa_token"]);
            $pin = Pin::with("user")->find($pin_id);
            if (empty($pin)) {
                throw new UserException("Invalid 2fa token provided");
            }
            $pin = AuthService::send2FACode($pin->user);
            $data["2fa_token"] = encrypt($pin->id);
            return ApiHelper::validResponse("Code resent successfully", $data);
        } catch (ValidationException $e) {
            $message = "Input validation errors";
            return ApiHelper::inputErrorResponse("Input Error", ApiConstants::VALIDATION_ERR_CODE, null, $e);
        } catch (UserException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, null, $e);
        }
    }

    public function verifyTwoFactorCode(Request $request)
    {
        try {
            $user = AuthService::verifyTwoFactorCode($request->all());
            return ApiHelper::validResponse("Code verified successfully" , [
                "token" => $user->createToken('AuthToken')->plainTextToken
            ]);
        } catch (ValidationException $e) {
            $message = "Input validation errors";
            return ApiHelper::inputErrorResponse("Input Error", ApiConstants::VALIDATION_ERR_CODE, null, $e);
        } catch (UserException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, null, $e);
        }
    }
}
