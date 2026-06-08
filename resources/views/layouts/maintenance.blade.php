<?php
use App\Models\Setting;

$setting = Setting::first();
?>
<!DOCTYPE html>
<html lang="id-ID">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <title>Under Maintenance</title>
    @include('content.seo')
    <script src="https://files.wizestatic.cloud/assets/jquery/jquery.min.js"></script>
    <script src="https://files.wizestatic.cloud/assets/bootstrap/bootstrap.min.js"></script>
    <link rel="preload" href="{{ asset('assets/fonts/ugsubskin/icomoon/fonts/icomoon8c13.woff2?h141kb') }}"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/fonts/ugsubskin/icomoon/style.mine67d.css?v=1.3') }}"
        media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('assets/css/ugsports/swiper.css') }}" />
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/css/ugsports/' . $setting->themes . '/app-mobile.css?id=64b3fbce6e7077216803') }}">
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/css/ugsports/' . $setting->themes . '/custom.css?id=495e40951c4898a602f0') }}">
    <link rel="stylesheet" href="https://files.wizestatic.cloud/assets/jquery/jquery-ui.min.css" media="print"
        onload="this.media='all'">
    <script src="https://files.wizestatic.cloud/assets/jquery/jquery-ui.min.js" defer></script>
    <script type="text/javascript" src="https://files.wizestatic.cloud/assets/jquery/jquery.ui.touch-punch.min.js" defer>
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=Montserrat:wght@700;800&display=swap">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/boray-midnight.css') }}">
</head>

<body class="mobile">
    <div class="full-container layout">
        <div class="maintenance-mode">
            <a href="{{ URL::to('/') }}" title="" class="logo">
                <div>
                    <img class="img-fluid" alt="{{ $setting->nama_web }}" src="{{ $setting->logo }}" />
                </div>
            </a>
            <h1>Maintenace</h1>
            <p>Our website is temporarily unavailable due to maintenance. We are working hard to make our
                website
                available soon. Please Check back later or you may leave your contact number for our
                customers support
                to be contacted once the service is resmued.
            </p>
            <p>
                We would like to assure you as our valued players that your details and funds are secure and
                safe with us.
                On behalf of management and team, we sincerely apologise for inconvenience that may have
                caused you and we
                seek for your kind understanding from this temporarily maintenance.
            </p>
            <p>
                Please contact our customers support for any inquiry. <a href="<?php echo $setting->live_chat; ?>">Livechat</a> or
                website.
            </p>
            <br>
            <h1>Peningkatan</h1>
            <p>Situs web kami untuk sementara tidak tersedia karena peningkatan. Kami bekerja keras untuk
                membuat website kami
                segera tersedia. Silakan Periksa kembali nanti atau Anda dapat meninggalkan nomor kontak
                Anda untuk dukungan
                pelanggan kami
                untuk dihubungi setelah layanan dilanjutkan.
            </p>
            <p>
                Kami ingin meyakinkan Anda sebagai pemain kami yang berharga bahwa detail dan dana Anda aman
                dan aman bersama
                kami.
                Atas nama manajemen dan tim, kami dengan tulus meminta maaf atas ketidaknyamanan yang
                mungkin ditimbulkan oleh
                Anda dan kami
                mohon pengertian Anda dari pemeliharaan sementara ini.
            </p>
            <p>
                Silakan hubungi dukungan pelanggan kami untuk pertanyaan apa pun. <a
                    href="<?php echo $setting->live_chat; ?>">Livechat</a> atau situs web.
            </p>
        </div>




</body>

</html>
