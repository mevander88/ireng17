@extends('layouts.ggr', ['title' => 'Deposit - ' . ($setting->nama_web ?? 'ireng17')])

@section('content')
    @php
        $minimum = (int) ($setting->minimal_depo ?? 20000);
        $qrisEnabled = (int) ($setting->qris_status ?? 0) === 1 && filled(config('jayapay.merchant_code')) && filled(config('jayapay.api_url'));
        $payments = $bank->merge($ewallet);
        $activePayments = $payments->where('status', 1);
        $defaultType = old('payment_type', old('type', $qrisEnabled ? 2 : 1));
        $quickAmounts = collect([20000, 50000, 100000, 250000, 500000, 1000000])
            ->filter(fn ($amount) => $amount >= $minimum)
            ->values();
        if ($quickAmounts->isEmpty()) {
            $quickAmounts = collect([$minimum, $minimum * 2, $minimum * 5]);
        }
    @endphp

    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <span class="ggr-kicker">Wallet</span>
                    <h1>Deposit</h1>
                    <p>QRIS otomatis tersedia sebagai jalur utama. Transfer manual hanya bisa dipakai jika rekening aktif.</p>
                </div>
                <a class="ggr-btn" href="{{ url('/account/lastDirectTransfer') }}">Riwayat</a>
            </div>

            <div class="ggr-account-layout">
                @include('ggr.partials.account-menu')

                <div class="ggr-deposit-flow">
                    @if (session('error'))
                        <div class="ggr-alert" style="color:#ffdad6">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="ggr-alert" style="color:#d9ffe9">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="ggr-alert" style="color:#ffdad6">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="ggr-stat-grid ggr-deposit-balance-grid">
                        <div class="ggr-stat-card">
                            <small>Saldo</small>
                            <strong>Rp {{ number_format((float) $saldos, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    @if (!empty($pendingDeposit))
                        <div class="ggr-account-panel ggr-pending-deposit-panel">
                            <div class="ggr-deposit-step">
                                <span>!</span>
                                <div>
                                    <h2>Deposit pending</h2>
                                    <p>Order {{ $pendingDeposit->trans_id }} masih menunggu pembayaran. Selesaikan dulu sebelum membuat deposit baru.</p>
                                </div>
                            </div>
                            <div class="ggr-payment-summary">
                                <div>
                                    <span>Nominal</span>
                                    <strong>Rp {{ number_format((int) $pendingDeposit->nominal, 0, ',', '.') }}</strong>
                                </div>
                                <div>
                                    <span>Dibuat</span>
                                    <strong>{{ optional($pendingDeposit->created_at)->format('d/m/Y H:i') }}</strong>
                                </div>
                            </div>
                            <div class="ggr-form-actions">
                                @if (!empty($pendingDeposit->qris_url))
                                    <a class="ggr-btn ggr-btn-primary" href="{{ $pendingDeposit->qris_url }}">
                                        <span class="material-symbols-outlined">qr_code_2</span>
                                        Bayar Sekarang
                                    </a>
                                @endif
                                <a class="ggr-btn" href="{{ url('/account/lastDirectTransfer') }}">
                                    <span class="material-symbols-outlined">receipt_long</span>
                                    Lihat Transaksi
                                </a>
                            </div>
                        </div>
                    @else

                    <form class="ggr-account-panel ggr-deposit-panel" action="{{ url('/account/deposit') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="ggr-deposit-step">
                            <span>1</span>
                            <div>
                                <h2>Pilih metode</h2>
                                <p>QRIS diproses lewat gateway otomatis. Manual menunggu verifikasi admin.</p>
                            </div>
                        </div>

                        <div class="ggr-method-switch">
                            <label class="ggr-method-card {{ $qrisEnabled ? '' : 'is-disabled' }}">
                                <input type="radio" name="payment_type" value="2" data-deposit-type="qris" {{ (int) $defaultType === 2 ? 'checked' : '' }} {{ $qrisEnabled ? '' : 'disabled' }}>
                                <span class="material-symbols-outlined">qr_code_2</span>
                                <strong>QRIS Otomatis</strong>
                                <small>{{ $qrisEnabled ? 'Langsung diarahkan ke halaman bayar.' : 'Gateway belum aktif.' }}</small>
                            </label>
                            <label class="ggr-method-card {{ $activePayments->isNotEmpty() ? '' : 'is-disabled' }}">
                                <input type="radio" name="payment_type" value="1" data-deposit-type="manual" {{ (int) $defaultType === 1 ? 'checked' : '' }} {{ $activePayments->isNotEmpty() ? '' : 'disabled' }}>
                                <span class="material-symbols-outlined">account_balance</span>
                                <strong>Transfer Manual</strong>
                                <small>{{ $activePayments->isNotEmpty() ? $activePayments->count() . ' rekening aktif.' : 'Semua rekening sedang maintenance.' }}</small>
                            </label>
                        </div>

                        <div class="ggr-deposit-step">
                            <span>2</span>
                            <div>
                                <h2>Isi nominal</h2>
                                <p>Gunakan nominal cepat atau ketik manual sesuai kebutuhan.</p>
                            </div>
                        </div>

                        <div class="ggr-amount-grid">
                            @foreach ($quickAmounts as $amount)
                                <button type="button" class="ggr-amount-chip" data-amount="{{ $amount }}">Rp {{ number_format($amount, 0, ',', '.') }}</button>
                            @endforeach
                        </div>

                        <div class="ggr-form-grid">
                            <div class="ggr-field is-full">
                                <label for="nominal">Nominal Deposit</label>
                                <input id="nominal" name="nominal" inputmode="numeric" type="text" value="{{ old('nominal') }}" data-minimum="{{ $minimum }}" placeholder="{{ number_format($minimum, 0, ',', '.') }}" required>
                                <span class="ggr-field-help">Minimal Rp {{ number_format($minimum, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="ggr-payment-summary" aria-live="polite">
                            <div>
                                <span>Nominal</span>
                                <strong id="summary-nominal">Rp 0</strong>
                            </div>
                            <div>
                                <span>Total transfer</span>
                                <strong id="summary-total">Rp 0</strong>
                            </div>
                        </div>

                        <div class="ggr-manual-section" data-manual-section>
                            <div class="ggr-deposit-step">
                                <span>3</span>
                                <div>
                                    <h2>Transfer manual</h2>
                                    <p>Pilih rekening aktif, transfer sesuai nominal, lalu upload bukti.</p>
                                </div>
                            </div>

                            <div class="ggr-payment-grid">
                                @forelse ($payments as $payment)
                                    @php
                                        $isActive = (int) $payment->status === 1;
                                    @endphp
                                    <label class="ggr-payment-card {{ $isActive ? '' : 'is-disabled' }}">
                                        <input type="radio" name="bank_id" value="{{ $payment->id }}" data-bank-name="{{ $payment->nama_bank }}" data-bank-owner="{{ $payment->nama_penerima }}" data-bank-number="{{ $payment->no_rek }}" {{ (string) old('bank_id') === (string) $payment->id || (!old('bank_id') && $loop->first && $isActive) ? 'checked' : '' }} {{ $isActive ? '' : 'disabled' }}>
                                        <span class="ggr-payment-type">{{ (int) $payment->type === 2 ? 'E-Wallet' : 'Bank' }}</span>
                                        <strong>{{ $payment->nama_bank }}</strong>
                                        <span>{{ $payment->nama_penerima }}</span>
                                        <span>{{ $payment->no_rek }}</span>
                                        @unless ($isActive)
                                            <em>Maintenance</em>
                                        @endunless
                                    </label>
                                @empty
                                    <div class="ggr-empty">Belum ada rekening deposit manual.</div>
                                @endforelse
                            </div>

                            <div class="ggr-bank-preview" data-bank-preview hidden>
                                <span class="material-symbols-outlined">payments</span>
                                <div>
                                    <small>Tujuan transfer</small>
                                    <strong data-bank-preview-name>-</strong>
                                    <p><span data-bank-preview-owner>-</span> · <span data-bank-preview-number>-</span></p>
                                </div>
                            </div>

                            <div class="ggr-form-grid">
                                <div class="ggr-field">
                                    <label for="bukti_transfer">Bukti Transfer</label>
                                    <input id="bukti_transfer" name="bukti_transfer" type="file" accept="image/*">
                                    <span class="ggr-field-help">Wajib untuk transfer manual. Maksimal 4MB.</span>
                                </div>

                                <div class="ggr-field">
                                    <label for="keterangan">Catatan</label>
                                    <input id="keterangan" name="keterangan" type="text" value="{{ old('keterangan') }}" placeholder="Nama pengirim atau catatan">
                                </div>
                            </div>
                        </div>

                        <div class="ggr-form-actions ggr-deposit-actions">
                            <button class="ggr-btn ggr-btn-primary" type="submit">
                                <span class="material-symbols-outlined">send</span>
                                Kirim
                            </button>
                            <a class="ggr-btn" href="{{ url('/account/lastDirectTransfer') }}">
                                <span class="material-symbols-outlined">receipt_long</span>
                                Riwayat
                            </a>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.ggr-deposit-panel');
            if (!form) return;

            const nominal = document.getElementById('nominal');
            const manualSection = document.querySelector('[data-manual-section]');
            const proof = document.getElementById('bukti_transfer');
            const bankInputs = Array.from(document.querySelectorAll('input[name="bank_id"]'));
            const typeInputs = Array.from(document.querySelectorAll('input[name="payment_type"]'));
            const formatter = new Intl.NumberFormat('id-ID');

            function parseAmount(value) {
                return Number(String(value || '').replace(/\D+/g, '')) || 0;
            }

            function rupiah(value) {
                return 'Rp ' + formatter.format(Math.max(0, Number(value || 0)));
            }

            function selectedType() {
                return form.querySelector('input[name="payment_type"]:checked')?.value || '1';
            }

            function updateSummary() {
                const amount = parseAmount(nominal.value);
                document.getElementById('summary-nominal').textContent = rupiah(amount);
                document.getElementById('summary-total').textContent = rupiah(amount);
            }

            function updateManualState() {
                const isManual = selectedType() === '1';
                manualSection.hidden = !isManual;
                proof.required = isManual;
                bankInputs.forEach((input) => {
                    input.required = isManual && !input.disabled;
                });
            }

            function updateBankPreview() {
                const selected = bankInputs.find((input) => input.checked && !input.disabled);
                const preview = document.querySelector('[data-bank-preview]');
                if (!preview || !selected) {
                    if (preview) preview.hidden = true;
                    return;
                }

                preview.hidden = false;
                document.querySelector('[data-bank-preview-name]').textContent = selected.dataset.bankName || '-';
                document.querySelector('[data-bank-preview-owner]').textContent = selected.dataset.bankOwner || '-';
                document.querySelector('[data-bank-preview-number]').textContent = selected.dataset.bankNumber || '-';
            }

            document.querySelectorAll('[data-amount]').forEach((button) => {
                button.addEventListener('click', function () {
                    nominal.value = formatter.format(Number(button.dataset.amount || 0));
                    updateSummary();
                });
            });

            nominal.addEventListener('input', function () {
                const amount = parseAmount(nominal.value);
                nominal.value = amount ? formatter.format(amount) : '';
                updateSummary();
            });

            typeInputs.forEach((input) => input.addEventListener('change', updateManualState));
            bankInputs.forEach((input) => input.addEventListener('change', updateBankPreview));

            updateSummary();
            updateManualState();
            updateBankPreview();
        });
    </script>
@endsection
