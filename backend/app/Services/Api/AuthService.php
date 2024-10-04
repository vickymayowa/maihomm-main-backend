<?php

namespace App\Services\Api;

use App\Constants\AppConstants;
use App\Exceptions\PinException;
use App\Exceptions\UserException;
use App\Models\Pin;
use App\Models\User;
use App\Services\Notifications\AppMailerService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public static function validate(array $data)
    {
        $validator = Validator::make($data, [
            'password' => 'required|min:6',
            'email' => 'required|email|exists:users,email',
        ], [
            "email.exists" => "This email does not exist in our records",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    public static function action($data)
    {
        $data = self::validate($data);
        $user = User::where('email', $data["email"])->first();
        if (empty($user)) {
            throw new UserException("Email address not found");
        }
        if (!Hash::check($data["password"], $user->password)) {
            throw new UserException("Invalid credentials");
        }
        return $user;
    }

    public static function sendPasswordResetPin(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where("email", $request->email)->first();
        $pin_expiry = Carbon::now()->addMinutes(5);
        self::storeOtp($user, AppConstants::PASSWORD_RESET, "App/Model/User", $pin_expiry);
    }

    public static function send2FACode(User $user)
    {
        if (!$user->two_factor_auth) {
            return;
        }
        $pin_expiry = Carbon::now()->addMinutes(5);
        return self::storeOtp($user, AppConstants::TWO_FA, "App/Model/User", $pin_expiry);
    }

    public static function storeOtp($user, $type, $model, $expiry_at)
    {

        $configs = [
            AppConstants::PASSWORD_RESET => [
                "subject" => "Password Reset",
                "view" => "emails.user.password_reset"
            ],
            AppConstants::TWO_FA => [
                "subject" => "Two Factor Authentication Code",
                "view" => "emails.user.two_factor_auth"
            ],

        ];
        $config = $configs[$type] ?? null;
        if(empty($config)){
            throw new Exception("No configuration found for the Pin type " . $type );
        }

        Pin::where([
            'reference_id' => $user->id,
            'type' => $type,
            'model' => $model,
        ])->delete();

        $pin = Pin::create([
            'code' => self::generatePin(),
            'reference_id' => $user->id,
            'type' => $type,
            'model' => $model,
            'expires_at' => $expiry_at,
        ]);

        AppMailerService::send([
            "data" => [
                "pin" => $pin->code,
                'name' => $user->names(),

            ],
            "to" => $user->email,
            "template" => $config["view"],
            "subject" => $config["subject"],
        ]);

        return $pin;
    }
    public static function passwordReset(array $data)
    {
        $validator = Validator::make($data, [
            "new_password" => "required|string",
            "confirm_password" => "required|min:6|same:new_password",
            "code" => "required|string|min:6",
            "email" => "required|exists:users,email",

        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $data = $validator->validated();

        $user = User::where("email", $data["email"])->first();
        $pin = Pin::where("reference_id", $user->id)->latest()->first();
        if (!$user) {
            throw new UserException("User does not exist!");
        }
        if ($data["code"] == $pin->code) {
            $user->update([
                "password" => Hash::make($data["new_password"]),
            ]);
            $pin->delete();
        } else {
            throw new UserException("Invalid Pin");
        }
        $now = Carbon::now()->toDateTimeString();
        if ($pin->expires_at <= $now) {
            throw new PinException("Pin has expired, resend otp");
        }
        return $user;
    }

    public static function sendResetLink(array $data)
    {

        $validator = Validator::make($data, [
            "email" => "required|exists:users,email",
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $data = $validator->validated();
        $user = User::where("email", $data["email"])->first();
        $pin_expiry = Carbon::now()->addMinutes(5);
        $pin = self::generatePin($user->id, AppConstants::PASSWORD_RESET, "App/Model/User", $pin_expiry);
        AppMailerService::send([
            "data" => [
                "name" => $user->name,
                "otp" => $pin->code,
            ],
            "to" => $user->email,
            "template" => "emails.user.password_reset_link",
            "subject" => "Password Reset Link",
        ]);
        return $user;
    }
    public static function generatePin()
    {
        for ($key = mt_rand(1, 9), $i = 1; $i < 6; $i++) {
            $key .= mt_rand(0, 9);
        }
        $check = Pin::where("code", $key)->count();
        if ($check > 0) {
            return self::generatePin();
        }
        return $key;
    }

    public static function getUserRole($request)
    {
        dd($request);
    }

    public static function changePassword($request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            throw new UserException("Current password is incorrect.");
        }

        $user->update(["password" => Hash::make($request->new_password)]);
    }


    public static function verifyTwoFactorCode(array $data)
    {
        $validator = Validator::make($data, [
            "code" => "required|string|min:6",
            "email" => "required|exists:users,email",
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $data = $validator->validated();

        $user = User::where('email', $data["email"])->first();
        $pin = Pin::where("reference_id", $user->id)->where("type" , AppConstants::TWO_FA)->latest()->first();
        if (!$user) {
            throw new UserException("User does not exist!");
        }
        if ($data["code"] == $pin->code) {
            $pin->delete();
        } else {
            throw new UserException("Invalid Pin");
        }
        $now = Carbon::now()->toDateTimeString();
        if ($pin->expires_at <= $now) {
            throw new PinException("Pin has expired, resend otp");
        }
        return $user;
    }
}
