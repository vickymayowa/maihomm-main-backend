<?php

namespace App\Services\Investment;

use App\Constants\StatusConstants;
use App\Models\Investment;
use App\Services\Portfolio\PortfolioService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvestmentService
{
    private function validate(array $data, $id = null): array
    {
        $validator = Validator::make($data, [
            "portfolio_id" => "required|exists:portfolios,id",
            "property_id" => "required|exists:properties,id",
            "payment_id" => "required|exists:payments,id",
            "user_id" => "required|exists:users,id",
            "description" => "nullable|string",
            "value" => "nullable|numeric|gt:-1",
            "slots" => "nullable|int|gt:-1",
            "term_in_month" => "nullable|numeric",
            "rate" => "nullable|numeric|gt:-1",
            "investment_cost" => "nullable|numeric|gt:-1",
            "roi" => "nullable|numeric|gt:-1",
            "start_date" => "nullable|date",
            "maturity_date" => "nullable|date",
            "status" => "nullable|string"
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public function save(array $data, $id = null): Investment
    {
        $data = self::validate($data, $id);
        if (!empty($id)) {
            $investment = Investment::findOrFail($id);
            $investment->update($data);
        } else {
            $investment = Investment::create($data);
        }
        return $investment;
    }

    public function investmentValue($user_id){
        $investment_value = Investment::where("user_id", $user_id)->sum("value");
        return $investment_value;
    }

    public function updatePortFolio($user_id)
    {
        $investment_cost = Investment::where("user_id", $user_id)
        ->where("status" , StatusConstants::ACTIVE)
        ->sum("investment_cost");
        $portfolio = PortfolioService::userPortfolio($user_id);
        $portfolio->update([
            "investment_value" => $investment_cost
        ]);
    }
}
