<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\UserTransactionResource;
use App\Models\UserTransaction;
use App\Services\Finance\UserTransactionService;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function list(Request $request)
    {
        try {
            $transactions = UserTransactionService::getUserTransactions($request, auth()->id());
            $data = ApiHelper::collect_pagination($transactions);
            $data["data"] = UserTransactionResource::collection($data["data"]);
            return ApiHelper::validResponse("Transactions retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
