<?php

namespace App\Http\Controllers\backoffice;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepositbankController extends Controller
{
    /**
     * Tampilkan semua data bank & e-wallet.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $bank = Bank::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('nama_bank', 'like', "%{$search}%")
                        ->orWhere('nama_penerima', 'like', "%{$search}%")
                        ->orWhere('no_rek', 'like', "%{$search}%");
                });
            })
            ->orderBy('type')
            ->orderBy('nama_bank')
            ->paginate(20)
            ->withQueryString();

        return view('backoffice.deposit_bank.deposit_bank', compact('bank', 'search'));
    }

    /**
     * Simpan data baru (Bank atau E-Wallet).
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_bank' => 'required|max:255',
            'no_rek' => 'required|max:255',
            'nama_penerima' => 'required|max:255',
            'image_qr' => 'nullable|image|file|max:2048',
            'logo' => 'nullable|image|file|max:2048',
            'type' => 'required|integer', // 1 = Bank, 2 = E-Wallet
        ]);

        // Upload QR jika ada
        if ($request->hasFile('image_qr')) {
            $validateData['image_qr'] = $request->file('image_qr')->store('post-images');
        }

        // Upload logo jika ada
        if ($request->hasFile('logo')) {
            $validateData['logo'] = $request->file('logo')->store('post-images');
        }

        $validateData['status'] = 1; // default aktif

        Bank::create($validateData);

        return redirect('/deposit_bank')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update data (Bank / E-Wallet).
     */
    public function update(Request $request, string $id)
    {
        $bank = Bank::findOrFail($id);

        // Jika hanya update status
        if ($request->has('status')) {
            $bank->status = $request->status;
        } else {
            $bank->nama_bank = $request->nama_bank;
            $bank->nama_penerima = $request->nama_penerima;
            $bank->no_rek = $request->no_rek;
            $bank->type = $request->type;
        }

        // Upload QR baru jika diubah
        if ($request->hasFile('image_qr')) {
            $bank->image_qr = $request->file('image_qr')->store('post-images');
        }

        // Upload logo baru jika diubah
        if ($request->hasFile('logo')) {
            $bank->logo = $request->file('logo')->store('post-images');
        }

        $bank->save();

        return redirect('/deposit_bank')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Hapus data.
     */
    public function destroy(string $id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return redirect('/deposit_bank')->with('error', 'Data tidak ditemukan.');
        }

        $bank->delete();

        return redirect('/deposit_bank')->with('success', 'Data berhasil dihapus.');
    }
}
