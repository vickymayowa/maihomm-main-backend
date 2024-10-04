<?php

namespace App\Services\Finance;

use App\Constants\PaymentConstants;
use App\Constants\PropertyConstants;
use App\Constants\StatusConstants;
use App\Exceptions\Property\PropertyException;
use App\Models\Payment;
use App\Models\PaymentFile;
use App\Models\Property;
use App\Notifications\Payment\StatusNotification;
use App\Services\Investment\InvestmentService;
use App\Services\Media\FileService;
use App\Services\Portfolio\PortfolioService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class PropertyPaymentService
{
    public static function validate(array $data, $id = null): array
    {
        $validator = Validator::make($data, [
            "property_id" => "required|exists:properties,id",
            "user_id" => "nullable|exists:users,id",
            "slots" => "required|numeric|gt:-1",
            "files" => "required|array",
            "files.*" => "image"
        ], [
            "files.required" => "Kindly upload your payment information.",
            "files.*.image" => "The file uploaded must be a valid image",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public static function save(array $data, $id = null)
    {
        DB::beginTransaction();
        $files = [];
        try {
            $data = self::validate($data, $id);
            $property = Property::find($data["property_id"]);

            $slots = $data["slots"];
            $amount = self::calculateAmount($property, $slots);

            $payment = PaymentService::create([
                "currency_id" => $property->currency_id,
                "user_id" => $data["user_id"] ?? auth()->id(),
                "amount" => $amount,
                'gateway' => PaymentConstants::GATEWAY_WALLET,
                'activity' => PaymentConstants::ACTIVITY_PROPERTY_PURCHASE,
            ]);

            self::createInvestment($property, $payment, $slots);

            foreach ($data["files"] as $key => $file) {
                $fileService = new FileService;
                $savedFile = $fileService->saveFromFile($file, "payment_files/properties", null, auth()->id());

                $files[] = PaymentFile::create([
                    "payment_id"  => $payment->id,
                    "user_id"  => $payment->user_id,
                    "file_id"  => $savedFile->id,
                ]);
            }

            $payment->refresh();
            $payment->user->notify(new StatusNotification($payment));
            DB::commit();
            return $payment;
        } catch (\Throwable $th) {
            DB::rollBack();
            foreach ($files as $file) {
                optional($file->file)->cleanDelete();
            }
            throw $th;
        }
    }

    public static function saveMultiple(array $data)
    {
        DB::beginTransaction();
        $files = [];
        try {
            $validator = Validator::make($data, [
                "amount" => "required|numeric",
                "properties" => "required|array",
                "properties.*.id" => "required|exists:properties,id",
                "properties.*.slots" => "required|numeric|gt:-1",
                "user_id" => "nullable|exists:users,id",
                "files" => "required|array",
                "files.*" => "required|image",
                "currency_id" => "required|exists:currencies,id",
            ], [
                "files.required" => "Kindly upload your payment information.",
                "files.*.image" => "The file uploaded must be a valid image",
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $data = $validator->validated();

            $payment = PaymentService::create([
                "currency_id" => $data["currency_id"],
                "user_id" => $data["user_id"] ?? auth()->id(),
                "amount" => $data["amount"],
                'gateway' => PaymentConstants::GATEWAY_WALLET,
                'activity' => PaymentConstants::ACTIVITY_PROPERTY_PURCHASE,
            ]);

            foreach ($data["files"] as $key => $file) {
                $fileService = new FileService;
                $savedFile = $fileService->saveFromFile($file, "payment_files/properties", null, auth()->id());

                $files[] = PaymentFile::create([
                    "payment_id"  => $payment->id,
                    "user_id"  => $payment->user_id,
                    "file_id"  => $savedFile->id,
                ]);
            }

            foreach ($data["properties"] as $key => $value) {
                $property = Property::find($value["id"]);
                $slots = $value["slots"];
                self::createInvestment($property, $payment, $slots);
            }

            $payment->refresh();
            $payment->user->notify(new StatusNotification($payment));
            DB::commit();
            return $payment;
        } catch (\Throwable $th) {
            DB::rollBack();
            foreach ($files as $file) {
                optional($file->file)->cleanDelete();
            }
            throw $th;
        }
    }

    private static function createInvestment(Property $property, Payment $payment, int $slots)
    {
        $available_slots = $property->total_slots - $property->total_sold;

        if (!$property->isAvailable()) {
            throw new PropertyException("The property '$property->name' is not available for purchase at the moment.");
        }

        if ($available_slots < $slots) {
            throw new PropertyException("The property '$property->name' does not have enough slots left.");
        }

        $amount = self::calculateAmount($property, $slots);

        $portfolio = PortfolioService::userPortfolio($payment->user_id);
        (new InvestmentService)->save([
            'portfolio_id' => $portfolio->id,
            'property_id' => $property->id,
            'payment_id' => $payment->id,
            "user_id" => $payment->user_id,
            "slots" => $slots,
            'description' => null,
            'value' => $amount,
            'term_in_month' => rand(1, 100),
            'rate' => rand(10, 20),
            'roi' => rand(10, 20),
            'investment_cost' => $amount,
            'status' => StatusConstants::PENDING,
            'start_date' => null,
            'maturity_date' => null,
        ]);

        $data = [
            "total_sold" => $property->total_sold + $slots
        ];

        if ($available_slots - $slots == 0) {
            $data["status"] = PropertyConstants::STATUS_SOLD;
        }
        $property->update($data);
    }

    public static function calculateAmount(Property $property, $slots)
    {
        $total_slots = $property->total_slots;
        $per_slot = $slots * ($property->price / $total_slots);
        $maihomm_fee = $slots * $property->maihomm_fee;
        $legal_and_closing_cost = $slots * $property->legal_and_closing_cost;
        $amount = $per_slot + $maihomm_fee + $legal_and_closing_cost;
        return $amount;
    }
}
