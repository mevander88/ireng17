<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;


class AdminLoginController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('auth.login', compact('setting'));
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/backoffice');
        }
        return back()->with('LoginError', 'Username atau kata sandi admin tidak sesuai.');
    }
}
