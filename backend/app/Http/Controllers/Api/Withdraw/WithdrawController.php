<?php

namespace App\Http\Controllers\Api\Withdraw;

use Exception;
use Throwable;
use App\Models\User;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Constants\ApiConstants;
use App\Constants\AppConstants;
use App\Exceptions\UserException;
use App\Services\Api\AuthService;
use App\Constants\StatusConstants;
use Illuminate\Support\Facades\DB;
use App\Constants\CurrencyConstants;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Constants\TransactionConstants;
use App\Services\Finance\CurrencyService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Constants\TransactionActivityConstants;
use App\Services\Finance\UserTransactionService;
use App\Http\Resources\Notification\NotificationResource;
use App\Notifications\Withdraw\WithdrawNotification;

class WithdrawController extends Controller
{

    const WITHDRAWAL_CURRENCY = CurrencyConstants::EURO_CURRENCY;


    public function withdraw(Request $request) {

        
        DB::beginTransaction();
        try {
            
            $validator = Validator::make($request->toArray(), [
                "amount" => "bail|required|numeric|gt:0",
                "password" => "bail|required",
            ]);
    
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            if (!Hash::check($request->password, auth()->user()->password)) {
                throw new UserException("Invalid credentials");
            }


            $currency = CurrencyService::getByType(self::WITHDRAWAL_CURRENCY);

            $user = User::find(auth()->id());

            $data = [
                'amount' => "(".self::WITHDRAWAL_CURRENCY.") {$request->amount}"
            ];

            Notification::route('mail', AppConstants::SUDO_EMAIL)->notify(new WithdrawNotification($data, $user));
            
            UserTransactionService::create([
                "user_id" => 4,
                "currency_id" => $currency->id,
                "amount" => $request->amount,
                "fees" => 0,
                "description" => "Withdrawal Request",
                "activity" => TransactionActivityConstants::USER_WITHDRAWAL,
                "batch_no" => null,
                "type" => TransactionConstants::CREDIT,
                "status" => StatusConstants::PENDING
            ]);
            
            
            // DB::commit();
            return ApiHelper::validResponse("Successful. Pending Approval!");
        } catch (ValidationException $e) {
            // throw $e;
            return ApiHelper::inputErrorResponse("Invalid data", ApiConstants::VALIDATION_ERR_CODE, null, $e);
        } catch (UserException $e){  
            return ApiHelper::inputErrorResponse("Invalid password", ApiConstants::VALIDATION_ERR_CODE, null);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::BAD_REQ_ERR_CODE, null,  $e);
        }

        
    }
}
