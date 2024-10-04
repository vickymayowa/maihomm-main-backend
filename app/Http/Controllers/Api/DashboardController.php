<?php

namespace App\Http\Controllers\Api;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function overview(){

        try {
            $overviews = DashboardService::overview();
            return ApiHelper::validResponse("Overview retrieved!", $overviews);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
