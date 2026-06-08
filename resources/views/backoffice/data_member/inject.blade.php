<?php
use App\Http\Api\fiver;
?>
@extends('backoffice.layouts.main')
@section('content')
    <div class="card mt-3">
        <div class="card-header">
            Data Member
        </div>
        <div class="card-body">
            @include('backoffice.layouts.msg_bar')
            <form method="GET" action="{{ URL::to('/inject-saldo') }}" class="admin-filter-bar">
                <div class="admin-filter-fields">
                    <label for="search-inject">Cari Member</label>
                    <input type="search" class="form-control" id="search-inject" name="search"
                        value="{{ $search ?? '' }}" placeholder="Username, email, no WA, ref, rekening">
                </div>
                <div class="admin-filter-actions">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                    @if (!empty($search))
                        <a href="{{ URL::to('/inject-saldo') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Username</th>
                            <th>Ref</th>
                            <th>Saldo</th>
                            <th>Email</th>
                            <th>No WA</th>
                            <th>Bank</th>
                            <th>Nama Rekening</th>
                            <th>Nomor Rekening</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user as $member)
                            <?php
                            $saldo = isset($member->saldo[0]) ? $member->saldo[0]->saldo : 0;
                            ?>
                            <tr>
                                <td>{{ $user->firstItem() + $loop->index }}</td>
                                <td>{{ $member->updated_at }} </td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->ref_code }}</td>
                                <td>{{ number_format($saldo) }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->telp }}</td>
                                <td>{{ $member->bank ?? '' }}</td>
                                <td>{{ $member->nama_rek }}</td>
                                <td>{{ $member->no_rek }}</td>
                                <td>
                                    <button data-toggle="modal" data-target="#ubah{{ $member->id }}" type="button"
                                        class="btn btn-primary btn-inject-saldo"><i class="fas fa-pen"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">Data member tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="admin-pagination">
                {{ $user->links() }}
            </div>
        </div>
    </div>

    <div class="inject-saldo-modals">
        @foreach ($user as $member)
            <?php
            $saldo = isset($member->saldo[0]) ? $member->saldo[0]->saldo : 0;
            ?>
            <div class="modal fade inject-saldo-modal" id="ubah{{ $member->id }}" tabindex="-1" role="dialog"
                aria-labelledby="modaledit{{ $member->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{ route('saldo.update', $member->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="modaledit{{ $member->id }}">Inject Saldo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name{{ $member->id }}">Username</label>
                                    <input type="text" class="form-control" id="name{{ $member->id }}" name="name"
                                        value="{{ $member->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="saldo{{ $member->id }}">Nominal</label>
                                    <input type="number" min="1" step="1" class="form-control"
                                        id="saldo{{ $member->id }}" name="saldo" value="{{ $saldo }}">
                                    <small class="text-muted">Isi nominal yang ingin ditambah atau ditarik.</small>
                                </div>
                                <div class="form-group">
                                    <label for="action{{ $member->id }}">Tindakan</label>
                                    <select class="form-control" id="action{{ $member->id }}" name="action" required>
                                        <option value="" selected disabled>-- Pilih Tindakan --</option>
                                        <option value="deposit">Tambah Saldo</option>
                                        <option value="withdraw">Tarik Saldo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
