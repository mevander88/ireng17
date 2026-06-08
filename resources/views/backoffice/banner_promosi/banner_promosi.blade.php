@extends('backoffice.layouts.main')

@section('content')
    <div class="pt-3">
        <button data-toggle="modal" data-target="#tambah" type="button" class="btn btn-success">Tambah Banner</button>
    </div>
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modalBannerBaru" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('banner_promosi.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" value="" id="nama">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" value="" id="deskripsi" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="batas_waktu">Batas Waktu</label>
                            <input type="datetime-local" class="form-control" name="batas_waktu" id="batas_waktu"
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option>All</option>
                                <option value="khusus">Khusus</option>
                                <option value="sports">Sports</option>
                                <option value="slots">Slots</option>
                                <option value="casino">Casino</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar Banner</label>
                            <input type="file" class="form-control-file" name="gambar" value="" id="gambar"
                                accept="image/png, image/jpg, image/jpeg, image/webp">
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
            Banner Promosi
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Batas Waktu</th>
                        <th>Kategori</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = ($banner_promosi->currentpage() - 1) * $banner_promosi->perpage() + 1; ?>
                    @foreach ($banner_promosi as $item)
                        <tr>
                            <td style="width:50px">{{ $i++ }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>{{ $item->batas_waktu }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>
                                <img alt="" src="{{ asset('storage/' . $item->gambar) }}" style="max-width:150px" />
                            </td>
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
                                        class="btn btn-success"><i class="fa fa-toggle-off"></i></button>
                                @else
                                    <button data-toggle="modal" data-target="#aktif{{ $item->id }}" type="button"
                                        class="btn btn-warning"><i class="fa fa-toggle-on"></i></button>
                                @endif
                                <button data-toggle="modal" data-target="#ubah{{ $item->id }}" type="button"
                                    class="btn btn-primary"><i class="fas fa-pen"></i></button>
                                <button data-toggle="modal" data-target="#hapus{{ $item->id }}" type="button"
                                    class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                            <div class="modal-area">
                                <div class="modal fade" id="non{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modaleditstatusnonactive" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('banner_promosi.update', $item->id) }}"
                                                method="POST">
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
                                            <form action="{{ route('banner_promosi.update', $item->id) }}"
                                                method="POST">
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
                                <div class="modal fade" id="ubah{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modaledit" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            @if ($message = Session::get('error'))
                                                <div class="alert alert-error">
                                                    <p>{{ $message }}</p>
                                                </div>
                                            @endif
                                            <form action="{{ route('banner_promosi.update', $item->id) }}" method="POST"
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
                                                        <label for="nama">Nama</label>
                                                        <input type="text" class="form-control" name="nama"
                                                            value="{{ $item->nama }}" id="nama">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="deskripsi">Deskripsi</label>
                                                        <textarea class="form-control" name="deskripsi" value="{{ $item->deskripsi }}" id="deskripsi" rows="5"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="batas_waktu">Batas Waktu</label>
                                                        <input type="datetime-local" class="form-control"
                                                            name="batas_waktu" id="batas_waktu"
                                                            value="{{ $item->batas_waktu }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="kategori">Kategori</label>
                                                        <select class="form-control" id="kategori" name="kategori">
                                                            <option>All</option>
                                                            <option value="khusus"
                                                                {{ $item->kategori == 'khusus' ? 'selected' : '' }}>Khusus
                                                            </option>
                                                            <option value="sports"
                                                                {{ $item->kategori == 'sports' ? 'selected' : '' }}>Sports
                                                            </option>
                                                            <option value="slots"
                                                                {{ $item->kategori == 'slots' ? 'selected' : '' }}>Slots
                                                            </option>
                                                            <option value="casino"
                                                                {{ $item->kategori == 'casino' ? 'selected' : '' }}>Casino
                                                            </option>
                                                            <option value="others"
                                                                {{ $item->kategori == 'others' ? 'selected' : '' }}>Others
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="gambar">Gambar Banner</label>
                                                        <input type="file" class="form-control-file" name="gambar"
                                                            value="{{ $item->gambar }}" id="gambar">
                                                        <div class="mt-3">
                                                            <img alt="" src="{{ asset('storage/' . $item['gambar']) }}"
                                                                style="max-width:150px" />
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
                                <div class="modal fade" id="hapus{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modaledit" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('banner_promosi.update', $item->id) }}"
                                                method="POST">
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
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex flex-row justify-content-center mt-3">
                {!! $banner_promosi->links() !!}
            </div>
        </div>
    </div>
@endsection
