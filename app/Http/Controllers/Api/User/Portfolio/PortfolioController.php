<?php

namespace App\Http\Controllers\Api\User\Portfolio;

use Exception;
use App\Models\Portfolio;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Models\SavedProperty;
use App\Constants\ApiConstants;
use App\Http\Controllers\Controller;
use App\Services\Portfolio\PortfolioService;
use App\Http\Resources\Portfolio\PortfolioResource;
use App\Http\Resources\Portfolio\InvestmentResource;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            PortfolioService::userPortfolio($user->id);
            $portfolio = Portfolio::withCount("pendingInvestments")
            ->withCount("activeInvestments")->with("investments")
            ->where("user_id", $user->id)
            ->first();
            // $data = PortfolioResource::make($portfolio);
            $data = array(
                "portfolio" => $portfolio,
            "investments" => $portfolio->investments,
            "rois" => $user->rois,
            "completed_payments" => $user->completedPayments(),
            "saved_properties_count" => SavedProperty::whereHas("property")
                ->where("user_id", $user->id)->count()
            );
            
            return ApiHelper::validResponse("Portfolio retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("An error occurred while processing this request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function investments(Request $request)
    {
        try {
            $user = auth()->user();
            $investments = PortfolioService::investments($request, $user);
            $data = ApiHelper::collect_pagination($investments);
            $data["data"] =  InvestmentResource::collection($data["data"]);
            return ApiHelper::validResponse("Investments retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("An error occurred while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
