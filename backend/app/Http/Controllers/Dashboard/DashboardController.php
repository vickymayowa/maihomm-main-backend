<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route("dashboard.user.portfolio.index");
    }
}
