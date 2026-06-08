@extends('backoffice.layouts.main')

@section('content')
    <div class="pt-3">
        <button data-toggle="modal" data-target="#tambah" type="button" class="btn btn-success">Bonus Baru</button>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Ups!</strong> Gagal update.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card mt-3">
        <div class="card-header">
            Bonus
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $i = ($bonus->currentpage() - 1) * $bonus->perpage() + 1; ?>
                    @foreach ($bonus as $item)
                        <tr>
                            <td style="width:50px">{{ $i++ }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>{{ $item->nominal . ' %' }}</td>
                         
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Off</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status == 1)
                                    <button data-toggle="modal" data-target="#non{{ $item->id }}" type="button"
                                        class="btn btn-danger">Non-Aktifkan</button>
                                @else
                                    <button data-toggle="modal" data-target="#aktif{{ $item->id }}" type="button"
                                        class="btn btn-primary">Aktifkan</button>
                                @endif
                                <div class="modal fade" id="non{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modaleditstatusnonactive" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('bonus.update', $item->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modaleditstatusnonactive">Nonaktifkan Data
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin akan menonaktifkan data ?
                                                </div>
                                                <input type="hidden" name="status" value="2">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="aktif{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modaleditstatusactive" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('bonus.update', $item->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modaleditstatusactive">Aktifkan Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin akan mengaktifkan data ?
                                                </div>

                                                <input type="hidden" name="status" value="1">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Aktifkan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <button data-toggle="modal" data-target="#ubah{{ $item->id }}" type="button"
                                    class="btn btn-warning">Ubah Data</button>
                                <div class="modal fade" id="ubah{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modaledit" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            @if ($message = Session::get('error'))
                                                <div class="alert alert-error">
                                                    <p>{{ $message }}</p>
                                                </div>
                                            @endif
                                            <form action="{{ route('bonus.update', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modaledit">Ubah Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="judul">Judul</label>
                                                        <input type="text" class="form-control" name="judul"
                                                            value="{{ $item->judul }}" id="judul">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="keterangan">Keterangan</label>
                                                        <input type="text" class="form-control" name="keterangan"
                                                            value="{{ $item->keterangan }}" id="keterangan">
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="nominal">Nominal</label>
                                                        <input type="number" class="form-control" name="nominal"
                                                            value="{{ $item->nominal }}" id="nominal">
                                                    </div>
                                                    <label for="nominal" class="label">Nominal</label>
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control" name="nominal"
                                                            value="{{ $item->nominal }}" id="nominal"
                                                            aria-label="Sizing example input"
                                                            aria-describedby="inputGroup-sizing-default">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                id="inputGroup-sizing-default">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <button data-toggle="modal" data-target="#hapus{{ $item->id }}" type="button"
                                    class="btn btn-danger">Hapus</button>
                                <div class="modal fade" id="hapus{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modaledit" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('bonus.update', $item->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modaleditstatusactive">Hapus</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin akan menghapus data ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex flex-row justify-content-center mt-3">
                {!! $bonus->links() !!}
            </div>
        </div>

        <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modalBannerBaru"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('bonus.store') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @method('POST')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalBannerBaru">Banner Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control" name="judul" value=""
                                    id="judul">
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" value=""
                                    id="keterangan">
                            </div>
                            {{-- <div class="form-group">
                                <label for="nominal">Nominal</label>
                                <input type="number" class="form-control" name="nominal" value=""
                                    id="nominal">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div> --}}
                            <label for="nominal" class="label">Nominal</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="nominal" value="" id="nominal"
                                    aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="inputGroup-sizing-default">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
