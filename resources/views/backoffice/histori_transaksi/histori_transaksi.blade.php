@extends('backoffice.layouts.main')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            Histori Transaksi
        </div>
        <div class="card-body">
            <form method="GET" action="{{ URL::to('/histori_transaksi') }}" class="admin-filter-bar">
                <div class="admin-filter-fields">
                    <label for="search-history">Cari Transaksi</label>
                    <input type="search" class="form-control" id="search-history" name="search"
                        value="{{ $search ?? '' }}" placeholder="Username, keterangan, atau alasan">
                </div>
                <div class="admin-filter-fields admin-filter-inline">
                    <label for="type-history">Type</label>
                    <select class="form-control" id="type-history" name="type">
                        <option value="">Semua</option>
                        <option value="1" {{ (string) ($type ?? '') === '1' ? 'selected' : '' }}>Deposit</option>
                        <option value="2" {{ (string) ($type ?? '') === '2' ? 'selected' : '' }}>Withdraw</option>
                    </select>
                </div>
                <div class="admin-filter-fields admin-filter-inline">
                    <label for="status-history">Status</label>
                    <select class="form-control" id="status-history" name="status">
                        <option value="">Semua</option>
                        <option value="1" {{ (string) ($status ?? '') === '1' ? 'selected' : '' }}>Progress</option>
                        <option value="2" {{ (string) ($status ?? '') === '2' ? 'selected' : '' }}>Sukses</option>
                        <option value="3" {{ (string) ($status ?? '') === '3' ? 'selected' : '' }}>Gagal</option>
                    </select>
                </div>
                <div class="admin-filter-actions">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                    @if (!empty($search) || !empty($type) || !empty($status))
                        <a href="{{ URL::to('/histori_transaksi') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Username</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Type</th>
                            <th scope="col">Nominal</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi as $item)
                            <tr>
                                <td>{{ $transaksi->firstItem() + $loop->index }}</td>
                                <td>{{ $item->user_name }} </td>
                                <td>{{ $item->created_at }} </td>
                                <td>{{ $item->type == 1 ? 'Deposit' : 'Withdraw' }}</td>
                                <td>
                                    @if ($item->status == 3)
                                        <strike>@currency($item->nominal)</strike>
                                    @else
                                        @currency($item->nominal)
                                    @endif
                                </td>
                                <td>
                                    @if ($item->type == 1)
                                        @if ($item->qris_url)
                                            <span>Deposit QRIS</span>
                                        @else
                                            {{ $item->Bank->nama_bank ?? 'Deposit manual' }}
                                        @endif
                                        @if ($item->alasan)
                                            <span class="text-danger">{{ $item->alasan }}</span>
                                        @endif
                                    @else
                                        {{ $item->keterangan }}
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status == 1)
                                        <span class="badge badge-warning">Progress</span>
                                    @elseif ($item->status == 2)
                                        <span class="badge badge-success">Sukses</span>
                                    @else
                                        <span class="badge badge-danger">Gagal</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Histori transaksi tidak ditemukan.</td>
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
@endsection
