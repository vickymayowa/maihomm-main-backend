<?php

namespace App\Services\Auth;

use App\Exceptions\General\GeneralException;
use App\Models\User;
use App\Services\Media\FileService;
use App\Services\Notifications\AppMailerService;
use App\Services\Reward\ReferralService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserService
{
    public User $user;

    public static function init(): self
    {
        return app()->make(self::class);
    }

    public static function validate(array $data, $id = null): array
    {
        $validator = Validator::make($data, [
            "avatar_id" => "nullable|image",
            "first_name" => "nullable|string|" . Rule::requiredIf(empty($id)),
            "last_name" => "nullable|string|" . Rule::requiredIf(empty($id)),
            "phone_no" => "nullable|string|unique:users,phone_no,$id|" . Rule::requiredIf(empty($id)),
            "email" => "nullable|email|unique:users,email,$id|" . Rule::requiredIf(empty($id)),
            "middle_name" => "nullable|string",
            "user_type" => "nullable|string|in:Guest,Co-Owner",
            "gender" => "nullable|string",
            "maiden_name" => "nullable|string",
            "date_of_birth" => "nullable|string",
            "status" => "nullable|string",
            "home_address" => "nullable|string",
            "country_id" => "nullable|string",
            "state_id" => "nullable|string",
            "city_id" => "nullable|string",
            'old_password' => [
                'nullable', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('Old Password didn\'t match');
                    }
                },
            ],

            'password' => [
                'nullable', 'different:old_password'
            ]

        ], [
            "avatar_id.image" => "The avatar must be an image file"
        ]);

        $validator->sometimes('password', 'required|confirmed', function ($input) {
            return (strlen($input->old_password) > 0);
        });

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    /**
     *  Update the user
     */

    public static function store(array $data)
    {

        if(isset($data["name"]) && !empty($data["name"])){
            $getName = self::getNames($data["name"]);
            $data["first_name"] = $getName["first_name"] ?? null;
            $data["middle_name"] = $getName["middle_name"] ?? null;
            $data["last_name"] = $getName["last_name"] ?? null;
        }else{
            $data["first_name"] = $data['first_name'] ?? null;
            $data["middle_name"] = $data['middle_name'] ?? null;
            $data["last_name"] = $data['last_name'] ?? null;
        }
        $refCode = $data['ref_code'] ?? "";
        
        $data = self::validate($data);
        // $data["password"] = "Tmp_" . getRandomToken(8, false);
        $user = RegisterationService::createUser($data);
        
        if (!empty($refCode)) {
            ReferralService::newReferral($user->id, $refCode);
        }
        RegisterationService::postRegisterActions($user);
        return $user;
    }
    
    public static function update(array $data, $id)
    {
        $getName = self::getNames($data["name"], $id);
        $data["first_name"] = $getName["first_name"];
        $data["middle_name"] = $getName["middle_name"];
        $data["last_name"] = $getName["last_name"];
        $data = self::validate($data, $id);
        if (!empty($logo = $data["avatar_id"] ?? null)) {
            $fileService = new FileService;
            $savedFile = $fileService->saveFromFile($logo, "user_image", null, auth()->id());
            $data["avatar_id"] = $savedFile->id;
        }
        $user = User::find($id);

        if (!empty($user->avatar_id)) {
            FileService::cleanDelete($user->avatar_id);
        }

        if (empty($data["old_password"])) {
            unset($data["old_password"]);
            unset($data["password"]);
        } else if (!empty($data["old_password"]) && empty($data["password"])) {
            unset($data["old_password"]);
            unset($data["password"]);
        } else if (!empty($data['password'] && $data["old_password"])) {
            $data["password"] = Hash::make($data['password'] ?? null);
            unset($data["old_password"]);
        }

        $user->update($data);
        return $user->refresh();
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

    // public static function getNames($names, $id = null)
    // {
    //     $user = User::find($id);
    //     $explodeName = explode(" ", $names);
    //     if (count($explodeName) == 3) {
    //         $data["first_name"] = $explodeName[0];
    //         $data["middle_name"] = $explodeName[1];
    //         $data["last_name"] = $explodeName[2];
    //     }
    //     if (count($explodeName) == 2) {
    //         $data["first_name"] = $explodeName[0];
    //         $data["middle_name"] = $user->middle_name ?? null;
    //         $data["last_name"] = $user->last_name ??  $explodeName[2];
    //     }
    //     if (count($explodeName) == 1) {
    //         $data["first_name"] = $explodeName[0];
    //         $data["middle_name"] = $user->middle_name ?? null;
    //         $data["last_name"] = $user->last_name ?? null;
    //     }
    //     return $data;
    // }
    public static function removePicture($id)
    {
        $user = User::find($id);
        $avatar_id = $user->avatar_id;
        if (!empty($avatar_id)) {
            $user->update([
                "avatar_id" => null
            ]);
            FileService::cleanDelete($avatar_id);
        } else {
            throw new GeneralException("You do not have a picture set");
        }
    }

    public static function uplaodPicture($data, $id)
    {
        if (!empty($logo = $data["avatar_id"] ?? null)) {
            $fileService = new FileService;
            $savedFile = $fileService->saveFromFile($logo, "user_image", null, auth()->id());
            $data["avatar_id"] = $savedFile->id;
        }

        $user = User::find($id);

        if (!empty($user->avatar_id)) {
            FileService::cleanDelete($user->avatar_id);
        }
        $user->update($data);
        return $user;
    }
    public static function emailUser($user, $password)
    {
        AppMailerService::send([
            "data" => [
                "name" => $user->names(),
                "password" => $password,
                "email" => $user->email,
            ],
            "to" => $user->email,
            "template" => "emails.user.register",
            "subject" => "Login Credentials",
        ]);
    }
    // public static function emailUserCredentials($user, $password)
    // {
    //     AppMailerService::send([
    //         "data" => [
    //             "name" => $user->names(),
    //             "password" => $password,
    //             "email" => $user->email,
    //         ],
    //         "to" => $user->email,
    //         "template" => "emails.user.user_credentials",
    //         "subject" => "Login Credentials",
    //     ]);
    // }
}
