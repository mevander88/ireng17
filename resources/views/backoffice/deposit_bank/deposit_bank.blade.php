@extends('backoffice.layouts.main')

@section('content')
<div class="pt-3">
    <button data-toggle="modal" data-target="#tambahBankModal" type="button" class="btn btn-primary btn-add">
        <i class="fa fa-bank"></i> Tambah Akun Bank
    </button>
</div>

<div class="card mt-3">
    <div class="card-header">
        Daftar Bank & E-Wallet
    </div>
    <div class="card-body">
        <form method="GET" action="{{ URL::to('/deposit_bank') }}" class="admin-filter-bar">
            <div class="admin-filter-fields">
                <label for="search-bank">Cari Payment</label>
                <input type="search" class="form-control" id="search-bank" name="search"
                    value="{{ $search ?? '' }}" placeholder="Nama bank, penerima, atau nomor rekening">
            </div>
            <div class="admin-filter-actions">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                @if (!empty($search))
                    <a href="{{ URL::to('/deposit_bank') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Logo</th>
                        <th>Nama Bank/E-Wallet</th>
                        <th>Nama Rekening/E-Wallet</th>
                        <th>Nomor Rekening/E-Wallet</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bank as $item)
                        <tr>
                            <td>{{ $bank->firstItem() + $loop->index }}</td>
                            <td>
                                @if ($item->logo)
                                    <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo {{ $item->nama_bank }}"
                                        class="admin-bank-logo">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->nama_bank }}</td>
                            <td>{{ $item->nama_penerima }}</td>
                            <td>{{ $item->no_rek }}</td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Off</span>
                                @endif
                            </td>
                            <td class="admin-action-cell">
                                @if ($item->status == 1)
                                    <button data-toggle="modal" data-target="#non{{ $item->id }}" type="button"
                                        class="btn btn-success"><i class="fa fa-toggle-on"></i></button>
                                @else
                                    <button data-toggle="modal" data-target="#aktif{{ $item->id }}" type="button"
                                        class="btn btn-danger"><i class="fa fa-toggle-off"></i></button>
                                @endif
                                <button data-toggle="modal" data-target="#ubah{{ $item->id }}" type="button"
                                    class="btn btn-primary"><i class="fas fa-pen"></i></button>
                                <button data-toggle="modal" data-target="#hapusBank{{ $item->id }}" type="button"
                                    class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Data payment tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="admin-pagination">
            {{ $bank->links() }}
        </div>
    </div>
</div>

@include('backoffice.component.addBank')

@foreach ($bank as $item)
    <div class="modal fade" id="hapusBank{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="hapusBankLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('bank.destroy', $item->id) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapusBankLabel{{ $item->id }}">Hapus Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin akan menghapus data payment ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="non{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="nonBankLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/deposit_bank/{{ $item->id }}" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="nonBankLabel{{ $item->id }}">Nonaktifkan Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin akan menonaktifkan data ini?
                    </div>
                    <input type="hidden" name="status" value="2">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="aktif{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="aktifBankLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/deposit_bank/{{ $item->id }}" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="aktifBankLabel{{ $item->id }}">Aktifkan Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin akan mengaktifkan data ini?
                    </div>
                    <input type="hidden" name="status" value="1">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Aktifkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('backoffice.component.updateBank')
@endforeach
@endsection
