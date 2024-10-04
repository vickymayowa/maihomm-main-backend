<?php

namespace App\Http\Controllers\Dashboard;

use App\Constants\AppConstants;
use App\Constants\NotificationConstants;
use App\Constants\StatusConstants;
use App\Exceptions\General\GeneralException;
use App\Exceptions\General\GuzzleException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use App\Models\User;
use App\Notifications\Profile\KycNotification;
use App\Services\Auth\UserService;
use App\Services\General\Integration\CredequityService;
use App\Services\General\Integration\MetaMapService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        return view("dashboards.user.profile.index", [
            "user" => $user,
            "redirect_url" => $request->redirect_url,
        ]);
    }

    public function updateProfile(Request $request)
    {
        try {
            UserService::update($request->all(), auth()->id());
            return redirect()->back()->with(NotificationConstants::SUCCESS_MSG, "Profile update successfully");
        } catch (ValidationException $th) {
            throw $th;
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with(NotificationConstants::ERROR_MSG, "An error occured while trying to process your request");
        }
    }

    public function kycPage(Request $request)
    {
        $user = auth()->user();
        $KycVerifications = KycVerification::where([
            "user_id" => $user->id,
        ])->get();

        $document_ids = $KycVerifications->whereIn("id_type", array_keys(AppConstants::ID_OPTIONS));
        if ($document_ids->count() < 1) {
            $show_document_form = true;
        }

        $nins = $KycVerifications->where("id_type", AppConstants::NIN);
        if ($nins->count() < 1) {
            $show_nin_form = true;
        }

        return view("dashboards.user.profile.kyc.index", [
            "redirect_url" => $request->redirect_url,
            "show_document_form" => $show_document_form ?? false,
            "show_nin_form" => $show_nin_form ?? false,
            "id_options" => AppConstants::ID_OPTIONS
        ]);
    }

    public function kycUpload(Request $request)
    {
        $data = $request->validate([
            "user_id" => "required|exists:users,id",
            "id_type" => "required|string",
            "id_card" => "nullable|image|" . Rule::requiredIf(in_array($request->id_type, array_keys(AppConstants::ID_OPTIONS))),
            "redirect_url" => "nullable",
            "nin" => "nullable|numeric|" . Rule::requiredIf($request->id_type == AppConstants::NIN)
        ]);


        if (!empty($data["nin"] ?? null)) {
            return $this->processNinVerification($data);
        } else {
            return $this->processMetamapVerification($data);
        }
    }

    public function processMetamapVerification(array $data)
    {
        try {
            $user = auth()->user();
            $metamap = new MetaMapService($user);
            $metamap->authenticate()->createVerification($data["id_type"])->uploadDocs([
                [
                    "page" => "front",
                    "file" => $data["id_card"]
                ]
            ]);

            $user->notify(new KycNotification());
            $url = route("dashboard.user.portfolio.index");
            if (!empty($redirect_url = $data["redirect_url"] ?? null)) {
                $url = $redirect_url;
            }
            return redirect($url)->with(NotificationConstants::SUCCESS_MSG, "KYC document(s) submitted successfully.");
        } catch (GuzzleException | GeneralException $e) {
            return back()->with(NotificationConstants::ERROR_MSG, $e);
        } catch (Throwable $e) {
            return back()->with(NotificationConstants::ERROR_MSG, "An error occurred while processing your request.");
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
            $url = route("dashboard.user.portfolio.index");
            if (!empty($redirect_url = $data["redirect_url"] ?? null)) {
                $url = $redirect_url;
            }
            return redirect($url)->with(NotificationConstants::SUCCESS_MSG, "KYC document(s) submitted successfully.");
        } catch (GuzzleException | GeneralException $e) {
            return back()->with(NotificationConstants::ERROR_MSG, $e->getMessage());
        } catch (Throwable $e) {
            return back()->with(NotificationConstants::ERROR_MSG, "An error occurred while processing your request.");
        }
    }

    public function handleWebhook(Request $request)
    {
        MetaMapService::incomingWebhook($request->all());
        return ApiHelper::validResponse("Hook received");
    }
}
