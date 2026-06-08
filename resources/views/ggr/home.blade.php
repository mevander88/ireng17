@extends('layouts.ggr', ['title' => ($setting->nama_web ?? 'ireng17') . ' - Lobby Slot, Casino, Sportsbook dan Promo Member'])

@push('head')
    @php
        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $setting->nama_web ?? 'ireng17',
            'url' => url('/'),
            'description' => $setting->seo_description ?? 'Lobby game online ireng17 dengan katalog slot, live casino, sportsbook, crash game, promo member, deposit cepat, dan tampilan mobile responsif.',
            'inLanguage' => 'id-ID',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/slots') . '?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'Apa saja kategori game di ireng17?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'ireng17 menampilkan kategori slot, live casino, sportsbook, crash game, dan promo member dalam satu lobby responsif.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Apakah tersedia deposit cepat?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Menu deposit dibuat ringkas dengan pilihan nominal cepat, QRIS jika aktif, serta transfer manual sesuai rekening yang tersedia.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Apakah katalog game bisa dicari?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Halaman provider dan game mendukung pencarian langsung untuk menemukan provider populer, slot pilihan, dan judul game tertentu.',
                    ],
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">
        {!! json_encode($websiteSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

@section('content')
    @php
        $heroGame = $featuredGames->first();
        $carousel = $featuredGames->take(6);
        $popularProviders = $slotProviders->take(10);
        $localBalance = auth()->check()
            ? (float) (\App\Models\Saldo::where('user_id', auth()->id())->value('saldo') ?? 0)
            : 0;
    @endphp

    <section class="ggr-hero">
        <div class="ggr-shell ggr-lobby-grid">
            <div class="ggr-balance-card" data-balance-card data-authenticated="{{ auth()->check() ? '1' : '0' }}">
                <div class="ggr-balance-row">
                    <span class="ggr-kicker">Total Saldo</span>
                    <div class="ggr-balance-tools">
                        <button class="ggr-icon-btn ggr-balance-refresh" type="button" data-balance-refresh aria-label="Refresh saldo" {{ auth()->check() ? '' : 'disabled' }}>
                            <span class="material-symbols-outlined">refresh</span>
                        </button>
                        <button class="ggr-icon-btn" type="button" data-balance-toggle aria-label="Sembunyikan saldo" aria-pressed="false">
                            <span class="material-symbols-outlined">visibility</span>
                        </button>
                    </div>
                </div>
                <h1 class="ggr-balance-amount">
                    <span>Rp</span><b data-balance-amount data-balance="{{ $localBalance }}">{{ number_format($localBalance, 0, ',', '.') }}</b>
                </h1>
                <p class="ggr-balance-note" data-balance-note>
                    {{ auth()->check() ? 'Saldo siap diperbarui.' : 'Login untuk melihat saldo akun.' }}
                </p>
                <div class="ggr-balance-actions">
                    <a class="ggr-btn ggr-btn-primary" href="{{ url('/account/deposit') }}">
                        <span class="material-symbols-outlined">add_circle</span>
                        Deposit
                    </a>
                    <a class="ggr-btn" href="{{ url('/account/withdrawal') }}">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                        Tarik Dana
                    </a>
                </div>
            </div>

            <div class="ggr-feature-strip">
                @forelse ($carousel as $game)
                    <a class="ggr-feature-card" href="{{ url('/ggr/provider/' . \Illuminate\Support\Str::slug($game->provider_code)) }}">
                        @if ($game->safe_banner)
                            <img src="{{ $game->safe_banner }}" alt="{{ $game->game_name }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                        @endif
                        <span class="ggr-feature-meta">
                            <span class="ggr-live-badge">{{ $loop->first ? 'Live Now' : $game->provider_code }}</span>
                            <strong class="ggr-feature-title">{{ $game->game_name }}</strong>
                        </span>
                    </a>
                @empty
                    <a class="ggr-feature-card" href="{{ url('/slots') }}">
                        <span class="ggr-feature-meta">
                            <span class="ggr-live-badge">GGR</span>
                            <strong class="ggr-feature-title">Sinkronkan katalog game</strong>
                        </span>
                    </a>
                @endforelse
            </div>
        </div>
    </section>

    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <h2>Kategori</h2>
                    <p>Shortcut utama dibuat seperti lobby referensi agar cepat dipakai di mobile.</p>
                </div>
            </div>
            <div class="ggr-category-bento">
                <a class="ggr-category-card is-large" href="{{ url('/slots') }}">
                    <span class="ggr-category-icon"><span class="material-symbols-outlined">casino</span></span>
                    <span>
                        <strong>Slot</strong><br>
                        <small>{{ $slotProviders->count() }} provider</small>
                    </span>
                </a>
                <a class="ggr-category-card" href="{{ url('/casino') }}">
                    <span>
                        <strong>Kasino Live</strong><br>
                        <small>{{ $liveProviders->count() }} provider</small>
                    </span>
                    <span class="ggr-category-icon"><span class="material-symbols-outlined">stadia_controller</span></span>
                </a>
                <a class="ggr-category-card" href="{{ url('/sports') }}">
                    <span>
                        <strong>Olahraga</strong><br>
                        <small>{{ $sportsProviders->count() }} provider</small>
                    </span>
                    <span class="ggr-category-icon"><span class="material-symbols-outlined">sports_soccer</span></span>
                </a>
                <a class="ggr-category-card" href="{{ url('/e-games') }}">
                    <span>
                        <strong>Crash</strong><br>
                        <small>{{ $miniProviders->count() }} provider</small>
                    </span>
                    <span class="ggr-category-icon"><span class="material-symbols-outlined">rocket_launch</span></span>
                </a>
                <a class="ggr-category-card" href="{{ url('/promotion') }}">
                    <span>
                        <strong>Promo</strong><br>
                        <small>Bonus aktif</small>
                    </span>
                    <span class="ggr-category-icon"><span class="material-symbols-outlined">local_offer</span></span>
                </a>
            </div>
        </div>
    </section>

    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <h2>Provider Populer</h2>
                    <p>Provider aktif dari GGR API.</p>
                </div>
                <a class="ggr-btn" href="{{ url('/slots') }}">Semua</a>
            </div>
            <div class="ggr-scroll">
                @forelse ($popularProviders as $provider)
                    @php($coverUrl = $provider->cover_url)
                    <a class="ggr-provider-card has-cover is-scroll-card" href="{{ url('/ggr/provider/' . \Illuminate\Support\Str::slug($provider->code)) }}">
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
                    <div class="ggr-empty">Belum ada provider. Jalankan sinkronisasi di backoffice.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <h2>Sedang Tren</h2>
                    <p>Game terbaru dari katalog lokal.</p>
                </div>
                <a class="ggr-btn" href="{{ url('/slots') }}">Lihat Semua</a>
            </div>
            <div class="ggr-game-grid">
                @forelse ($featuredGames as $game)
                    <a class="ggr-game-card" href="{{ url('/game_process/api:' . rawurlencode($game->provider_code) . ':' . rawurlencode($game->game_code)) }}" target="_blank" rel="noopener noreferrer">
                        <span class="ggr-hot-badge">{{ $loop->first ? 'Hot' : 'New' }}</span>
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
                    <div class="ggr-empty">Belum ada game. Sinkronkan katalog GGR dari backoffice.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="ggr-section ggr-seo-section">
        <div class="ggr-shell">
            <div class="ggr-seo-panel">
                <div class="ggr-seo-lead">
                    <span class="ggr-kicker">Tentang {{ strtoupper($setting->nama_web ?? 'ireng17') }}</span>
                    <h2>Lobby game online ringan untuk slot, casino, sportsbook, dan crash game</h2>
                    <p>
                        {{ $setting->nama_web ?? 'ireng17' }} dirancang sebagai lobby cepat untuk pemain yang ingin menelusuri provider populer, membuka game favorit, melihat promo, dan mengelola transaksi dari satu tampilan yang responsif di mobile, tablet, dan desktop.
                    </p>
                </div>

                <div class="ggr-seo-grid">
                    <article>
                        <span class="material-symbols-outlined">casino</span>
                        <h3>Katalog slot populer</h3>
                        <p>Provider slot ditata berdasarkan katalog aktif dari API, termasuk pilihan populer seperti PG Soft dan Pragmatic Play saat tersedia.</p>
                    </article>
                    <article>
                        <span class="material-symbols-outlined">search</span>
                        <h3>Pencarian langsung</h3>
                        <p>Gunakan live search untuk menemukan provider, game mahjong, game tren, atau kategori tertentu tanpa reload halaman.</p>
                    </article>
                    <article>
                        <span class="material-symbols-outlined">payments</span>
                        <h3>Transaksi ringkas</h3>
                        <p>Deposit dan withdraw dipisahkan jelas lewat menu transaksi, dengan riwayat yang mudah dibuka dari area akun.</p>
                    </article>
                    <article>
                        <span class="material-symbols-outlined">local_offer</span>
                        <h3>Promo member</h3>
                        <p>Halaman promo menampilkan bonus aktif, sementara Promo Saya membantu memantau klaim dan progres turnover.</p>
                    </article>
                </div>

                <div class="ggr-seo-copy">
                    <h2>Pengalaman bermain yang rapi dari halaman utama</h2>
                    <p>
                        Beranda {{ $setting->nama_web ?? 'ireng17' }} menempatkan saldo, shortcut kategori, provider populer, dan game tren di area yang mudah dijangkau. Struktur ini membantu pengguna masuk dari pencarian organik, memahami isi platform, lalu langsung menuju slot, casino live, olahraga, crash game, promo, deposit, atau profil tanpa banyak langkah.
                    </p>
                    <p>
                        Tampilan baru mengikuti gaya gelap modern dengan aksen gold dan ungu. Elemen penting seperti provider, cover game, live search, saldo, tombol transaksi, dan navigasi bawah dibuat konsisten agar halaman tetap ringan sekaligus informatif untuk kebutuhan SEO.
                    </p>
                </div>

                <div class="ggr-faq-list">
                    <details>
                        <summary>Apa fungsi halaman Telusuri?</summary>
                        <p>Telusuri membuka daftar provider aktif dan memungkinkan pencarian provider atau kategori game secara langsung.</p>
                    </details>
                    <details>
                        <summary>Di mana menu deposit dan withdraw?</summary>
                        <p>Pada mobile, tombol Transaksi di tengah bottom bar membuka pilihan Deposit dan Withdraw. Pada desktop, menu tersebut juga tersedia di navigasi dan area akun.</p>
                    </details>
                    <details>
                        <summary>Apakah halaman ini mobile friendly?</summary>
                        <p>Ya. Layout utama, card provider, game grid, sidebar, profile, deposit, dan bottom bar sudah disesuaikan untuk mobile, tablet, dan desktop.</p>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const card = document.querySelector('[data-balance-card]');
            if (!card) return;

            const amount = card.querySelector('[data-balance-amount]');
            const toggle = card.querySelector('[data-balance-toggle]');
            const toggleIcon = toggle?.querySelector('.material-symbols-outlined');
            const refresh = card.querySelector('[data-balance-refresh]');
            const note = card.querySelector('[data-balance-note]');
            const isAuthenticated = card.dataset.authenticated === '1';
            const formatter = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 });
            const storageKey = 'ireng17.balance.hidden';

            function currentBalance() {
                return Number(amount?.dataset.balance || 0);
            }

            function render() {
                const hidden = localStorage.getItem(storageKey) === '1';
                amount.textContent = hidden ? '••••••' : formatter.format(currentBalance());
                toggle.setAttribute('aria-pressed', hidden ? 'true' : 'false');
                toggle.setAttribute('aria-label', hidden ? 'Tampilkan saldo' : 'Sembunyikan saldo');
                toggleIcon.textContent = hidden ? 'visibility_off' : 'visibility';
            }

            async function refreshBalance() {
                if (!isAuthenticated) {
                    note.textContent = 'Login untuk melihat saldo akun.';
                    return;
                }

                refresh.disabled = true;
                note.textContent = 'Memperbarui saldo...';

                try {
                    const response = await fetch('{{ url('/saldo-refresh') }}', {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Saldo request failed');
                    }

                    const data = await response.json();
                    amount.dataset.balance = Number(data.balance || 0);
                    note.textContent = data.source === 'api'
                        ? 'Saldo tersinkron dari provider.'
                        : 'Saldo memakai data lokal.';
                    render();
                } catch (error) {
                    note.textContent = 'Saldo belum bisa diperbarui. Coba lagi.';
                } finally {
                    refresh.disabled = false;
                }
            }

            toggle?.addEventListener('click', function () {
                const hidden = localStorage.getItem(storageKey) === '1';
                localStorage.setItem(storageKey, hidden ? '0' : '1');
                render();
            });

            refresh?.addEventListener('click', refreshBalance);
            render();

            if (isAuthenticated) {
                refreshBalance();
            }
        });
    </script>
@endsection
