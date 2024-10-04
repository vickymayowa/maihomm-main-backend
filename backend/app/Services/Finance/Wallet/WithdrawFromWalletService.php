<?php

namespace App\Services\Finance\Wallet;

use App\Models\BankAccount;
use App\Constants\StatusConstants;
use Illuminate\Support\Facades\DB;
use App\Constants\CurrencyConstants;
use App\Constants\TransactionConstants;
use App\Services\Finance\CurrencyService;
use Illuminate\Support\Facades\Validator;
use App\Services\Providers\ProviderService;
use App\Services\System\TransactionService;
use App\Services\Finance\Wallet\WalletService;
use Illuminate\Validation\ValidationException;
use App\Constants\TransactionActivityConstants;
use App\Services\Finance\UserTransactionService;
use App\Services\Finance\WithdrawalRequestService;
use App\Services\Providers\ProviderUserTransactionService;
use App\Exceptions\Finance\Wallet\WithdrawFromWalletException;
use App\Exceptions\Plan\SubscriptionException;
use App\Services\Plan\CreditSubscriptionService;
use App\Services\Plan\SubscriptionService;

class WithdrawFromWalletService
{

    public static function byProvider($provider_id, float $amount)
    {
        $user = auth()->user();

        if (!empty(CreditSubscriptionService::check($user->id))) {
            throw new SubscriptionException("You have to clear your pending credit subscription to process withdrawals.");
        }

        $provider = ProviderService::getById($provider_id);
        $wallet = WalletService::getByCurrencyType($user->id, CurrencyConstants::DOLLAR_CURRENCY);

        ProviderUserTransactionService::sendMoneyFromUserWalletToProviderClient(
            $wallet,
            $provider,
            $amount
        );
    }


    public static function withBank($data)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();

            if (!empty(CreditSubscriptionService::check($user->id))) {
                throw new SubscriptionException("You have to clear your pending credit subscription to process withdrawals.");
            }

            $currency = CurrencyService::getByType($data["currency_type"]);
            $account_id = null;
            $account = BankAccount::where("user_id", $user->id)->where("currency_id", $currency->id)->first();
            if (!empty($account)) {
                $account_id = $account->id;
            }

            $data = self::validateBankWithdrawal($data, $account_id);

            if (empty($account)) {
                BankAccount::create([
                    "currency_id" => $currency->id,
                    "user_id" => $user->id,
                    "bank_name" => $data["bank_name"],
                    "account_name" => $data["account_name"],
                    "account_number" => $data["account_number"],
                ]);
            }
            else{
                BankAccount::where([
                    "currency_id" => $currency->id,
                    "user_id" => $user->id,
                ])->update([
                    "bank_name" => $data["bank_name"],
                    "account_name" => $data["account_name"],
                    "account_number" => $data["account_number"],
                ]);
            }

            $amount = $data["amount"];
            $fee = $amount * (TransactionConstants::WALLET_WITHDRAWAL_WITH_BANK_PERCENT_FEE / 100);

            $wallet = WalletService::getByCurrencyId($user->id, $currency->id);
            WalletService::debit($wallet, ($amount + $fee));
            UserTransactionService::create([
                "user_id" => $wallet->user_id,
                "currency_id" => $wallet->currency_id,
                "amount" => $amount,
                "fees" => $fee,
                "description" => "Withdrawal with Bank",
                "activity" => TransactionActivityConstants::WITHDRAW_WITH_BANK,
                "batch_no" => null,
                "type" => TransactionConstants::DEBIT,
                "status" => StatusConstants::COMPLETED
            ]);


            WithdrawalRequestService::create([
                "currency_id" => $currency->id,
                "user_id" => $user->id,
                "amount" => $amount,
                "fee" => $fee,
                "bank_name" => $data["bank_name"],
                "account_name" => $data["account_name"],
                "account_number" => $data["account_number"],
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public static function validateBankWithdrawal($data, $account_id): array
    {
        $validator = Validator::make($data, [
            "currency_type" => "required|string",
            "amount" => "required|string",
            "bank_name" => "required|string",
            "account_name" => "required|string",
            "account_number" => "required|string|unique:bank_accounts,account_number,$account_id",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        if ($data["currency_type"] != CurrencyConstants::NAIRA_CURRENCY) {
            throw new WithdrawFromWalletException("You can only withdraw with Nigerian Naira at this time");
        }

        $min = TransactionConstants::WALLET_WITHDRAWAL_WITH_BANK_MINIMUM_AMOUNT;
        if ($data["amount"] < $min) {
            $min_f = number_format($min);
            throw new WithdrawFromWalletException("Minimum withdrawal amount is $min_f Nigerian Naira");
        }

        return $validator->validated();
    }
}
