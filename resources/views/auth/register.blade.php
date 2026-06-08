@extends('layouts.ggr', ['title' => 'Daftar - ' . ($setting->nama_web ?? 'ireng17')])

@section('content')
    <section class="ggr-section ggr-auth-section">
        <div class="ggr-shell ggr-auth-shell">
            <div class="ggr-auth-copy">
                <span class="ggr-kicker">Akun Baru</span>
                <h1>Daftar {{ strtoupper($setting->nama_web ?? 'ireng17') }}</h1>
                <p>Buat akun member untuk deposit, withdraw, promo, dan akses game dari lobby baru yang responsif.</p>
            </div>

            <form class="ggr-account-panel ggr-auth-card" method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="ip_register" value="{{ request()->ip() }}">

                <div class="ggr-deposit-step">
                    <span>1</span>
                    <div>
                        <h2>Rincian Akun</h2>
                        <p>Isi data akun dan rekening dengan benar.</p>
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
                        <input id="name" type="text" name="name" value="{{ old('name') }}" minlength="6" maxlength="12" autocomplete="username" required>
                        <small class="ggr-field-help">6-12 karakter, huruf atau angka.</small>
                    </div>
                    <div class="ggr-field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                    </div>
                    <div class="ggr-field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" minlength="8" autocomplete="new-password" required>
                    </div>
                    <div class="ggr-field">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" minlength="8" autocomplete="new-password" required>
                    </div>
                    <div class="ggr-field">
                        <label for="mobile_no">Nomor Telepon</label>
                        <input id="mobile_no" type="tel" name="mobile_no" value="{{ old('mobile_no') }}" maxlength="20" required>
                    </div>
                    <div class="ggr-field">
                        <label for="ref_code">Kode Referral</label>
                        <input id="ref_code" type="text" name="ref_code" value="{{ old('ref_code', request('ref')) }}" maxlength="50" placeholder="Opsional">
                    </div>
                    <div class="ggr-field">
                        <label for="acc_name">Nama Rekening</label>
                        <input id="acc_name" type="text" name="acc_name" value="{{ old('acc_name') }}" maxlength="100" required>
                    </div>
                    <div class="ggr-field">
                        <label for="acc_no">Nomor Rekening / E-Wallet</label>
                        <input id="acc_no" type="tel" name="acc_no" value="{{ old('acc_no') }}" minlength="8" maxlength="20" required>
                    </div>
                    <div class="ggr-field">
                        <label for="method">Jenis Akun Transaksi</label>
                        <select id="method" name="method" data-account-method>
                            <option value="5" {{ old('method', '5') == '5' ? 'selected' : '' }}>Bank</option>
                            <option value="7" {{ old('method') == '7' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                    </div>
                    <div class="ggr-field" data-bank-field>
                        <label for="bank_name">Bank</label>
                        <select id="bank_name" name="bank_name">
                            <option value="">Pilih Bank</option>
                            @foreach (['BRI', 'BCA', 'SEABANK', 'Mandiri', 'BNI', 'BSI', 'Bank JAGO', 'CIMB NIAGA', 'Bank Permata', 'Bank OCBC', 'BANK RAYA', 'BANK PANIN', 'BANK ALADIN', 'BANK LAINNYA'] as $bank)
                                <option value="{{ $bank }}" {{ old('bank_name') === $bank ? 'selected' : '' }}>{{ $bank }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ggr-field" data-ewallet-field hidden>
                        <label for="ewallet_name">E-Wallet</label>
                        <select id="ewallet_name" name="ewallet_name">
                            <option value="">Pilih E-Wallet</option>
                            @foreach (['DANA', 'OVO', 'GOPAY', 'LINKAJA', 'SHOPEEPAY'] as $wallet)
                                <option value="{{ $wallet }}" {{ old('ewallet_name') === $wallet ? 'selected' : '' }}>{{ $wallet }}</option>
                            @endforeach
                        </select>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const method = document.querySelector('[data-account-method]');
            const bank = document.querySelector('[data-bank-field]');
            const wallet = document.querySelector('[data-ewallet-field]');

            function syncMethod() {
                const isWallet = method?.value === '7';
                if (bank) bank.hidden = isWallet;
                if (wallet) wallet.hidden = !isWallet;
            }

            method?.addEventListener('change', syncMethod);
            syncMethod();
        });
    </script>
@endsection
