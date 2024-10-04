<?php

namespace App\Http\Controllers\Api\Admin\Wallet;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Wallet\WalletFundProofResource;
use App\QueryBuilders\General\ProofQueryBuilder;
use App\Services\Finance\Wallet\FundWalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
{
    public function proofs(Request $request)
    {
        try {
            $proofs = ProofQueryBuilder::filterList($request)->with(["wallet"])->paginate();
            $data = ApiHelper::collect_pagination($proofs);
            $data["data"] = WalletFundProofResource::collection($data["data"]);
            return ApiHelper::validResponse("Proofs retrieved", $data);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function changeStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $proof = FundWalletService::changeStatus($data, $id);
            $data = WalletFundProofResource::make($proof);
            DB::commit();
            return ApiHelper::validResponse("Status changed successfully", $data);
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            DB::rollBack();
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
}
