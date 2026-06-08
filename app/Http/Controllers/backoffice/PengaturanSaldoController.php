<?php

namespace App\Http\Controllers\backoffice;

use App\Models\User;
use App\Models\Saldo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Api\fiver;

class PengaturanSaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Saldo $Saldo)
    {
        $src = trim((string) $request->query('search', ''));
        $decoded = base64_decode($src, true);
        if ($decoded !== false && base64_encode($decoded) === $src) {
            $src = $decoded;
        }
        $saldo = Saldo::query()
            ->leftJoin('users', 'users.id', '=', 'saldo.user_id')
            ->select([
                'saldo.id',
                'saldo.user_id',
                'saldo.user_name',
                'saldo.saldo',
                'saldo.bonus',
                'users.name',
                'users.email',
                'users.telp',
            ])
            ->when($src !== '', function ($query) use ($src) {
                $query->where(function ($inner) use ($src) {
                    $inner->where('users.name', 'like', "%{$src}%")
                        ->orWhere('users.email', 'like', "%{$src}%")
                        ->orWhere('users.telp', 'like', "%{$src}%")
                        ->orWhere('saldo.user_name', 'like', "%{$src}%");
                });
            })
            ->orderByDesc('saldo.id')
            ->paginate(20)
            ->withQueryString();
        $id = $Saldo->id ?? '';
        return view('backoffice.pengaturan_saldo.pengaturan_saldo', [
            'saldo' => $saldo,
            'src' => $src,
            'id' => $id

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        // Find the user


        // Find the user's balance
        $saldo_user = Saldo::find($id);
        if (!$saldo_user) {
            return redirect()->back()->with('error', 'Data saldo tidak ditemukan');
        }

        $User = User::where('id', $saldo_user->user_id)->first();
        if (!$User) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $validated = $request->validate([
            'type' => 'required|integer|in:1,2,3,4',
            'nominal' => 'required|numeric|min:1',
        ]);

        $nominal = (int) $validated['nominal'];

        // Check if the request has 'type' and 'nominal' fields
        if ($request->has('type') && $request->has('nominal')) {
            // Calculate the new balance based on the request type
            if ((int) $validated['type'] === 1) {

                $SG = new fiver();
                $act =  json_decode($SG->deposit($User->name, $nominal));
                if (isset($act->status) && in_array($act->status, [1, '1', 'success', 'SUCCESS'], true)) {
                    $saldo_user->saldo += $nominal;
                } else {
                    return redirect()->back()->with('error', 'Terjadi Kesalahan Input');
                }
            } elseif ((int) $validated['type'] === 2) {
                if ($saldo_user->saldo < $nominal) {
                    return redirect()->back()->with('error', 'Saldo tidak mencukupi');
                }

                $SG = new fiver();
                $act =  json_decode($SG->withdraw($User->name, $nominal));
                if (isset($act->status) && in_array($act->status, [1, '1', 'success', 'SUCCESS'], true)) {
                    $saldo_user->saldo -= $nominal;
                } else {
                    return redirect()->back()->with('error', 'Terjadi Kesalahan Input');
                }
            } elseif ((int) $validated['type'] === 3) {
                $saldo_user->bonus += $nominal;
            } elseif ((int) $validated['type'] === 4) {
                if ($saldo_user->bonus < $nominal) {
                    return redirect()->back()->with('error', 'Bonus tidak mencukupi');
                }

                $saldo_user->bonus -= $nominal;
            }

            // Save the changes to the saldo

        }

        $saldo_user->save();
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
