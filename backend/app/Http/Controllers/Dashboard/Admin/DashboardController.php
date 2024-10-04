<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserTransactionModel;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     $users = User::paginate();
    //     return view("dashboards.admin.user.user-list", [
    //         "sn" => $users->firstItem(),
    //         "users" => $users,
    //     ]);
    // }

    public function index()
    {
        $users = User::latest("id")->limit(10)->get();
        $payments = Payment::latest("id")->limit(10)->get();
        $statistics = [
            "users" => int_format(User::count()),
            "transactions" => int_format(UserTransactionModel::count()),
        ];
        return view("dashboards.admin.index.index" , [
            "users" => $users,
            "payments" => $payments,
            "statistics" => $statistics

        ]);
    }
}
