<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPernyataanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transaksi = null;
        if ($request->daterange != null) {
            $string = explode('-', $request->daterange);

            $date1 = explode('/', $string[0]);
            $date2 = explode('/', $string[1]);

            $start =  $date1[0]  . '-' . $date1[1] . '-' . $date1[2];
            $start = str_replace(' ', '', $start);
            $end =  $date2[0] . '-' . $date2[1] . '-' . $date2[2];
            $end = str_replace(' ', '', $end);
            $transaksi = Transaksi::where('user_id', Auth::user()->id)->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])->get();
        }
        return view('account.history', compact('transaksi'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
