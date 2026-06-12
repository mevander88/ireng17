@extends('layouts.ggr', ['title' => 'Profil - ' . ($setting->nama_web ?? 'ireng17')])

@section('content')
    @php
        $user = Auth::user();
        $depositHref = !empty($pendingDeposit?->qris_url) ? $pendingDeposit->qris_url : url('/account/deposit');
        $depositIcon = !empty($pendingDeposit?->qris_url) ? 'qr_code_2' : 'add_circle';
    @endphp

    <section class="ggr-section ggr-profile-section">
        <div class="ggr-shell">
            <div class="ggr-section-head ggr-profile-head">
                <div>
                    <span class="ggr-kicker">Member</span>
                    <h1>Profil Saya</h1>
                </div>
                <a class="ggr-btn" href="{{ url('/') }}">
                    <span class="material-symbols-outlined">grid_view</span>
                    Lobby
                </a>
            </div>

            <div class="ggr-account-layout">
                @include('ggr.partials.account-menu')

                <div class="ggr-profile-content">
                    <div class="ggr-profile-wallet">
                        <div class="ggr-profile-wallet-main">
                            <span class="ggr-kicker">Saldo Aktif</span>
                            <strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong>
                            <div class="ggr-profile-status-row">
                                <span class="ggr-status {{ $accountComplete ? 'is-success' : 'is-pending' }}">
                                    {{ $accountComplete ? 'Data rekening lengkap' : 'Lengkapi rekening' }}
                                </span>
                                @if (!empty($pendingDeposit))
                                    <span class="ggr-status is-pending">Deposit pending</span>
                                @endif
                            </div>
                        </div>

                        <div class="ggr-profile-wallet-actions">
                            <a class="ggr-btn ggr-btn-primary ggr-profile-deposit-cta" href="{{ $depositHref }}">
                                <span class="material-symbols-outlined">{{ $depositIcon }}</span>
                                Deposit
                            </a>
                            <a class="ggr-btn" href="{{ url('/account/withdrawal') }}">
                                <span class="material-symbols-outlined">payments</span>
                                Withdraw
                            </a>
                        </div>
                    </div>

                    <div class="ggr-profile-quick-grid">
                        <a class="ggr-profile-quick-card is-primary" href="{{ $depositHref }}">
                            <span class="material-symbols-outlined">{{ $depositIcon }}</span>
                            <div>
                                <small>{{ !empty($pendingDeposit) ? 'Pending' : 'Wallet' }}</small>
                                <strong>{{ !empty($pendingDeposit) ? 'Bayar deposit' : 'Deposit' }}</strong>
                            </div>
                        </a>
                        <a class="ggr-profile-quick-card" href="{{ url('/slots') }}">
                            <span class="material-symbols-outlined">casino</span>
                            <div>
                                <small>Game</small>
                                <strong>Slot</strong>
                            </div>
                        </a>
                        <a class="ggr-profile-quick-card" href="{{ url('/account/lastDirectTransfer') }}">
                            <span class="material-symbols-outlined">receipt_long</span>
                            <div>
                                <small>Mutasi</small>
                                <strong>Transaksi</strong>
                            </div>
                        </a>
                        <a class="ggr-profile-quick-card" href="{{ url('/promo/saya') }}">
                            <span class="material-symbols-outlined">redeem</span>
                            <div>
                                <small>Benefit</small>
                                <strong>Promo</strong>
                            </div>
                        </a>
                    </div>

                    <div class="ggr-stat-grid ggr-profile-stat-grid">
                        <div class="ggr-stat-card">
                            <small>Username</small>
                            <strong>{{ $user->name }}</strong>
                        </div>
                        <div class="ggr-stat-card">
                            <small>Deposit sukses</small>
                            <strong>{{ number_format($successfulDeposits) }}</strong>
                        </div>
                        <div class="ggr-stat-card">
                            <small>Withdraw sukses</small>
                            <strong>{{ number_format($successfulWithdraws) }}</strong>
                        </div>
                    </div>

                    <div class="ggr-profile-grid">
                        <div class="ggr-account-panel ggr-profile-panel">
                            <div class="ggr-profile-panel-head">
                                <span class="material-symbols-outlined">badge</span>
                                <div>
                                    <span class="ggr-kicker">Akun</span>
                                    <h2>Identitas</h2>
                                </div>
                            </div>
                            <div class="ggr-profile-info-list">
                                <div>
                                    <small>Email</small>
                                    <strong>{{ $user->email ?? '-' }}</strong>
                                </div>
                                <div>
                                    <small>Nomor Kontak</small>
                                    <strong>{{ $user->telp ?? '-' }}</strong>
                                </div>
                                <div>
                                    <small>Referral</small>
                                    <strong>{{ $user->ref_code ?? '-' }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="ggr-account-panel ggr-profile-panel">
                            <div class="ggr-profile-panel-head">
                                <span class="material-symbols-outlined">account_balance</span>
                                <div>
                                    <span class="ggr-kicker">Rekening</span>
                                    <h2>Pencairan</h2>
                                </div>
                            </div>
                            <div class="ggr-profile-info-list">
                                <div>
                                    <small>Nama Rekening</small>
                                    <strong>{{ $user->nama_rek ?? '-' }}</strong>
                                </div>
                                <div>
                                    <small>Bank/E-Wallet</small>
                                    <strong>{{ $user->bank ?? '-' }}</strong>
                                </div>
                                <div>
                                    <small>Nomor Rekening</small>
                                    <strong>{{ $user->no_rek ?? '-' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ggr-account-panel ggr-profile-referral">
                        <div class="ggr-profile-panel-head">
                            <span class="material-symbols-outlined">ios_share</span>
                            <div>
                                <span class="ggr-kicker">Referral</span>
                                <h2>Link Akun</h2>
                            </div>
                        </div>
                        <div class="ggr-profile-copy-row">
                            <input id="referralLink" type="text" value="{{ $user->ref_link ?? '' }}" readonly>
                            <button class="ggr-btn ggr-btn-primary" type="button" onclick="copyReferral()">
                                <span class="material-symbols-outlined">content_copy</span>
                                Copy
                            </button>
                        </div>
                        <div class="ggr-stat-grid ggr-profile-stat-grid" style="margin-top:16px;">
                            <div class="ggr-stat-card">
                                <small>Member referral</small>
                                <strong>{{ number_format($referralSummary['members'] ?? 0, 0, ',', '.') }}</strong>
                            </div>
                            <div class="ggr-stat-card">
                                <small>Total penghasilan</small>
                                <strong>Rp {{ number_format($referralSummary['paid_total'] ?? 0, 0, ',', '.') }}</strong>
                            </div>
                            <div class="ggr-stat-card">
                                <small>Komisi sukses</small>
                                <strong>{{ number_format($referralSummary['paid_count'] ?? 0, 0, ',', '.') }}</strong>
                            </div>
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
            field.select();
            navigator.clipboard?.writeText(field.value);
        }
    </script>
@endsection
