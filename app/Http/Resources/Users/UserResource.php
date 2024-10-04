<?php

namespace App\Http\Resources\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public $token;
    // public __construct(){
    //     $this->token = $token
    // }
    public function toArray(Request $request): array
    {
        return [
            "id" => (int) $this->id,
            "first_name" => (string) $this->first_name,
            "middle_name" => (string) $this->middle_name,
            "last_name" => (string) $this->last_name,
            "email" => (string) $this->email,
            "role" => (string) $this->role,
            "phone_no" => (string) $this->phone_no,
            "gender" => $this->gender,
            "status" => $this->status,
            "home_address" => $this->home_address,
            "country" => $this->country_id ? $this->country->name : "",
            "ref_code" => $this->ref_code,
            "profile_pic" => $this->imageUrl(),
            "user_type" => $this->user_type,
            "email_verified" => empty($this->email_verified_at) ? 'no' : 'yes',
            "settings" => [
                "two_factor_auth" => $this->two_factor_auth,
                "hide_balance" => $this->hide_balance,
                "receive_email_notifications" => $this->receive_email_notifications,
                "receive_text_notifications" => $this->receive_text_notifications
            ],
            "verification" => $this->verificationData()
        ];
    }

    public function userArray(User $user): array
    {
        return [
            "id" => (int) $this->id,
            "first_name" => (string) $this->first_name,
            "middle_name" => (string) $this->middle_name,
            "last_name" => (string) $this->last_name,
            "email" => (string) $this->email,
            "role" => (string) $this->role,
            "phone_no" => (string) $this->phone_no,
            "gender" => $this->gender,
            "status" => $this->status,
            "ref_code" => $this->ref_code,
            "profile_pic" => $this->imageUrl(),
            "user_type" => $this->user_type,
            "email_verified" => empty($this->email_verified_at) ? 'no' : 'yes',
            "settings" => [
                "two_factor_auth" => $this->two_factor_auth,
                "hide_balance" => $this->hide_balance,
                "receive_email_notifications" => $this->receive_email_notifications,
                "receive_text_notifications" => $this->receive_text_notifications
            ],
            "verification" => $this->verificationData()
        ];
    }
}
