<!doctype html>
<html lang="id" class="dark">
<head>
    @php
        $brandName = $setting->nama_web ?? 'ireng17';
        $pageTitle = $title ?? $brandName;
        $seoDescription = $setting->seo_description
            ?? 'ireng17 adalah lobby game online dengan katalog slot, live casino, sportsbook, crash game, promo member, deposit cepat, dan navigasi mobile yang ringan.';
        $seoKeywords = $setting->seo_meta_keywords
            ?? 'ireng17, slot online, game slot, pragmatic play, pg soft, mahjong ways, live casino, sportsbook, deposit qris';
        $seoImage = ($setting->seo_banner ?? null) ?: asset('assets/images/provider-covers/spribe-aviator.svg');
        $siteLogo = !empty($setting->logo)
            ? asset('storage/' . $setting->logo)
            : asset('assets/images/provider-covers/spribe-aviator.svg');
        $canonicalUrl = url()->current();
        $ampUrl = config('app.amp_url') ?: url('/amp.html');
        $isHomePage = request()->getPathInfo() === '/';
        $siteCssPath = public_path('assets/css/ggr-site.css');
        $siteCssVersion = is_file($siteCssPath) ? filemtime($siteCssPath) : time();
        $siteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $brandName,
            'alternateName' => strtoupper($brandName),
            'url' => url('/'),
            'description' => $seoDescription,
            'publisher' => [
                '@type' => 'Organization',
                'name' => $brandName,
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $siteLogo,
                ],
            ],
        ];
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="author" content="{{ $brandName }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @if ($isHomePage)
        <link rel="amphtml" href="{{ $ampUrl }}">
    @endif
    <link rel="sitemap" type="application/xml" href="{{ url('/sitemap.xml') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ $brandName }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:image:alt" content="{{ $brandName }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
    <link rel="icon" href="{{ asset('assets/images/provider-covers/spribe-aviator.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/css/ggr-site.css') }}?v={{ $siteCssVersion }}">
    <script type="application/ld+json">
        @json($siteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    </script>
    @stack('head')
</head>
<body class="{{ $isHomePage ? 'ggr-home-page' : '' }}">
    <header class="ggr-topbar">
        <div class="ggr-shell ggr-nav">
            <button class="ggr-icon-btn" type="button" data-sidebar-open aria-label="Buka sidebar" aria-expanded="false">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <a class="ggr-brand" href="{{ url('/') }}">
                <span class="ggr-brand-mark">I</span>
                <span>{{ strtoupper($setting->nama_web ?? 'ireng17') }}</span>
            </a>
            <nav class="ggr-nav-actions" aria-label="Navigasi utama">
                <a class="ggr-btn" href="{{ url('/slots') }}">
                    <span class="material-symbols-outlined">grid_view</span>
                    Provider
                </a>
                @auth
                    <a class="ggr-btn" href="{{ url('/profile') }}">
                        <span class="material-symbols-outlined">person</span>
                        Akun
                    </a>
                    <a class="ggr-btn" href="{{ url('/account/withdrawal') }}">
                        <span class="material-symbols-outlined">payments</span>
                        Withdraw
                    </a>
                    <a class="ggr-btn ggr-btn-primary" href="{{ url('/account/deposit') }}">
                        <span class="material-symbols-outlined">add_circle</span>
                        Deposit
                    </a>
                @else
                    <a class="ggr-btn ggr-nav-login" href="{{ url('/login') }}">
                        <span class="material-symbols-outlined">login</span>
                        Login
                    </a>
                    <a class="ggr-btn ggr-btn-primary ggr-nav-register" href="{{ url('/register') }}">
                        <span class="material-symbols-outlined">person_add</span>
                        Daftar
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <div class="ggr-sidebar-backdrop" data-sidebar-close hidden></div>
    <aside class="ggr-sidebar-drawer" data-sidebar-drawer aria-label="Sidebar utama" aria-hidden="true">
        <div class="ggr-sidebar-head">
            <a class="ggr-brand" href="{{ url('/') }}">
                <span class="ggr-brand-mark">I</span>
                <span>{{ strtoupper($setting->nama_web ?? 'ireng17') }}</span>
            </a>
            <button class="ggr-icon-btn" type="button" data-sidebar-close aria-label="Tutup sidebar">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        @auth
            <div class="ggr-sidebar-user">
                <span class="ggr-account-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                <div>
                    <span class="ggr-kicker">Akun</span>
                    <strong>{{ Auth::user()->name }}</strong>
                </div>
            </div>
        @endauth

        <nav class="ggr-sidebar-menu" aria-label="Menu sidebar">
            <a class="{{ request()->is('/') ? 'is-active' : '' }}" href="{{ url('/') }}">
                <span class="material-symbols-outlined">home</span>
                Beranda
            </a>
            <a class="{{ request()->is('slots*') || request()->is('ggr/provider*') ? 'is-active' : '' }}" href="{{ url('/slots') }}">
                <span class="material-symbols-outlined">casino</span>
                Slot
            </a>
            <a class="{{ request()->is('casino*') ? 'is-active' : '' }}" href="{{ url('/casino') }}">
                <span class="material-symbols-outlined">stadia_controller</span>
                Kasino Live
            </a>
            <a class="{{ request()->is('sports*') ? 'is-active' : '' }}" href="{{ url('/sports') }}">
                <span class="material-symbols-outlined">sports_soccer</span>
                Olahraga
            </a>
            <a class="{{ request()->is('e-games*') ? 'is-active' : '' }}" href="{{ url('/e-games') }}">
                <span class="material-symbols-outlined">rocket_launch</span>
                Crash
            </a>
            <a class="{{ request()->is('promotion') ? 'is-active' : '' }}" href="{{ url('/promotion') }}">
                <span class="material-symbols-outlined">local_offer</span>
                Promo
            </a>
            @auth
                <a class="{{ request()->is('profile') ? 'is-active' : '' }}" href="{{ url('/profile') }}">
                    <span class="material-symbols-outlined">person</span>
                    Profil
                </a>
                <a class="{{ request()->is('account/deposit') ? 'is-active' : '' }}" href="{{ url('/account/deposit') }}">
                    <span class="material-symbols-outlined">add_circle</span>
                    Deposit
                </a>
                <a class="{{ request()->is('account/withdrawal') ? 'is-active' : '' }}" href="{{ url('/account/withdrawal') }}">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                    Withdraw
                </a>
                <a class="{{ request()->is('promo/saya') ? 'is-active' : '' }}" href="{{ url('/promo/saya') }}">
                    <span class="material-symbols-outlined">redeem</span>
                    Promo Saya
                </a>
            @else
                <a href="{{ url('/login') }}">
                    <span class="material-symbols-outlined">login</span>
                    Login
                </a>
                <a href="{{ url('/register') }}">
                    <span class="material-symbols-outlined">person_add</span>
                    Daftar
                </a>
            @endauth
        </nav>

    </aside>

    <main class="ggr-main">
        @if (session('error'))
            <div class="ggr-shell">
                <div class="ggr-alert" style="color:#ffdad6">{{ session('error') }}</div>
            </div>
        @endif
        @if (session('success'))
            <div class="ggr-shell">
                <div class="ggr-alert" style="color:#d9ffe9">{{ session('success') }}</div>
            </div>
        @endif
        @yield('content')
    </main>

    <nav class="ggr-bottom-nav @auth has-transaction-hub @endauth" aria-label="Navigasi bawah">
        <a class="{{ request()->is('/') ? 'is-active' : '' }}" href="{{ url('/') }}">
            <span class="material-symbols-outlined">home</span>
            Beranda
        </a>
        <a class="{{ request()->is('slots*') || request()->is('ggr/provider*') ? 'is-active' : '' }}" href="{{ url('/slots') }}">
            <span class="material-symbols-outlined">explore</span>
            Telusuri
        </a>
        @auth
            <div class="ggr-bottom-transaction {{ request()->is('account/deposit') || request()->is('account/withdrawal') ? 'is-active' : '' }}" data-transaction-menu>
                <button class="ggr-bottom-transaction-button" type="button" data-transaction-toggle aria-label="Buka menu transaksi" aria-expanded="false">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                    Transaksi
                </button>
                <div class="ggr-bottom-transaction-popover" data-transaction-popover hidden>
                    <a class="{{ request()->is('account/deposit') ? 'is-active' : '' }}" href="{{ url('/account/deposit') }}">
                        <span class="material-symbols-outlined">add_circle</span>
                        Deposit
                    </a>
                    <a class="{{ request()->is('account/withdrawal') ? 'is-active' : '' }}" href="{{ url('/account/withdrawal') }}">
                        <span class="material-symbols-outlined">payments</span>
                        Withdraw
                    </a>
                </div>
            </div>
        @endauth
        <a class="{{ request()->is('promotion') ? 'is-active' : '' }}" href="{{ url('/promotion') }}">
            <span class="material-symbols-outlined">local_offer</span>
            Promo
        </a>
        @auth
            <a class="{{ request()->is('profile') ? 'is-active' : '' }}" href="{{ url('/profile') }}">
                <span class="material-symbols-outlined">person</span>
                Profil
            </a>
        @else
            <a class="{{ request()->is('login') ? 'is-active' : '' }}" href="{{ url('/login') }}">
                <span class="material-symbols-outlined">login</span>
                Login
            </a>
        @endauth
    </nav>

    <footer class="ggr-footer">
        <div class="ggr-shell">
            <strong>{{ strtoupper($setting->nama_web ?? 'ireng17') }}</strong>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openButton = document.querySelector('[data-sidebar-open]');
            const drawer = document.querySelector('[data-sidebar-drawer]');
            const closers = document.querySelectorAll('[data-sidebar-close]');
            const backdrop = document.querySelector('.ggr-sidebar-backdrop');

            function setSidebar(open) {
                document.body.classList.toggle('ggr-sidebar-open', open);
                drawer?.setAttribute('aria-hidden', open ? 'false' : 'true');
                openButton?.setAttribute('aria-expanded', open ? 'true' : 'false');
                if (backdrop) {
                    backdrop.hidden = !open;
                }
            }

            openButton?.addEventListener('click', () => setSidebar(true));
            closers.forEach((button) => button.addEventListener('click', () => setSidebar(false)));
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    setSidebar(false);
                }
            });

            const transactionMenu = document.querySelector('[data-transaction-menu]');
            const transactionToggle = document.querySelector('[data-transaction-toggle]');
            const transactionPopover = document.querySelector('[data-transaction-popover]');

            function setTransactionMenu(open) {
                if (!transactionMenu || !transactionToggle || !transactionPopover) {
                    return;
                }
                transactionMenu.classList.toggle('is-open', open);
                transactionToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                transactionPopover.hidden = !open;
            }

            transactionToggle?.addEventListener('click', function (event) {
                event.stopPropagation();
                setTransactionMenu(!transactionMenu?.classList.contains('is-open'));
            });

            document.addEventListener('click', function (event) {
                if (transactionMenu && !transactionMenu.contains(event.target)) {
                    setTransactionMenu(false);
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    setTransactionMenu(false);
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-live-search-form]').forEach(function (form) {
                const input = form.querySelector('[data-live-search-input]');
                const clear = form.querySelector('[data-live-search-clear]');
                const scope = document.querySelector(form.dataset.liveSearchScope);
                const countTarget = document.querySelector(form.dataset.liveSearchCount);
                const emptyTarget = document.querySelector(form.dataset.liveSearchEmpty);

                if (!input || !scope) {
                    return;
                }

                const items = Array.from(scope.querySelectorAll('[data-live-search-item]'));
                const label = items.some((item) => item.classList.contains('ggr-game-card')) ? 'game' : 'provider';

                function normalize(value) {
                    return String(value || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim();
                }

                function applySearch() {
                    const query = normalize(input.value);
                    let visible = 0;

                    items.forEach(function (item) {
                        const haystack = normalize(item.dataset.searchText || item.textContent);
                        const match = !query || haystack.includes(query);
                        item.hidden = !match;
                        if (match) {
                            visible += 1;
                        }
                    });

                    if (countTarget) {
                        countTarget.textContent = visible + ' ' + label + ' tampil';
                    }

                    if (emptyTarget) {
                        emptyTarget.hidden = visible > 0 || query === '';
                    }
                }

                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    applySearch();
                });

                input.addEventListener('input', applySearch);

                clear?.addEventListener('click', function () {
                    input.value = '';
                    input.focus();
                    applySearch();
                });

                applySearch();
            });
        });
    </script>
</body>
</html>
