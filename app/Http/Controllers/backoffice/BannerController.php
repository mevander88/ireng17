<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = Banner::query()
            ->latest()
            ->paginate(20);

        return view('backoffice.banner.banner', compact('banner'));
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

        $validateData  = $request->validate([

            'gambar' => 'image|file|mimes:jpeg,png,webp,gif|max:4048',


        ]);

        if ($request->file('gambar')) {
            $validateData['gambar'] = $request->file('gambar')->store('post-images');
        }


        $validateData['nama'] = $request->nama;
        $validateData['status'] = $request->status;

        Banner::create($validateData);
        return redirect()->back()->with('success', 'Data berhasil diubah');
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
        $banner = Banner::find($id);
        if ($request->status != null) {
            $banner->status = $request->status;
        } else {
            $banner->nama = $request->nama;
            if ($request->hasFile('gambar')) {
                $banner->gambar = $request->file('gambar')->store('post-images');
            }
        }
        $banner->save();
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::find($id);
        $file_path = public_path() . '/storage/post-images/' . $banner->gambar;
        if (File::exists($file_path)) {
            unlink($file_path);
        }
        $banner->save();
        Banner::find($id)->delete();
        return Redirect::to('banner');
    }
}
