<?php

namespace App\Http\Controllers\Auth;

use App\Constants\General\NotificationConstants;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Auth\ReferralService;
use App\Services\Auth\RegisterationService;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_no' => ['required', 'string', 'max:15', 'unique:users,phone_no'],
            'country_code' => ['required', 'string', 'max:5'],
            'nationality' => ['required', 'string', 'max:255'],
            'password' => [
                'required', 
                'confirmed', 
                'string',
                'min:8',
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
                'confirmed'
            ],
        ],  [
            'password.regex' => 'Password must be at least 8 characters long and include at least one uppercase letter, one number, and one special character.',
            'terms.accepted' => 'You must accept the terms and conditions.',
            'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
            'g-recaptcha-response.required' => 'Please complete the captcha'
        ]);

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

     public function create(array $data)
     {
         DB::beginTransaction();
         try {
             $user = User::create([
                 'first_name' => $data['first_name'],
                 'last_name' => $data['last_name'],
                 'email' => $data['email'],
                 'phone_no' => $data['country_code'] . $data['phone_no'],
                 'nationality' => $data['nationality'],
                 'password' => Hash::make($data['password']),
             ]);
     
             // Perform any additional actions, such as referral logic
             ReferralService::newReferral($user, $data["ref_code"] ?? null);
     
             DB::commit();
             return $user;
         } catch (Exception $e) {
             DB::rollBack();
             throw $e;
         }
     }
     
    // public function create($data)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $user = RegisterationService::createUser($data);
    //         ReferralService::newReferral($user, $data["ref_code"] ?? null);
    //         if (!empty($phone = $data["phone_no"] ?? null)) {
    //             $user->update(["phone_no" => $phone]);
    //         }
    //         DB::commit();
    //         return $user;
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         throw $e;
    //     }
    // }

    protected function registered(Request $request, $user)
    {
        RegisterationService::postRegisterActions($user);
    }

    protected function redirectTo()
    {
        return route("dashboard.user.show-kyc-page");
    }
}
