<?php
use App\Models\Setting;

$setting = Setting::first();
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $setting->nama_web ?? config('app.name', 'Boray') }}</title>
    @if (!empty($setting?->logo))
        <link rel="icon" type="image" href="{{ asset('storage/' . $setting->logo) }}">
    @endif
    <link rel="stylesheet" href="{{ asset('Admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/dist/css/adminlte.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=Montserrat:wght@700;800&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/css/boray-midnight.css') }}">
</head>

<body class="mobile auth-shell">
    <main class="auth-main">
        <div class="auth-brand">
            <a href="{{ URL::to('/') }}" aria-label="{{ $setting->nama_web ?? 'Beranda' }}">
                @if (!empty($setting?->logo))
                    <img alt="{{ $setting->nama_web ?? 'Logo' }}" src="{{ asset('storage/' . $setting->logo) }}">
                @else
                    <span>{{ $setting->nama_web ?? config('app.name', 'Boray') }}</span>
                @endif
            </a>
        </div>

        @yield('content')
    </main>

    <script src="{{ asset('Admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('Admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
