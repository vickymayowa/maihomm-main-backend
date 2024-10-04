<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Constants\NotificationConstants;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view("dashboards.admin.profile.index", [
            "user" => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        try {
            UserService::update($request->all(), auth()->id());
        } catch (ValidationException $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with(NotificationConstants::ERROR_MSG, "An error occured while trying to process your request");
        }
    }
}
