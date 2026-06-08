<?php

namespace App\Http\Controllers;

use App\Http\Api\fiver;
use App\Models\Banner;
use App\Models\Setting;
use App\Http\Api\Aktivasi;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    
    public function index()
    {
        $setting = Setting::first();
        $banners = Banner::all();
        return view('welcome', compact('setting', 'banners'));
    }
}
