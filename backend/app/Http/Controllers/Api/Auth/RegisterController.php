<?php

namespace App\Http\Controllers\Api\Auth;

use Exception;
use App\Models\User;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Constants\ApiConstants;
use App\Services\Auth\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Auth\VerifyEmailService;
use App\Http\Resources\Users\UserResource;
use App\Models\VerifyEmail;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = UserService::store($request->all());
            $data =  UserResource::make($user)->toArray($request);
            $data["token"] = $user->createToken('AuthToken')->plainTextToken;
            DB::commit();
            return ApiHelper::validResponse("User registration successfull!", $data);
        } catch (ValidationException $e) {
            throw $e;
            return ApiHelper::inputErrorResponse("Invalid data", ApiConstants::VALIDATION_ERR_CODE, null, $e);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::BAD_REQ_ERR_CODE, null,  $e);
        }
    }

    public function resendEmailOtp($user_id){
        $user = User::find($user_id);

        if(!$user){
        return ApiHelper::problemResponse("Invalid User", ApiConstants::SERVER_ERR_CODE, null);
        }
        
        VerifyEmailService::sendOtp($user);
        
        return ApiHelper::validResponse("OTP sent!", "");
    }
            
        public function verifyEmailOtp(Request $request, $user_id){
            $user = User::find($user_id);

            if(!$user){
                return ApiHelper::problemResponse("Invalid User", ApiConstants::SERVER_ERR_CODE, null);
            }

            $otp = $request->otp;
            
            if(!$otp){
                return ApiHelper::problemResponse("Empty OTP", ApiConstants::SERVER_ERR_CODE, null);
            }
            
            $valid_otp = VerifyEmail::where('user_id', $user_id)->where('otp', $otp)->where('expires', '>=', time())->first();
            
            if(!$valid_otp){
                return ApiHelper::problemResponse("Invalid OTP", ApiConstants::SERVER_ERR_CODE, null);
            }

            // update user email verified
            $user->update(['email_verified_at' => time()]);
            
            VerifyEmail::where('user_id', $user->id)->delete();

            return ApiHelper::validResponse("Email verified!", "");
        }
}
