<?php

namespace App\Http\Controllers\Api\Loan;

use App\Constants\ApiConstants;
use App\Exceptions\LoanException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Loan\LoanResource;
use App\Services\Loan\LoanService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function history(Request $request)
    {
        try {
            $user = auth()->user();
            $loans = LoanService::getUserLoanHistory($request, $user);
            $data = ApiHelper::collect_pagination($loans);
            $data["data"] = LoanResource::collection($data["data"]);
            return ApiHelper::validResponse("Loan history retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function apply(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $data = $request->all();
            $data["user_id"] = $user->id;
            $data["eligible_amount"] = LoanService::loanEligibilityAmount($user);
            $loan = LoanService::apply($data);
            $data = LoanResource::make($loan);
            DB::commit();
            return ApiHelper::validResponse("Loan application submitted!", $data);
        } catch (LoanException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::SERVER_ERR_CODE, null,  $e);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
