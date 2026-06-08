<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Api\fiver;
use App\Http\Api\ngaming;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bank;
use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Http\Api\softgaming;
use App\Models\Network;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class DatamemberController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $data_member = User::query()
            ->with('Saldo')
            ->where('id', '!=', 1)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('telp', 'like', "%{$search}%")
                        ->orWhere('ref_code', 'like', "%{$search}%")
                        ->orWhere('nama_rek', 'like', "%{$search}%")
                        ->orWhere('no_rek', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $data_bank = Bank::query()
            ->orderBy('type')
            ->orderBy('nama_bank')
            ->get();

        return view('backoffice.data_member.data_member', compact(['data_member', 'data_bank', 'search']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $refferalcode = Str::random(6);
        $domain = URL::to('/');
        $Url = $domain . '/referral-register?ref=' . $refferalcode;
        $extplayer = $request['nama'];

        $API = new fiver();
        $act = json_decode($API->create($extplayer));
        
        if ($act->status == 'success') {
            $request->validate([
                'nama' => 'required|unique:users,name',
            ], [
                'nama.unique' => 'Nama sudah terdaftar.',
            ]);

            $user = User::create([
                'extplayer' => $extplayer,
                'name' => $request->input('nama'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'telp' => $request->input('telp'),
                'ref_code' => $refferalcode,
                'ref_link' => $Url,
                'nama_rek' => $request->input('nama_rek'),
                'bank' => $request->input('bank'),
                'no_rek' => $request->input('no_rek'),
                'ip_register' => $request->input('ip_register'),
                'token' => Str::random(7),
            ]);
    
            if (isset($data['ref_code'])) {
                $UserData = User::where('ref_code', $data['ref_code'])->first();
                if ($UserData) {
                    Network::create([
                        'user_id' => $user->id,
                        'ref_code' => $data['ref_code'],
                        'username' => $data['name'],
                        'parent_id' => $UserData->id,
                    ]);
                }
            }

            $saldo = new Saldo();
            $saldo->user_id = $user->id;
            $saldo->user_name = $user->name;
            $saldo->saldo = 0;
            $saldo->bonus = 0;
            $saldo->save();
            
            return redirect('/data_member')->with('success', 'Akun berhasil ditambahkan');
        }else {
            \Log::warning('Gagal membuat member di API', ['response' => $act]);
            return redirect('/data_member')->with('error', 'Akun belum bisa dibuat di sistem game. Silakan coba lagi.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $saldo = Saldo::where('user_id', $user->id);
        return response()->json([
            'saldo' => $saldo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // Ambil data member berdasarkan id
        $member = User::findOrFail($id);

        // Update data member
        $member->name = $request->nama;

        // Hanya update password jika ada
        if ($request->filled('password')) {
            $member->password = bcrypt($request->password);
        }

        $member->email = $request->email;
        $member->telp = $request->telp;
        $member->ref_code = $request->ref_code;
        $member->nama_rek = $request->nama_rek;
        $member->bank = $request->bank;
        $member->no_rek = $request->no_rek;
        $member->save();

        return redirect('/data_member')->with('success', 'Data member berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan data berdasarkan ID
        $data = User::find($id);

        // Periksa apakah data ditemukan
        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Hapus data
        $data->delete();
        $msg = 'Member berhasil dihapus';

        // Berikan respons sukses
        return redirect('/data_member')->with('success', $msg);
        
    }
}
