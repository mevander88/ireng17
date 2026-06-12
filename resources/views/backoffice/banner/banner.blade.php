@extends('backoffice.layouts.main')

@section('content')
    @if (session('success') || session('error'))
        <div class="pt-3">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Banner belum bisa disimpan.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-header">
            Banner Halaman Utama
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                @if (($activeBannerCount ?? 0) > 0)
                    Homepage memakai {{ $activeBannerCount }} banner aktif dari data backoffice di bawah.
                @else
                    Homepage sedang memakai fallback banner statis dari <code>public/assets/images/home-banners</code>
                    karena belum ada banner aktif di backoffice.
                @endif
            </div>

            @if (($activeBannerCount ?? 0) === 0 && !empty($staticBanners))
                <div class="mb-3">
                    <div class="text-muted mb-2">Fallback banner yang sedang tampil:</div>
                    <div class="row">
                        @foreach ($staticBanners as $staticBanner)
                            <div class="col-6 col-md-3 mb-3">
                                <div class="border rounded p-2 h-100">
                                    <img src="{{ $staticBanner['url'] }}" alt="{{ $staticBanner['name'] }}"
                                        class="img-fluid rounded">
                                    <small class="d-block text-muted mt-2 text-truncate">{{ $staticBanner['name'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <button data-toggle="modal" data-target="#tambah_banner" type="button" class="btn btn-primary">Tambah
                        Banner</button>
                    <div class="modal fade" id="tambah_banner" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ URL::to('banner') }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Banner</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="form-text text-muted">Judul
                                                        :</label>
                                                    <input name="nama" type="text" class="form-control"
                                                        placeholder="Judul Banner" value="">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="form-text text-muted">Gambar
                                                        Banner :</label>
                                                    <input name="gambar" type="file" class="form-control uploads"
                                                        accept="image/png, image/jpg, image/jpeg, image/webp, image/gif">
                                                    <small class="form-text text-muted">
                                                        Rekomendasi rasio lebar, misalnya 1920x520. Format JPG, PNG, WEBP,
                                                        atau GIF.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="status" value="1">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($banner as $item)
                        <tr>
                            <td>{{ $banner->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                @if (!empty($item->gambar))
                                    <img src="{{ asset('storage/' . $item->gambar) }}" style="max-width:180px;width:100%"
                                        alt="Banner {{ $item->nama }}" loading="lazy">
                                    <small class="d-block text-muted mt-1">{{ $item->gambar }}</small>
                                @else
                                    <span class="text-muted">Belum ada gambar</span>
                                @endif
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
                                        class="btn btn-dark"><i class="fas fa-eye-slash"></i></button>
                                @else
                                    <button data-toggle="modal" data-target="#aktif{{ $item->id }}" type="button"
                                        class="btn btn-primary"><i class="fas fa-eye"></i></button>
                                @endif
                                <button data-toggle="modal" data-target="#ubah_banner{{ $item->id }}" type="button"
                                    class="btn btn-warning"><i class="fas fa-pen"></i></button>
                                <button data-toggle="modal" data-target="#hapus_banner{{ $item->id }}" type="button"
                                    class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                            <div class="modal-area">
                                <div class="modal fade" id="non{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('banner.update', $item->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Nonaktifkan Banner</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin akan menonaktifkan banner ?
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
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('banner.update', $item->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Aktifkan Banner</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin akan mengaktifkan banner ?
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

                                <div class="modal fade" id="hapus_banner{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('banner.destroy', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Banner</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin akan manghapus banner ?
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

                                <div class="modal fade" id="ubah_banner{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('banner.update', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Banner</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlInput1">Judul</label>
                                                        <input type="text" class="form-control" name="nama"
                                                            value="{{ $item->nama }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlInput1">Gambar Banner</label>
                                                        <input type="file" class="form-control uploads" name="gambar"
                                                            accept="image/png, image/jpg, image/jpeg, image/webp, image/gif">
                                                        @if (!empty($item->gambar))
                                                            <div class="mt-3">
                                                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                                                    alt="Banner {{ $item->nama }}"
                                                                    style="max-width:220px;width:100%">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-warning">Ubah Data</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Banner belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="admin-pagination">
                {{ $banner->links() }}
            </div>
        </div>
    </div>

@endsection
