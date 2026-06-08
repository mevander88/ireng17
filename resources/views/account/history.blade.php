@extends('layouts.ggr', ['title' => 'Pernyataan - ireng17'])

@section('content')
    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div>
                    <span class="ggr-kicker">Wallet</span>
                    <h1>Pernyataan</h1>
                    <p>Filter transaksi berdasarkan rentang tanggal.</p>
                </div>
                <a class="ggr-btn" href="{{ url('/account/lastDirectTransfer') }}">Transaksi</a>
            </div>

            <div class="ggr-account-layout">
                @include('ggr.partials.account-menu')

                <div>
                    <div class="ggr-account-panel" style="margin-bottom:18px">
                        <form action="{{ url('/account/history') }}" method="GET" class="ggr-form-grid">
                            <div class="ggr-field">
                                <label for="daterange">Rentang Tanggal</label>
                                <input id="daterange" name="daterange" type="text" value="{{ request('daterange') }}" placeholder="YYYY/MM/DD - YYYY/MM/DD">
                                <span class="ggr-field-help">Format mengikuti sistem lama: tahun/bulan/tanggal - tahun/bulan/tanggal.</span>
                            </div>
                            <div class="ggr-field">
                                <label for="transaction_type">Jenis</label>
                                <select id="transaction_type" name="transaction_type">
                                    <option value="2">Transaksi</option>
                                </select>
                            </div>
                            <div class="ggr-form-actions">
                                <button class="ggr-btn ggr-btn-primary" type="submit">
                                    <span class="material-symbols-outlined">search</span>
                                    Cari
                                </button>
                                <a class="ggr-btn" href="{{ url('/account/history') }}">Reset</a>
                            </div>
                        </form>
                    </div>

                    <div class="ggr-table-card ggr-mobile-scroll">
                        <table class="ggr-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th>Nominal</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksi ?? [] as $item)
                                    <tr>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>{{ $item->type == 1 ? 'Deposit' : 'Withdraw' }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="ggr-status is-pending">Dalam Proses</span>
                                            @elseif ($item->status == 2)
                                                <span class="ggr-status is-success">Berhasil</span>
                                            @else
                                                <span class="ggr-status is-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format((float) $item->nominal, 0, ',', '.') }}</td>
                                        <td>{{ $item->keterangan ?? $item->alasan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Pilih rentang tanggal untuk melihat pernyataan transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
