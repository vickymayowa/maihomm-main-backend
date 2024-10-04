<?php

namespace App\Http\Controllers\Api\Profile;

use App\Constants\ApiConstants;
use App\Constants\AppConstants;
use App\Exceptions\General\GeneralException;
use App\Exceptions\General\GuzzleException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Profile\KycNotification;
use App\Services\General\Integration\CredequityService;
use App\Services\General\Integration\MetaMapService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KycController extends Controller
{
    public function uploadKyc(Request $request)
    {
        try {
            $request["user_id"] = auth()->id();
            $data = $request->validate([
                "user_id" => "required|exists:users,id",
                "document_type" => "required|string|in:id_card,driver_license", // Updated field
                // "id_card" => "required_if:document_type,id_card|image",
                "driver_license" => "required_if:document_type,driver_license|image",
                "nationality" => "required|string", 
                "nin" => "nullable|numeric|"
            ]);
            // $this->processNinVerification($data)
            $this->processMetamapVerification($data);
            return ApiHelper::validResponse("Your KYC document(s) has been submitted, you can start purchasing properties once verified");
        } catch (GuzzleException | GeneralException $e) {
            ApiHelper::problemResponse($e->getMessage(), ApiConstants::VALIDATION_ERR_CODE, null, $e);
        } catch (Exception $e) {
            ApiHelper::problemResponse("Something occured while processing your request", ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function processMetamapVerification(array $data)
    {
        try {
            $user = auth()->user();
            $metamap = new MetaMapService($user);

            $file = $data['document_type'] === 'ID_card' ? $data['ID_card'] : $data['driver_license'];

            $metamap->authenticate()->createVerification($data["id_type"])->uploadDocs([
                [
                    "page" => "front",
                    "file" => $file
                ]
            ]);
            $user->notify(new KycNotification);
        } catch (GuzzleException | GeneralException $e) {
            ApiHelper::problemResponse($e->getMessage(), ApiConstants::VALIDATION_ERR_CODE, null, $e);
        } catch (Exception $e) {
            ApiHelper::problemResponse("Something occured while processing your request", ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function processNinVerification(array $data)
    {
        try {
            $user = User::find($data["user_id"]);
            $credequity = new CredequityService($user);

            $credequity->setNin($data["nin"])
                ->setIdType(AppConstants::NIN)
                ->verify()->update();
            $user->notify(new KycNotification());
        } catch (GuzzleException | GeneralException $e) {
        } catch (Exception $e) {
            ApiHelper::problemResponse("Something occured while processing your request", ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
}
