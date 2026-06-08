@extends('layouts.ggr')

@section('title', 'Password Baru')

@section('content')
    <section class="ggr-section ggr-auth-section">
        <div class="ggr-auth-shell">
            <div class="ggr-auth-copy">
                <span class="ggr-eyebrow">Akun ireng17</span>
                <h1>Password baru</h1>
                <p>Buat password baru untuk mengamankan akses akun.</p>
            </div>

            <form class="ggr-account-panel ggr-auth-card" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="ggr-section-heading">
                    <div>
                        <span class="ggr-eyebrow">Recovery</span>
                        <h2>Reset Password</h2>
                    </div>
                </div>

                @foreach (['email', 'password'] as $field)
                    @error($field)
                        <div class="ggr-alert is-danger">{{ $message }}</div>
                    @enderror
                @endforeach

                <label>
                    Email
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                </label>

                <label>
                    Password Baru
                    <input type="password" name="password" required autocomplete="new-password">
                </label>

                <label>
                    Konfirmasi Password
                    <input type="password" name="password_confirmation" required autocomplete="new-password">
                </label>

                <button type="submit" class="ggr-btn ggr-btn-primary">Simpan Password</button>
            </form>
        </div>
    </section>
@endsection
