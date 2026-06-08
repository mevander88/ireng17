@extends('layouts.ggr')

@section('title', 'Verifikasi Email')

@section('content')
    <section class="ggr-section ggr-auth-section">
        <div class="ggr-auth-shell">
            <div class="ggr-auth-copy">
                <span class="ggr-eyebrow">Akun ireng17</span>
                <h1>Verifikasi email</h1>
                <p>Cek email akun untuk membuka tautan verifikasi.</p>
            </div>

            <div class="ggr-account-panel ggr-auth-card">
                <div class="ggr-section-heading">
                    <div>
                        <span class="ggr-eyebrow">Email</span>
                        <h2>Butuh Link Baru?</h2>
                    </div>
                </div>

                @if (session('resent'))
                    <div class="ggr-alert is-success">Link verifikasi baru sudah dikirim ke email.</div>
                @endif

                <p class="ggr-muted">Jika email belum masuk, kirim ulang link verifikasi dari tombol di bawah.</p>

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="ggr-btn ggr-btn-primary">Kirim Ulang</button>
                </form>
            </div>
        </div>
    </section>
@endsection
