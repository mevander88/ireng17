@extends('backoffice.layouts.main')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        Data Deposit Member
    </div>

    {{-- Alert --}}
    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire('Berhasil', '{{ Session::get('success') }}', 'success');
        </script>
    @endif
    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire('Warning', '{{ Session::get('error') }}', 'error');
        </script>
    @endif

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Username</th>
                        <th>Rek Pengirim</th>
                        <th>Metode</th>
                        <th>Deposit</th>
                        <th>Bonus</th>
                        <th>Keterangan</th>
                        <th>Bukti TF</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $index => $transaksis)
                        <tr>
                            <td>{{ $transaksi->firstItem() + $index }}</td>
                            <td>{{ $transaksis->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $transaksis->user->name ?? $transaksis->user_name }}</td>
                            <td>{{ $transaksis->rek_pengirim ?? '-' }}</td>
                            <td>
                                @if ($transaksis->qris_url || $transaksis->approved_by == 'jayapay_auto')
                                    QRIS (TopPayment)
                                @elseif ($transaksis->type == 1)
                                    Manual
                                @else
                                    -
                                @endif
                            </td>
                            <td>Rp {{ number_format($transaksis->nominal, 0, ',', '.') }}</td>
                            <td>{{ $transaksis->bonus->judul ?? 'Tidak ada bonus' }}</td>
                            <td>{{ $transaksis->keterangan }}</td>
                            <td>
                                @if ($transaksis->bukti_transfer)
                                    <a href="{{ asset('storage/' . $transaksis->bukti_transfer) }}" target="_blank" rel="noopener noreferrer">Lihat Bukti</a>
                                @else
                                    Tidak Ada Bukti
                                @endif
                            </td>
                            <td class="admin-action-cell">
                                @if ($transaksis->status == 2)
                                    <span class="badge badge-success">Berhasil</span>
                                @elseif ($transaksis->status == 3)
                                    <span class="badge badge-danger">Gagal</span>
                                @elseif ($transaksis->status == 1 && $transaksis->type == 1)
                                    <form action="{{ route('depo.confirm', $transaksis->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success">Konfirmasi</button>
                                    </form>
                                    <form action="{{ route('depo.reject', $transaksis->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-warning">Reject</button>
                                    </form>
                                @else
                                    <span class="text-muted">Status tidak diketahui</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Tidak ada transaksi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $transaksi->links() }}
        </div>
    </div>
</div>

{{-- Modal Konfirmasi --}}
<div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="konfirmasi_pay" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan mengkonfirmasi transaksi ?
                </div>
                <input type="hidden" name="status" value="2">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Bukti Transfer --}}
<div class="modal fade" id="bukti_transfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bukti Transfer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="data_transfer" src="" style="width: 100%" alt="Bukti Image">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
