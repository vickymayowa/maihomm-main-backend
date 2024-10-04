<?php

namespace App\Services\Dashboard;

use App\Constants\StatusConstants;
use App\Constants\TransactionConstants;
use App\Http\Resources\Notification\NotificationResource;
use App\Http\Resources\Properties\PropertyResource;
use App\Models\Booking;
use App\Services\Finance\UserTransactionService;
use App\Services\Finance\Wallet\WalletService;
use App\Services\Investment\InvestmentService;
use App\Services\Portfolio\PortfolioService;
use App\Services\Property\PropertyService;

class DashboardService
{
    public static function overview()
    {
        $user = auth()->user();
        $wallet = WalletService::getByUserId($user->id);
        $portfolio = PortfolioService::userPortfolio($user->id);
        $properties = PropertyService::propertyOwner();
        $booking = Booking::with('property')->where('user_id', $user->id)->latest()->first();
        $transaction = UserTransactionService::getByUser($user);
        $account_funding = $transaction->where("type", TransactionConstants::CREDIT)->sum("amount");
        $withdrawal = $transaction->where("type", TransactionConstants::DEBIT)->sum("amount");
        $investment_value = (new InvestmentService())->investmentValue($user->id);
        $data = [
            "wallet_balance" => (double) $wallet->balance,
            "amount_invested" => (double) $portfolio->investment_value,
            "current_value" => (double) $portfolio->current_value,
            "reward" => 0,
            "booking" => $booking,
            "investment_value" => (double) $investment_value,
            "recent_transactions" => [
                "account_funding" => $account_funding,
                "withdrawal" => $withdrawal,
                "property" => 0
            ],
            "my_properties" => PropertyResource::collection($properties),
            "my_notifications" => NotificationResource::collection($user->notifications)
        ];
        return $data;
    }
}
