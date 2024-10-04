<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constants\ApiConstants;
use App\Exceptions\General\GeneralException;
use App\Exceptions\UserException;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use App\QueryBuilders\General\UserQueryBuilder;
use App\Services\Auth\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $users = UserQueryBuilder::filterList($request)->whereNotIn("id", [auth()->id()])->get();
            // $data = ApiHelper::collect_pagination($users);
            $data["data"] = UserResource::collection($users);
            return ApiHelper::validResponse("Users retrieved", $data);
        } catch (Exception $e) {
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data["password"] = "Tmp_" . getRandomToken(8, false);
            $user = UserService::store($data);
            UserService::emailUser($user, $data["password"]);
            $data = UserResource::make($user);
            DB::commit();
            return ApiHelper::validResponse("User added successfully", $data);
        } catch (Exception $e) {
            DB::rollBack();
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if (empty($user)) {
                throw new UserException("User not found");
            }
            $data = UserResource::make($user);
            DB::commit();
            return ApiHelper::validResponse("User retrieved successfully", $data);
        } catch (UserException $e) {
            DB::rollBack();
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            DB::rollBack();
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $user = UserService::update($data, $id);
            $data = UserResource::make($user);
            DB::commit();
            return ApiHelper::validResponse("User updated successfully", $data);
        } catch (Exception $e) {
            DB::rollBack();
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function removePicture($id)
    {
        DB::beginTransaction();
        try {
            $user = UserService::removePicture($id);
            DB::commit();
            return ApiHelper::validResponse("Picture removed successfully");
        } catch (GeneralException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            DB::rollBack();
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }

    public function uploadPicture(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $user = UserService::uplaodPicture($data, $id);
            $data = UserResource::make($user);
            DB::commit();
            return ApiHelper::validResponse("Picture uploaded successfully", $data);
        } catch (GeneralException $e) {
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            DB::rollBack();
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if (empty($user)) {
                throw new UserException("User not found");
            }
            // optional($user->portfolio)->delete();
            // optional($user->wallet)->delete();
            $suffix = "?deleted=" . time();
            $user->update([
                "email" => $user->email.$suffix,
                "phone_no" => $user->phone_no . $suffix,
            ]);
            $user->delete();

            DB::commit();
            return ApiHelper::validResponse("User deleted successfully");
        } catch (UserException $e) {
            DB::rollBack();
            return ApiHelper::problemResponse($e->getMessage(), ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        } catch (Exception $e) {
            DB::rollBack();
            $message = 'Something went wrong while processing your request.';
            return ApiHelper::problemResponse($message, ApiConstants::BAD_REQ_ERR_CODE, null, $e);
        }
    }
}
