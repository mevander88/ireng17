@extends('layouts.ggr', ['title' => 'Transaksi - ireng17'])

@section('content')
    <section class="ggr-section">
        <div class="ggr-shell">
            <div class="ggr-section-head">
                <div class="ggr-transaction-content">
                    <span class="ggr-kicker">Wallet</span>
                    <h1>Riwayat Transaksi</h1>
                    <p>Deposit dan withdraw terakhir dari akun Anda.</p>
                </div>
                <a class="ggr-btn" href="{{ url('/account/deposit') }}">Deposit</a>
            </div>

            <div class="ggr-account-layout">
                @include('ggr.partials.account-menu')

                <div>
                    <div class="ggr-stat-grid">
                        <div class="ggr-stat-card">
                            <small>Saldo</small>
                            <strong>Rp {{ number_format((float) $saldos, 0, ',', '.') }}</strong>
                        </div>
                        <div class="ggr-stat-card">
                            <small>Total Berhasil</small>
                            <strong>Rp {{ number_format((float) $totalNominal, 0, ',', '.') }}</strong>
                        </div>
                        <div class="ggr-stat-card">
                            <small>Transaksi</small>
                            <strong>{{ $transaksi->count() }}</strong>
                        </div>
                    </div>

                    <div class="ggr-table-card ggr-mobile-scroll">
                        <table class="ggr-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Trx ID</th>
                                    <th>Jenis</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksi as $item)
                                    <tr>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->trans_id }}</td>
                                        <td>{{ $item->type == 1 ? 'Deposit' : 'Withdraw' }}</td>
                                        <td>{{ $item->type == 1 ? ($item->Bank->nama_bank ?? '-') : ($item->keterangan ?? '-') }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="ggr-status is-pending">Pending</span>
                                            @elseif ($item->status == 2)
                                                <span class="ggr-status is-success">Confirmed</span>
                                            @else
                                                <span class="ggr-status is-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format((float) $item->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Belum ada transaksi.</td>
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
