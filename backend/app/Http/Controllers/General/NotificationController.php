<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAs($id, $action)
    {
        $user = auth()->user();
        $notification = $user->notifications()->where("id", $id)->first();
        $redirect_link = $notification->data["link"] ?? null;
        if ($action == "read") {
            $notification->markAsRead();
        }

        if (empty($redirect_link)) {
            return back();
        }
        return redirect()->away($redirect_link);
    }

    public function list(Request $request)
    {
        $user = auth()->user();
        $notifications = $user->notifications()
            ->latest()
            ->paginate($request->pagination)
            ->appends($request->query());
        return view("dashboards.general.notifications.index", ["notifications" => $notifications]);
    }

    public function info($id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->where("id", $id)->first();
            $notification->markAsRead();
            return view("dashboards.general.notifications.show", ["notification" => $notification]);
    }
}
