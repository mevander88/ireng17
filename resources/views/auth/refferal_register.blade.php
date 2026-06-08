@extends('layouts.ggr', ['title' => 'Daftar Referral - ' . ($setting->nama_web ?? 'ireng17')])

@section('content')
    <section class="ggr-section ggr-auth-section">
        <div class="ggr-shell ggr-auth-shell">
            <div class="ggr-auth-copy">
                <span class="ggr-kicker">Referral</span>
                <h1>Daftar dari Referral</h1>
                <p>Lengkapi data akun untuk bergabung melalui kode referral yang sudah terverifikasi.</p>
            </div>

            <form class="ggr-account-panel ggr-auth-card" method="POST" action="{{ url('/referral-register/store') }}">
                @csrf
                <input type="hidden" name="ref" value="{{ $refferal }}">
                <input type="hidden" name="ip_register" value="{{ request()->ip() }}">

                <div class="ggr-deposit-step">
                    <span>1</span>
                    <div>
                        <h2>Data Member</h2>
                        <p>Kode referral: {{ $refferal }}</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="ggr-alert is-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="ggr-form-grid">
                    <div class="ggr-field">
                        <label for="name">Username</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" minlength="6" maxlength="12" required>
                    </div>
                    <div class="ggr-field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="ggr-field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" minlength="8" required>
                    </div>
                    <div class="ggr-field">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" minlength="8" required>
                    </div>
                    <div class="ggr-field">
                        <label for="mobile_no">Nomor Telepon</label>
                        <input id="mobile_no" type="tel" name="mobile_no" value="{{ old('mobile_no') }}" maxlength="20" required>
                    </div>
                    <div class="ggr-field">
                        <label for="captcha">Kode Verifikasi</label>
                        <input id="captcha" type="text" name="captcha" maxlength="4" required>
                    </div>
                    <div class="ggr-field">
                        <label for="acc_name">Nama Rekening</label>
                        <input id="acc_name" type="text" name="acc_name" value="{{ old('acc_name') }}" maxlength="100">
                    </div>
                    <div class="ggr-field">
                        <label for="bank_name">Bank / E-Wallet</label>
                        <input id="bank_name" type="text" name="bank_name" value="{{ old('bank_name') }}" maxlength="50">
                    </div>
                    <div class="ggr-field is-full">
                        <label for="acc_no">Nomor Rekening / E-Wallet</label>
                        <input id="acc_no" type="tel" name="acc_no" value="{{ old('acc_no') }}" minlength="8" maxlength="20">
                    </div>
                </div>

                <label class="ggr-check-field">
                    <input type="checkbox" name="terms" value="1" required>
                    <span>Saya menyetujui ketentuan layanan.</span>
                </label>

                <div class="ggr-form-actions">
                    <button class="ggr-btn ggr-btn-primary" type="submit">
                        <span class="material-symbols-outlined">person_add</span>
                        Daftar
                    </button>
                    <a class="ggr-btn" href="{{ url('/login') }}">
                        <span class="material-symbols-outlined">login</span>
                        Login
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection
