<?php

namespace App\Http\Controllers\Api\User;

use App\Constants\ApiConstants;
use App\Exceptions\Property\PropertyException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Services\Finance\PropertyPaymentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function send(Request $request)
    {
        DB::beginTransaction();
        try {
            PropertyPaymentService::save($request->all());
            DB::commit();
            return  ApiHelper::validResponse("Payment proof sent successfully. Do not resend", null);
        } catch (ValidationException $th) {
            DB::rollBack();
            return ApiHelper::inputErrorResponse("The given data is invalid", ApiConstants::BAD_REQ_ERR_CODE, null, $th);
        } catch (PropertyException $th) {
            DB::rollBack();
            return ApiHelper::problemResponse($th->getMessage(), ApiConstants::SERVER_ERR_CODE, null,  $th);
        } catch (Exception $th) {
            DB::rollBack();
            return ApiHelper::problemResponse("An error occured while trying to process your request", ApiConstants::SERVER_ERR_CODE, null,  $th);
        }
    }
}
