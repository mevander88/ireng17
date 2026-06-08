<?php
use Illuminate\Support\Facades\Auth;

$user_level = Auth::user()->level;
$is_developer = (int) $user_level === 2;
$is_admin = (int) $user_level <= 2;

?>
@extends('backoffice.layouts.main')

@section('content')
    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire(
                'Berhasil',
                '{{ Session::get('success') }}',
                'success'
            );
        </script>
    @endif
    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire(
                'Warning',
                '{{ Session::get('error') }}',
                'error'
            );
        </script>
    @endif
    <div class="card mt-3">
        <div class="card-header">
            Data Request Withdraw Member
        </div>
        <div class="card-body">
            <form method="GET" action="{{ URL::to('/withdraw') }}" class="admin-filter-bar">
                <div class="admin-filter-fields">
                    <label for="search-withdraw">Cari Withdraw</label>
                    <input type="search" class="form-control" id="search-withdraw" name="search"
                        value="{{ $search ?? '' }}" placeholder="Username, rekening, atau keterangan">
                </div>
                <div class="admin-filter-actions">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                    @if (!empty($search))
                        <a href="{{ URL::to('/withdraw') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th scope="col">Tanggal</th>
                            <th>Username</th>
                            <th>Nominal</th>
                            <th>Rekening Tujuan</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi as $key => $transaksis)
                            <tr>
                                <td>{{ $transaksi->firstItem() + $key }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaksis->created_at)->format('d-m-Y') }}</td>
                                <td>{{ $transaksis->user_name }}</td>
                                <td>Rp {{ number_format($transaksis->nominal, 0, ',', '.') }}</td>
                                <td>{{ $transaksis->rek_pengirim ?: '-' }}</td>
                                <td>{{ $transaksis->keterangan ?: '-' }}</td>
                                <td>
                                    @if ($transaksis->status == 2)
                                        <span class="badge badge-success">Berhasil</span>
                                    @elseif ($transaksis->status == 3)
                                        <span class="badge badge-danger">Reject</span>
                                    @elseif ($transaksis->status == 1)
                                        <span class="badge badge-warning">Menunggu</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak diketahui</span>
                                    @endif
                                </td>
                                <td class="admin-action-cell">
                                    @if ($transaksis->status == 1)
                                        <form action="{{ route('withdraw.confirm', $transaksis->user_id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success">Konfirmasi</button>
                                        </form>
                                        <form action="{{ route('withdraw.reject', $transaksis->user_id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Data withdraw tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="admin-pagination">
                {{ $transaksi->links() }}
            </div>
        </div>
    </div>

    <div class="modal-area">
        <div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="konfirmasi_pay" method="POST">
                        {{ csrf_field() }}
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Transaksi
                            </h5>
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
        <div class="modal fade" id="tolak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" id="tolak_pay">
                        {{ csrf_field() }}
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tolak Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="form-text text-muted">Alasan Penolakan
                                            :</label>
                                        <input name="alasan" type="text" class="form-control"
                                            placeholder="Masukan Alasan Penolakan" value="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="status" value="3">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
