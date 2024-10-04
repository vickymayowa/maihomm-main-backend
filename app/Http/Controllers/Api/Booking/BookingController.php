<?php

namespace App\Http\Controllers\Api\Booking;

use App\Constants\ApiConstants;
use App\Exceptions\BookingException;
use App\Exceptions\HabitableDayException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Booking\BookingResource;
use App\Services\Booking\BookingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function history(Request $request)
    {
        try {
            $user = auth()->user();
            $bookings = BookingService::getUserBookingHistory($request, $user);
            $data = ApiHelper::collect_pagination($bookings);
            $data["data"] = BookingResource::collection($data["data"]);
            return ApiHelper::validResponse("Booking history retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function checkCode(Request $request)
    {
        try {
            $user = auth()->user();
            $request["user_id"] = $user->id;
            $code = BookingService::checkCode($request->all());
            return ApiHelper::validResponse("Code retrieved!", $code);
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::VALIDATION_ERR_CODE, null,  $e);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function book(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $data = $request->all();
            $data["user_id"] = $user->id;
            $booking = BookingService::save($data);
            $data = BookingResource::make($booking);
            DB::commit();
            return ApiHelper::validResponse("Booking successful!", $data);
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::VALIDATION_ERR_CODE, null,  $e);
        } catch (HabitableDayException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::SERVER_ERR_CODE, null,  $e);
        } catch (BookingException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::SERVER_ERR_CODE, null,  $e);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
