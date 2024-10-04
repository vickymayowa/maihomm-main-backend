<?php

namespace App\Services\Loan;

use App\Constants\AppConstants;
use App\Exceptions\LoanException;
use App\Models\Loan;
use App\Models\Portfolio;
use App\Models\User;
use App\QueryBuilders\Finance\LoanQueryBuilder;
use App\Services\Notifications\AppMailerService;
use App\Services\Portfolio\PortfolioService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoanService
{
    public static function validate(array $data, $id = null)
    {
        $validator = Validator::make($data, [
            "user_id" => "required|exists:users,id",
            "amount" => "required|integer",
            "eligible_amount" => "nullable|integer",
            "reference" => "required|string",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public static function apply(array $data): Loan
    {
        $data["reference"] = self::generateReferenceNo();
        $data = self::validate($data);
        self::eligibiltyRestriction($data["user_id"], $data["amount"]);
        $loan = Loan::create($data);
        self::sendMailToAdmin($loan);
        return $loan->refresh();
    }

    public static function eligibiltyRestriction(int $user_id, float $loan_amount)
    {
        $portfolio = PortfolioService::userPortfolio($user_id);
        $eligibilty_amount = $portfolio->loanEligibilityCalculator();
        if ($eligibilty_amount < $loan_amount) {
            throw new LoanException("You are not eligible for loans at the moment");
        }
        return $eligibilty_amount;
    }
    public static function sendMailToAdmin(Loan $loan)
    {
        AppMailerService::send([
            "data" => [
                "loan" => $loan,
            ],
            "to" => AppConstants::SUDO_EMAIL,
            "template" => "emails.loan.request",
            "subject" => "Loan Application",
        ]);
    }
    public static function generateReferenceNo()
    {
        $code = "MAI_" . getRandomToken(6, true);
        $reference = Loan::where("reference", $code)->count();
        if ($reference > 0) {
            return self::generateReferenceNo();
        }

        return $code;
    }

    public static function getUserLoanHistory($request, User $user): LengthAwarePaginator
    {
        return LoanQueryBuilder::filterList($request)->where("user_id", $user->id)->paginate();
    }

    public static function loanEligibilityAmount(User $user)
    {
        $portfolio = Portfolio::where("user_id", $user->id)->first();
        return $portfolio->loanEligibilityCalculator();
    }
}
