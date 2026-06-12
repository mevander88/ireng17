<!doctype html>
<html amp lang="id">
<head>
    @php
        $brandName = $setting->nama_web ?? 'ireng17';
        $description = $setting->seo_description
            ?? 'ireng17 adalah lobby game online ringan untuk slot, live casino, sportsbook, dan mini game.';
        $logo = !empty($setting->logo) ? asset('storage/' . $setting->logo) : asset('assets/images/logo.png');
        $canonical = url('/');
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <title>{{ $brandName }} - AMP</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical }}">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <style amp-custom>
        :root{color-scheme:dark;--bg:#08090d;--panel:#12141b;--panel2:#181b24;--text:#f7f3e8;--muted:#a9a597;--gold:#f1c15d;--line:rgba(255,255,255,.1)}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);color:var(--text);font-family:Arial,Helvetica,sans-serif;line-height:1.5}
        a{color:inherit;text-decoration:none}
        .shell{max-width:760px;margin:0 auto;padding:14px 14px 76px}
        .top{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:6px 0 14px}
        .brand{display:flex;align-items:center;gap:10px;font-weight:800;text-transform:uppercase}
        .logo{width:42px;height:42px;border-radius:8px;background:#1d2028;overflow:hidden}
        .actions{display:flex;gap:8px}
        .btn{display:inline-flex;align-items:center;justify-content:center;min-height:40px;padding:0 14px;border-radius:8px;background:var(--gold);color:#17110a;font-weight:800}
        .btn.secondary{background:var(--panel2);color:var(--text);border:1px solid var(--line)}
        .hero{overflow:hidden;border:1px solid var(--line);border-radius:12px;background:var(--panel)}
        .hero-copy{padding:16px}
        h1{margin:0;font-size:28px;line-height:1.08;letter-spacing:0}
        p{margin:8px 0 0;color:var(--muted)}
        .grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-top:14px}
        .metric,.card{background:var(--panel);border:1px solid var(--line);border-radius:10px;padding:12px;min-width:0}
        .metric span,.card span{display:block;color:var(--muted);font-size:12px}
        .metric strong{display:block;margin-top:4px;color:var(--gold);font-size:22px}
        .section{margin-top:22px}
        .section h2{font-size:18px;margin:0 0 10px}
        .providers{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}
        .provider{padding:12px;border:1px solid var(--line);border-radius:10px;background:var(--panel)}
        .provider strong{display:block;overflow-wrap:anywhere}
        .games{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}
        .game{overflow:hidden;border:1px solid var(--line);border-radius:10px;background:var(--panel)}
        .game-title{padding:9px;font-size:13px;font-weight:700;min-height:54px}
        .bottom{position:fixed;left:0;right:0;bottom:0;background:rgba(8,9,13,.96);border-top:1px solid var(--line);padding:10px 14px}
        .bottom-inner{max-width:760px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:10px}
        @media (min-width:640px){.hero-copy{padding:20px}.providers,.games{grid-template-columns:repeat(4,minmax(0,1fr))}h1{font-size:36px}}
    </style>
</head>
<body>
    <main class="shell">
        <header class="top">
            <a class="brand" href="{{ url('/') }}">
                <span class="logo">
                    <amp-img src="{{ $logo }}" width="42" height="42" layout="fixed" alt="{{ $brandName }}"></amp-img>
                </span>
                <span>{{ $brandName }}</span>
            </a>
            <nav class="actions" aria-label="Akun">
                <a class="btn secondary" href="{{ url('/login') }}">Login</a>
                <a class="btn" href="{{ url('/register') }}">Daftar</a>
            </nav>
        </header>

        <section class="hero">
            @if ($banner)
                <amp-img src="{{ $banner }}" width="760" height="260" layout="responsive" alt="Banner {{ $brandName }}"></amp-img>
            @endif
            <div class="hero-copy">
                <h1>{{ strtoupper($brandName) }}</h1>
                <p>{{ $description }}</p>
                <div class="grid">
                    <div class="metric">
                        <span>Provider aktif</span>
                        <strong>{{ number_format($providerCount) }}+</strong>
                    </div>
                    <div class="metric">
                        <span>Game lokal</span>
                        <strong>{{ number_format($gameCount) }}+</strong>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <h2>Provider populer</h2>
            <div class="providers">
                @foreach ($providers as $provider)
                    <a class="provider" href="{{ url('/ggr/provider/' . \Illuminate\Support\Str::slug($provider->code)) }}">
                        <strong>{{ $provider->name }}</strong>
                        <span>{{ number_format($provider->games_count) }} game</span>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="section">
            <h2>Game terbaru</h2>
            <div class="games">
                @foreach ($games as $game)
                    <a class="game" href="{{ url('/game_process/api:' . rawurlencode($game->provider_code) . ':' . rawurlencode($game->game_code)) }}">
                        @if ($game->safe_banner)
                            <amp-img src="{{ $game->safe_banner }}" width="320" height="220" layout="responsive" alt="{{ $game->game_name }}"></amp-img>
                        @endif
                        <div class="game-title">{{ $game->game_name }}</div>
                    </a>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="bottom">
        <div class="bottom-inner">
            <a class="btn secondary" href="{{ url('/slots') }}">Slot</a>
            <a class="btn" href="{{ url('/register') }}">Main sekarang</a>
        </div>
    </footer>
</body>
</html>
