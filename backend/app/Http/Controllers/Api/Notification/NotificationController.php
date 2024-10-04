<?php

namespace App\Http\Controllers\Api\Notification;

use Exception;
use Throwable;
use App\Models\User;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Constants\ApiConstants;
use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;

class NotificationController extends Controller
{
    public function myNotifications()
    {
        try {
            $user = User::find(auth()->id());
            $notifications = $user->notifications()->paginate();
            $data = ApiHelper::collect_pagination($notifications);
            $data["data"] = NotificationResource::collection($notifications);
            return ApiHelper::validResponse("Notifications retrieved successfully", $data);
        } catch (Throwable $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function markAsRead($id)
    {
        try {
            $user = auth()->user();
            $userUnreadNotification = $user
                ->notifications
                ->whereNull('readAt')
                ->find($id);
                if (empty($userUnreadNotification)) {
                    return ApiHelper::problemResponse("Notification not found", ApiConstants::NOT_FOUND_ERR_CODE, null);
                }
            $userUnreadNotification->markAsRead();
            return ApiHelper::validResponse("Notification marked as read");
        } catch (Throwable $e) {
            return ApiHelper::problemResponse("An error occured while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
