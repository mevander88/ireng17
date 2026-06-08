<?php

namespace App\Http\Controllers;

use App\Http\Api\fiver;
use App\Models\User;
use App\Models\Saldo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $user = User::query()
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

        return view('backoffice.data_member.inject', compact('user', 'search'));
    }


    /**
     * Update saldo (deposit/withdraw) ke user.
     */
    public function update(Request $request, string $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'saldo' => 'required|numeric',
        'action' => 'required|in:deposit,withdraw',
    ]);

    $saldo = floatval($request->input('saldo'));
    $SG = new fiver();

    if ($request->input('action') === 'deposit') {
        $act = json_decode($SG->deposit($user->name, $saldo));
        if ($act->status == 'success' || $act->status == 1) {
            $saldo_user = Saldo::firstOrCreate(['user_id' => $user->id], ['saldo' => 0]);
            $saldo_user->saldo += $saldo;
            $saldo_user->save();
            return redirect()->back()->with('success', 'Saldo berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Saldo belum bisa ditambahkan. Silakan coba lagi.');
        }
    }

    if ($request->input('action') === 'withdraw') {
        $act = json_decode($SG->withdraw($user->name, $saldo));
        if ($act->status == 'success' || $act->status == 1) {
            $saldo_user = Saldo::firstOrCreate(['user_id' => $user->id], ['saldo' => 0]);
            $saldo_user->saldo -= $saldo;
            $saldo_user->save();
            return redirect()->back()->with('success', 'Saldo berhasil dikurangi.');
        } else {
            return redirect()->back()->with('error', 'Saldo belum bisa dikurangi. Silakan coba lagi.');
        }
    }

    return redirect()->back()->with('error', 'Tindakan tidak valid.');
}

}
