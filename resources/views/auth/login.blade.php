@extends('layouts.ggr', ['title' => 'Login - ' . ($setting->nama_web ?? 'ireng17')])

@section('content')
    <section class="ggr-section ggr-auth-section">
        <div class="ggr-shell ggr-auth-shell">
            <div class="ggr-auth-copy">
                <span class="ggr-kicker">Akses Member</span>
                <h1>Login {{ strtoupper($setting->nama_web ?? 'ireng17') }}</h1>
                <p>Masuk untuk melihat saldo, membuka transaksi, mengambil promo, dan melanjutkan permainan dari lobby baru.</p>
            </div>

            <form class="ggr-account-panel ggr-auth-card" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="ggr-deposit-step">
                    <span>1</span>
                    <div>
                        <h2>Masuk Akun</h2>
                        <p>Gunakan username dan password member.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="ggr-alert is-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="ggr-form-grid">
                    <div class="ggr-field is-full">
                        <label for="name">Username</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="username" required autofocus>
                    </div>
                    <div class="ggr-field is-full">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" autocomplete="current-password" required>
                    </div>
                    <label class="ggr-check-field is-full">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ingat sesi login</span>
                    </label>
                </div>

                <div class="ggr-form-actions">
                    <button class="ggr-btn ggr-btn-primary" type="submit">
                        <span class="material-symbols-outlined">login</span>
                        Login
                    </button>
                    <a class="ggr-btn" href="{{ url('/register') }}">
                        <span class="material-symbols-outlined">person_add</span>
                        Daftar
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection
