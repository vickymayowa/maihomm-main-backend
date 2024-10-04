<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Constants\ApiConstants;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Reward\ReferralService;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\Users\UserResource;
use App\Services\Auth\RegisterationService;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
        ->scopes(['openid', 'profile', 'email'])
        ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid()), // Creating a random password
                    'google_id' => $googleUser->getId(), // Save Google ID to link accounts
                ]);

                Auth::login($user);
            }

            return redirect()->intended('dashboard'); // Redirect to your intended route
        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage());
            return redirect('/login')->withErrors(['error' => 'Failed to authenticate using Google.']);
        }
    }

    public function handleApiGoogleCallback()
    {

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $getName = self::getNames($googleUser->getName());
                $first_name = $getName["first_name"] ?? null;
                $middle_name = $getName["middle_name"] ?? null;
                $last_name = $getName["last_name"] ?? null;

                $data = [
                    'first_name' => $first_name,
                    'middle_name' => $middle_name,
                    'last_name' => $last_name,
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid()), // Creating a random password
                    'google_id' => $googleUser->getId(), // Save Google ID to link accounts
                    'ref_code' => '',
                ];

                $user = RegisterationService::createUser($data);

                if (!empty($data['ref_code'])) {
                    ReferralService::newReferral($user->id, $data['ref_code']);
                }

                RegisterationService::postRegisterActions($user);
            }

            $data =  UserResource::make($user)->userArray($user);

            $data["token"] = $user->createToken('AuthToken')->plainTextToken;

            return ApiHelper::validResponse("User Logged In successfully", $data);

        }catch (UserException $e) {
            $message = '';
            return ApiHelper::problemResponse("Error", ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::SERVER_ERR_CODE, null, $e);
        }
    }

    public static function getNames($name)
    {
        $names = explode(" ", $name);
        if (count($names) > 1) {
            $data = [
                "first_name" => $names[0],
                "last_name" => $names[1],
            ];
        } else {
            $data = [
                "first_name" => $names[0],
                "last_name" => null,
            ];
        }
        return $data;
    }
}
