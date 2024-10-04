<?php

namespace App\Services\Reward;

use App\Constants\CurrencyConstants;
use App\Constants\StatusConstants;
use App\Constants\TransactionActivityConstants;
use App\Constants\TransactionConstants;
use App\Models\Referral;
use App\Models\User;
use App\Services\Finance\CurrencyService;
use App\Services\Finance\UserTransactionService;
use App\Services\Finance\Wallet\WalletService;
use Illuminate\Support\Facades\DB;

class ReferralService
{
    // const REFERRAL_SESSION_KEY = "ref_invite_code";
    const REFERRAL_BONUS_CURRENCY = CurrencyConstants::POUND_CURRENCY;
    const REFERRAL_BONUS_AMOUNT = 50;

    public static function newReferral($new_user_id, $ref_code = null)
    {
        DB::beginTransaction();
        try {
            $newUser = User::find($new_user_id);
            if (empty($newUser)) {
                return;
            }
            $currency = CurrencyService::getByType(self::REFERRAL_BONUS_CURRENCY);
            $referrerUser = User::where("ref_code", $ref_code)->first();
            if (empty($referrerUser)) {
                return;
            }
            $data = [
                "user_id" => $newUser->id,
                "referrer_id" => $referrerUser->id ?? null,
                "currency_id" => $currency->id,
                "bonus" => self::REFERRAL_BONUS_AMOUNT,
                // "is_auto" => 1,
                "status" => StatusConstants::PENDING
            ];
            if (!empty($ref_code) && !empty($referrerUser)) {
                $data["referrer_id"] = $referrerUser->id;
                // $data["is_auto"] = 0;
            }
            
            $referral = Referral::firstOrCreate(
                [
                    "user_id" => $data["user_id"],
                    "referrer_id" => $data["referrer_id"],
                ],
                $data
            );
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            throw $th;
        }
    }

    public static function rewardReferrer(Referral $referral)
    {
        $user = $referral->user;
        $creditAmount = $referral->bonus;
        $wallet = WalletService::getByCurrencyId(
            $referral->referrer_id,
            $referral->currency_id
        );
        WalletService::credit($wallet, $creditAmount);
        UserTransactionService::create([
            "user_id" => $wallet->user_id,
            "currency_id" => $wallet->currency_id,
            "amount" => $creditAmount,
            "fees" => 0,
            "description" => "Referral bonus for " . $user->names(),
            "activity" => TransactionActivityConstants::REFERRAL_BONUS,
            "batch_no" => null,
            "type" => TransactionConstants::CREDIT,
            "status" => StatusConstants::COMPLETED
        ]);
        $referral->update([
            "status" => StatusConstants::COMPLETED
        ]);
    }

    public static function rewardReferrerIfEligible($user_id)
    {
        DB::beginTransaction();
        try {
            $referral = Referral::where("user_id", $user_id)->first();
            if (
                !empty($referral) &&
                $referral->status == StatusConstants::PENDING
            ) {
                self::rewardReferrer($referral);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public static function amountIsEligible($transaction_amount, $price_per_dollar)
    {
        return ($transaction_amount / $price_per_dollar) >= 1;
    }
}
