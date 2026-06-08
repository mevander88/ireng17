<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoucherController extends Controller
{
    public function index()
    {
        $Voucher = Voucher::query()
            ->latest()
            ->paginate(20);

        return view('backoffice.kode.generate_kode', compact('Voucher'));
    }

    public function generateVoucher(Request $request)
    {
        $code = $this->generateVoucherCode();

        // Simpan kode voucher ke database
        Voucher::create([
            'code' => $code,
            'is_valid' => 1
        ]);

        return response()->json(['voucher_code' => $code]);
    }

    private function generateVoucherCode()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($characters), 0, 6);
    }
}
