@extends('backoffice.layouts.main')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            Profil Administrator
        </div>
        <div class="card-body">
            <form action="{{ route('profil_admin.update', $user->id) }}"method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-text text-muted">Username :</label>
                            <input name="username" type="text" class="form-control" aria-describedby="emailHelp"
                                placeholder="Username" value="{{ $user->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-text text-muted">Email :</label>
                            <input name="email" type="email" class="form-control" placeholder="Email"
                                value="{{ $user->email }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-text text-muted">No Telepon :</label>
                            <input name="telp" type="text" class="form-control" value="{{ $user->telp }}"
                                placeholder="No Telepon">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-text text-muted">Jabatan :</label>
                            @if (Auth::user()->id >= 1)
                                @php
                                    $jabatan = 'developer';
                                @endphp
                            @else
                                @php
                                    $jabatan = 'admin';
                                @endphp
                            @endif
                            <input type="text" class="form-control" value="{{ $jabatan }}" placeholder="Jabatan"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-6">
                        <!-- <div class="form-group">
                            <label class="form-text text-muted">Photo :</label>
                            <input name="photo" type="file" class="form-control uploads" value=""
                                accept="image/png, image/jpg, image/jpeg">
                        </div> -->
                    </div>
                    <div class="col-6">

                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
