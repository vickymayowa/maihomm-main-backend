<?php

namespace App\Services\Finance;

use App\Exceptions\Finance\PaymentException;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PaymentService
{

     public static function validate(array $data, $id = null): array
    {
        $validator = Validator::make($data, [
            "currency_id" => "nullable|exists:currencies,id|".Rule::requiredIf(empty($id)),
            "user_id" => "nullable|exists:users,id|".Rule::requiredIf(empty($id)),
            "transaction_id" => "nullable|exists:transactions,id",
            "amount" => "nullable|numeric|gt:-1|".Rule::requiredIf(empty($id)),
            "discount" => "nullable|numeric|gt:-1",
            "fee" => "nullable|numeric|gt:-1",
            'gateway' => "nullable|string|".Rule::requiredIf(empty($id)),
            'activity' => "nullable|string|".Rule::requiredIf(empty($id)),
            "status" => "nullable|string"
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
    public static function getByReference($reference): Payment
    {
        $payment = Payment::where("reference", $reference)->first();

        if (empty($payment)) {
            throw new PaymentException("Payment not found");
        }
        return $payment;
    }

    public static function getById($id): Payment
    {
        $payment = Payment::where("id", $id)->first();

        if (empty($payment)) {
            throw new PaymentException("Payment not found");
        }
        return $payment;
    }

    public static function create($data): Payment
    {
        $data = self::validate($data);
        $data["reference"] = self::generateReferenceNo();
        $payment = Payment::create($data);
        return $payment;
    }

    public static function generateReferenceNo()
    {
        $key = "PRF_" . getRandomToken(5, true);
        $check = Payment::where("reference", $key)->count();
        if ($check > 0) {
            return self::generateReferenceNo();
        }
        return $key;
    }
}
