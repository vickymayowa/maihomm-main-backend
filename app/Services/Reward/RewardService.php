<?php

namespace App\Services\Reward;

use App\Models\HabitableDay;
use App\Models\Referral;

class RewardService
{
    public static function getRewards()
    {
        $user = auth()->user();
        $referrer_bonus = Referral::where("referrer_id", $user->id)->pluck("bonus")->toArray();
        $habitable_days = optional(HabitableDay::where("user_id", $user->id)->first())->available_days;
        $data = [
            "referrals" => (int) array_sum($referrer_bonus),
            "habitable_days" => (int) $habitable_days,
            "ref_code" => $user->ref_code
        ];

        return $data;
    }
}
