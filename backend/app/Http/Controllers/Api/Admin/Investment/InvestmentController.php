<?php

namespace App\Http\Controllers\Api\Admin\Investment;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\InvestmentResource;
use App\Models\Investment;
use Exception;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function list(Request $request)
    {
        try {
            $builder = Investment::with("user");
            if (!empty($key = $request->search)) {
                $builder = $builder->search($key);
            }
            // $investments = $builder->paginate();
            $investments = $builder->get();
            // $data = ApiHelper::collect_pagination($investments);
            // $data["data"] = InvestmentResource::collection($data["data"]);
            return ApiHelper::validResponse("Investment retrieved", $investments);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
}
