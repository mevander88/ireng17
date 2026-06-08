@extends('layouts.ggr')

@section('title', 'Konfirmasi Password')

@section('content')
    <section class="ggr-section ggr-auth-section">
        <div class="ggr-auth-shell">
            <div class="ggr-auth-copy">
                <span class="ggr-eyebrow">Akun ireng17</span>
                <h1>Konfirmasi password</h1>
                <p>Masukkan password untuk melanjutkan akses ke area aman.</p>
            </div>

            <form class="ggr-account-panel ggr-auth-card" method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="ggr-section-heading">
                    <div>
                        <span class="ggr-eyebrow">Keamanan</span>
                        <h2>Verifikasi Akses</h2>
                    </div>
                </div>

                @error('password')
                    <div class="ggr-alert is-danger">{{ $message }}</div>
                @enderror

                <label>
                    Password
                    <input type="password" name="password" required autocomplete="current-password">
                </label>

                <div class="ggr-auth-actions">
                    <button type="submit" class="ggr-btn ggr-btn-primary">Konfirmasi</button>
                    @if (Route::has('password.request'))
                        <a class="ggr-btn" href="{{ route('password.request') }}">Lupa Password</a>
                    @endif
                </div>
            </form>
        </div>
    </section>
@endsection
