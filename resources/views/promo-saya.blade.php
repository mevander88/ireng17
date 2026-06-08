@extends('layouts.ggr', ['title' => 'Promo Saya - ireng17'])

@section('content')
    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <span class="ggr-kicker">Member</span>
                    <h1>Promo saya</h1>
                    <p>Pantau promo deposit dan progres turnover akun Anda.</p>
                </div>
                <a class="ggr-btn ggr-btn-primary" href="{{ url('/promotion') }}">
                    <span class="material-symbols-outlined">local_offer</span>
                    Semua Promo
                </a>
            </div>

            <div class="ggr-account-layout">
                @include('ggr.partials.account-menu')

                <div class="ggr-promo-member">
                    <div class="ggr-account-panel">
                        <div class="ggr-section-head ggr-panel-head">
                            <div>
                                <span class="ggr-kicker">Klaim</span>
                                <h2>Promo deposit aktif</h2>
                            </div>
                            <a class="ggr-btn" href="{{ url('/account/deposit') }}">Deposit</a>
                        </div>

                        @if ($transaksi && $transaksi->Bonus)
                            @php
                                $bonusValue = ((float) $transaksi->nominal * (float) $transaksi->bonus_persentase) / 100;
                            @endphp
                            <div class="ggr-member-promo-card">
                                <div>
                                    <span class="ggr-kicker">Promosi</span>
                                    <h3>{{ $transaksi->Bonus->judul }}</h3>
                                    <p>{{ $transaksi->Bonus->keterangan }}</p>
                                </div>
                                <dl>
                                    <div>
                                        <dt>Nominal</dt>
                                        <dd>Rp {{ number_format((float) $transaksi->nominal, 0, ',', '.') }}</dd>
                                    </div>
                                    <div>
                                        <dt>Bonus</dt>
                                        <dd>Rp {{ number_format($bonusValue, 0, ',', '.') }}</dd>
                                    </div>
                                    <div>
                                        <dt>Status</dt>
                                        <dd>
                                            <span class="ggr-status {{ (int) $transaksi->status === 2 ? 'is-success' : 'is-pending' }}">
                                                {{ (int) $transaksi->status === 2 ? 'Claim' : 'Dalam Proses' }}
                                            </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        @else
                            <div class="ggr-empty">Belum ada promo deposit yang bisa ditampilkan.</div>
                        @endif
                    </div>

                    <div class="ggr-account-panel">
                        <div class="ggr-section-head ggr-panel-head">
                            <div>
                                <span class="ggr-kicker">Turnover</span>
                                <h2>Bonus saya</h2>
                            </div>
                            <button class="ggr-btn" type="button" id="refresh-turnover">
                                <span class="material-symbols-outlined">refresh</span>
                                Refresh
                            </button>
                        </div>

                        <div class="ggr-turnover-grid">
                            <div>
                                <span>Latest Date</span>
                                <strong id="latest-date">-</strong>
                            </div>
                            <div>
                                <span>Spin</span>
                                <strong id="spin-count">0</strong>
                            </div>
                            <div>
                                <span>Latest Bet</span>
                                <strong id="latest-bet">0</strong>
                            </div>
                            <div>
                                <span>Turnover</span>
                                <strong id="turnover-value">0</strong>
                            </div>
                        </div>

                        <div class="ggr-progress-wrap">
                            <div class="ggr-progress-meta">
                                <span>Progressive</span>
                                <strong id="progressive-value">0%</strong>
                            </div>
                            <div class="ggr-progress-track">
                                <span id="progressive-bar"></span>
                            </div>
                        </div>

                        <div class="ggr-empty" id="turnover-message" hidden>Bonus belum bisa dimuat. Silakan coba lagi.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrf = '{{ csrf_token() }}';
            const message = document.getElementById('turnover-message');
            const refreshButton = document.getElementById('refresh-turnover');
            const formatNumber = new Intl.NumberFormat('id-ID');

            function setText(id, value) {
                const element = document.getElementById(id);
                if (element) {
                    element.textContent = value;
                }
            }

            function setProgress(value) {
                const normalized = Math.max(0, Math.min(100, Number(value || 0)));
                setText('progressive-value', normalized.toFixed(1) + '%');
                document.getElementById('progressive-bar').style.width = normalized + '%';
            }

            async function loadTurnover() {
                refreshButton.disabled = true;
                message.hidden = true;

                try {
                    const response = await fetch('{{ url('/turnover') }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Request failed');
                    }

                    const data = await response.json();
                    setText('latest-date', data.latest_date || '-');
                    setText('spin-count', formatNumber.format(Number(data.spin || 0)));
                    setText('latest-bet', formatNumber.format(Number(data.latest_bet || 0)));
                    setText('turnover-value', formatNumber.format(Number(data.turnover || 0)));
                    setProgress(data.progressive);
                } catch (error) {
                    message.hidden = false;
                } finally {
                    refreshButton.disabled = false;
                }
            }

            refreshButton.addEventListener('click', loadTurnover);
            loadTurnover();
        });
    </script>
@endsection
