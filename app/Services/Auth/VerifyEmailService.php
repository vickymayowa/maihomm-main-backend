<?php

namespace App\Services\Auth;

use App\Constants\AppConstants;
use App\Constants\CurrencyConstants;
use App\Constants\StatusConstants;
use App\Models\User;
use App\Models\VerifyEmail;
use App\Notifications\Auth\EmailVerificationNotification;
use App\Notifications\Auth\SignupNotification;
use App\Services\Finance\Wallet\WalletService;
use App\Services\Portfolio\PortfolioService;
use Illuminate\Support\Facades\Hash;

class VerifyEmailService
{
    static function sendOtp(User $user){
        $otp = rand(100000, 999999);

        // delete previous otp
        VerifyEmail::where('user_id', $user->id)->delete();

        VerifyEmail::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires' => time() + (10 * 60),
        ]);

        $user->notify(new EmailVerificationNotification($otp));
    }
}