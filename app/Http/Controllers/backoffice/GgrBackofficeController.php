<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Api\fiver;
use App\Http\Controllers\Controller;
use App\Models\Api;
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
        $api = Api::query()->first();
        $agent = json_decode((new fiver())->agentbalance(), true) ?: [];
        $search = trim((string) $request->query('search', ''));

        return view('backoffice.ggr.index', [
            'api' => $api,
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

    public function testProviderApi(): RedirectResponse
    {
        $response = json_decode((new fiver())->providerlist(), true) ?: [];
        $providers = $this->extractProviderItems($response);

        if ((array_key_exists('status', $response) && (int) $response['status'] !== 1) || $providers === []) {
            $message = $response['msg']
                ?? $response['message']
                ?? $response['error']
                ?? 'Provider API belum mengembalikan data.';

            return back()->with('error', 'Test Provider API gagal: ' . $message);
        }

        return back()->with('success', 'Test Provider API berhasil. Provider terbaca: ' . count($providers));
    }

    public function syncGames(): RedirectResponse
    {
        $summary = $this->catalog->syncGames(null, 10);
        $synced = collect($summary)->sum('synced');
        $failed = collect($summary)->filter(fn ($row) => !($row['ok'] ?? false));

        if ($summary === [] || ($synced === 0 && $failed->isNotEmpty())) {
            $message = $failed->first()['message'] ?? 'Sync game gagal. Provider belum tersedia atau API tidak mengembalikan data.';

            return back()->with('error', $message);
        }

        return back()->with('success', "Sinkronisasi game selesai. {$synced} game diproses.");
    }

    public function syncProvider(string $code): RedirectResponse
    {
        $summary = $this->catalog->syncGames($code);
        $result = $summary[$code] ?? ['ok' => false, 'message' => 'Provider tidak ditemukan.', 'synced' => 0];

        return back()->with($result['ok'] ? 'success' : 'error', $result['message'] . ' Total: ' . $result['synced']);
    }

    private function extractProviderItems(array $response): array
    {
        foreach (['providers', 'provider_list', 'providerList', 'data'] as $key) {
            if (isset($response[$key]) && is_array($response[$key])) {
                return array_values($response[$key]);
            }
        }

        if (isset($response['data']) && is_array($response['data'])) {
            foreach (['providers', 'provider_list', 'providerList'] as $key) {
                if (isset($response['data'][$key]) && is_array($response['data'][$key])) {
                    return array_values($response['data'][$key]);
                }
            }
        }

        if (array_is_list($response)) {
            return $response;
        }

        return [];
    }
}
