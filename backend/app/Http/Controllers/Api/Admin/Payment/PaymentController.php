<?php

namespace App\Http\Controllers\Api\Admin\Payment;

use App\Constants\ApiConstants;
use App\Exceptions\Finance\PaymentException;
use App\Exports\PaymentExport;
use App\Exports\UserExport;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Payment\PaymentResource;
use App\Http\Resources\Payment\PaymentSettingResource;
use App\Models\Payment;
use App\QueryBuilders\General\PaymentQueryBuilder;
use App\Services\Finance\PaymentSettingService;
use App\Services\Finance\PaymentStatusService;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $payments = PaymentQueryBuilder::filterIndex($request)
                ->withCount("investments")
                ->withCount("files")
                ->latest()
                ->get();
            // $data = ApiHelper::collect_pagination($payments);
            // $data["data"] = PaymentResource::collection($data["data"]);
            return ApiHelper::validResponse("Payments retrieved", $payments);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, null, $e);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $payment = Payment::withCount("investments")
                ->withCount("files")
                ->with(["investments", "files"])
                ->findOrFail($id);
            return ApiHelper::validResponse("Payment retrieved", PaymentResource::make($payment));
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, null, $e);
        }
    }

    public function settings(Request $request)
    {
        try {
            $settings = PaymentSettingService::set($request->all());
            $data = PaymentSettingResource::make($settings);
            return ApiHelper::validResponse("Settings configured successfully", $data);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, null, $e);
        }
    }

    // public function settings(Request $request)
    // {
    //     try {
    //         $payments = PaymentSettingService::set($request->all());
    //         $data = PaymentResource::collection($payments);
    //         return ApiHelper::validResponse("Payments retrieved", $data);
    //     } catch (Exception $e) {
    //         $message = 'Something went wrong while processing your request.';
    //         return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
    //     }
    // }

    public function export(Request $request)
    {
        try {
            $filename = "payments.xlsx";
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            $export = new PaymentExport();
            return Excel::download($export, 'payments.xlsx', null, $headers);
            //  ApiHelper::validResponse("Payment exported successfully");
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, null, $e);
        }
    }


    public function changeStatus(Request $request, $id)
    {
        try {
            PaymentStatusService::changeStatus($id, $request->status, $request->comment);
            return ApiHelper::validResponse("Payment status updated successfully");
        } catch (PaymentException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Throwable $e) {
            dd($e);
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, null, $e);
        }
    }
}
