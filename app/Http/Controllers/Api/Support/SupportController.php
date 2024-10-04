<?php

namespace App\Http\Controllers\Api\Support;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Support\SupportResource;
use App\Services\Support\SupportService;
use Exception;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function submit(Request $request)
    {
        try {
            $data = (new SupportService)->create($request->all());
            return ApiHelper::validResponse("Support ticket created successfully", SupportResource::make($data));
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
}
