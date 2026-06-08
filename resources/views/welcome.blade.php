@extends('layouts.main')
@desktop
@section('desktop')
<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="background: {{$setting->popup_bg}}; border-radius: 15px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="align-content: flex-end"></span>
          </button>
        </div>
        <div class="modal-body text-center">
          <img src="{{ asset('storage/' . $setting->popup) }}" alt="Popup {{ $setting->nama_web }}" class="img-fluid mb-3">
          <p>{!! $setting->msg_popup !!}</p>
        </div>
        <div class="modal-footer" style="text-align:center;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Show the modal when the page loads
        $('#welcomeModal').modal('show');
    });
</script>
<style>
    .slider-size {
        max-height: 500px;
        min-height: 130px;
    }
</style>


<section class="carousel-fixed-height">
    <div id="carousel-fixed-height" class="carousel slide  " data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            @foreach ($banners as $key => $banner)
            <div class="item {{ $key == 0 ? 'active' : '' }}">
                <img class="slider-size home-hero-image" src="{{ asset('storage/' . $banner->gambar) }}"
                    style="display: block; width: 100%; max-height: 500px;  min-height: 130px;"
                    alt="{{ $banner['nama'] }}">
            </div>
            @endforeach
        </div>
        <a class="left carousel-control" href="#carousel-fixed-height" role="button" data-slide="prev">
            <!-- <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> -->
            <span class="icon-wrap">
                <i class="icon-chevron-left icon-prev"></i>
            </span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-fixed-height" role="button" data-slide="next">
            <!-- <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> -->
            <span class="icon-wrap"><i class="icon-arrow_forward_ios icon-next"></i></span>

            <span class="sr-only">Next</span>
        </a>

    </div>
</section>

<div class="container home-jackpot-wrap">
    <div class="jackpot home-jackpot">
        <img class="img-fluid home-jackpot-image" style="width:60%;"
            src="https://files.sitestatic.net/progressive_img/64b9827ed0f47_jp%20okta388.gif" alt="jackpot" />
        <div class="txt-overlay">
            <div class="text-content home-jackpot-text" style="font-size : 2.85em; margin-left: -150px">
                <span id="jackpot_amount"></span>
            </div>
        </div>
    </div>
</div>
<div class="app-wrapper container">
    @include('layouts.desktop.gamerow')
    <div>

        <div class="row home-info-grp" style="padding-top:15px;">
            <div class="col-xs-12 col-md-5 col-lg-5 svc-advantage d-md-pl-0">
                <!--Service advantages -->
                <div class="title-box">
                    <h3 class="u-section-title">
                        KELEBIHAN LAYANAN </h3>
                </div>
                <div class="content-box u-section-box--bg">
                    <div class="row ">
                        <div class=" col-xs-12 col-md-6 d-md-pl-5">
                            <div class="card">
                                <div class="card-header clearfix">
                                    <div class="circle-wrp"><i class="icon-atm"></i> </div>
<div class="text-wrp">
                                        <div class="u-section-title">
                                            DEPOSIT </div>
                                        <div>Waktu rata-rata</div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="text-right fs-md" style="padding-bottom:8px;">
                                        1 Mins </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="10"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                            <span class="sr-only">10% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="   col-xs-12 col-md-6  d-md-pl-5">
                            <div class="card">
                                <div class="card-header clearfix">
                                    <div class="circle-wrp"><i class="icon-coinbag"></i></div>
                                    <div class="text-wrp">
                                        <div class="u-section-title">
                                            WITHDRAW </div>
                                        <div>Waktu rata-rata</div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="text-right fs-md" style="padding-bottom:8px;">
                                        3 Mins </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="30"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                                            <span class="sr-only">30% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="  col-xs-12  mt-3 text-center">
                            <div class="card">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="circle-wrp">
                                            <i class="icon-users2"></i>
                                        </div>
                                        <div>
                                            <div>Pengguna</div>
                                            <div>73857</div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="circle-wrp">
                                            <i class="icon-cash"></i>
                                        </div>
                                        <div>
                                            <div>Jumlah Taruhan</div>
                                            <div>10,839,580 </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="circle-wrp">
                                            <i class="icon-stamp"></i>
</div>
                                        <div>
                                            <div>Online</div>
                                            <div>22157 </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xs-12  col-md-7 col-lg-7 ">
                <div class="row">
                    <div class="col-xs-12  col-md-6 col-lg-6 info-centre d-md-pl-0">
                        <div class="title-box">
                            <h3 class="u-section-title">
                                PUSAT INFO
                            </h3>
                        </div>
                        <div class="content-box u-section-box--bg">
                            <ul>
                                <li>
                                    <div class="text">Cara Bermain SportsBook</div>
                                    <a class="btn btn-link" href="#"> Lebihnya</a>
                                </li>
                                <li>
                                    <div class="text">Cara Bermain Slot</div>
                                    <a class="btn btn-link" href="#"> Lebihnya</a>
                                </li>

                                <li>
                                    <div class="text">Cara Melakukan Deposit</div>
                                    <a class="btn btn-link" href="#"> Lebihnya</a>
                                </li>
                                <li>
                                    <div class="text">Cara Melakukan Withdraw </div>
                                    <a class="btn btn-link" href="#"> Lebihnya</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-6 col-lg-6 member-svc">
                        <div class="title-box">
                            <h3 class="u-section-title">
                                MEMBER SERVICE
                            </h3>
                        </div>
                        <div class="content-box u-section-box--bg">
                            <section class="contacts-carousel">
                                <div id="contacts-carousel" class=" carousel slide  " data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#contacts-carousel" data-slide-to="0" class="active"></li>
                                    </ol>
                                    <div class="carousel-inner" role="listbox">
                                        <div class="item active">
                                            <a target="_blank" rel="noopener noreferrer" href="https://t.me/{{ $setting->tele }}"
                                                class="contact-item">
                                                <div class="icon-wrp"> <i class="icon-telegram"></i> </div>
                                                <div class="text-wrp">
                                                    <div class="u-muted-txt">TELEGRAM</div>
                                                    <div class="">{{ $setting->tele }}</div>
                                                    <div class="u-muted-txt">24/7 Support</div>
                                                </div>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </section>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        if (document.referrer.indexOf(location.protocol + "//" + location.host) === 0 && (!document.referrer
                .includes('__cf'))) {
            sessionStorage.setItem('isClosedPopUp', 'true');
        }
        var isClosedPopUp = sessionStorage.getItem('isClosedPopUp');



        ajax_jackpot();

        setInterval(function() {
            prize += getRandomIntInclusive(3558451, 357585158)
            prize = parseFloat(prize);
            prize = prize;
            $('#jackpot_amount').html(window.currencyCode + ' ' + commaSeparateNumber(prize, true));
            //$('.jackpot_numbers_home').html(IDR  + commaSeparateNumber(prize));
        }, 751);

    });
</script>
</div>
<div class="site-footer">
    <div class="container">
        <div class="footer-content clearfix">
            <br />
            <div>
                <div class="pull-right footerlink">
                    <ul class="clearfix">
                        <li>
                            <div class="copyright">
                                @2024 {{ $setting->nama_web }}. Seluruh hak cipta | 18+ |
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="footerlink">
                    <ul class="clearfix">
                        <li><a href="{{ $setting->live_chat }}" target="_blank" rel="noopener noreferrer">Tentang kami</a></li>
                        <li>|</li>
                        <li><a href="{{ $setting->live_chat }}" target="_blank" rel="noopener noreferrer">Info Perbankan</a></li>
                        <li>|</li>
                        <li><a href="{{ $setting->live_chat }}" target="_blank" rel="noopener noreferrer">Pusat Info</a></li>
                        <li>|</li>
                        <li><a href="{{ $setting->live_chat }}" target="_blank" rel="noopener noreferrer">Hubungi kami</a></li>

                    </ul>
                </div>
            </div>
            <div style="height: 5px; margin-top: 5px;" class="dotted_line"></div>
            <br />
            <div class="footer-desc">
                <!--- check amp or not ------------------------>
                <div class="footer-title  text-center sdf" id="collapsible-footer">
                    <span id="more-txt" class=" ">More &nbsp;Info &nbsp;<i
                            class="i-collapse icon-chevron-thin-down"></i>
                    </span>
                    <span id="less-txt" class=" hide  ">Less&nbsp;Info &nbsp;<i
                            class="i-collapse icon-chevron-thin-up"></i></span>
                </div>
                <div class="footer-body footertext text-justify  hide ">
                    <h2><b>Bandar Judi Online Slot Gacor {{ $setting->nama_web }} Terpercaya dan Terpercaya di
                            Indonesia</b></h2>
                    <p>Begitu banyak pilihan bandar judi online <a
                            href="{{ url('/') }}" target="_blank" rel="noopener noreferrer">slot
                            gacor</a> membuat kalian bingung memilih yang mana? Tidak perlu ragu langsung saja pilih
                        {{ $setting->nama_web }}.
                        Situs yang sudah berpengalaman bertahun-tahun siap melayani kalian semua dengan staff yang sudah
                        terlahir
                        dan profesional. Pelayanan customer 24 jam sehari selalu aktif setiap hari untuk membantu
                        permasalahan
                        yang ada. Berbagai macam permainan dari kasino, sportsbook, slot online sampai togel ada disini
                        jadi semua
                        bisa kalian nikmati tanpa perlu pindah situs.
                    </p>
                    <p>Kalian juga tidak perlu lagi khawatir karena {{ $setting->nama_web }} berlisensi resmi PAGCOR.
Data pribadi
                        kalian
                        dikelola dengan baik tidak akan bocor disimpan dengan enkripsi tingkat tinggi sesuai standar
                        keamanan
                        PAGCOR. Transaksi deposit dan withdraw akan diproses dengan cepat. Pemain juga akan dimanjakan
                        oleh
                        berbagai promo dan bonus bila bermain disini. Baik pemain baru ataupun lama diberikan bonus
                        harian, bonus
                        mingguan dan juga bonus bulanan.  Langsung saja daftarkan diri kalian untuk bergabung dengan <a
                            href="{{ url('/') }}" target="_blank" rel="noopener noreferrer">bandar judi
                            oline</a> slot gacor
                        {{ $setting->nama_web }}.
                        Dibagian atas sebelah kanan situs ini ada tombol untuk pendaftarkan yang bisa kalian klik. Isi
                        data-data
                        yang diminta lalu deposit ke rekening {{ $setting->nama_web }}. Permainan judi seru siap untuk
                        kalian mainkan.
                    </p>
                    <p><br></p>
                    <h2><b>Metode Deposit yang Tersedia di {{ $setting->nama_web }}</b></h2>
                    <p>Kami tentu menyediakan semua metode deposit agar kalian semua merasa nyaman untuk bertransaksi.
                        Berikut
                        metode yang bisa kalian gunakan :</p>
                    <h3><b>Deposit Via Bank</b></h3>
                    <p>Yang paling umum tentunya deposit melalui transfer bank. Kalian bisa melakukan deposit ke
                        rekening yang
                        sudah disediakan oleh {{ $setting->nama_web }}. Menggunakan mesin ATM, mobile banking ataupun
                        internet banking
                        kapan saja
                        dan dimana saja selalu bisa dilakukan.</p>
                    <h3><b>Deposit Via Pulsa</b></h3>
                    <p>Dijaman yang canggih sekarang ini tentunya hampir setiap orang memiliki handphone. Bahkan
                        anak-anak
                        sekarang pun juga sudah pandai menggunakan teknologi ini. Handphone pastinya dilengkapi dengan
                        nomor
                        operator prabayar tertentu (XL, Telkomsel, Tri, Smartfren dan sebagainya) yang diisi pulsa.
                        Dengan pulsa
                        tersebut kalian juga bisa melakukan transaksi deposit ke nomor yang sudah disediakan oleh staff
                        kami.</p>
                    <h3><b>Deposit Via Dompet Digital</b></h3>
                    <p>Semakin majunya teknologi ini sekarang dompet dan uang pun ada dalam bentuk digitalnya. Kalian
                        bisa
                        bertransaksi secara online menggunakan dompet digital. Kami menyediakan metode deposit melalui
                        dompet
                        digital seperti Gopay, Dana, LinkAja dan juga QRIS.</p>
                    <p>Dengan metode yang lengkap seperti ini memudahkan kalian untuk bertransaksi kapan saja dimana
                        saja kalian
                        ingin bermain judi online slot gacor {{ $setting->nama_web }}.</p>
                    <p><br></p>
                    <h2><b>Bonus yang Diberikan Kepada Member {{ $setting->nama_web }}</b></h2>
                    <p>Bergabung dengan bandar judi online slot gacor {{ $setting->nama_web }} pastinya kalian akan
                        mendapatkan bonus.
                        Ingin
                        tahu apa saja bonusnya? Berikut kami rincikan untuk kalian semua</p>
                    <h3><b>Bonus New Member 10K</b></h3>
<p>Dari namanya saja kalian pasti tahu bahwa bonus ini diberikan kepada member yang baru
                        mendaftarkan diri
                        di {{ $setting->nama_web }}. Bonus yang diberikan adalah sebesar sepuluh ribu rupiah.
                        Persyaratkan untuk
                        mendapatkan
                        bonus ini adalah kalian harus melakukan deposit minimal lima puluh ribu rupiah.</p>
                    <h3><b>Bonus Harian 5%</b></h3>
                    <p>Bonus ini bisa kalian klaim setiap hari apabila kalian melakukan deposit minimal seratus ribu
                        dengan
                        maksimal bonus yang bisa diperolah adalah lima ratus ribu rupiah. Untuk bisa melakukan withdraw
                        bonus ini
                        kalian harus mencapai syarat TO (TurnOver) sebesar 5x nilai deposit ditambah nilai bonus.</p>
                    <h3><b>Bonus Cashback</b></h3>
                    <p>Besaran bonus ini berbeda-beda tergantung permainan apa yang kalian mainkan. Untuk permainan
                        sport, live
                        casino dan sabung ayam nilai bonus cashback adalah 5% sedangkan untuk permainan slot dan tembak
                        ikan yaitu
                        10%. Bonus ini akan dibagikan setiap hari Senin.</p>
                    <h3><b>Bonus All Member 10%</b></h3>
                    <p>Terakhir adalah bonus all member 10% yang bisa kalian nikmati bila sudah melakukan deposit
                        minimal lima
                        puluh ribu rupiah dengan maksimal bonus yang bisa didapatkan juga sebesar lima puluh ribu. </p>
                    <p>Bisa kalian lihat bonus yang diberikan memanjakan member baru dan juga member lama.
                        {{ $setting->nama_web }}
                        selalu
                        menjaga kepercayaan pemain judi online gacor Indonesia. 
                    </p>
                    <p><br></p>
                    <h2><b>Pilihan Permainan Judi Gacor {{ $setting->nama_web }} Lengkap</b></h2>
                    <p>{{ $setting->nama_web }} <a href="https://{{ $setting->nama_web }}.top/"
                            target="_blank" rel="noopener noreferrer">bandar terbaik</a> telah
                        bekerjasama dengan
                        berbagai provider slot gacor ternama. Permainan yang ada tentu lengkap dengan ratusan judul bisa
                        kalian
                        mainkan. Ada beberapa permainan slot gacor yang sangat digemari oleh pejudi Indonesia. Sudah
                        tidak asing
                        ditelinga kita semua permainan dari provider Pragmatic Play yaitu Gates of Olympus yang terkenal
                        dengan
                        kakek Zeus. Ada juga permainan Sweet Bonanza dengan permen-permen manis membuat lidah bergoyang.
                        Selain
                        itu permainan dengan tema hewan seperti Koi Gate juga digemari banyak orang. 3 permainan ini
                        digemari
                        karena selain gambarnya yang menarik juga sering memberikan kemenangan pada pejudi. Dengan modal
                        yang
                        kecil mereka bisa meraih kemenangan besar maxwin bahkan juga ada yang mendapatkan jackpot
                        ratusan juta
                        rupiah.</p>
                </div>

            </div>
            <br />
            <div class="footer-misc">
                <div class="row equal" style="justify-content:space-between;">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="title">INFORMASI</div>
                        <div style="height: 5px; margin-top: 15px;" class="dotted_line"></div>
<div class="box-wrapper mt-4">
                            <div class="subtitle">Registrasi</div>
                            <div class="box-content mt-2">Bergabunglah {{ $setting->nama_web }} untuk mengalami
                                permainan yang luar
                                biasa dan
                                menarik. Nikmati kepuasan dengan bonus dan promosi di situs kami.</div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Afiliasi</div>
                            <div class="box-content mt-2">Menjadi mitra kami dengan bergabung dengan afiliasi
                                {{ $setting->nama_web }}. Dapatkan
                                penghasilan dan komisi Anda setiap bulan dengan mengundang teman-teman Anda untuk
                                bermain di
                                {{ $setting->nama_web }}.
                            </div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Game yang bertanggung jawab</div>
                            <div class="box-content mt-2">{{ $setting->nama_web }} menawarkan game online terbaik
                                dengan tanggung
                                jawab penuh dan
                                game fairplay. Keamanan selalu menjadi prioritas kami. </div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Keamanan</div>
                            <div class="box-content mt-2">
                                <div class="box-content mt-2">{{ $setting->nama_web }} menawarkan game online terbaik
                                    dengan tanggung
                                    jawab penuh dan
                                    game fairplay. Keamanan selalu menjadi prioritas kami.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="title">PRODUK</div>
                        <div style="height: 5px; margin-top: 15px;" class="dotted_line"></div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle">Sportsbook & Permainan Langsung</div>
                            <div class="box-content mt-2">Dapatkan ribuan peluang olahraga setiap hari di
                                {{ $setting->nama_web }}.
                                Kemungkinan
                                untuk olahraga paling populer seperti sepak bola, bola basket, tenis, hoki tersedia
                                dengan Permainan
                                Langsung setiap hari.
                            </div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Kasino online</div>
                            <div class="box-content mt-2">{{ $setting->nama_web }} menyediakan permainan kasino online
                                terbaik seperti
                                Baccarat,
                                Blackjack, Roulete, Sic Bo, Poker, dan permainan populer lainnya di kasino online.</div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Live Kasino</div>
                            <div class="box-content mt-2">Main di live casino {{ $setting->nama_web }} dan Anda akan
                                merasakan sensasi
                                kasino yang
                                sebenarnya. Pilih berbagai permainan kasino yang Anda inginkan.</div>
</div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="title">PUSAT INFO</div>
                        <div style="height: 5px; margin-top: 15px;" class="dotted_line"></div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle">Promosi</div>
                            <div class="box-content mt-2">Dapatkan banyak promosi dari {{ $setting->nama_web }}
                                seperti bonus
                                sambutan, bonus
                                setoran, dan diskon tunai. Merasa puas dengan bergabung dalam promosi
                                {{ $setting->nama_web }}.
                            </div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Bantuan</div>
                            <div class="box-content mt-2">Jika Anda memiliki masalah saat bermain Permainan online di
                                {{ $setting->nama_web }},
                                Anda dapat segera menghubungi kami, dan kami selalu siap membantu Anda 24 jam.
                            </div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Metode Transaksi</div>
                            <div class="box-content mt-2">{{ $setting->nama_web }} menyediakan bank lokal dan
                                internasional untuk
                                memudahkan setiap
                                pelanggan untuk melakukan deposit dan penarikan. Metode transaksi dijamin aman, cepat,
                                dan andal.
                            </div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Hubungi kami</div>
                            <div class="box-content mt-2">
                                <div class="box-content mt-2">Anda dapat menghubungi {{ $setting->nama_web }} kapan
                                    saja jika Anda
                                    memiliki
                                    pertanyaan dan masalah. Anda dapat menghubungi kami melalui livechat, telepon,
                                    Skype, atau email.
                                    Staf kami selalu siap 24 jam untuk Anda.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="title">INFO BETTING</div>
                        <div style="height: 5px; margin-top: 15px;" class="dotted_line"></div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle">Hasil Pertandingan Olahraga</div>
                            <div class="box-content mt-2">Hasil lengkap dari Permainan olahraga Anda tersedia di
                                {{ $setting->nama_web }}. Dapatkan
                                hasil terbaru yang Anda mainkan dalam riwayat Anda.
                            </div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Statistik Permainan</div>
                            <div class="box-content mt-2">Akses semua detail Permainan olahraga yang Anda mainkan dan
                                periksa
                                riwayat Permainan secara penuh di {{ $setting->nama_web }}.</div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Permainan olahraga</div>
<div class="box-content mt-2">Permainan pada permainan olahraga, dapatkan rintangan lengkap
                                setiap hari
                                dan rasakan kesenangan dengan sportsbook {{ $setting->nama_web }}.</div>
                        </div>
                        <div class="box-wrapper mt-4">
                            <div class="subtitle ">Permainan Kasino</div>
                            <div class="box-content mt-2">
                                <div class="box-content mt-2">Rasakan kemewahan Permainan kasino, selesaikan riwayat
                                    Permainan lengkap
                                    yang telah Anda mainkan. Per Permainan kasino di {{ $setting->nama_web }}, cepat,
                                    aman, dan
                                    menyenangkan.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="height: 5px; margin-top: 15px;" class="dotted_line"></div>
            <div class="clearfix mt-3">

                <div class="pull-left text-left footerlink">
                    <div class="small small-theme-color">
                        Platform Penyedia Layanan </div>
                    <div class="mt-2 footer_btm_logo_img">
                        <img class="footer_logimg" style="max-height: 50px;" alt="logo"
                            src="{{ asset('storage/' . $setting->logo) }}">
                        {{-- <img class="footer_logimg" style="max-height: 50px;" alt="{{ $setting->nama_web }}"
                        src="https://files.sitestatic.net/ImageFile/638c1476e2626_pagcorweblogolast (3).png"> --}}
                    </div>
                </div>

                <div class="pull-right social-icons">
                    <a href="https://web.facebook.com/profile.php?id=61586703874097" target="_blank" rel="noopener noreferrer" class="button icon circle is-outline facebook"><i
                            class="icon-facebook"></i></a>
                </div>
            </div>
            <div style="height: 5px; margin-top: 15px;" class="dotted_line"></div>
            <div class="clearfix mt-3">
                <div class="row">
                    <div class="col-md-10 col-sm-8">
                        <div class="pull-left text-left footerlink">
                            <div class="small">
                                Cara Pembayaran </div>
                            <div class="payment_imgs mt-2">
                                <img alt="" class="img-fluid" style="width: 150px; border-radius:10px"
                                    src="https://files.sitestatic.net/sprites/bank_logos/bank_col.jpg?v=4">
                                <img alt="" class="img-fluid" style="width: 150px; border-radius:10px"
                                    src="https://files.sitestatic.net/sprites/bank_logos/ewallet_col.jpg?v=4">

                                <img alt="" class="img-fluid" style="width: 150px; border-radius:10px"
                                    src="https://files.sitestatic.net/sprites/bank_logos/pulsa_col.jpg?v=4">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4">
                        <div class="pull-right text-right footerlink">
<div class="small">
                                Browser yang Disarankan </div>
                            <ul class="text-t600 mt-2">
                                <li>
                                    <h2><i class="icon-chrome"></i></h2>
                                </li>
                                <li>
                                    <h2><i class="icon-firefox"></i></h2>
                                </li>
                                <li class="pr-0">
                                    <h2><i class="icon-safari"></i></h2>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix mt-3">
                <div class="pull-left footerlink">
                    <div class="small">
                        Game Provider </div>
                    <div class="footer_pwrd_by_logo">
                        <img alt="" class="img-fluid"
                            src="https://files.sitestatic.net/images/footer_provider_col.png?v=0.3">

                    </div>

                </div>
            </div>

            <br />
            <br />
        </div>
    </div>
</div>
@endsection
<!-- current path here : /-->
<!-- if($Current_URL == '/') -->
@elsedesktop
{{-- IS MOBILE --}}

@section('content')

<div class="modal fade" id="midil" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background: {{$setting->popup_bg}}; border-radius: 15px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="welcomeModalLabel" style="flex-grow: 1; text-align: center;"><strong>Informasi {{$setting->nama_web}}</strong></h3>
                
            </div>
            <div class="modal-body text-center">
                <img alt="" src="{{ asset('storage/' . $setting->popup) }}" alt="Welcome Image" class="img-fluid mb-3">
                <p>{!! $setting->msg_popup !!}</p>
            </div>
            <div class="modal-footer" style="text-align:center;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Show the modal without backdrop (no dark transparent background)
        $('#midil').modal({
            backdrop: false,
            keyboard: true,
            show: true
        });
        
        // Hapus backdrop jika masih muncul (fallback)
        $('#midil').on('shown.bs.modal', function () {
            // Hapus backdrop jika ada
            $('.modal-backdrop').remove();
            // Pastikan body tidak locked
            $('body').removeClass('modal-open');
            $('body').css({
                'overflow': '',
                'padding-right': ''
            });
        });
        
        // Pastikan backdrop dihapus saat modal ditutup
        $('#midil').on('hidden.bs.modal', function () {
            // Hapus backdrop manual jika masih ada
            $('.modal-backdrop').remove();
            // Hapus class modal-open dari body
            $('body').removeClass('modal-open');
            // Reset style overflow dan padding
            $('body').css({
                'overflow': '',
                'padding-right': ''
            });
        });
        
        // Handle close button
        $('#midil .close, #midil [data-dismiss="modal"]').on('click', function(e) {
            e.preventDefault();
            $('#midil').modal('hide');
        });
        
        // Pastikan backdrop dihapus segera setelah modal ditampilkan
        setTimeout(function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css({
                'overflow': '',
                'padding-right': ''
            });
        }, 100);
    });
</script>


<style>
    .slider-size {
        max-height: 500px;
        min-height: 130px;
    }
    
    /* Hilangkan backdrop hitam transparan pada modal mobile */
    #midil + .modal-backdrop,
    .modal-backdrop.fade.in {
        display: none !important;
        opacity: 0 !important;
        background: none !important;
    }
    
    /* Pastikan body tidak locked saat modal terbuka */
    body.modal-open {
        overflow: auto !important;
        padding-right: 0 !important;
    }
</style>
<section class="carousel-fixed-height">
    <div id="carousel-fixed-height" class="carousel slide  " data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            @foreach ($banners as $key => $banner)
            <div class="item {{ $key == 0 ? 'active' : '' }}">
                <img alt="" class="slider-size" src="{{ asset('storage/' . $banner->gambar) }}"
                    style="display: block; width: 100%; max-height: 500px;  min-height: 130px;"
                    alt="{{ $banner['nama'] }}">
            </div>
            @endforeach
        </div>

        <a class="left carousel-control" href="#carousel-fixed-height" role="button" data-slide="prev">
            <!-- <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> -->
            <span class="icon-wrap">
                <i class="icon-chevron-left icon-prev"></i>
            </span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-fixed-height" role="button" data-slide="next">
            <!-- <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> -->
            <span class="icon-wrap"><i class="icon-arrow_forward_ios icon-next"></i></span>

            <span class="sr-only">Next</span>
        </a>

    </div>
</section>
<div class="ann-wrapper" style="padding-left:15px;padding-right:15px;">
    <div class="clearfix pt-2">
        <div class="pull-left pointer">
            <div>
                <i class="icon-megaphone"></i>
            </div>
        </div>
        <div class="ann-content">
            <marquee scrollamount="5">{{ $setting->running_text }}</marquee>
        </div>
    </div>
</div>

<!-- Login Buttons -->
@if (Auth::check())
@else
<div class="btns-log row no-gutters">
    <div class="col-xs-6">
        <button type="button" class="btn btn-tertiery btn-block" id="btnLogin--home">LOGIN</button>
    </div>
    <div class="col-xs-6">
        <a class="btn btn-accent btn-block" href="{{ URL::to('/register') }}">DAFTAR</a>
    </div>

</div>
@endif
<!-- END Login Buttons-->

<!--Shorcut Menu -->

<div class="scroll-wrapper no-gutters" _home>

    <div style="overflow:hidden; " class="scroller">
        <div class="  no-gutters text-center slider-content" #scrollContent>
            <!--//hardcoded links.......-->
            <div class="col">
                <a class="btn-box" href="{{ URL::to('slots') }}">
                    <i class="icon-slot"></i>
                    <div>SLOTS</div>
                    <span class='hot'>HOT</span>
                </a>
            </div>
            <div class="col">
                <a class="btn-box" href="{{ URL::to('sports') }}">
                    <i class="icon-soccer"></i>
                    <div>SPORTS</div>
                </a>
            </div>
            <div class="col">
                <a class="btn-box" href="{{ URL::to('casino') }}">
                    <i class="icon-casino"></i>
                    <div>CASINO</div>
                </a>
            </div>
            <div class="col">
                <a class="btn-box" href="{{ URL::to('p2p') }}">
                    <i class="icon-menu-poker-01"></i>
                    <div>P2P</div>
                </a>
            </div>
            <div class="col">
                <a class="btn-box" href="{{ URL::to('fish-hunter') }}">
                    <i class="icon-fish_hunter"></i>
                    <div>TEMBAK IKAN</div>
                </a>
            </div>
            <div class="col">
                <a class="btn-box" href="{{ URL::to('lottery') }}">
                    <i class="icon-lottery"></i>
                    <div>LOTRE</div>

                    <span class="hot new ">NEW</span>
                </a>
            </div>
            <div class="col">
                <a class="btn-box" href="{{ URL::to('e-games') }}">
                    <i class="icon-others"></i>
                    <div>E-GAMES</div>
                </a>
            </div>
            <div class="col">
                <a class="btn-box" href="{{ URL::to('cockfight') }}">
                    <i class="icon-cockfight"></i>
                    <div>SABUNG AYAM</div>
                </a>
            </div>
        </div>
    </div>

</div>
<br>
<div class="home-mobile-jackpot-band">
    <div class="jackpot home-jackpot" style="position: relative; display: inline-block; margin-left: 20px; margin-right: 20px;">
        <img class="img-fluid home-jackpot-image" style="width:100%;"
            src="https://files.sitestatic.net/progressive_img/64b9827ed0f47_jp%20okta388.gif" alt="jackpot" />
        <div class="txt-overlay">
            <div class="text-content mt-2 home-jackpot-text" style="font-size : 1.7em; margin-right: 50px">
                <span id="jackpot_amount">9.321.332</span>
            </div>
        </div>
    </div>
</div>
<br>


<div class="app-wrapper container">
    
    
    <div class="card">
        @include('content.provider')
    </div>
    <hr>
    {{-- <hr> --}}
    <!--Onix game-->
    <div class="card">
        @include('content.gameNew')
    <hr>
    </div>
    
    <!--Onix game-->
    <div>
<div class="row home-info-grp" style="padding-top:15px;">
            <div class="col-xs-12 col-md-5 col-lg-5 svc-advantage d-md-pl-0">
                <!--Service advantages -->
                <div class="title-box">
                    <h3 class="u-section-title">
                        KELEBIHAN LAYANAN </h3>
                </div>
                <div class="content-box u-section-box--bg">
                    <div class="row ">
                        <div class=" col-xs-12 col-md-6 d-md-pl-5">
                            <div class="card">
                                <div class="card-header clearfix">
                                    <div class="circle-wrp"><i class="icon-atm"></i> </div>
                                    <div class="text-wrp">
                                        <div class="u-section-title">
                                            DEPOSIT </div>
                                        <div>Waktu rata-rata</div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="text-right fs-md" style="padding-bottom:8px;">
                                        1 Mins </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="10"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                            <span class="sr-only">10% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="   col-xs-12 col-md-6  d-md-pl-5">
                            <div class="card">
                                <div class="card-header clearfix">
                                    <div class="circle-wrp"><i class="icon-coinbag"></i></div>
                                    <div class="text-wrp">
                                        <div class="u-section-title">
                                            WITHDRAW </div>
                                        <div>Waktu rata-rata</div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="text-right fs-md" style="padding-bottom:8px;">
                                        3 Mins </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="30"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                                            <span class="sr-only">30% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="  col-xs-12  mt-3 text-center">
                            <div class="card">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="circle-wrp">
                                            <i class="icon-users2"></i>
                                        </div>
                                        <div>
                                            <div>Pengguna</div>
                                            <div>72034</div>
                                        </div>
</div>
                                    <div class="col-xs-4">
                                        <div class="circle-wrp">
                                            <i class="icon-cash"></i>
                                        </div>
                                        <div>
                                            <div>Jumlah Taruhan</div>
                                            <div>12,523,827 </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="circle-wrp">
                                            <i class="icon-stamp"></i>
                                        </div>
                                        <div>
                                            <div>Online</div>
                                            <div>21610 </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xs-12  col-md-7 col-lg-7 ">
                <div class="row">
                    <div class="col-xs-12  col-md-6 col-lg-6 info-centre d-md-pl-0">
                        <div class="title-box">
                            <h3 class="u-section-title">
                                PUSAT INFO
                            </h3>
                        </div>
                        <div class="content-box u-section-box--bg">
                            <ul>
                                <li>
                                    <div class="text">Cara Bermain SportsBook</div>
                                    <a class="btn btn-link" href="{{ $setting->live_chat }}"> Lebihnya</a>
                                </li>
                                <li>
                                    <div class="text">Cara Bermain Slot</div>
                                    <a class="btn btn-link" href="{{ $setting->live_chat }}"> Lebihnya</a>
                                </li>

                                <li>
                                    <div class="text">Cara Melakukan Deposit</div>
                                    <a class="btn btn-link" href="{{ $setting->live_chat }}"> Lebihnya</a>
                                </li>
                                <li>
                                    <div class="text">Cara Melakukan Withdraw </div>
                                    <a class="btn btn-link" href="{{ $setting->live_chat }}"> Lebihnya</a>
                                </li>


                            </ul>

                        </div>
                    </div>

                    <div class="col-xs-12  col-md-6 col-lg-6 member-svc">
                        <div class="title-box">
                            <h3 class="u-section-title">
                                MEMBER SERVICE
                            </h3>
                        </div>
                        <div class="content-box u-section-box--bg">

                            <section class="contacts-carousel">
                                <div id="contacts-carousel" class=" carousel slide  " data-ride="carousel">
                                    <ol class="carousel-indicators">


                                        <li data-target="#contacts-carousel" data-slide-to="0" class="active">
                                        </li>

                                    </ol>

                                    <div class="carousel-inner" role="listbox">
                                        <div class="item active">
<a target="_blank" rel="noopener noreferrer" href="https://t.me/{{ $setting->tele }}"
                                                class="contact-item">
                                                <div class="icon-wrp"> <i class="icon-telegram"></i> </div>
                                                <div class="text-wrp">

                                                    <div class="u-muted-txt">TELEGRAM</div>
                                                    <div class="">{{ $setting->tele }}</div>
                                                    <div class="u-muted-txt">24/7 Support</div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class=" container">
    <div class=" text-left footerlink mt-4  ">
        <div class="small"> Platform Penyedia Layanan </div>
        <div class="mt-2 footer_btm_logo_img">
            <img class="footer_logimg" style="max-height: 50px;" alt="{{ $setting->nama_web }}"
                src="{{ asset('storage/' . $setting->logo) }}">
        </div>
    </div>
    <div class=" text-left footerlink mt-2">
        <div class="small">Cara Pembayaran </div>
        <div class="payment_imgs mt-2">
            <img alt="" class="img-fluid mb-3" style="width: 150px; border-radius:10px;border: 1px solid currentColor;"
                src="https://files.sitestatic.net/sprites/bank_logos/bank_col.jpg?v=3">

            <img alt="" class="img-fluid mb-3" style="width: 150px; border-radius:10px;border: 1px solid currentColor;"
                src="https://files.sitestatic.net/sprites/bank_logos/ewallet_col.jpg?v=3">

            <img alt="" class="img-fluid mb-3" style="width: 150px; border-radius:10px;border: 1px solid currentColor;"
                src="https://files.sitestatic.net/sprites/bank_logos/pulsa_col.jpg?v=3">
        </div>
    </div>
</div>
<br>
<div class="footer-title text-center" id="collapsible-footer">
    <i class="i-collapse icon-chevron-thin-up"></i>
</div>
<div class="footer-body text-center">
    <h2><b>Bandar Judi Online Slot Gacor {{ $setting->nama_web }} Terpercaya dan Terpercaya di Indonesia</b></h2>
    <p>Begitu banyak pilihan bandar judi online <a href="{{ URL::to('/') }}" target="_blank" rel="noopener noreferrer">slot
            gacor</a> membuat kalian bingung memilih yang mana? Tidak perlu ragu langsung saja pilih
        {{ $setting->nama_web }}.
        Situs yang sudah berpengalaman bertahun-tahun siap melayani kalian semua dengan staff yang sudah
        terlahir dan profesional. Pelayanan customer 24 jam sehari selalu aktif setiap hari untuk membantu
        permasalahan yang ada. Berbagai macam permainan dari kasino, sportsbook, slot online sampai togel ada
        disini jadi semua bisa kalian nikmati tanpa perlu pindah situs.
    </p>
    <p>Kalian juga tidak perlu lagi khawatir karena {{ $setting->nama_web }} berlisensi resmi PAGCOR. Data pribadi
        kalian
        dikelola dengan baik tidak akan bocor disimpan dengan enkripsi tingkat tinggi sesuai standar keamanan
        PAGCOR. Transaksi deposit dan withdraw akan diproses dengan cepat. Pemain juga akan dimanjakan oleh
        berbagai promo dan bonus bila bermain disini. Baik pemain baru ataupun lama diberikan bonus harian,
        bonus mingguan dan juga bonus bulanan. Langsung saja daftarkan diri kalian untuk bergabung dengan <a
            href="{{ URL::to('/') }}" target="_blank" rel="noopener noreferrer">bandar judi oline</a> slot gacor {{ $setting->nama_web }}.
        Dibagian atas sebelah kanan situs ini ada tombol untuk pendaftarkan yang bisa kalian klik. Isi data-data
yang diminta lalu deposit ke rekening {{ $setting->nama_web }}. Permainan judi seru siap untuk kalian mainkan.
    </p>
    <p><br></p>
    <h2><b>Metode Deposit yang Tersedia di {{ $setting->nama_web }}</b></h2>
    <p>Kami tentu menyediakan semua metode deposit agar kalian semua merasa nyaman untuk bertransaksi. Berikut
        metode yang bisa kalian gunakan :</p>
    <h3><b>Deposit Via Bank</b></h3>
    <p>Yang paling umum tentunya deposit melalui transfer bank. Kalian bisa melakukan deposit ke rekening yang
        sudah disediakan oleh {{ $setting->nama_web }}. Menggunakan mesin ATM, mobile banking ataupun internet banking
        kapan
        saja dan dimana saja selalu bisa dilakukan.</p>
    <h3><b>Deposit Via Pulsa</b></h3>
    <p>Dijaman yang canggih sekarang ini tentunya hampir setiap orang memiliki handphone. Bahkan anak-anak
        sekarang pun juga sudah pandai menggunakan teknologi ini. Handphone pastinya dilengkapi dengan nomor
        operator prabayar tertentu (XL, Telkomsel, Tri, Smartfren dan sebagainya) yang diisi pulsa. Dengan pulsa
        tersebut kalian juga bisa melakukan transaksi deposit ke nomor yang sudah disediakan oleh staff kami.
    </p>
    <h3><b>Deposit Via Dompet Digital</b></h3>
    <p>Semakin majunya teknologi ini sekarang dompet dan uang pun ada dalam bentuk digitalnya. Kalian bisa
        bertransaksi secara online menggunakan dompet digital. Kami menyediakan metode deposit melalui dompet
        digital seperti Gopay, Dana, LinkAja dan juga QRIS.</p>
    <p>Dengan metode yang lengkap seperti ini memudahkan kalian untuk bertransaksi kapan saja dimana saja kalian
        ingin bermain judi online slot gacor {{ $setting->nama_web }}.</p>
    <p><br></p>
    <h2><b>Bonus yang Diberikan Kepada Member {{ $setting->nama_web }}</b></h2>
    <p>Bergabung dengan bandar judi online slot gacor {{ $setting->nama_web }} pastinya kalian akan mendapatkan bonus.
        Ingin
        tahu apa saja bonusnya? Berikut kami rincikan untuk kalian semua</p>
    <h3><b>Bonus New Member 10K</b></h3>
    <p>Dari namanya saja kalian pasti tahu bahwa bonus ini diberikan kepada member yang baru mendaftarkan diri
        di {{ $setting->nama_web }}. Bonus yang diberikan adalah sebesar sepuluh ribu rupiah. Persyaratkan untuk
        mendapatkan
        bonus ini adalah kalian harus melakukan deposit minimal lima puluh ribu rupiah.</p>
    <h3><b>Bonus Harian 5%</b></h3>
    <p>Bonus ini bisa kalian klaim setiap hari apabila kalian melakukan deposit minimal seratus ribu dengan
        maksimal bonus yang bisa diperolah adalah lima ratus ribu rupiah. Untuk bisa melakukan withdraw bonus
        ini kalian harus mencapai syarat TO (TurnOver) sebesar 5x nilai deposit ditambah nilai bonus.</p>
    <h3><b>Bonus Cashback</b></h3>
    <p>Besaran bonus ini berbeda-beda tergantung permainan apa yang kalian mainkan. Untuk permainan sport, live
        casino dan sabung ayam nilai bonus cashback adalah 5% sedangkan untuk permainan slot dan tembak ikan
        yaitu 10%. Bonus ini akan dibagikan setiap hari Senin.</p>
    <h3><b>Bonus All Member 10%</b></h3>
    <p>Terakhir adalah bonus all member 10% yang bisa kalian nikmati bila sudah melakukan deposit minimal lima
        puluh ribu rupiah dengan maksimal bonus yang bisa didapatkan juga sebesar lima puluh ribu. </p>
    <p>Bisa kalian lihat bonus yang diberikan memanjakan member baru dan juga member lama. {{ $setting->nama_web }}
        selalu
        menjaga kepercayaan pemain judi online gacor Indonesia. </p>
    <p><br></p>
    <h2><b>Pilihan Permainan Judi Gacor {{ $setting->nama_web }} Lengkap</b></h2>
    <p>{{ $setting->nama_web }} <a href="{{ URL::to('/') }}" target="_blank" rel="noopener noreferrer">bandar terbaik</a> telah bekerjasama
        dengan
        berbagai provider slot gacor ternama. Permainan yang ada tentu lengkap dengan ratusan judul bisa kalian
mainkan. Ada beberapa permainan slot gacor yang sangat digemari oleh pejudi Indonesia. Sudah tidak asing
        ditelinga kita semua permainan dari provider Pragmatic Play yaitu Gates of Olympus yang terkenal dengan
        kakek Zeus. Ada juga permainan Sweet Bonanza dengan permen-permen manis membuat lidah bergoyang. Selain
        itu permainan dengan tema hewan seperti Koi Gate juga digemari banyak orang. 3 permainan ini digemari
        karena selain gambarnya yang menarik juga sering memberikan kemenangan pada pejudi. Dengan modal yang
        kecil mereka bisa meraih kemenangan besar maxwin bahkan juga ada yang mendapatkan jackpot ratusan juta
        rupiah.</p>
</div><br><br>
<script>
    const popups = [
        {name: 'Joko***', id: 'Withdraw - Rp. 1.920.000',  img: 'https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg'},
        {name: 'Rudi**', id: 'Withdraw - Rp. 3.120.000',  img: 'https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg'},
        {name: 'Jpma**', id: 'Withdraw - Rp. 4.000.000',  img: 'https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg'},
        {name: 'Wins***', id: 'Withdraw - Rp. 2.750.000',  img: 'https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg'},
        {name: 'Mega**', id: 'Withdraw - Rp. 6.450.000',  img: 'https://upload.wikimedia.org/wikipedia/commons/3/38/CIMB_Niaga_logo.svg'},
        {name: 'Amir***', id: 'Withdraw - Rp. 11.220.000',  img: 'https://www.linkqu.id/wp-content/uploads/2021/07/filedownload.png'},
        {name: 'Puki**', id: 'Withdraw - Rp. 5.900.000',  img: 'https://upload.wikimedia.org/wikipedia/commons/5/54/OCBC_Bank_logo.png'},
        {name: 'Jawa***', id: 'Withdraw - Rp. 7.920.000',  img: 'https://upload.wikimedia.org/wikipedia/commons/c/c0/Logo-jago.svg'}
    ];

    let currentIndex = 0;

function showPopup() {
    const popup = document.getElementById('popup');
    const title = document.getElementById('popupTitle');
    const message = document.getElementById('popupMessage');
    const image = document.getElementById('popupImage');

    const currentPopup = popups[currentIndex];

    // Update konten popup
    title.innerText = currentPopup.name;
    message.innerText = (${currentPopup.id});
    image.src = currentPopup.img;

    // Tampilkan popup dengan efek fade-in
    popup.classList.add('show');

    // Setelah 3 detik, hilangkan popup tanpa efek fade-out
    setTimeout(() => {
        popup.classList.remove('show'); // Sembunyikan dengan menghapus kelas 'show'
    }, 2000); // Popup tampil selama 3 detik

    currentIndex = (currentIndex + 1) % popups.length;
}

// Tampilkan popup setiap 5 detik
setInterval(showPopup, 5000);
</script>
<script>
        function commaSeparateNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function removeTrailingZeros(str) {
            return str.replace(/\.00$/, ''); 
        }

        let fullNumber = 19321332;

        function increaseNumber() {
            let lastThreeDigits = fullNumber % 1000;
            let remainingNumber = Math.floor(fullNumber / 1000); 

            lastThreeDigits += 5;

            if (lastThreeDigits >= 1000) {
                lastThreeDigits = lastThreeDigits % 1000;
                remainingNumber += 1;
            }

            fullNumber = remainingNumber * 1000 + lastThreeDigits;

            let formattedNumber = commaSeparateNumber(Math.floor(fullNumber));

            formattedNumber = removeTrailingZeros(formattedNumber);

            document.getElementById('jackpot_amount').innerHTML = 'IDR ' + formattedNumber + '.00';
        }

        setInterval(increaseNumber, 500);
</script>
@endsection
@enddesktop
