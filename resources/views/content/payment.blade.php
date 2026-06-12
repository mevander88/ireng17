@extends('layouts.ggr', ['title' => 'Pembayaran - ' . ($setting->nama_web ?? 'ireng17')])

@section('content')
    <section class="ggr-section">
        <div class="ggr-shell ggr-account-layout">
            @include('ggr.partials.account-menu')

            <div class="ggr-deposit-flow">
                <div class="ggr-stat-grid ggr-deposit-balance-grid">
                    <div class="ggr-stat-card">
                        <small>Jumlah Bayar</small>
                        <strong>{{ $nominal ? 'Rp ' . number_format($nominal, 0, ',', '.') : 'Rp 0' }}</strong>
                    </div>
                </div>

                <div class="ggr-account-panel ggr-deposit-panel">
                    <div class="ggr-deposit-step">
                        <span>1</span>
                        <div>
                            <h2>QRIS Otomatis</h2>
                            <p>Scan kode pembayaran dan cek status transaksi dari halaman ini.</p>
                        </div>
                    </div>

                    <div class="ggr-payment-summary">
                        <div class="ggr-bank-preview">
                            <span class="material-symbols-outlined">qr_code_2</span>
                            <div>
                                <small>Metode Pembayaran</small>
                                <strong>TopPayment Otomatis</strong>
                                <p>QRIS</p>
                            </div>
                        </div>
                        <div class="ggr-bank-preview">
                            <span class="material-symbols-outlined">timer</span>
                            <div>
                                <small>Batas Waktu</small>
                                <strong id="timer">15:00</strong>
                                <p>Selesaikan sebelum waktu habis.</p>
                            </div>
                        </div>
                    </div>

                    @if (!empty($payQRIS))
                        <div class="ggr-qris-box">
                            @if (Str::endsWith($payQRIS, ['.png', '.jpg', '.jpeg']))
                                <img src="{{ $payQRIS }}" alt="QRIS {{ $setting->nama_web ?? 'ireng17' }}">
                            @else
                                <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($payQRIS) }}&size=260x260" alt="QRIS {{ $setting->nama_web ?? 'ireng17' }}">
                            @endif
                            <p>Scan QRIS dengan aplikasi pembayaran Anda.</p>
                        </div>
                    @else
                        <div class="ggr-alert is-error">
                            QRIS atau link pembayaran tidak tersedia. Silakan buat pesanan baru.
                        </div>
                    @endif

                    <div class="ggr-form-actions ggr-deposit-actions">
                        <button id="confirm-btn" class="ggr-btn ggr-btn-primary" type="button">
                            <span class="material-symbols-outlined">sync</span>
                            Cek Status
                        </button>
                        <a href="{{ url('/account/deposit') }}" class="ggr-btn">
                            <span class="material-symbols-outlined">arrow_back</span>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        let remainingTime = 15 * 60;
        const timer = document.getElementById('timer');
        const button = document.getElementById('confirm-btn');

        function updateCountdown() {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            if (timer) {
                timer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
            if (remainingTime <= 0) {
                clearInterval(countdownInterval);
                window.location.href = "{{ url('/account/deposit') }}";
            }
            remainingTime--;
        }

        async function checkPaymentStatus(auto = false) {
            try {
                const response = await fetch("{{ route('status.payment') }}", {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const payload = await response.json();
                if (payload.success) {
                    clearInterval(countdownInterval);
                    if (button) button.disabled = true;
                    window.location.href = "{{ url('/account/lastDirectTransfer') }}";
                    return;
                }
                if (!auto && payload.info) {
                    alert(payload.info);
                }
            } catch (error) {
                if (!auto) {
                    alert('Terjadi kesalahan, silakan coba lagi.');
                }
            }
        }

        const countdownInterval = setInterval(updateCountdown, 1000);
        button?.addEventListener('click', () => checkPaymentStatus(false));
        setInterval(() => checkPaymentStatus(true), 10000);
        updateCountdown();
    </script>
@endsection
