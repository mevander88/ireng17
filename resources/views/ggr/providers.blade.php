@extends('layouts.ggr', ['title' => 'Provider - ' . ($setting->nama_web ?? 'ireng17')])

@section('content')
    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <span class="ggr-kicker">{{ $type ? strtoupper($type) : 'ALL' }}</span>
                    <h1>Provider GGR</h1>
                    <p>Daftar provider aktif yang sudah disinkronkan ke database lokal.</p>
                </div>
                <a class="ggr-btn" href="{{ url('/') }}">Home</a>
            </div>

            <div class="ggr-chip-row">
                <a class="ggr-chip {{ request()->is('slots') ? 'is-active' : '' }}" href="{{ url('/slots') }}">
                    <span class="material-symbols-outlined">casino</span>
                    Slot
                </a>
                <a class="ggr-chip {{ request()->is('casino') ? 'is-active' : '' }}" href="{{ url('/casino') }}">
                    <span class="material-symbols-outlined">stadia_controller</span>
                    Live
                </a>
                <a class="ggr-chip {{ request()->is('sports') ? 'is-active' : '' }}" href="{{ url('/sports') }}">
                    <span class="material-symbols-outlined">sports_soccer</span>
                    Sports
                </a>
                <a class="ggr-chip {{ request()->is('e-games') ? 'is-active' : '' }}" href="{{ url('/e-games') }}">
                    <span class="material-symbols-outlined">rocket_launch</span>
                    Mini Games
                </a>
            </div>

            <form class="ggr-search" data-live-search-form data-live-search-scope="#provider-grid" data-live-search-count="#provider-count" data-live-search-empty="#provider-empty">
                <input type="search" data-live-search-input placeholder="Cari provider atau kategori..." autocomplete="off">
                <button class="ggr-btn" type="button" data-live-search-clear>
                    <span class="material-symbols-outlined">close</span>
                    Reset
                </button>
            </form>

            <div class="ggr-result-meta">
                <span id="provider-count">{{ $providers->count() }} provider tampil</span>
            </div>

            <div class="ggr-provider-grid" id="provider-grid">
                @forelse ($providers as $provider)
                    @php($coverUrl = $provider->cover_url)
                    <a class="ggr-provider-card has-cover" data-live-search-item data-search-text="{{ strtolower($provider->code . ' ' . $provider->name . ' ' . $provider->type) }}" href="{{ url('/ggr/provider/' . \Illuminate\Support\Str::slug($provider->code)) }}">
                        <span class="ggr-provider-art {{ $coverUrl ? '' : 'is-empty' }}">
                            @if ($coverUrl)
                                <img src="{{ $coverUrl }}" alt="{{ $provider->name }}" loading="lazy" onerror="this.remove(); this.parentElement.classList.add('is-empty');">
                            @else
                                <span class="material-symbols-outlined">casino</span>
                            @endif
                        </span>
                        <span class="ggr-provider-overlay">
                            <span class="ggr-provider-code">{{ $provider->code }}</span>
                            <span class="ggr-provider-name">{{ $provider->name }}</span>
                            <span class="ggr-provider-count">{{ number_format($provider->games_count) }} game</span>
                        </span>
                    </a>
                @empty
                    <div class="ggr-empty">Provider belum tersedia. Jalankan sinkronisasi di backoffice.</div>
                @endforelse
                <div class="ggr-empty" id="provider-empty" hidden>Tidak ada provider yang cocok.</div>
            </div>
        </div>
    </section>
@endsection
