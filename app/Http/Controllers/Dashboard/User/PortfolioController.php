<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\SavedProperty;
use App\Services\Portfolio\PortfolioService;

class PortfolioController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        PortfolioService::userPortfolio($user->id);
        $portfolio = Portfolio::withCount("pendingInvestments")
            ->withCount("activeInvestments")->with("investments")
            ->where("user_id", $user->id)
            ->first();
        return view("dashboards.user.portfolio.index", [
            "portfolio" => $portfolio,
            "investments" => $portfolio->investments,
            "completed_payments" => $user->completedPayments(),
            "saved_properties_count" => SavedProperty::whereHas("property")
                ->where("user_id", $user->id)->count()
        ]);
    }
}
