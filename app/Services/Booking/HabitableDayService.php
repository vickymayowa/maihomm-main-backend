<?php

namespace App\Services\Booking;

use App\Exceptions\HabitableDayException;
use App\Models\HabitableDay;
use App\Notifications\Payment\NewHabitableDayNotification;
use App\Services\Portfolio\PortfolioService;
use Illuminate\Support\Facades\Notification;

class HabitableDayService
{
    const TWO_THOUSAND = "2700";
    const FIVE_THOUSAND = "5000";
    const TWO_AVAILABLE_DAYS = 2;
    const ONE_AVAILABLE_DAYS = 1;

    public $user_id;
    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function rewardHabitableDays($purchase_value, $model_id = null)
    {
        $portfolio = PortfolioService::userPortfolio($this->user_id);
        $investment_value = $portfolio->investment_value;
        $checkIfUserHasHabitableDays = $this->checkIfUserHasHabitableDays();
        $currentDate = now();
        $oneYearLater = $currentDate->addYear()->format('Y-m-d H:i:s');
        if ($investment_value > self::FIVE_THOUSAND) {
            if ($checkIfUserHasHabitableDays["bool"] == false && $purchase_value >= self::FIVE_THOUSAND) {
                $day = HabitableDay::create([
                    "user_id" => $this->user_id,
                    "code" => $this->generateHabitableCode(),
                    "available_days" => self::TWO_AVAILABLE_DAYS,
                    "total_days" => self::TWO_AVAILABLE_DAYS,
                    "expires_at" => $oneYearLater,
                    "log" => json_encode([
                        "booking_id" => $model_id,
                        "available_days" => self::TWO_AVAILABLE_DAYS,
                    ])
                ]);
                Notification::send($day->user , new NewHabitableDayNotification($day));
            }
            if ($checkIfUserHasHabitableDays["bool"] == true && $purchase_value >= self::FIVE_THOUSAND) {
                if ($checkIfUserHasHabitableDays["available_days"] == self::ONE_AVAILABLE_DAYS) {
                   $day =  HabitableDay::create([
                        "user_id" => $this->user_id,
                        "code" => $this->generateHabitableCode(),
                        "available_days" => self::ONE_AVAILABLE_DAYS,
                        "total_days" =>  self::ONE_AVAILABLE_DAYS,
                        "expires_at" => $oneYearLater,
                        "log" => json_encode([
                            "booking_id" => $model_id,
                            "available_days" => self::TWO_AVAILABLE_DAYS,
                        ])
                    ]);
                    Notification::send($day->user, new NewHabitableDayNotification($day));
                }
            }
        }
    }

    public function checkIfUserHasHabitableDays()
    {
        $habitable_days = HabitableDay::where("user_id", $this->user_id)->first();
        if (empty($habitable_days)) {
            return [
                "bool" => false,
                "available_days" => 0
            ];
        } else {
            return [
                "available_days" => $habitable_days->available_days,
                "bool" => true
            ];
        }
    }

    public function generateHabitableCode()
    {

        $code = "HBD-" . getRandomToken(6);
        return $code;
    }

    public function getByCode($code)
    {
        $habitable_day = HabitableDay::where("user_id", $this->user_id)->where("code", $code)->first();
        if (empty($habitable_day)) {
            throw new HabitableDayException("Invalid habitable code");
        }
        if ($habitable_day->available_days == 0) {
            throw new HabitableDayException("No available day(s) found");
        }

        return $habitable_day;
    }

    public function updateHabitableRecord(string $code, $usage)
    {
        $habitable_day = $this->getByCode($code);
        $habitable_day->update([
            "available_days" => $habitable_day->available_days - $usage,
            "used_days" => $habitable_day->usage + $usage
            // "log" =>
        ]);
        return $habitable_day;
    }
}
