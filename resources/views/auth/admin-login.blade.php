<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting->nama_web ?? 'ireng17' }} - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('Admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/css/ireng-admin.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box d-flex align-items-center">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                @if (!empty($setting->logo))
                    <img src="{{ asset('storage/' . $setting->logo) }}" width="200" alt="{{ $setting->nama_web ?? 'Admin' }}">
                @else
                    <strong>{{ strtoupper($setting->nama_web ?? 'ireng17') }}</strong>
                @endif
            </div>
            <div class="card-body">
                <p class="login-box-msg">Masuk ke backoffice</p>
                <form action="{{ route('admin.login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Username" value="{{ old('name') }}" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('Admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('Admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.sitestatic.net/assets/jquery/sweet_alert2.min.js"></script>
    @include('components.alert-popup')
</body>

</html>
