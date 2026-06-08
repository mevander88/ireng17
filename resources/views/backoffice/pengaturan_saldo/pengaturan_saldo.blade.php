@extends('backoffice.layouts.main')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            Pengaturan saldo dan bonus member
        </div>
        <div class="card-body">
            <form method="GET" action="{{ URL::to('/pengaturan_saldo') }}" class="admin-filter-bar">
                <div class="admin-filter-fields">
                    <label for="search-saldo">Cari Saldo</label>
                    <input type="search" class="form-control" id="search-saldo" name="search"
                        value="{{ $src }}" placeholder="Username, email, atau no telp">
                </div>
                <div class="admin-filter-actions">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                    @if (!empty($src))
                        <a href="{{ URL::to('/pengaturan_saldo') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Saldo</th>
                            <th>Bonus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($saldo as $item)
                            <tr>
                                <td>{{ $saldo->firstItem() + $loop->index }}</td>
                                <td>{{ $item->name ?? $item->user_name }}</td>
                                <td>{{ $item->email ?? '-' }}</td>
                                <td>{{ $item->telp ?? '-' }}</td>
                                <td>@currency($item->saldo)</td>
                                <td>@currency($item->bonus)</td>
                                <td class="admin-action-cell">
                                    <button data-id="{{ $item->id }}" data-username="{{ $item->name ?? $item->user_name }}"
                                        type="button" class="btn btn-success btn-ubah-saldo">Saldo</button>
                                    <button data-id="{{ $item->id }}" data-username="{{ $item->name ?? $item->user_name }}"
                                        type="button" class="btn btn-warning btn-ubah-bonus">Bonus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Data saldo tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="admin-pagination">
                {{ $saldo->links() }}
            </div>
        </div>
    </div>

    <div class="modal-area">
        <div class="modal fade" id="saldo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/pengaturan_saldo/{{ $id }}" class="form-saldo" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ubah Saldo Dari
                                <b class="data-username"></b>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Type</label>
                                <select class="form-control" name="type" required>
                                    <option disabled selected value="">Pilih Type</option>
                                    <option value="1"> Tambah Saldo </option>
                                    <option value="2"> Kurangi Saldo </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nominal</label>
                                <input type="number" class="form-control" name="nominal" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Ubah Saldo </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ubah_bonus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-saldo" method="POST">
                        {{ csrf_field() }}
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ubah Bonus Dari
                                <b class="data-username"></b>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Type</label>
                                <select class="form-control" name="type" required>
                                    <option disabled selected value="">Pilih Type</option>
                                    <option value="3"> Tambah Bonus </option>
                                    <option value="4"> Kurangi Bonus </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nominal</label>
                                <input type="number" class="form-control" name="nominal" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Ubah Bonus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            const url = {
                saldo: '{{ URL::to('pengaturan_saldo') }}'
            };

            $(document).on('click', '.btn-ubah-saldo', function(e) {
                $('#saldo').modal('show');
                const id = $(this).attr('data-id');

                $('.data-username').text($(this).attr('data-username') || '');
                $('.form-saldo').attr('action', url.saldo + '/' + id);
            });

            $(document).on('click', '.btn-ubah-bonus', function(e) {
                $('#ubah_bonus').modal('show');
                const id = $(this).attr('data-id');

                $('.data-username').text($(this).attr('data-username') || '');
                $('.form-saldo').attr('action', url.saldo + '/' + id);
            });
        });
    </script>
@endsection
