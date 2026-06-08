<?php
use App\Models\Setting;

$setting = Setting::first();
$activeBanners = collect($banners ?? [])->filter(fn ($item) => (string) $item->status === '2' || (string) $item->status === '1');
$categories = $activeBanners
    ->pluck('kategori')
    ->filter()
    ->flatMap(fn ($value) => collect(explode(',', $value))->map(fn ($category) => trim($category)))
    ->filter()
    ->unique()
    ->values();
?>

@extends('layouts.ggr', ['title' => 'Promo - ' . ($setting->nama_web ?? 'ireng17')])

@section('content')
    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <span class="ggr-kicker">Promo</span>
                    <h1>Bonus & promosi</h1>
                    <p>Pilih promo aktif, baca ketentuan, lalu lanjutkan ke deposit atau akun Anda.</p>
                </div>
                @auth
                    <a class="ggr-btn ggr-btn-primary" href="{{ url('/promo/saya') }}">
                        <span class="material-symbols-outlined">redeem</span>
                        Promo Saya
                    </a>
                @else
                    <a class="ggr-btn ggr-btn-primary" href="{{ url('/register') }}">
                        <span class="material-symbols-outlined">person_add</span>
                        Daftar
                    </a>
                @endauth
            </div>

            <div class="ggr-chip-row ggr-promo-filter" role="tablist" aria-label="Filter promo">
                <button class="ggr-chip is-active" type="button" data-promo-filter="ALL">
                    <span class="material-symbols-outlined">apps</span>
                    Semua
                </button>
                @foreach ($categories as $category)
                    <button class="ggr-chip" type="button" data-promo-filter="{{ $category }}">
                        {{ $category }}
                    </button>
                @endforeach
            </div>

            <div class="ggr-promo-grid" id="promotion-group">
                @forelse ($activeBanners as $item)
                    @php
                        $filters = collect(explode(',', $item->kategori ?: 'ALL'))
                            ->map(fn ($category) => trim($category))
                            ->filter()
                            ->prepend('ALL')
                            ->unique()
                            ->implode(',');
                    @endphp
                    <article class="ggr-promo-card" data-filter="{{ $filters }}">
                        <div class="ggr-promo-media">
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}" loading="lazy">
                            @if ($item->kategori)
                                <span class="ggr-hot-badge">{{ $item->kategori }}</span>
                            @endif
                        </div>
                        <div class="ggr-promo-body">
                            <div>
                                <span class="ggr-kicker">Promosi</span>
                                <h2>{{ $item->nama }}</h2>
                            </div>
                            <div class="ggr-promo-meta">
                                <span class="material-symbols-outlined">schedule</span>
                                <span>{{ $item->batas_waktu ?: 'Tanpa batas waktu' }}</span>
                            </div>
                            <details class="ggr-promo-detail">
                                <summary>Rincian promo</summary>
                                <div>{{ $item->deskripsi }}</div>
                            </details>
                            <div class="ggr-promo-actions">
                                @auth
                                    <a class="ggr-btn ggr-btn-primary" href="{{ url('/account/deposit') }}">
                                        <span class="material-symbols-outlined">add_circle</span>
                                        Deposit
                                    </a>
                                    <a class="ggr-btn" href="{{ url('/promo/saya') }}">Cek Promo</a>
                                @else
                                    <a class="ggr-btn ggr-btn-primary" href="{{ url('/register') }}">Ambil Promo</a>
                                    <a class="ggr-btn" href="{{ url('/login') }}">Login</a>
                                @endauth
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="ggr-empty">Promo belum tersedia saat ini.</div>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filters = Array.from(document.querySelectorAll('[data-promo-filter]'));
            const cards = Array.from(document.querySelectorAll('.ggr-promo-card'));

            filters.forEach(function (button) {
                button.addEventListener('click', function () {
                    const selected = button.dataset.promoFilter;
                    filters.forEach((item) => item.classList.toggle('is-active', item === button));
                    cards.forEach(function (card) {
                        const values = (card.dataset.filter || 'ALL').split(',');
                        card.hidden = !values.includes(selected);
                    });
                });
            });
        });
    </script>
@endsection
