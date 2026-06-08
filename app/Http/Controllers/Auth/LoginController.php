<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\UserLogin;
use App\Models\Game_users;
use App\Models\Game_api;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
{
    $user = auth()->user();
    \Log::info('Login user level: '.$user->level);
    if ($user->level == 1 || $user->level == 2) {
        return '/backoffice';
    }
    return '/';
}

  public function showLoginForm()
{
    $setting = Setting::first(); // Ambil setting pertama dari DB
    return view('auth.login', compact('setting'));
}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    /**
     * Handle failed login attempt
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only('name', 'remember'))
            ->withErrors([
                'name' => 'Username atau password salah. Silakan coba lagi.',
            ])
            ->with('error', 'Username atau password salah. Silakan coba lagi.');
    }

    /**
     * Handle authenticated user
     */
    protected function authenticated(Request $request, $user)
    {
        // Log login activity jika diperlukan
        \Log::info('User logged in: ' . $user->name);
        
        return redirect()->intended($this->redirectPath())
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }
}
