<?php
use App\Models\Setting;
use App\Models\Saldo;

$setting = Setting::first();
?>
@if ($setting->maintenance_mode == 0)
@else
    @include('layouts.maintenance')
@endif

@if ($setting->maintenance_mode == 1)
@else
    <!DOCTYPE html>
    <html lang="id-ID">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <head>
        <title>{{ $setting->seo_social_title }}</title>
        <link rel="icon" type="image" href="{{ asset('storage/' . $setting->logo) }}">
        @include('layouts.desktop.seo')

        <meta charset="utf-8">
        <script src="https://cdn.sitestatic.net/assets/jquery/jquery.min.js"></script>
        <script src="https://cdn.sitestatic.net/assets/bootstrap/bootstrap.min.js"></script>

        <link rel="preload" href="{{ asset('assets/fonts/ugsubskin/icomoon/fonts/icomoon8c13.woff2?h141kb') }}"
            as="font" type="font/woff2" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('assets/fonts/ugsubskin/icomoon/style.mine67d.css?v=1.3') }}"
            media="print" onload="this.media='all'">
        <link rel="stylesheet" href="{{ asset('assets/css/ugsports/swiper.css') }}" />
        <style>
            .footer_pwrd_by_logo>img {
                background: transparent !important;
                box-shadow: none !important;
            }
        </style>
        <link type="text/css" rel="stylesheet"
            href="{{ asset('assets/css/ugsports/' . $setting->themes . '/app-desktop.css?id=791a6313733ec2c34443') }}">
        <link type="text/css" rel="stylesheet"
            href="{{ asset('assets/css/ugsports/' . $setting->themes . '/custom.css?id=495e40951c4898a602f0') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=Montserrat:wght@700;800&display=swap">
        <script src="https://cdn.sitestatic.net/assets/jquery/sweet_alert2.min.js"></script>


        <link rel="stylesheet" href="https://cdn.sitestatic.net/assets/jquery/jquery-ui.min.css">
        <script src="https://cdn.sitestatic.net/assets/jquery/jquery-ui.min.js" defer></script>
        <script type="text/javascript" src="https://cdn.sitestatic.net/assets/jquery/jquery.ui.touch-punch.min.js" defer>
        </script>
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/boray-midnight.css') }}">
        <meta name="google-site-verification" content="oJwTWpzUOAdPQQO1yrHmjp8-Dk1Z_ST2Qiv1WLv1LXE" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="desktop home">
        <div style="display:none;"> 8</div>
        @php
            $setting = Setting::first();
        @endphp
        <div class="top_navbar">
            <div class="header-wrapper">
                <div id="masthead" class="main-header container">
                    <div class="inner-header flex-row logo-left md-logo-center">
                        <div id="logo" class="flex-col logo">
                            <a href="{{ URL::to('/') }}" title="">
                                <!--TODO put site tile-->
                                <img class="img-fluid" alt="{{ $setting->nama_web }}"
                                    src="{{ asset('storage/' . $setting->logo) }}" style="max-width: 270px;" />
                            </a>
                        </div>
                        <!-- Mobile Left Elements -->
                        <div class="flex-col show-for-medium flex-left  fs-lg ">
                            <i class="icon-bars"></i>
                        </div>
                        <!-- Left Elements -->
                        <div class="flex-col hide-for-medium flex-left flex-grow">
                        </div>
                        <!-- Desktop Right Elements -->

                        <div class="flex-col hide-for-medium flex-right">
                            <div class="flex-row top text-right">
                                <div class="ann-wrapper">
                                    <div class="clearfix pt-2">
                                        <div class="pull-left pointer">
                                            <div>
                                                <i class="icon-megaphone"></i>
                                            </div>
                                        </div>
                                        <div class="ann-content">
                                            <marquee scrollamount="5">
                                                {{ $setting->running_text }}
                                            </marquee>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ URL::to('complain-form') }}" class="btn compliant-btn btn-primary">
                                    <span><i class="icon-info"></i></span> <span>Pengaduan Member</span>
                                </a>
                                <span class="text-right time"></span>
                                <div class=" line"></div>
                                <div class="social-icons fade-in" id="blk-socialIcons--top-bar"
                                    style="flex-wrap:nowrap;">
                                    <a href="{{ URL::to('/') }}" target="_blank" rel="noopener noreferrer" i18n-tooltip="@Follow-FB"
                                        tooltip="Ikuti di Facebook" data-toggle="tooltip" data-placement="top"
                                        title="Follow on Facebook!" class="facebook button icon circle ">
                                        <i class="icon-facebook"></i>
                                    </a>
                                    <!--
    -->
                                    <a href="{{ URL::to('/') }}" target="_blank" rel="noopener noreferrer" i18n-tooltip="@Tweet-us" data-toggle="tooltip"
                                        data-placement="top" title="Tweet us!" class="twitter  button icon circle  "><i
                                            class="icon-twitter "></i></a>
                                    <!--
    -->
                                    <a href="{{ URL::to('/') }}" target="_blank" rel="noopener noreferrer" i18n-tooltip="@Instagram-us"
                                        data-toggle="tooltip" data-placement="top" title="Instagram us!"
                                        class="instagram  button icon circle "><i class="icon-instagram"></i></a>
                                    <!--
    -->
                                    <a href="{{ URL::to('/') }}" target="_blank" rel="noopener noreferrer" i18n-tooltip="@See-our-youtube"
                                        data-toggle="tooltip" data-placement="top"
                                        title="See our youtube video to know more!"
                                        class=" youtube button icon circle "><i class="icon-youtube-play"></i></a>

                                </div>
                                <button class="btn button icon circle share" style=""
                                    id="btn-showSocialIcons--top-bar">
                                    <i class="icon-share" style="left:-1px;"></i>
                                    <i class="icon-close hide"></i>
                                </button>
                                <div class=" line"></div>
                                <a class="country_detail" href="javascript:void(0);" data-trigger='nifty'
                                    data-target='#langModal-mobile'>
                                    <span class="d-inline-block circle-id"></span>
                                    <span class="contry_name">Indonesia</span>
                                    <span class='dot'></span>
                                    <span class="lang_name">indonesian</span>
                                </a>
                                <div class="  line"></div>
                            </div>
                            @guest
                                <div class="flex-row text-right mid">
                                    <a class="pointer button twitter icon" href="{{ $setting->live_chat }}"
                                        target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="top" title="Cara bermain">
                                        <i class="icon-help-circle"></i>
                                    </a>
                                    <div class="line"></div>
                                    <a class="pointer button twitter icon" href="{{ $setting->live_chat }}"
                                        target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="top" title="Pusat Info">
                                        <i class="icon-info"></i>
                                    </a>
                                    <div class="  line"></div>
                                    <a class="pointer" href="{{ $setting->live_chat }}" target="_blank" rel="noopener noreferrer"
                                        data-toggle="tooltip" data-placement="top" title="Obrolan Langsung">
                                        <i class="icon-chat1"></i>
                                    </a>
                                    <div class="  line"></div>
                                    <button type="button" class="btn fix btn-tertiery green_over" _ajaxLForm
                                        data-trigger='nifty'
                                        data-target='#login-modal--layout'><span>LOGIN</span></button>
                                    <a type="button" class="btn fix  btn-accent yellow_over" style="margin-right: 0;"
                                        i18n="@Join" href="{{ URL::to('register') }}"
                                        routerLinkActive="link-active"><span>DAFTAR</span></a>
                                </div>
                            @endguest
                            @auth
                                @include('layouts.desktop.prof')
                            @endauth
                        </div>
                        <!-- MObile Right Elements -->
                        <div class="flex-col show-for-medium flex-right">
                            <div class="flex-row  text-right" style="justify-content: flex-end;">
                                <button style="" type="button" class="btn btn-primary btnLogin" _ajaxLForm
                                    _ajaxLForm data-trigger='nifty' data-target='#login-modal--layout'>LOGIN</button>
                                <!--<a *ngIf="!isLogin" class="btn btn-secondary" (click)="register.emit()" routerLink="#" routerLinkActive="link-active">Join</a>-->
                                <a style="" type="button" class="btn btn-tertiery"
                                    href="{{ URL::to('register') }}">DAFTAR</button>
                                    <a style="display:none" class="btn btn-primary" href="#">KELUAR</a>
                            </div>
                        </div>
                        </ng-container>
                    </div>
                </div>
            </div>
            <!--Main Nav-->
            @include('layouts.desktop.navbar')
            <!--END main nav-->
        </div>
        <div class="content my01">
            @yield('desktop')
            <style>
                .icon-zalo .path1:before {
                    content: "\e966";
                    color: #e6eff4;
                }

                .icon-zalo .path2:before {
                    content: "\e969";
                    color: #b6d1dd;
                    margin-left: -1em;
                }

                .icon-zalo .path3:before {
                    content: "\e96e";
                    color: #41a0d7;
                    margin-left: -1em;
                }

                .icon-zalo .path4:before {
                    content: "\e96f";
                    color: var(--boray-text);
                    margin-left: -1em;
                }

                .bottom-to-top {
                    transform: none !important;
                }
            </style>
            <div class="floats floats-right">
                <div class="slider">
                    <div class="fc">
                        <div class="fc-left text-center">

                            <div class="center i-circle" style="padding-top:5px;">
                                <i class="icon-phone"></i>
                            </div>

                            <div class="bottom-to-top center fs-lg" i18n="@CONTACT-US-"> &nbsp;HUBUNGI KAMI &nbsp;
                            </div>
                            <div class="center fs-md">
                                <i class="icon-double_arrow_r"></i>
                            </div>
                        </div>
                        <div class="fc-right center fs-lg">
                            <div class="bg-1">
                                <div class="text-center"> <span class="txt-xxl"><i
                                            class="icon-24-7 icon-sun-moon"></i><span>24x7</span></span> </div>
                                <div class="row no-gutters">
                                    <div class="col-xs-6">
                                        <a class="btn btn-block btn-accent green_over"
                                            href="{{ $setting->live_chat }}" target="_blank" rel="noopener noreferrer" id="btn-joinNow"
                                            i18n="@LIVE-HELP">LIVE
                                            HELP</a>
                                    </div>
                                    <div class="col-xs-6">
                                        <a class="btn btn-block btn-tertiery yellow_over"
                                            href="{{ URL::to('register') }}" id="btn-joinNow" i18n>JOIN
                                            NOW</a>
                                    </div>
                                </div>
                                <div class="box flex flex-align-top ">
                                    <i class="icon-clock"></i>
                                    <div class="pl-2 font-size-sm "><span i18n>Quick Easy Deposit</span><br /><span
                                            i18n="@Fast-withdraw">Fast
                                            withdraw</span></div>
                                </div>
                            </div>
                            <div class="bg-2 fs-lg text-left">
                                <a class="btn btn-block box btn-primary contact-values"
                                    href="https://t.me/{{ $setting->tele }}" target="_blank" rel="noopener noreferrer">
                                    <span class="dis_flex">
                                        <span class="icon-txt"><i
                                                class="icon-telegram"></i></span><span>{{ $setting->tele }}</span>
                                    </span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- login form -->
            <div class="modal-wrapper nifty-modal fade-in-scale" id="login-modal--layout"
                data-isnotcloseoverlay="true">
                <div class="md-content">
                    <div class='md-body'>
                        <style type="text/css">
                        </style>
                        <div class="modal-header text-center">
                            <button class="btn btn-link pull-left" id="btn-close--login-modal"> X </button>
                            <div style="width:100%;">
                                <h4 class="text-center modal-title">Login</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            <!--app_sub_skin != \Constants::onix  -->
                            <form class="form-horizontal" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group ">
                                    <label for="password" class="fs-lg" i18n>Nama pengguna</label>
                                    <div class="icon-input">
                                        <input type="text" class="form-control input-l" maxlength="50"
                                            name="name" autocomplete="off" required="required" id="UserName"
                                            aria-describedby="emailHelp" placeholder="">
                                        <i class="icon-user left"></i>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="password" class="fs-lg" i18n>Kata sandi</label>
                                    <div class="icon-input">
                                        <input type="password" class="form-control  input-l" maxlength="20"
                                            id="pwd--login" name="password" required="required"
                                            autocomplete="current-password" />
                                        <i class="icon-lock left"></i>
                                        <i class="icon-eye toggle-password" input_id="#pwd--login"></i>
                                    </div>
                                </div>
                                <div class="row  alert alert-danger message" _login-modal>
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" *ngIf="!inProgress"
                                        class="btn btn-block btn-primary fs-lg btn-submit">Login</button>

                                    <button type="button" *ngIf="!inProgress" class="btn btn-link"
                                        id="forgotPwd-btn--login-modal" i18n>
                                        Lupa kata sandi? &nbsp;<i class="icon-redo"></i>
                                    </button>


                                    <app-ellipsis *ngIf="inProgress"></app-ellipsis>
                                </div>

                            </form>

                            <form class="form-horizontal" id="resetPwdForm" name="resetPwdForm" action="#"
                                method="post">
                                <input type="hidden" name="_token"
                                    value="GsEudEmQupM5UDbts1L3PyrztF8KQaFVBrcjjJ68">

                                <div class="form-group">
                                    <label for="password" class="fs-lg" i18n>Alamat email</label>
                                    <div class="icon-input">
                                        <input type="email" class="form-control input-l" name="email"
                                            required="required" id="email" aria-describedby="emailHelp"
                                            placeholder="">
                                        <i class="icon-envelope left"></i>
                                    </div>
                                </div>
                                <div class="form-group row no-gutters">
                                    <div class="col-xs-8 col-md-8">
                                        <input type="tel" id='registerCaptchaimg' class="form-control"
                                            name="forgotPwCaptchaimg" maxlength="4" autocomplete="off"
                                            style="height: 50px;" placeholder="Captcha">
                                    </div>
                                </div>
                                <div class="row alert alert-danger message" _login-modal>
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-block btn-primary fs-lg">Reset</button>
                                    <button type="button" id="btn-back--login-modal" class="btn btn-link" i18n>
                                        <i class="icon-undo"></i>&nbsp; Kembali untuk masuk </button>
                                    <app-ellipsis *ngIf="inProgress"></app-ellipsis>
                                </div>

                            </form>


                            <form class="form-horizontal text-center" id="pinForm" action="#">

                                <div class="form-group ">
                                    <h3>Kode Pin Aman</h3>
                                    <p class="">Silakan Masukkan Kode Pin Aman Anda</p>
                                </div>
                                <div class="form-group ">
                                    <div class="pin-in-grp" id="pin-in-grp">


                                        <input type="password" maxlength="1" name="pincode[0]" required
                                            class="form-control pincode" style="width:16.66%">


                                        <input type="password" maxlength="1" name="pincode[1]" required
                                            class="form-control pincode" style="width:16.66%">


                                        <input type="password" maxlength="1" name="pincode[2]" required
                                            class="form-control pincode" style="width:16.66%">


                                        <input type="password" maxlength="1" name="pincode[3]" required
                                            class="form-control pincode" style="width:16.66%">


                                        <input type="password" maxlength="1" name="pincode[4]" required
                                            class="form-control pincode" style="width:16.66%">


                                        <input type="password" maxlength="1" name="pincode[5]" required
                                            class="form-control pincode" style="width:16.66%">


                                    </div>
                                </div>
                                <div class="form-group button-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <input class="btn btn-primary btn-round btn-block pinkey" type="button"
                                                value="4">
                                        </div>
                                        <div class="col-xs-4">
                                            <input class="btn btn-primary btn-round btn-block pinkey" type="button"
                                                value="2">
                                        </div>
                                        <div class="col-xs-4">
                                            <input class="btn btn-primary btn-round btn-block pinkey" type="button"
                                                value="6">
                                        </div>
                                        <div class="col-xs-4">
                                            <input class="btn btn-primary btn-round btn-block pinkey" type="button"
                                                value="3">
                                        </div>
                                        <div class="col-xs-4">
                                            <input class="btn btn-primary btn-round btn-block pinkey" type="button"
                                                value="0">
                                        </div>
                                        <div class="col-xs-4">
                                            <input class="btn btn-primary btn-round btn-block pinkey" type="button"
                                                value="8">
                                        </div>
                                        <div class="col-xs-4">
                                            <input class="btn btn-primary btn-round btn-block pinkey" type="button"
                                                value="1">
                                        </div>
                                        <div class="col-xs-4">
                                            <input class="btn btn-primary btn-round btn-block pinkey" type="button"
                                                value="5">
                                        </div>
                                        <div class="col-xs-4">
                                            <input class="btn btn-primary btn-round btn-block pinkey" type="button"
                                                value="9">
                                        </div>
                                        <div class="col-xs-4">
                                            <input id='back_bt' class="btn btn-warning btn-block  btn-round"
                                                type="button" value="RESET">
                                        </div>
                                        <div class="col-xs-4">
                                            <input class="btn btn-primary btn-block  btn-round pinkey" type="button"
                                                value="7">
                                        </div>
                                        <div class="col-xs-4">
                                            <button
                                                class="btn btn-info btn-round btn-block waves-effect waves-light btn-submit"
                                                type="submit">Kirimkan</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-4"></div>
                                        <div class="col-xs-4"><a style=""
                                                class="btn btn-danger btn-round btn-block waves-effect "
                                                href="index.html" i18n="@Logout">LOGOUT</a></div>
                                        <div class="col-xs-4"></div>
                                    </div>
                                </div>
                                <div class="row  alert alert-danger message" _login-modal>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer text-center" id="footer--login-modal">
                            <div class="footer-content">Tidak terdaftar? <a href="{{ URL::to('register') }}"
                                    i18n>Daftar</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='md-overlay'></div> <!-- END login form -->



            <!-- Loading modal -->
            <div class="nifty-modal fade-in-scale" id="loading--layout" style="z-index:1000001;"
                data-isnotcloseoverlay="true">
                <div class="md-content">
                    <div class='md-body'>

                        <div class="loader-b large"></div>
                    </div>
                </div>
            </div>
            <div class='md-overlay' style="z-index:1000000;"></div>
            <!-- END Loading modal-->

            <!-- APK download ||Transfer Wallet  modal start-->
            <div class="nifty-modal slide-in-bottom downloadapk-modal" id="apk-modal">
                <div class="md-content">
                    <div class="modal-header">
                        <button class="pull-right md-close"><i class="icon-x fs-lg"></i></button>
                        <h3 id="downloadgame-title"></h3>
                    </div>
                    <div class="md-body">
                        <!--region Transfer Wallet Menu -->
                        <div class="row no-gutters" id="trans_to_game_menu__game-modal">
                            <form action="#" method="post" id="tw_transfer_form" class="tw_transfer_form">
                                <input type="hidden" name="_token"
                                    value="GsEudEmQupM5UDbts1L3PyrztF8KQaFVBrcjjJ68">
                                <div class="form-group">
                                    <label for="mainwallet_amount">From Main Wallet</label>
                                    <input type="text" class="form-control" readonly name="mainwallet_amount"
                                        id="mainwallet_amount" value="" />

                                </div>
                                <div class="text-center">
                                    <span class="vertical"><i class="icon-arrow-long-right"></i></span>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="mainwallet_amount">Transfer to <span id="gamename"></span>
                                            Wallet</label>
                                        <div class="form-group">

                                            <div class="customrange-slider">
                                                <div id="slider" overflow-scroll="false"
                                                    class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                                    <span tabindex="0"
                                                        class="ui-slider-handle ui-corner-all ui-state-default"
                                                        style="left: 0%;"></span>
                                                    <div class="ui-slider-range ui-corner-all ui-widget-header ui-slider-range-min"
                                                        style="width: 0%;"></div>
                                                </div>
                                                <div class="decrease-btn cusbtn">
                                                    <div id="tw_decrease_btn"> <span
                                                            class="minus-icon custom-icon">-</span> </div>

                                                    <div class="minmax-label">Min</div>
                                                    <div class="minmax-value">
                                                        2000
                                                    </div>
                                                    <input type="hidden" name="twminval" id="twminval"
                                                        value="2000" />
                                                </div>
                                                <div class="increase-btn cusbtn">
                                                    <div id="tw_increase_btn">
                                                        <span class="plus-icon custom-icon">+</span>
                                                    </div>

                                                    <div class="minmax-label">Max</div>
                                                    <div class="minmax-value" id="maxSliderApk"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control"
                                                    name="transfer_amount" id="transfer_amount" placeholder="0.00"
                                                    value="00.00" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <input type="submit" class="btn btn-primary" value="SUBMIT" />
                                </div>
                            </form>
                        </div>
                        <!--endregion Transfer Wallet Menu -->

                        <div class="row no-gutters">
                            <div class="col-xs-12 text-center">
                                <a href="#" id="launchurl" class="url-link" target="_blank" rel="noopener noreferrer">
                                    <img class="img-fluid" src="assets/images/log_html5.png" alt="play-in-browser">
                                    <div class="download-caption text-center">
                                        Play now in your browser
                                    </div>
                                    <div class="download-linkbtn text-center">
                                        <img class="img-fluid" src="assets/images/btn_playnow.png"
                                            alt="play-now-in-browser">
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-wrapper nifty-modal fade-in-scale" id="live-draw-modal" data-isnotcloseoverlay="true">
                <div class="md-content">
                    <div class='md-body'>
                        <div class="modal-header">
                            <h4 class="modal-title">Live Draw</h4>
                            <button class="btn btn-link pull-left " id="btn-close--live-draw-modal"> <i
                                    class="icon icon-close"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div id='live_draw_table'>

                            </div>
                            <div id='img_details'>
                                <img alt="" src="#" class="draw_img" id='draw_img'>
                                <div class="details">

                                    <p class="tickte_id">undian berikutnya: <span id='ticket_id'></span></p>
                                </div>

                                <div class="close_btn_section">
                                    <button class="btn btn-close" id='img--section-closebtn'
                                        onclick="closeImageSection()">Kembali</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="md-overlay"></div>
            @include('content.outer')
            <!-- APK download modal end-->




            <script type="text/javascript" src="https://cdn.sitestatic.net/assets/jquery-validation/jquery.validate.min.js">
            </script>
            <script type="text/javascript" src="https://cdn.sitestatic.net/assets/jquery-validation/additional-methods.min.js">
            </script>
            <link rel="stylesheet" href="https://cdn.sitestatic.net/assets/fancybox/jquery.fancybox.min.css">
            <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/boray-midnight.css') }}">


            <script type="text/javascript" src="https://cdn.sitestatic.net/assets/fancybox/jquery.fancybox.min.js"></script>
            <script>
                window.isAuth = '1' ? false : true;
                window.currencyCode = 'IDR';
                window.lang = "id";
                window.agentCode = '{{ $setting->nama_web }}';
                window.sweetAlert = function(msg, type, title, showCancelBtn) {
                    //check CF error
                    var dateNow = "2023-12-26 07:36:10";

                    if (msg.indexOf('cloudflare') >= 0) {
                        msg = transMsgs.cfTimeout + ' (error time: ' + dateNow + ')';
                        title = " ";
                    }
                    return Swal.fire({
                        title: !title ? "Warning" : title,
                        text: msg,
                        icon: !type ? "error" : type,
                        buttons: {
                            confirm: {
                                text: "OK",
                                value: true,
                                visible: true,
                                className: "",
                                closeModal: true
                            },
                            cancel: {
                                text: "Cancel",
                                value: false,
                                visible: showCancelBtn ? true : false,
                                className: "",
                                closeModal: true,
                            }
                        }
                    });
                }
                console.log('window.name ' + window.name);
                window.name = !window.name ? "parent" + Date.now() + Math.floor(Math.random() * 100000000) : window.name;
                console.log('window.name ' + window.name);
                window.formatNumber = function(n) {
                    // format number 1000000 to 1,234,567
                    return n.replace(/[^0-9\-]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                }
                window.convertToNumber = function(value) {

                    if (!value) {
                        return 0;
                    }
                    if (value.indexOf(".") >= 0) {
                        var decimal_pos = value.indexOf(".");
                        value = value.substring(0, decimal_pos);

                    }
                    var number = value.replace(/[^0-9.-]+/g, "");
                    if (isNaN(number)) {
                        number = 0;
                    }
                    return number;
                }

                window.formatCurrency = function(value) {
                    const symbol = ""; //"$"
                    // get input value
                    var input_val = value;

                    if (typeof value !== 'string') {
                        var input_val = value.toString();
                    }
                    if (input_val === "") {
                        return;
                    }

                    var original_len = input_val.length;


                    if (input_val.indexOf(".") >= 0) {

                        var decimal_pos = input_val.indexOf(".");
                        var left_side = input_val.substring(0, decimal_pos);
                        var right_side = input_val.substring(decimal_pos + 1);

                        left_side = formatNumber(left_side);

                        right_side += "00";

                        right_side = right_side.substring(0, 2);

                        input_val = symbol + left_side + "." + right_side;

                    } else {
                        input_val = formatNumber(input_val);
                        input_val = symbol + input_val + ".00";;

                    }

                    return input_val;
                }

                window.prize = 0;
                window.ajax_jackpot = function() {
                    $.ajax({
                        url: "/getPokerJackpotAmt",
                        type: 'post',
                        data: {
                            _token: $('meta[name=csrf-token]').attr('content')
                        },
                        success: function(data) {
                            prize = (data / 2000.000) * 2000.000;
                            $('.jackpot_numbers_home').html(
                                `IDR <span id="jackpot_amount ">${commaSeparateNumber(prize)}</span>`
                            )

                            //$('.jackpot_numbers_home').html(`IDR ` + commaSeparateNumber(data.prize));
                        }
                    });
                }

                var newI = 0;
                window.popitup = function(url, gameid) {
                    //alert(gameid);
                    newwindow = window.open(url, window.agentCode + '_gameWindow' + gameid + newI,
                        'toolbar=0,width=1200,height=750');
                    newI++;
                    if (window.focus) {
                        newwindow.focus()
                    }
                    return false;
                }

                window.popup = function(mylink, windowname) {
                    if (!window.focus) return true;
                    var href;
                    if (typeof(mylink) == 'string')
                        href = mylink;
                    else
                        href = mylink.href;
                    window.open(href, windowname, 'width=600,height=800,scrollbars=yes');
                    return false;
                }
                window.commaSeparateNumber = function(val, isJP) {
                    while (/(\d+)(\d{3})/.test(val.toString())) {

                        if (window.currencyCode == 'VND' && isJP) {
                            val = val.toFixed(0);
                        } else {
                            val = Number(val).toFixed(2);
                        }
                        val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    }
                    return val;
                }

                window.getRandomIntInclusive = function(min, max) {
                    min = Math.ceil(min);
                    max = Math.floor(max);
                    return Math.floor(Math.random() * (max - min + 1)) +
                        min; //The maximum is inclusive and the minimum is inclusive
                }

                /*bank acc min and maxlength limitation */
                window.accLength = parseInt("8");
                window.bankAccLength = function(selectedBank, default_minlength, default_maxlength) {
                    console.log(selectedBank, default_minlength, default_maxlength);
                    var custom_minLength, custom_maxLength;
                    if (selectedBank == 'MDR') {
                        custom_minLength = 13;
                        custom_maxLength = 13;
                    } else if (selectedBank == 'BNI' || selectedBank == 'BCA' || selectedBank == 'DMN' || selectedBank ==
                        'BSI' || selectedBank == 'BLA') {
                        custom_minLength = 10;
                        custom_maxLength = 10;
                    } else if (selectedBank == 'BRI') {
                        custom_minLength = 15;
                        custom_maxLength = 15;
                    } else if (selectedBank == 'CIMBN' || selectedBank == 'BANKJAGO' || selectedBank == 'MDRLV') {
                        custom_minLength = 12;
                        custom_maxLength = 12;
                    } else {
                        custom_minLength = default_minlength;
                        custom_maxLength = default_maxlength;
                    }

                    return {
                        'min_len': custom_minLength,
                        'max_len': custom_maxLength
                    }
                }

                $.ajax({
                    url: "{{ url('saldo-refresh') }}",
                    timeout: 3000 // sets timeout to 3 seconds
                });
                /*bank acc min and maxlength limitation end*/


                $(document).ready(function() {
                    //suspend-alert
                    // login-alert
                    // promo-disabled-alert
                    // "maintenance-alert";
                    // "comingsoon-alert";
                    window.alertLogin = function(e) {
                        e.preventDefault();
                        sweetAlert(transMsgs.plsLogin);
                        return false;
                    }

                    $(".suspend-alert").click(function(e) {
                        e.preventDefault();
                        sweetAlert(transMsgs.blockedFrGame);
                        return false;
                    });

                    $(".login-alert").click(function(e) {
                        if ($("#login-modal--layout").length && !$('#loginForm').hasClass('js-inline-form')) {
                            $("#login-modal--layout").nifty("show")
                        } else {
                            alertLogin(e);
                        }

                        return false;
                    });

                    $(".maintenance-alert").click(function(e) {
                        e.preventDefault();
                        sweetAlert(transMsgs.gameMaintenance);
                        return false;
                    });

                    $(".comingsoon-alert").click(function(e) {
                        e.preventDefault();
                        sweetAlert(transMsgs.gameComingSoon);
                        return false;
                    });

                    $(".promo-disabled-alert").click(function(e) {
                        e.preventDefault();
                        sweetAlert(transMsgs.gamePromoBlock);
                        return false;
                    });



                });


                $("input").focus(function() {
                    $("body").addClass("input-focused");
                });
                $("input").focusout(function() {
                    $("body").removeClass("input-focused");
                });

                var host = window.location.host;
                var curr_host = "{{ URL::to('/') }}";
                var agent_url = "{{ URL::to('/') }}";

                console.log(host, curr_host, agent_url, agent_url.includes(host));

                if (host != curr_host && !agent_url.includes(host)) {

                    location.href = "{{ URL::to('/') }}";
                }
            </script>

            <script type="text/javascript" src="{{ asset('assets/js/ugsports/app-desktop.js?id=a29133822823e15af7ca') }}"></script>
            <!--Language Option Modal -->
            <div class="nifty-modal slide-in-bottom " id="langModal-mobile">
                <div class="md-content">
                    <div class="md-body">
                        <div class="wrap language">
                            <div class="title">Wilayah dan bahasa</div>
                            <table class="table-borderless">

                                <tr>
                                    <td class="country">Indonesia</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="flag-wrap">
                                        <div class="circle-id"></div>
                                    </td>
                                    <td class="i  ">
                                        <a href="javascript:void(0)" onclick='change_lang("id")'> indonesian</a>
                                    </td>

                                    <td class="i b-line ">
                                        <a href="javascript:void(0)" onclick='change_lang("en")'> English</a>
                                    </td>

                                    <td class="i b-line ">
                                        <a href="javascript:void(0)" onclick='change_lang("cn")'> Mandarin</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md-overlay"></div>
            <!--END Language Option Modal -->

            <script>
                $('.btn-refresh-captcha').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var $captchaImg = $(this).parent().find('img');
                    var curCapUrl = $captchaImg.attr("data-url");
                    var url = curCapUrl + Date.now() + Math.floor(Math.random() * 100000000);
                    $captchaImg.attr("src", url);

                });
            </script>
    </body>

    </html>
@endif
