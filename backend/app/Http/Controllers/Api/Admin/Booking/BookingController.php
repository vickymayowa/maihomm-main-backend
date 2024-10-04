<?php

namespace App\Http\Controllers\Api\Admin\Booking;

use App\Constants\ApiConstants;
use App\Exports\BookingExport;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Booking\BookingResource;
use App\Models\Booking;
use App\Services\Booking\BookingService;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    public function list(Request $request)
    {
        try {
            $builder = Booking::with("user");
            if (!empty($key = $request->search)) {
                $builder = $builder->search($key);
            }
            $bookings = $builder->get();
            // $data = ApiHelper::collect_pagination($bookings);
            // $data["data"] = BookingResource::collection($data["data"]);
            return ApiHelper::validResponse("Bookings retrieved", $bookings);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function approve(Request $request)
    {
        try {
            $bookings = BookingService::approve($request->all());
            $data = BookingResource::make($bookings);
            return ApiHelper::validResponse("Bookings status changed succcessfully", $data);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $bookings = BookingService::update($request->all(), $id);
            $data = BookingResource::make($bookings);
            return ApiHelper::validResponse("Bookings status changed succcessfully", $data);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
    public function export(Request $request)
    {
        try {
            $filename = "bookings.xlsx";
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            $export = new BookingExport();
            return Excel::download($export, $filename, null, $headers);
            //  ApiHelper::validResponse("Payment exported successfully");
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
}
