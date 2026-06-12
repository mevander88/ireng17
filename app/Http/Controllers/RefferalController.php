<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Saldo;
use App\Models\Network;
use Illuminate\Support\Str;
use App\Http\Api\fiver;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RefferalController extends Controller
{
    public function loadRefferal(Request $request)
    {
        if (isset($request->ref)) {
            $refferal = $request->ref;
            $User = User::where('ref_code', $refferal)->first();


            if ($User && filled($User->ref_code)) {
                return view('auth.refferal_register', compact('refferal'));
            }

            abort(404);
        } else {
            return back()->with('info', 'Kode referral tidak valid. Periksa kembali link pendaftaran Anda.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:6|max:12|regex:/^[a-zA-Z0-9]+$/',
            'email' => 'required|email|unique:users,email',
            'ref' => 'required|string|exists:users,ref_code',
            'password' => 'required|string|min:8|confirmed',
            'mobile_no' => 'required|string|max:20',
            'captcha' => 'required|string|max:4',
            'acc_name' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:50',
            'acc_no' => 'nullable|string|min:8|max:20',
            'terms' => 'accepted',
        ]);




        $refferalcode = Str::random(6);
        $domain = URL::to('/');
        $Url = $domain . '/referral-register?ref=' . $refferalcode;
        $extplayer = $request->name . mt_rand(100, 1000);

        $SG = new fiver();
        $act = json_decode($SG->create($extplayer));
        if (!in_array($act->status ?? null, [1, '1', 'success', 'SUCCESS'], true)) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', $act->msg ?? 'Provider API gagal membuat user. Silakan coba lagi.');
        }

        DB::transaction(function () use ($request, $refferalcode, $Url, $extplayer) {
            $user = User::create([
                'extplayer' => $extplayer,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telp' => $request->mobile_no,
                'ref_code' => $refferalcode,
                'ref_link' => $Url,
                'captcha' => $request->captcha,
                'nama_rek' => $request->acc_name,
                'bank' => $request->bank_name,
                'no_rek' => $request->acc_no,
                'ip_register' => $request->ip_register ?: request()->ip(),
                'token' => Str::random(7),
            ]);

            $UserData = User::where('ref_code', $request->ref)->first();
            if ($UserData) {
                Network::create([
                    'user_id' => $user->id,
                    'ref_code' => $request->ref,
                    'username' => $request->name,
                    'parent_id' => $UserData->id,
                ]);
            }

            Saldo::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'saldo' => 0,
                'bonus' => 0,
            ]);
        });

        return redirect('/')->with('success', 'Selamat Datang di Situs Kami');
    }

    public function searchHistory(Request $request)
    {

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $data = Network::where('parent_id', Auth()->user()->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function getTodaReff()
    {
        $todayData = Network::where('parent_id', Auth()->user()->id)
            ->whereDate('created_at', now())
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json($todayData);
    }
}
