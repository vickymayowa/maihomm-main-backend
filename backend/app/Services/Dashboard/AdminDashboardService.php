<?php

namespace App\Services\Dashboard;

use App\Constants\StatusConstants;
use App\Http\Resources\Payment\PaymentResource;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardService
{
    public static function overview()
    {
        $users = [];
        $today = Carbon::today();
        for ($i = 0; $i < 7; $i++) {
            $currentMonth = $today->format('F Y');

            $total = User::whereYear('created_at', $today->year)
                ->whereMonth('created_at', $today->month)
                ->withTrashed()
                ->count();

            $users[$currentMonth] = [
                'amount_joined' => $total
            ];
            $today->startOfMonth();
            $today->subMonth();
        }
        $user_init = new User;
        $active_users = $user_init->where("status", StatusConstants::ACTIVE)->count();
        $payments = Payment::latest()->take(5)->get();
        $data = [
            "registered_users_chart" => $users,
            "all_users_count" => $user_init->count(),
            "active_users_count" => $active_users,
            "recent_payments" => PaymentResource::collection($payments),
            "trannsaction_value" => [
                "total_investors" => 0,
                "transaction_volume" => 0,
                "transaction_value" => 0
            ],
            "recent_transactions" => [
                "account_funding" => 0,
                "withdrawals" => 0,
                "property" => 0
            ]
        ];
        return $data;
    }
}
