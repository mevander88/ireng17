@extends('layouts.ggr')

@section('title', 'Reset Password')

@section('content')
    <section class="ggr-section ggr-auth-section">
        <div class="ggr-auth-shell">
            <div class="ggr-auth-copy">
                <span class="ggr-eyebrow">Akun ireng17</span>
                <h1>Reset password</h1>
                <p>Masukkan email akun untuk menerima tautan reset password.</p>
            </div>

            <form class="ggr-account-panel ggr-auth-card" method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="ggr-section-heading">
                    <div>
                        <span class="ggr-eyebrow">Recovery</span>
                        <h2>Kirim Link Reset</h2>
                    </div>
                </div>

                @if (session('status'))
                    <div class="ggr-alert is-success">{{ session('status') }}</div>
                @endif

                @error('email')
                    <div class="ggr-alert is-danger">{{ $message }}</div>
                @enderror

                <label>
                    Email
                    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </label>

                <button type="submit" class="ggr-btn ggr-btn-primary">Kirim Link</button>
            </form>
        </div>
    </section>
@endsection
