@extends('layouts.ggr', ['title' => $provider->name . ' - ' . ($setting->nama_web ?? 'ireng17')])

@section('content')
    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <span class="ggr-kicker">{{ $provider->code }}</span>
                    <h1>{{ $provider->name }}</h1>
                    <p>{{ strtoupper($provider->type) }} - {{ $games->count() }} game tersedia.</p>
                </div>
                <a class="ggr-btn" href="{{ url('/slots') }}">Provider</a>
            </div>

            <form class="ggr-search" method="get" data-live-search-form data-live-search-scope="#game-grid" data-live-search-count="#game-count" data-live-search-empty="#game-empty">
                <input type="search" name="q" value="{{ $query }}" data-live-search-input placeholder="Cari game favorit Anda..." autocomplete="off">
                <button class="ggr-btn" type="button" data-live-search-clear>
                    <span class="material-symbols-outlined">close</span>
                    Reset
                </button>
            </form>

            <div class="ggr-result-meta">
                <span id="game-count">{{ $games->count() }} game tampil</span>
            </div>

            <div class="ggr-chip-row">
                <a class="ggr-chip is-active" href="{{ url('/ggr/provider/' . \Illuminate\Support\Str::slug($provider->code)) }}">
                    <span class="material-symbols-outlined">casino</span>
                    {{ $provider->code }}
                </a>
                <a class="ggr-chip" href="{{ url('/slots') }}">
                    <span class="material-symbols-outlined">grid_view</span>
                    Provider Lain
                </a>
                <a class="ggr-chip" href="{{ url('/casino') }}">
                    <span class="material-symbols-outlined">live_tv</span>
                    Live
                </a>
                <a class="ggr-chip" href="{{ url('/sports') }}">
                    <span class="material-symbols-outlined">sports_soccer</span>
                    Sports
                </a>
            </div>

            <div class="ggr-game-grid" id="game-grid">
                @forelse ($games as $game)
                    <a class="ggr-game-card" data-live-search-item data-search-text="{{ strtolower($game->game_name . ' ' . $game->provider_code . ' ' . $game->game_code) }}" href="{{ url('/game_process/api:' . rawurlencode($game->provider_code) . ':' . rawurlencode($game->game_code)) }}" target="_blank" rel="noopener noreferrer">
                        @if ($loop->first)
                            <span class="ggr-hot-badge">Hot</span>
                        @endif
                        <div class="ggr-game-media {{ $game->safe_banner ? '' : 'is-empty' }}">
                            @if ($game->safe_banner)
                                <img src="{{ $game->safe_banner }}" alt="{{ $game->game_name }}" loading="lazy">
                            @else
                                <span class="material-symbols-outlined">casino</span>
                            @endif
                        </div>
                        <div class="ggr-game-body">
                            <span class="ggr-game-title">{{ $game->game_name }}</span>
                            <span class="ggr-provider-count">{{ $game->provider_code }}</span>
                        </div>
                    </a>
                @empty
                    <div class="ggr-empty">Game belum tersedia untuk provider ini.</div>
                @endforelse
                <div class="ggr-empty" id="game-empty" hidden>Tidak ada game yang cocok.</div>
            </div>
        </div>
    </section>
@endsection
