<?php

namespace App\Services\Auth;

use App\Constants\AppConstants;
use App\Constants\CurrencyConstants;
use App\Constants\StatusConstants;
use App\Models\User;
use App\Notifications\Auth\SignupNotification;
use App\Services\Finance\Wallet\WalletService;
use App\Services\Portfolio\PortfolioService;
use Illuminate\Support\Facades\Hash;

class RegisterationService
{
    public static function generateUsername($firstname, $lastname = "", int $suffix = null)
    {
        $lastname = $lastname ?? " ";
        $username = $firstname . $lastname[0] ?? "";
        $username .= "$suffix";

        $check = User::where("username", $username)->count();
        if ($check > 0) {   
            return self::generateUsername($firstname, $lastname, ((int)$suffix) + 1);
        }
        return slugify(str_replace(" ", "", $username));
    }

    public static function generateRefCode()
    {
        $code = getRandomToken(8);
        $check = User::where("ref_code", $code)->withTrashed()->count();
        if ($check > 0) {
            return self::generateRefCode();
        }
        return $code;
    }


    public static function createUser($data): User
    {

        $data["role"] = ($data["email"] == AppConstants::SUDO_EMAIL) ? "Admin" : "User";
        $data["ref_code"] = self::generateRefCode();
        $data["password"] = Hash::make($data['password']);
        $data["status"] = StatusConstants::ACTIVE;

        unset($data["password_confirmation"]);
        return User::create($data);
    }


    public static function postRegisterActions(User $user)
    {
        VerifyEmailService::sendOtp($user);
        $user->notify(new SignupNotification());
        PortfolioService::userPortfolio($user->id);
        WalletService::getByCurrencyType($user->id, CurrencyConstants::POUND_CURRENCY);
    }
}
