<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::getPublicAsArray();
        return view('frontend.home', compact('settings'));
    }
} 