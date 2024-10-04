<?php

namespace App\Services\Portfolio;

use App\Models\Investment;
use App\Models\Portfolio;
use App\Models\User;
use App\QueryBuilders\Finance\InvestmentQueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PortfolioService
{
    public static function validate(array $data, $id = null): array
    {
        $validator = Validator::make($data, [
            "user_id" => "required|exists:users,id",
            "monthly_income" => "nullable|int",
            "total_income" => "nullable|int",
            "value_appreciation" => "nullable|int|gt:-1",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public static function create(array $data, $id = null): Portfolio
    {
        $data = self::validate($data, $id);
        if (!empty($id)) {
            $portfolio = Portfolio::find($id);
            $portfolio->update($data);
        } else {
            $portfolio = Portfolio::updateOrCreate(["user_id" => $data["user_id"]],$data);
        }
        return $portfolio;
    }

    public static function userPortfolio($user_id): Portfolio
    {
        $portfolio = Portfolio::where("user_id", $user_id)->first();
        if (empty($portfolio)) {
            $portfolio = self::create([
                "user_id" => $user_id,
                "monthly_income" => 0,
                "total_income" => 0,
                "value_appreciation" => 0,
            ]);
        }

        return $portfolio;
    }

    public static function investments($request, User $user): LengthAwarePaginator
    {
        $portfolio = self::userPortfolio($user->id);
        $investment = InvestmentQueryBuilder::filterList($request)->where("portfolio_id", $portfolio->id)->paginate();
        return $investment;
    }

}
