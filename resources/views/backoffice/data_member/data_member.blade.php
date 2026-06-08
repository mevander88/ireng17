@extends('backoffice.layouts.main')
@section('content')
<div class="pt-3">
    <button data-toggle="modal" data-target="#tambah" type="button" class="btn btn-success btn-add"><i
            class="fa fa-plus"></i> Member Baru</button>
</div>
<div class="card mt-3">
    <div class="card-header">
        Data Member
    </div>
    <div class="card-body">
        @include('backoffice.layouts.msg_bar')
        <form method="GET" action="{{ URL::to('/data_member') }}" class="admin-filter-bar">
            <div class="admin-filter-fields">
                <label for="search-member">Cari Member</label>
                <input type="search" class="form-control" id="search-member" name="search"
                    value="{{ $search ?? '' }}" placeholder="Username, email, no WA, ref, rekening">
            </div>
            <div class="admin-filter-actions">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                @if (!empty($search))
                    <a href="{{ URL::to('/data_member') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Ref</th>
                        <th>Saldo</th>
                        <th>Email</th>
                        <th>No WA</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_member as $item)
                    <?php
                    $saldo = isset($item->saldo[0]) ? $item->saldo[0]->saldo : 0;
                    $bonus = isset($item->saldo[0]) ? $item->saldo[0]->bonus : 0;
                    ?>
                    <tr>
                        <td>{{ $data_member->firstItem() + $loop->index }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->ref_code }}</td>
                        <td>Rp. {{ number_format($saldo) }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telp }}</td>

                        <td>
                            <button data-toggle="modal" data-target="#update-{{ $item->id }}" type="button" class="btn btn-primary">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button data-toggle="modal" data-target="#delete{{ $item->id }}"
                                data-member="{{ json_encode($item) }}" type="button"
                                class="btn btn-danger btn-ubah"><i class="fas fa-trash"></i></button>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Data member tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="admin-pagination">
            {{ $data_member->links() }}
        </div>
    </div>
</div>
@foreach ($data_member as $item)
    <div class="modal fade" id="delete{{ $item->id }}" tabindex="-1"
        role="dialog" aria-labelledby="deleteMember{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('data_member.destroy', $item->id) }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteMember{{ $item->id }}">Hapus Data Member</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin akan menghapus data member?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@include('backoffice.component.addMember')
@include('backoffice.component.updateMember')

@endsection
