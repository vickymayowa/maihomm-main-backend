<?php

namespace App\Services\Finance;

use App\Constants\PaymentConstants;
use App\Constants\StatusConstants;
use App\Exceptions\Finance\PaymentException;
use App\Models\Investment;
use App\Models\Payment;
use App\Models\PropertyFile;
use App\Notifications\Payment\StatusNotification;
use App\Services\Booking\HabitableDayService;
use App\Services\Investment\InvestmentService;
use App\Services\Portfolio\PortfolioService;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentStatusService
{


    public static function changeStatus($payments_id, $status, $comment = null)
    {
        DB::beginTransaction();
        try {
            if (!in_array($status, StatusConstants::PAYMENT_OPTIONS)) {
                throw new PaymentException("Invalid status provided");
            }

            $payment = Payment::find($payments_id);

            if (in_array($payment->status, [StatusConstants::COMPLETED])) {
                throw new PaymentException("You cannot modify a completed request!");
            }

            // if (in_array($payment->status, [StatusConstants::PENDING])) {
            //     if (!in_array($status, [StatusConstants::PROCESSING])) {
            //         throw new PaymentException("Allowed status is Processing!");
            //     }
            // }

            if ($status == StatusConstants::PROCESSING) {
                self::markAsProcessing($payment);
            }
            if ($status == StatusConstants::COMPLETED) {
                self::markAsComplete($payment);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public static function markAsProcessing(Payment $payment)
    {

        if (!in_array($payment->status, [StatusConstants::PENDING])) {
            throw new PaymentException("Only pending requests can be marked as Processing!");
        }

        $status = StatusConstants::PROCESSING;
        $payment->update([
            "status" => $status,
        ]);
    }

    public static function markAsComplete(Payment $payment)
    {
        DB::beginTransaction();
        try {
            if (in_array($payment->status, [StatusConstants::COMPLETED])) {
                throw new PaymentException("You cannot modify an approved request!");
            }

            if (in_array($payment->status, [StatusConstants::DECLINED])) {
                throw new PaymentException("This request has been declined!");
            }

            $status = StatusConstants::COMPLETED;
            $payment->update([
                "status" => $status,
                "confirmation_date" => now(),
            ]);

            $payment = $payment->refresh();

            $activity = $payment->activity;
            if ($activity == PaymentConstants::ACTIVITY_PROPERTY_PURCHASE) {
                Investment::where("payment_id", $payment->id)
                ->update([
                    "start_date" => now(),
                    "maturity_date" => now()->addYear(),
                    "status" => StatusConstants::ACTIVE
                ]);
            }

            $payment->user->notify(new StatusNotification($payment));
            (new InvestmentService)->updatePortFolio($payment->user_id);
            $habitable_service = new HabitableDayService($payment->user_id);
            $habitable_service->rewardHabitableDays($payment->amount , $payment->id);

            DB::commit();
            //code...
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public static function updateLog(PropertyFile $payment, $status, $comment = null)
    {
        $actor = auth()->user();
        $payment->refresh();
        $logs = json_decode($payment->logs, true);
        $logs[] = [
            "status" => $status,
            "timestamp" => now(),
            "actor_id" => $actor->id,
            "comment" => $comment
        ];

        $payment->update([
            "logs" => json_encode($logs),
        ]);
    }
}
