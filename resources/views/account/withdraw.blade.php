@extends('layouts.ggr', ['title' => 'Withdraw - ireng17'])

@section('content')
    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <span class="ggr-kicker">Wallet</span>
                    <h1>Withdraw</h1>
                    <p>Ajukan penarikan ke rekening yang terdaftar di profil akun.</p>
                </div>
                <a class="ggr-btn" href="{{ url('/') }}">Lobby</a>
            </div>

            <div class="ggr-account-layout">
                @include('ggr.partials.account-menu')

                <div>
                    @if (session('error'))
                        <div class="ggr-alert" style="color:#ffdad6">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="ggr-alert" style="color:#d9ffe9">{{ session('success') }}</div>
                    @endif
                    @if (session('info'))
                        <div class="ggr-alert">{{ session('info') }}</div>
                    @endif

                    <div class="ggr-stat-grid">
                        <div class="ggr-stat-card">
                            <small>Saldo</small>
                            <strong>Rp {{ number_format((float) $saldos, 0, ',', '.') }}</strong>
                        </div>
                        <div class="ggr-stat-card">
                            <small>Bank</small>
                            <strong style="font-size:20px">{{ $rek->bank ?? '-' }}</strong>
                        </div>
                        <div class="ggr-stat-card">
                            <small>Rekening</small>
                            <strong style="font-size:20px">{{ $rek->no_rek ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="ggr-account-panel">
                        <form id="withdrawForm" action="{{ url('/withdrawal/user') }}" method="POST">
                            @csrf
                            <div class="ggr-form-grid">
                                <div class="ggr-field">
                                    <label for="amount">Nominal Withdraw</label>
                                    <input id="amount" name="amount" type="number" min="1000" step="1000" placeholder="50000" required>
                                    <span class="ggr-field-help">Minimal Rp 1.000</span>
                                </div>

                                <div class="ggr-field">
                                    <label for="acc_no">Nomor Rekening</label>
                                    <input id="acc_no" name="acc_no" type="text" value="{{ $rek->no_rek ?? '' }}" required>
                                </div>

                                <div class="ggr-field">
                                    <label>Nama Rekening</label>
                                    <input type="text" value="{{ $rek->nama_rek ?? '-' }}" readonly>
                                </div>

                                <div class="ggr-field">
                                    <label>Bank/E-Wallet</label>
                                    <input type="text" value="{{ $rek->bank ?? '-' }}" readonly>
                                </div>
                            </div>

                            <div class="ggr-form-actions">
                                <button class="ggr-btn ggr-btn-primary" type="submit">
                                    <span class="material-symbols-outlined">payments</span>
                                    Ajukan Withdraw
                                </button>
                                <a class="ggr-btn" href="{{ url('/account/lastDirectTransfer') }}">Lihat Transaksi</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
