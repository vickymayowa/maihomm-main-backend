<?php

namespace App\Http\Controllers\Api\Wallet;

use App\Constants\ApiConstants;
use App\Constants\CurrencyConstants;
use App\Exceptions\Finance\Wallet\WalletException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Wallet\WalletFundProofResource;
use App\Http\Resources\Wallet\WalletResource;
use App\Services\Finance\Wallet\FundWalletService;
use App\Services\Finance\Wallet\WalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
{
    public function myWallet(Request $request)
    {
        try {
            $user = auth()->user();
            $wallet = WalletService::getByCurrencyType($user->id, CurrencyConstants::POUND_CURRENCY);
            $data = WalletResource::make($wallet);
            return ApiHelper::validResponse("Wallet retrieved!", $data); 
        } catch (WalletException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::SERVER_ERR_CODE, null,  $e);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function uploadProof(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $proof = FundWalletService::proofProcess($data);
            $data = WalletFundProofResource::make($proof);
            DB::commit();
            return ApiHelper::validResponse("Proof sent successfully, transaction processing!", $data);
        } catch (ValidationException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::SERVER_ERR_CODE, null,  $e);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
