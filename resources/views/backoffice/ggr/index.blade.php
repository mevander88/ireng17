@extends('backoffice.layouts.main')

@section('content')
    @php
        $balance = data_get($agent, 'agent.balance', data_get($agent, 'balance', 0));
        $agentStatus = data_get($agent, 'status');
    @endphp

    <div class="ggr-admin-page">
        @if (session('success') || session('error'))
            <div class="ggr-admin-alerts">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
            </div>
        @endif

        <header class="ggr-admin-page-header">
            <div class="ggr-admin-heading">
                <span class="ggr-admin-kicker">GGR Catalog</span>
                <h1>Katalog GGR</h1>
                <p>Data provider dan game dibaca dari tabel lokal agar frontend tetap ringan. Gunakan sync bertahap untuk menghindari rate limit GGR.</p>
            </div>
            <div class="ggr-admin-actions" aria-label="Aksi sinkronisasi katalog">
                <form method="POST" action="{{ route('backoffice.ggr.syncProviders') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-cloud-download-alt"></i>
                        <span>Sync Provider</span>
                    </button>
                </form>
                <form method="POST" action="{{ route('backoffice.ggr.syncGames') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync"></i>
                        <span>Sync Game</span>
                    </button>
                </form>
            </div>
        </header>

        <section class="ggr-admin-metrics" aria-label="Ringkasan katalog GGR">
            <article class="ggr-admin-metric">
                <span>Agent Balance</span>
                <strong>{{ number_format((float) $balance, 2) }}</strong>
                <small>Status API: {{ $agentStatus ?? 'tidak tersedia' }}</small>
            </article>
            <article class="ggr-admin-metric">
                <span>Provider Aktif</span>
                <strong>{{ number_format($providerTotal ?? $providers->total()) }}</strong>
                <small>Total provider lokal</small>
            </article>
            <article class="ggr-admin-metric">
                <span>Game Tersimpan</span>
                <strong>{{ number_format($totalGames) }}</strong>
                <small>Game aktif di database</small>
            </article>
            <article class="ggr-admin-metric">
                <span>Sinkronisasi Terakhir</span>
                <strong>{{ optional($lastSync)->diffForHumans() ?? 'Belum sync' }}</strong>
                <small>{{ optional($lastSync)->format('d M Y H:i') ?? 'Menunggu sinkronisasi' }}</small>
            </article>
        </section>

        <section class="ggr-admin-panel" aria-labelledby="ggr-provider-list-title">
            <div class="ggr-admin-toolbar">
                <div>
                    <h2 id="ggr-provider-list-title">Provider List</h2>
                    <p>{{ number_format($providers->total()) }} provider ditemukan</p>
                </div>
                <form method="GET" action="{{ route('backoffice.ggr') }}" class="ggr-admin-search-form">
                    <label class="sr-only" for="search-provider">Cari Provider</label>
                    <div class="ggr-admin-search">
                        <i class="fas fa-search" aria-hidden="true"></i>
                        <input type="search" id="search-provider" name="search" value="{{ $search ?? '' }}"
                            placeholder="Cari kode, nama, atau tipe provider">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                    @if (!empty($search))
                        <a href="{{ route('backoffice.ggr') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                    @endif
                </form>
            </div>

            <div class="ggr-admin-table-wrap">
                <table class="ggr-admin-table">
                    <thead>
                        <tr>
                            <th>Provider</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th class="text-right">Game</th>
                            <th>Sync</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($providers as $provider)
                            <tr>
                                <td>
                                    <span class="ggr-admin-provider-code">{{ $provider->code }}</span>
                                </td>
                                <td>
                                    <span class="ggr-admin-provider-name">{{ $provider->name }}</span>
                                </td>
                                <td>
                                    <span class="ggr-admin-chip">{{ strtoupper($provider->type) }}</span>
                                </td>
                                <td>
                                    <span class="ggr-admin-badge {{ $provider->is_open ? 'is-active' : 'is-muted' }}">
                                        {{ $provider->is_open ? 'Aktif' : 'Tutup' }}
                                    </span>
                                </td>
                                <td class="text-right">{{ number_format($provider->games_count) }}</td>
                                <td>{{ optional($provider->synced_at)->format('d M Y H:i') ?? '-' }}</td>
                                <td class="text-right">
                                    <form method="POST" action="{{ route('backoffice.ggr.syncProvider', $provider->code) }}">
                                        @csrf
                                        <button type="submit" class="ggr-admin-row-action">
                                            <i class="fas fa-redo" aria-hidden="true"></i>
                                            <span>Sync</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="ggr-admin-empty">
                                    Provider belum tersedia. Jalankan Sync Provider terlebih dahulu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="ggr-admin-panel-footer">
                <span>Status API: {{ $agentStatus ?? 'tidak tersedia' }}</span>
                <div class="admin-pagination">
                    {{ $providers->links() }}
                </div>
            </div>
        </section>
    </div>
@endsection
