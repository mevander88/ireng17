<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
        $staticBanners = $this->staticHomeBanners();
        $activeBannerCount = Banner::where('status', '1')->count();

        return view('backoffice.banner.banner', compact('banner', 'staticBanners', 'activeBannerCount'));
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
            'nama' => 'required|string|max:255',
            'gambar' => 'required|image|file|mimes:jpeg,jpg,png,webp,gif|max:4096',
            'status' => 'required|in:1,2',
        ]);

        if ($request->file('gambar')) {
            $validateData['gambar'] = $request->file('gambar')->store('banner-home', 'public');
        }


        Banner::create($validateData);
        return redirect()->back()->with('success', 'Banner berhasil ditambahkan.');
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
        $banner = Banner::findOrFail($id);
        if ($request->status != null) {
            $request->validate(['status' => 'required|in:1,2']);
            $banner->status = $request->status;
        } else {
            $request->validate([
                'nama' => 'required|string|max:255',
                'gambar' => 'nullable|image|file|mimes:jpeg,jpg,png,webp,gif|max:4096',
            ]);

            $banner->nama = $request->nama;
            if ($request->hasFile('gambar')) {
                if ($banner->gambar && Storage::disk('public')->exists($banner->gambar)) {
                    Storage::disk('public')->delete($banner->gambar);
                }

                $banner->gambar = $request->file('gambar')->store('banner-home', 'public');
            }
        }
        $banner->save();
        return redirect()->back()->with('success', 'Banner berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->gambar && Storage::disk('public')->exists($banner->gambar)) {
            Storage::disk('public')->delete($banner->gambar);
        }

        $banner->delete();

        return Redirect::to('banner')->with('success', 'Banner berhasil dihapus.');
    }

    private function staticHomeBanners(): array
    {
        $directory = public_path('assets/images/home-banners');

        if (! is_dir($directory)) {
            return [];
        }

        return collect(glob($directory . DIRECTORY_SEPARATOR . '*.webp') ?: [])
            ->sort()
            ->values()
            ->map(fn (string $path): array => [
                'name' => basename($path),
                'url' => asset('assets/images/home-banners/' . basename($path)),
            ])
            ->all();
    }
}
