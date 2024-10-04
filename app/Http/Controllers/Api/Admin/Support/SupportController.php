<?php

namespace App\Http\Controllers\Api\Admin\Support;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Support\SupportResource;
use App\Services\Support\SupportService;
use Exception;
use Illuminate\Http\Request;

class SupportController extends Controller
{

    public function list(Request $request)
    {
        try {
            $data = (new SupportService)->list($request->all())->get();
            // $data = ApiHelper::collect_pagination($data);
            // $data["data"] = SupportResource::collection($data["data"]);
            return ApiHelper::validResponse("Support tickets retrieved", $data);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = (new SupportService)->update($id, $request->all());
            return ApiHelper::validResponse("Support ticket updated successfully", SupportResource::make($data));
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function broadcast(Request $request)
    {
        try {
            (new SupportService)->broadcast($request->all());
            return ApiHelper::validResponse("Message broadcasted successfully");
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
}
