<?php

namespace App\Http\Controllers\Api\Income;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Services\Income\IncomeService;
use Exception;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function history(Request $request){
        try {
            $user = auth()->user();
            $history = IncomeService::history($user);
            return ApiHelper::validResponse("Income history retrieved!", $history);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
