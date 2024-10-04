<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\AdminDashboardService;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function overview(Request $request)
    {
        try {
            $overviews = AdminDashboardService::overview();
            return ApiHelper::validResponse("Admin overview retrieved!", $overviews);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
