<?php

namespace App\Services\Finance\Wallet;

use Exception;
use App\Models\User;
use App\Constants\StatusConstants;
use Illuminate\Support\Facades\DB;
use App\Constants\TransactionConstants;
use App\Services\System\ExceptionService;
use App\Services\System\TransactionService;
use App\Services\Finance\Wallet\WalletService;
use App\Constants\TransactionActivityConstants;
use App\Services\Finance\UserTransactionService;

class WalletTransferService
{
    public static function process($sender_id, $receiver_id, $currency_type, $amount, $description = null)
    {
        DB::beginTransaction();
        try {
            $sender = User::find($sender_id);
            $receiver = User::find($receiver_id);

            $sender_wallet = WalletService::getByCurrencyType($sender->id, $currency_type);
            $receiver_wallet = WalletService::getByCurrencyType($receiver->id, $currency_type);

            $fee = $amount * (TransactionConstants::WALLET_TRANSFER_PERCENT_FEE / 100);
            $debit_amount = $amount + $fee;
            $batchNo = UserTransactionService::generateBatchNo();

            WalletService::debit($sender_wallet, $debit_amount);
            UserTransactionService::create([
                "user_id" => $sender_wallet->user_id,
                "currency_id" => $sender_wallet->currency_id,
                "amount" => $debit_amount,
                "fees" => $fee,
                "description" => "Transfered funds to " . $receiver->names(),
                "activity" => TransactionActivityConstants::WALLET_TRANSFER,
                "batch_no" => $batchNo,
                "type" => TransactionConstants::DEBIT,
                "status" => StatusConstants::COMPLETED
            ]);

            WalletService::credit($receiver_wallet, $amount);
            UserTransactionService::create([
                "user_id" => $receiver_wallet->user_id,
                "currency_id" => $receiver_wallet->currency_id,
                "amount" => $amount,
                "fees" => 0,
                "description" => $description ?? "Funds transfer from " . $sender->names(),
                "activity" => TransactionActivityConstants::WALLET_TRANSFER,
                "batch_no" => $batchNo,
                "type" => TransactionConstants::CREDIT,
                "status" => StatusConstants::COMPLETED
            ]);

            if ($fee > 0) {
                TransactionService::recordWalletTransferRevenue($sender_wallet->currency_id, $fee);
            }


            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            ExceptionService::broadcastOnAllChannels($e);
            throw $e;
        }
    }
}
