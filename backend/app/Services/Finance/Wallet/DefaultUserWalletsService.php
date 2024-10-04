<?php

namespace App\Services\Finance\Wallet;

use App\Constants\CurrencyConstants;
use App\Models\User;

class DefaultUserWalletsService
{

    public static function setup(User $user)
    {
        WalletService::getByCurrencyType($user->id , CurrencyConstants::POUND_CURRENCY);
    }

}
