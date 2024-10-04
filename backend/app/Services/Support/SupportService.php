<?php

namespace App\Services\Support;

use App\Models\User;
use App\Models\Support;
use App\Constants\AppConstants;
use Illuminate\Validation\Rule;
use App\Constants\StatusConstants;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Auth\SignupNotification;
use Illuminate\Validation\ValidationException;
use App\Notifications\Support\SupportNotification;
use App\Notifications\Support\BroadcastNotification;

class SupportService
{

    public function list(array $query)
    {
        $builder = Support::query();
        return $builder;
    }

    public function create($data)
    {
        $validator = Validator::make($data, [
            "title" => "required|string",
            "message" => "required|string",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = $validator->validated();
        $data["user_id"] = auth()->id();
        $data["status"] = StatusConstants::PENDING;

        $user = User::find(auth()->id());

        Notification::route('mail', AppConstants::SUDO_EMAIL)->notify(new SupportNotification($data, $user));
        
        $support = Support::create($data);
        return $support;
    }

    public function update($id , $data)
    {
        $validator = Validator::make($data, [
            "priority" => "required|string",
            "category" => "required|string",
            "status" => "required|string|".Rule::in(StatusConstants::PAYMENT_OPTIONS),
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = $validator->validated();
        $support = Support::findOrFail($id);
        $history = $support->history ?? [];
        $history[] = [
            "admin" => auth()->user()->full_name,
            "timestamp" => now(),
            "data" => $data
        ];
        $data["history"] = $history;
        $support->update($data);
        return $support->refresh();
    }

    public function broadcast($data)
    {
        $validator = Validator::make($data, [
            "title" => "required|string",
            "message" => "required|string",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = $validator->validated();
        User::chunk(100, function ($users) use ($data){
            foreach ($users as $user) {
                $user->notify(new BroadcastNotification($data));
            }
        });

    }
}
