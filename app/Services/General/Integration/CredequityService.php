<?php

namespace App\Services\General\Integration;

use App\Constants\StatusConstants;
use App\Exceptions\General\GeneralException;
use App\Models\KycVerification;
use App\Models\User;
use App\Services\General\Guzzle\GuzzleService;
use Illuminate\Support\Facades\DB;
use Throwable;

class CredequityService
{
    public $user, $guzzle_service, $nin, $id_type, $kyc_verification, $response_data;

    public function __construct(User $user = null)
    {
        $this->guzzle_service = new GuzzleService();
        $this->user = $user ?? auth()->user();
    }

    public function setNin($nin)
    {
        $this->nin = $nin;
        return $this;
    }

    public function setIdType(string $id_type)
    {
        $this->id_type = $id_type;
        return $this;
    }

    public function verify()
    {
        try {
            $response = $this->guzzle_service->request('POST', env("CREDEQUITY_URL")."?nin=$this->nin", [
                'headers' => [
                    'accept' => 'application/json',
                    'Access-Key' => env("CREDEQUITY_KEY"),
                ],
            ]);
            logger("Credequity response", $response);
            if (in_array($response["status"], [200, 201])) {
                $this->response_data = $response["data"]['data'];
            } else {
                throw new GeneralException("Failed to verify your NIN details. Kindly confirm that your credentials are valid and retry.");
            }
            return $this;
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function update()
    {
        DB::beginTransaction();
        $data = $this->response_data;
        $this->kyc_verification = KycVerification::create([
            "user_id" => $this->user->id,
            "id_type" => $this->id_type,
            "verifier" => "Credequity",
            "status" => StatusConstants::VERIFIED,
            "metadata" => json_encode([
                "first_name" => $data["firstname"],
                "middle_name" => $data["middlename"],
                "last_name" => $data["surname"],
                "date_of_birth" => $data["birthdate"],
            ])
        ]);

        $this->user->update([
            "date_of_birth" => $data["birthdate"],
        ]);
        DB::commit();
    }
}
