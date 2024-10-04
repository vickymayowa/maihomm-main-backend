<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Models\User;
use App\Constants\AppConstants;
use App\Constants\TransactionActivityConstants;
use App\Http\Controllers\Controller;
use App\QueryBuilders\General\UserQueryBuilder;
use Spatie\Permission\Models\Role;
use App\Constants\NotificationConstants;
use App\Constants\StatusConstants;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Services\Auth\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sudo = sudo();
        $users = UserQueryBuilder::filterList($request)
        ->orderby("id", "desc")
        ->whereNotIn("id", [$sudo->id])
        ->paginate(AppConstants::ADMIN_PAGINATION_SIZE)
        ->appends($request->query());
        return view('dashboards.admin.user.index', [
            "users" => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::get();
        $states = State::get();
        $countries = Country::get();
        return view("dashboards.admin.user.create", [
            'cities' => $cities,
            'states' => $states,
            'countries' => $countries,
            "statuses" => StatusConstants::ACTIVE_OPTIONS,
            "genders" => AppConstants::GENDERS
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        UserService::store($request->all());
        session()->flash(NotificationConstants::SUCCESS_MSG, "User added successfully");
        return redirect()->route('dashboard.admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view("dashboards.admin.user.show", [
            "user" => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        $cities = City::get();
        $states = State::get();
        $countries = Country::get();
        return view('dashboards.admin.user.edit', [
            'user' => $user,
            'cities' => $cities,
            'states' => $states,
            'countries' => $countries,
            "statuses" => StatusConstants::ACTIVE_OPTIONS,
            "genders" => AppConstants::GENDERS
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        UserService::update($request->all(), $id);
        session()->flash(NotificationConstants::SUCCESS_MSG, "User updated successfully");
        return redirect()->route('dashboard.admin.users.show' , $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $user = User::find($id);
        $user->delete();
        return back();
    }

    public function imitate($id)
    {
        if (!isSudo()) {
            return back();
        }
        Auth::loginUsingId($id);
        return redirect()->route("auth.home");
    }

}
