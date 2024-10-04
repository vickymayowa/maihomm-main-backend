<?php

namespace App\Services\General\Integration;

use App\Constants\StatusConstants;
use App\Exceptions\General\GeneralException;
use App\Models\KycVerification;
use App\Models\User;
use App\Services\General\Guzzle\GuzzleService;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Facades\DB;
use Throwable;

class MetaMapService
{
    public $user, $guzzle_service, $auth_data, $verify_data, $upload_data, $kyc_verification = null;

    public function __construct(User $user = null)
    {
        $this->guzzle_service = new GuzzleService();
        $this->user = $user ?? auth()->user();
    }

    public function authenticate()
    {
        $token = base64_encode(env("METAMAP_CLIENT_ID") . ":" . env("METAMAP_CLIENT_SECRET"));
        $response = $this->guzzle_service->request('POST', 'https://api.getmati.com/oauth', [
            'form_params' => [
                'grant_type' => 'client_credentials'
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'accept' => 'application/json',
                'authorization' => 'Basic ' . $token,
            ],
        ]);
        if ($response["status"] == 200) {
            $this->auth_data = $response["data"];
        } else {
            throw new GeneralException("Failed to authenticate MetaMap");
        }

        return $this;
    }

    public function createVerification($id_type)
    {
        if (empty($this->auth_data)) {
            throw new GeneralException("No authetication data for MetaMap");
        }

        DB::beginTransaction();
        $this->kyc_verification = KycVerification::create([
            "user_id" => $this->user->id,
            "id_type" => $id_type,
            "verifier" => "MetaMap"
        ]);

        $response = $this->guzzle_service->request('POST', 'https://api.getmati.com/v2/verifications/', [
            'body' => json_encode([
                "flowId" => env("METAMAP_FLOW_ID"),
                "metadata" => [
                    "kyc_id" => $this->kyc_verification->id,
                    "name" => $this->user->names(),
                    "id" => $this->user->id
                ],
            ]),
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'authorization' => 'Bearer ' . $this->auth_data["access_token"],
            ],
        ]);
        if ($response["status"] == 200) {
            $this->verify_data = $response["data"];
        } else {
            throw new GeneralException("Failed to create verification on MetaMap");
        }

        return $this;
    }
    public function uploadDocs(array $documents)
    {
        if (empty($this->auth_data)) {
            throw new GeneralException("No authetication data for MetaMap");
        }

        if (empty($this->verify_data)) {
            throw new GeneralException("No verification data for MetaMap");
        }

        $inputs = $docs = $file_paths = [];

        try {
            foreach ($documents as $document) {
                $file = $document["file"];
                $name = $file->getClientOriginalName();
                $mime = $file->getClientMimeType();
                $file_path = putFileInPrivateStorage($file, "tmp");
                $full_path = storage_path("app/" . $file_path);

                $inputs[] = [
                    "inputType" => "document-photo",
                    "group" => 0,
                    "data" => [
                        "type" => $this->kyc_verification->id_type,
                        "country" => "NG",
                        "page" => $document["page"],
                        "filename" => $name
                    ]
                ];

                $docs[] = [
                    'name' => 'document',
                    'contents' => Utils::tryFopen($full_path, 'r'),
                    'filename' => $name,
                    'headers' => [
                        'Content-Type' => $mime
                    ]
                ];

                $file_paths[] = $file_path;
            }
            $multipart = array_merge([
                [
                    'name' => 'inputs',
                    'contents' => json_encode($inputs)
                ]
            ], $docs);

            $identity = $this->verify_data["identity"];
            $response = $this->guzzle_service->request('POST', "https://api.getmati.com/v2/identities/$identity/send-input", [
                'multipart' => $multipart,
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Bearer ' . $this->auth_data["access_token"],
                ],
            ]);

            if (in_array($response["status"], [200, 201])) {
                $this->upload_data = $response["data"];
            } else {
                throw new GeneralException("Failed to submit verification details to MetaMap");
            }
            $this->deleteFiles($file_paths);
            DB::commit();
            return $this;
        } catch (Throwable $e) {
            $this->deleteFiles($file_paths);
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteFiles($paths)
    {
        foreach ($paths as $path) {
            deleteFileFromPrivateStorage($path);
        }
    }

    public static function incomingWebhook(array $payload)
    {
        logger("metamap webhook data", $payload);
        $meta = $payload["metadata"];
        $new_status = $payload["identityStatus"] ?? null;
        if (empty($new_status)) {
            return;
        }

        $kyc = KycVerification::find($meta["kyc_id"]);
        if (empty($kyc)) {
            return;
        }

        $update_data = [];

        $status_map = [
            "reviewNeeded" => StatusConstants::PENDING,
            "verified" => StatusConstants::VERIFIED,
            "rejected" => StatusConstants::REJECTED,
        ];
        $update_data["status"] =
            $status_map[$new_status] ?? "Unknown";


        $webhooks = json_decode($kyc->metadata)["webhooks"] ?? [];
        $webhooks[] = [
            "identityStatus" => $new_status,
            "timestamp" => now(),
        ];

        $update_data["metadata"] = json_encode($webhooks);

        $kyc->update($update_data);
    }
}
