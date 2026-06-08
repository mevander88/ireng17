<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bonus;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = 10;
        $bonus = Bonus::latest()->paginate($limit);
        return view(
            'backoffice.bonus.bonus',
            compact('bonus')
        )->with('i', (request()->input('page', 1) - 1) * $limit);
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
        try {
            $input = $request->all();
            $input['status'] = "2"; // set default status as nonactive

            Bonus::create($input);

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan bonus: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Bonus belum bisa disimpan. Periksa data lalu coba lagi.');
        }
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
        $bonus = Bonus::find($id);
        if ($request->status != null) {
            $bonus->status = $request->status;
        } else {
            $bonus->judul = $request->judul;
            $bonus->keterangan = $request->keterangan;
            $bonus->nominal = $request->nominal;
        }

        $bonus->save();
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bonus = Bonus::find($id);
        $bonus->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
