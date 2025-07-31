<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MetricsController;

class HomeController extends Controller
{
    public function index()
    {
        MetricsController::incCounter('home_requests_total');
        return view('welcome');
    }

    public function login()
    {
        MetricsController::incCounter('login_requests_total');
        return view('login');
    }
}
