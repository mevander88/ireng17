<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran {{ $setting->nama_web ?? 'Website' }}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<style>
body { margin:0; padding:20px; font-family:Arial,sans-serif; background-color:#f8f9fa; display:flex; justify-content:center; align-items:center; min-height:100vh; }
.card { background:#fff; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); width:100%; max-width:480px; overflow:hidden; }
.card-header { background:#f1f1f1; padding:15px; border-bottom:1px solid #e9ecef; }
.card-title { margin:0; font-size:1.25rem; font-weight:600; }
.card-body { padding:15px; }
.text-center { text-align:center; }
.qr-box { display:flex; justify-content:center; align-items:center; flex-direction:column; margin-top:10px; }
#countdown { font-weight:bold; color:#dc3545; margin-top:10px; }
pre { background:#eee; padding:10px; border-radius:5px; overflow:auto; max-height:200px; }
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=Montserrat:wght@700;800&display=swap">
<link rel="stylesheet" href="{{ asset('assets/css/boray-midnight.css') }}">
</head>
<body>

<div class="card shadow-lg">
    <div class="card-header">
        <h5 class="card-title">Pembayaran {{ $setting->nama_web ?? 'Website' }}</h5>
    </div>

    <div class="card-body">
        <div class="form-group">
            <label>Metode Pembayaran</label>
            <input value="JayaPay Otomatis (QRIS)" class="form-control" disabled>
        </div>
        <div class="form-group">
            <label>Jumlah Bayar</label>
            <input type="text" class="form-control" disabled
                value="{{ $nominal ? 'Rp ' . number_format($nominal,0,',','.') : 'Rp 0' }}">
        </div>

        @if(!empty($payQRIS))
            <div class="qr-box">
                @if(Str::endsWith($payQRIS, ['.png', '.jpg', '.jpeg']))
                    <img src="{{ $payQRIS }}" alt="QRIS" height="230">
                @else
                    <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($payQRIS) }}&size=230x230" alt="QRIS">
                @endif
                <small>Silakan scan QR untuk melakukan pembayaran</small>
            </div>
        @else
            <div style="color:red; font-weight:bold;">QRIS / Link pembayaran tidak tersedia</div>
            <pre>{{ json_encode($response ?? [], JSON_PRETTY_PRINT) }}</pre>
        @endif

        <div id="countdown">Batas waktu pembayaran: <span id="timer">15:00</span></div>

        <div style="margin-top:20px; text-align:center;">
            <button id="confirm-btn" class="btn btn-primary">Cek Status Pembayaran</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let remainingTime = 15*60;
function updateCountdown() {
    let minutes = Math.floor(remainingTime/60);
    let seconds = remainingTime%60;
    document.getElementById('timer').textContent =
        `${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
    if(remainingTime<=0){ clearInterval(countdownInterval); alert('Waktu pembayaran habis. Silakan buat pesanan baru.'); window.location.href="{{ url('/') }}"; }
    remainingTime--;
}
const countdownInterval = setInterval(updateCountdown, 1000);

function checkPaymentStatus(auto=false){
    $.ajax({
        url:"{{ route('status.payment') }}",
        type:'GET',
        success:function(resp){
            if(resp.success){
                clearInterval(countdownInterval);
                alert(resp.success);
                $('#confirm-btn').prop('disabled', true);
                window.location.href='/';
            } else if(auto && resp.info){ console.log('Status:', resp.info); }
            else if(!auto && resp.info){ alert(resp.info); }
        },
        error:function(){ if(!auto) alert('Terjadi kesalahan, silakan coba lagi.'); }
    });
}
$('#confirm-btn').click(()=>checkPaymentStatus(false));
setInterval(()=>checkPaymentStatus(true), 10000);
</script>
</body>
</html>
