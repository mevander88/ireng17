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
        return view('auth.admin-login', compact('setting'));
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            if (!in_array((int) Auth::user()->level, [1, 2], true)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->with('LoginError', 'Username atau kata sandi admin tidak sesuai.');
            }

            $request->session()->regenerate();
            return redirect('/backoffice');
        }
        return back()->with('LoginError', 'Username atau kata sandi admin tidak sesuai.');
    }
}
