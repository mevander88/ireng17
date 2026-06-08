@extends('layouts.ggr', ['title' => 'Profil - ireng17'])

@section('content')
    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <span class="ggr-kicker">Member</span>
                    <h1>Profil Saya</h1>
                    <p>Data akun dan rekening yang dipakai untuk transaksi.</p>
                </div>
                <a class="ggr-btn" href="{{ url('/') }}">Lobby</a>
            </div>

            <div class="ggr-account-layout">
                @include('ggr.partials.account-menu')

                <div>
                    <div class="ggr-stat-grid">
                        <div class="ggr-stat-card">
                            <small>Username</small>
                            <strong style="font-size:22px">{{ Auth::user()->name }}</strong>
                        </div>
                        <div class="ggr-stat-card">
                            <small>Level</small>
                            <strong style="font-size:22px">Member</strong>
                        </div>
                        <div class="ggr-stat-card">
                            <small>Referral</small>
                            <strong style="font-size:22px">{{ Auth::user()->ref_code ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="ggr-account-panel">
                        <div class="ggr-form-grid">
                            <div class="ggr-field">
                                <label>Nama Rekening</label>
                                <input type="text" value="{{ Auth::user()->nama_rek ?? '-' }}" readonly>
                            </div>
                            <div class="ggr-field">
                                <label>Email</label>
                                <input type="text" value="{{ Auth::user()->email ?? '-' }}" readonly>
                            </div>
                            <div class="ggr-field">
                                <label>Nomor Kontak</label>
                                <input type="text" value="{{ Auth::user()->telp ?? '-' }}" readonly>
                            </div>
                            <div class="ggr-field">
                                <label>Bank/E-Wallet</label>
                                <input type="text" value="{{ Auth::user()->bank ?? '-' }}" readonly>
                            </div>
                            <div class="ggr-field">
                                <label>Nomor Rekening</label>
                                <input type="text" value="{{ Auth::user()->no_rek ?? '-' }}" readonly>
                            </div>
                            <div class="ggr-field">
                                <label>Referral Link</label>
                                <input id="referralLink" type="text" value="{{ Auth::user()->ref_link ?? '' }}" readonly>
                            </div>
                        </div>

                        <div class="ggr-form-actions">
                            <button class="ggr-btn ggr-btn-primary" type="button" onclick="copyReferral()">
                                <span class="material-symbols-outlined">content_copy</span>
                                Copy Referral
                            </button>
                            <a class="ggr-btn" href="{{ url('/account/deposit') }}">Deposit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function copyReferral() {
            const field = document.getElementById('referralLink');
            if (!field || !field.value) return;
            navigator.clipboard?.writeText(field.value);
        }
    </script>
@endsection
