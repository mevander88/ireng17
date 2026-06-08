<?php

namespace App\Http\Controllers\Auth;

use App\Http\Api\fiver;
use App\Http\IP\IP;
use App\Models\User;
use App\Models\Saldo;
use App\Models\Network;
use Illuminate\Support\Str;
use App\Http\Api\softgaming;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo()
    {
        if (auth()->user()->level == 'Admin' || auth()->user()->level == 'Developer') {
            return '/backoffice';
        }
        return '/';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Username wajib diisi.',
            'name.unique' => 'Username sudah terdaftar. Silakan gunakan username lain.',
            'name.max' => 'Username maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
  protected function create(array $data)
{
    $refferalcode = Str::random(6);
    $domain = URL::to('/');
    $Url = $domain . '/referral-register?ref=' . $refferalcode;
    // extplayer dipakai sebagai username unik untuk provider/game API
    // (karena provider bisa menolak username yang sama walaupun DB lokal masih kosong)
    $extplayer = $data['name'] . mt_rand(100, 1000);
    $username = $data['name'];
    $providerUsername = $extplayer;

    // 🔹 Panggil Fiver API
    $SG = new fiver();
    $response = $SG->create($providerUsername);

    // Decode JSON aman
    $act = json_decode($response, true);

    // Log hasil API untuk debugging
    \Log::info('Fiver user_create response', [
        'username' => $username,
        'providerUsername' => $providerUsername,
        'response' => $act
    ]);

    // 🔴 Jika API gagal
    if (!is_array($act) || !isset($act['status']) || $act['status'] != 1) {
        $errorMessage = $act['msg'] ?? 'Fiver API gagal membuat user. Username mungkin sudah terdaftar.';
        
        // Pesan error yang lebih user-friendly
        if (isset($act['msg']) && strpos(strtolower($act['msg']), 'duplicated') !== false) {
            $errorMessage = 'Username sudah terdaftar. Silakan gunakan username lain.';
        } elseif (isset($act['msg']) && strpos(strtolower($act['msg']), 'duplicate') !== false) {
            $errorMessage = 'Username sudah terdaftar. Silakan gunakan username lain.';
        }

        // Lempar error agar muncul di form register dengan flash message
        throw \Illuminate\Validation\ValidationException::withMessages([
            'name' => $errorMessage,
        ])->errorBag('default')->redirectTo(request()->url())->with('error', $errorMessage);
    }

    // 🟢 Jika API berhasil
    // Tentukan bank/ewallet name berdasarkan method yang dipilih
    $bankOrEwalletName = $data['bank_name'] ?? $data['ewallet_name'] ?? null;
    
    $user = User::create([
        'extplayer'    => $extplayer,
        'name'         => $data['name'],
        'email'        => $data['email'],
        'password'     => Hash::make($data['password']),
        'telp'         => $data['mobile_no'] ?? null,
        'ref_code'     => $refferalcode,
        'ref_link'     => $Url,
        'nama_rek'     => $data['acc_name'] ?? null,
        'bank'         => $bankOrEwalletName,
        'no_rek'       => $data['acc_no'] ?? null,
        'ip_register'  => $data['ip_register'] ?? request()->ip(),
        'token'        => Str::random(7),
    ]);

    // Referral network
    if (!empty($data['ref_code'])) {
        $parent = User::where('ref_code', $data['ref_code'])->first();
        if ($parent) {
            Network::create([
                'user_id'   => $user->id,
                'ref_code'  => $data['ref_code'],
                'username'  => $user->name,
                'parent_id' => $parent->id,
            ]);
        }
    }

    // Saldo awal
    Saldo::create([
        'user_id'   => $user->id,
        'user_name' => $user->name,
        'saldo'     => $act['user_balance'] ?? 0,
        'bonus'     => 0,
    ]);

    return $user; // <- Penting, agar trait RegistersUsers auto-login
}

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return redirect($this->redirectPath())
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name . '!');
    }
}
