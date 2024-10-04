<?php

namespace App\Http\Controllers\Api\Admin\Payout;

use App\Constants\ApiConstants;
use App\Exports\PayoutExport;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Payout\PayoutResource;
use App\Models\Payout;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PayoutController extends Controller
{
    public function list(Request $request)
    {
        try {

            $builder = Payout::with("property");
            if(!empty($key = $request->search)){
                $builder = $builder->search($key);
            }
            $payouts = $builder->paginate();
            $data = ApiHelper::collect_pagination($payouts);
            $data["data"] = PayoutResource::collection($data["data"]);
            return ApiHelper::validResponse("Payouts retrieved", $data);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function export(Request $request)
    {
        try {
            $filename = "payouts.xlsx";
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            $export = new PayoutExport();
            return Excel::download($export, $filename, null, $headers);
            //  ApiHelper::validResponse("Payment exported successfully");
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

}
