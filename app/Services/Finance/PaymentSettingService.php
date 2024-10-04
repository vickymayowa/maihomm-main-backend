<?php

namespace App\Services\Finance;

use App\Exceptions\Finance\PaymentException;
use App\Models\Payment;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PaymentSettingService
{
    public static function validate(array $data, $id = null): array
    {
        $validator = Validator::make($data, [
            "min_deposit" => "nullable|integer",
            "max_deposit" => "nullable|integer",
            "min_withdrawal" => "nullable|integer",
            "max_withdrawal" => "nullable|integer",
            "allow_naira" => "nullable|boolean",
            "allow_pound" => "nullable|boolean",
            "allow_naira" => "nullable|boolean",
            "allow_dollar" => "nullable|boolean",
            "is_cash" => "nullable|boolean",
            "is_paystack" => "nullable|boolean",
            "is_flutterwave" => "nullable|boolean",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public static function set($data): PaymentSetting
    {
        $data = self::validate($data);
        $settings = PaymentSetting::updateOrCreate($data);
        return $settings;
    }
}
