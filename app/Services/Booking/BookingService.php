<?php

namespace App\Services\Booking;

use App\Constants\AppConstants;
use App\Exceptions\BookingException;
use App\Models\Booking;
use App\Models\Portfolio;
use App\Models\Property;
use App\Models\User;
use App\QueryBuilders\General\BookingQueryBuilder;
use App\Services\Notifications\AppMailerService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class BookingService
{
    public static function validate(array $data, $id = null)
    {
        $validator = Validator::make($data, [
            "user_id" => "nullable|exists:users,id|" . Rule::requiredIf(empty($id)),
            "property_id" => "nullable|exists:properties,id|" . Rule::requiredIf(empty($id)),
            "reference" => "nullable|string|" . Rule::requiredIf(empty($id)),
            "check_in" => "nullable|string|" . Rule::requiredIf(empty($id)),
            "check_out" => "nullable|string|" . Rule::requiredIf(empty($id)),
            "habitable_code" => "nullable|string",
            "habitable_days_usage" => "nullable|integer|" . Rule::requiredIf(!empty($data["habitable_code"])),
            "slots" => "nullable|integer|" . Rule::requiredIf(empty($id)),
            "number_of_guests" => "nullable|integer",
            "service_fee" => "nullable|integer",
            "total_price" => "nullable|integer",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public static function checkCode(array $data)
    {
        $validator = Validator::make($data, [
            "user_id" => "required",
            "habitable_code" => "required|string|exists:habitable_days,code",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $initialize_habitable_days = new HabitableDayService($data["user_id"]);
        $habitable_days = $initialize_habitable_days->getByCode($data["habitable_code"]);
        return $habitable_days;
    }

    public static function save(array $data): Booking
    {
        $data["reference"] = self::generateReferenceNo();
        $data = self::validate($data);
        $price = self::calculateBookingPrice($data);
        $data["total_price"] = $price[0];
        $data["service_fee"] = $price[1];
        unset($data["habitable_code"]);
        $booking = Booking::create($data);
        // self::bookingAlertMail($booking);
        return $booking->refresh();
    }

    public static function update(array $data, $id): Booking
    {
        $data = self::validate($data, $id);
        $booking = self::getById($id);
        $booking->update($data);
        return $booking->refresh();
    }

    public static function getUserBookingHistory($request, User $user): LengthAwarePaginator
    {
        return BookingQueryBuilder::filterList($request)->where("user_id", $user->id)->paginate();
    }

    public static function calculateBookingPrice($data)
    {
        DB::beginTransaction();
        try {
            $property = Property::find($data["property_id"]);

            $requested_slot = $data["slots"] ?? 1;
            if ($property->total_slots < $requested_slot) {
                throw new BookingException("Slots are currently unavailable at the moment");
            }

            $price_per_slot = $property->per_slot;
            $price = $requested_slot * $price_per_slot;

            $initialize_habitable_days = new HabitableDayService($data["user_id"]);
            if (!empty($code = $data["habitable_code"] ?? null)) {
                $habitable_days = $initialize_habitable_days->getByCode($code);
                $habitable_usage = $data["habitable_days_usage"];
                $habitable_days_count = $habitable_days->available_days;
                if ($habitable_days_count < $habitable_usage) {
                    throw new BookingException("Insufficient habitable days");
                }

                $price = self::calcHabitableUsage($habitable_usage, $price, $price_per_slot);
                $initialize_habitable_days->updateHabitableRecord($data["habitable_code"], $habitable_usage);
            }


            DB::commit();
            return [$price, $property->service_charge];
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public static function calcHabitableUsage(int $habitable_usage, $price, $price_per_slot)
    {
        $one_habitable_days = $price_per_slot;
        $deductHabitableDaysFromPrice = $price * $habitable_usage - $one_habitable_days;
        return $deductHabitableDaysFromPrice;
    }

    public static function bookingAlertMail(Booking $booking)
    {
        AppMailerService::send([
            "data" => [
                "booking" => $booking,
            ],
            "to" => auth()->user()->email,
            "template" => "emails.booking.alert_user",
            "subject" => "Loan Application",
        ]);
    }

    public static function generateReferenceNo()
    {
        $code = "MAI_" . getRandomToken(6, true);
        $reference = Booking::where("reference", $code)->count();
        if ($reference > 0) {
            return self::generateReferenceNo();
        }
        return $code;
    }

    public static function getById($id)
    {
        $booking = Booking::find($id);
        if (empty($booking)) {
            throw new BookingException("Booking not found");
        }

        return $booking;
    }
    public static function approve($data)
    {
        $booking = self::getById($data["booking_id"]);
        $booking->update([
            "status" => $data["status"]
        ]);

        return $booking;
    }
}
