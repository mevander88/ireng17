<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Api\fiver;
use App\Http\Controllers\Controller;
use App\Models\GgrGame;
use App\Models\GgrProvider;
use App\Services\GgrCatalogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GgrBackofficeController extends Controller
{
    public function __construct(private readonly GgrCatalogService $catalog)
    {
    }

    public function index(Request $request)
    {
        $agent = json_decode((new fiver())->agentbalance(), true) ?: [];
        $search = trim((string) $request->query('search', ''));

        return view('backoffice.ggr.index', [
            'agent' => $agent,
            'providers' => GgrProvider::query()
                ->withCount(['games' => fn ($query) => $query->where('is_open', true)])
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($inner) use ($search) {
                        $inner->where('code', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('type', 'like', "%{$search}%");
                    });
                })
                ->orderBy('type')
                ->orderBy('name')
                ->paginate(25)
                ->withQueryString(),
            'providerTotal' => GgrProvider::count(),
            'totalGames' => GgrGame::where('is_open', true)->count(),
            'lastSync' => GgrProvider::max('synced_at'),
            'search' => $search,
        ]);
    }

    public function syncProviders(): RedirectResponse
    {
        $result = $this->catalog->syncProviders();

        return back()->with($result['ok'] ? 'success' : 'error', $result['message']);
    }

    public function syncGames(): RedirectResponse
    {
        $summary = $this->catalog->syncGames(null, 10);
        $synced = collect($summary)->sum('synced');

        return back()->with('success', "Sinkronisasi game selesai. {$synced} game diproses.");
    }

    public function syncProvider(string $code): RedirectResponse
    {
        $summary = $this->catalog->syncGames($code);
        $result = $summary[$code] ?? ['ok' => false, 'message' => 'Provider tidak ditemukan.', 'synced' => 0];

        return back()->with($result['ok'] ? 'success' : 'error', $result['message'] . ' Total: ' . $result['synced']);
    }
}
