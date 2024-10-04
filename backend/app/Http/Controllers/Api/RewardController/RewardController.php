<?php

namespace App\Http\Controllers\Api\RewardController;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Services\Reward\RewardService;
use Exception;

class RewardController extends Controller
{
    public function list()
    {
        try {
            $reward = RewardService::getRewards();
            $data = $reward;
            return ApiHelper::validResponse("Rewards retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
