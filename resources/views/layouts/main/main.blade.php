<?php
use App\Models\Setting;

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
        <title>{{ $setting->nama_web }}</title>
        <link rel="icon" type="image" href="{{ asset('storage/' . $setting->logo) }}">
        @include('content.seo')
        <script src="https://cdn.sitestatic.net/assets/jquery/jquery.min.js"></script>
        <script src="https://cdn.sitestatic.net/assets/bootstrap/bootstrap.min.js"></script>
        <link rel="preload" href="{{ asset('assets/fonts/ugsubskin/icomoon/fonts/icomoon8c13.woff2?h141kb') }}"
            as="font" type="font/woff2" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('assets/fonts/ugsubskin/icomoon/style.mine67d.css?v=1.3') }}"
            media="print" onload="this.media='all'">
        <link rel="stylesheet" href="{{ asset('assets/css/ugsports/swiper.css') }}" />
        <link type="text/css" rel="stylesheet"
            href="{{ asset('assets/css/ugsports/' . $setting->themes . '/app-mobile.css?id=64b3fbce6e7077216803') }}">
        <link type="text/css" rel="stylesheet"
            href="{{ asset('assets/css/ugsports/' . $setting->themes . '/custom.css?id=495e40951c4898a602f0') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&family=Montserrat:wght@700;800&display=swap">
        <script src="https://cdn.sitestatic.net/assets/jquery/sweet_alert2.min.js"></script>


        <link rel="stylesheet" href="https://cdn.sitestatic.net/assets/jquery/jquery-ui.min.css" media="print"
            onload="this.media='all'">
        <script src="https://cdn.sitestatic.net/assets/jquery/jquery-ui.min.js" defer></script>
        <script type="text/javascript" src="https://cdn.sitestatic.net/assets/jquery/jquery.ui.touch-punch.min.js" defer>
        </script>
        <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/boray-midnight.css') }}">
        <meta name="google-site-verification" content="oJwTWpzUOAdPQQO1yrHmjp8-Dk1Z_ST2Qiv1WLv1LXE" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="mobile">
        


        <div class="full-container layout">

            @include('layouts.sidenav')

            @php
                $setting = Setting::first();
            @endphp

            <div class="main-content" id="mainContent">
                <div class="backdrop" id="mainContentContainer">
                    <div class="top-bar">
                        <div class="inner-header flex-row ">
                            <button id="btnToggleSideNav" class="btn btn-link">
                                <i class="icon-bars"></i>
                            </button>
                            <a href="{{ URL::to('/') }}" title="" class="logo">
                                <div>
                                    <img class="img-fluid" alt="{{ $setting->nama_web }}"
                                        src="{{ asset('storage/' . $setting->logo) }}" />
                                </div>
                            </a>
                            <a id="btnToggleRSideNav">
                                <i class="icon-user-o"></i>
                            </a>
                        </div>
                    </div>
                    <div class="content my01">

                        @include('content.nav_saldo')

                        @yield('content')
                        @auth
                            <div class="mobilesite-footer">
                                <div class="container">
                                    <style media="screen">
                                        .left-custom-livechat-code {
                                            bottom: 58px !important;
                                        }

                                        #chat-widget-container {
                                            bottom: 51px !important;
                                        }
                                    </style>

                                    <div class="menu-bottom">
                                        <nav class="navbar-inverse navbar-fixed-bottom">
                                            <div class=" ">
                                                <div class="flex-row  text-center">
                                                    <div class=" footericon-single">
                                                        <a href="{{ URL::to('/') }}"><i class="icon-home"></i>
                                                            <div>HOME</div>
                                                        </a>
                                                    </div>
                                                    <div class="  footericon-single">
                                                        <a href="/promo/saya"><i class="icon-gift"></i>
                                                            <div>PROMO SAYA</div>
                                                        </a>
                                                    </div>


                                                    <div class=" footericon-single">
                                                        <a href="javascript:void(0);"
                                                            class="text-uppercase togglemenu-trigger footer-funds"
                                                            data-showID="#fundshover_menu"><i class="icon-transfer"></i>
                                                            <div>Dana</div>
                                                        </a>
                                                        <ul class="list-inline horizontal-hover togglemenu-content"
                                                            id="fundshover_menu">
                                                            <li>
                                                                <a href="{{ URL::to('account/deposit') }}"
                                                                    (click)
="closeNav($event);">
                                                                    <div class="fs-sm mt-1" i18n>Deposit</div>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ URL::to('account/withdrawal') }}"
                                                                    (click)="closeNav($event);">
                                                                    <div class="fs-sm mt-1" i18n>Withdraw</div>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ URL::to('account/lastDirectTransfer') }}"
                                                                    (click)="closeNav($event);">
                                                                    <div class="fs-sm mt-1" i18n="@History">Pernyataan
                                                                        &nbsp;
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class=" footericon-single">
                                                        <a href="{{ URL::to('memo') }}" style="position:relative;"><i
                                                                class="icon-mail_outline"></i>
                                                            <div>MEMO</div>

                                                            <div class="mail_icon" style="display:none;">
                                                                0
                                                            </div>

                                                        </a>
                                                    </div>

                                                    <div class=" footericon-single" style="position: relative">
                                                        <a href="javascript:void(0)"
                                                            class="text-uppercase togglemenu-trigger"
                                                            data-showID="#livechathover_menu"><i class="icon-chat1"></i>
                                                            <div>LIVE CHAT</div>
                                                        </a>
                                                        <ul class="list-inline vertical-hover togglemenu-content"
                                                            id="livechathover_menu">
                                                            <li>
                                                                <a href="{{ $setting->live_chat }}" target="_blank" rel="noopener noreferrer">
    <i class="icon-chat1"></i>
</a>

                                                            </li>
                                                            <li>
                                                                <a href="https://wa.me/{{ $setting->wa }}"
                                                                    target="_blank "><i class="icon-whatsapp"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="https://t.me/{{ $setting->tele }}"
                                                                    target="_blank "><i class="icon-telegram"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                    <button class="btn btn-link" id="btn-wrap--goToTop" onclick="topFunction()">
                                        <i class="i-collapse icon-chevron-thin-up"></i>
                                    </button>
                                    <script type="text/javascript">
                                        $(".togglemenu-trigger").click(function() {
                                            var currentToggle = $(this).attr("data-showID");
                                            if ($(currentToggle).hasClass("show")) {
                                                $(currentToggle).removeClass("show");
                                            } else {
                                                $(".togglemenu-content").removeClass("show");
                                                $(currentToggle).addClass("show");
                                            }

                                        });
                                    </script>
                                </div>
                            </div>
                        @else
                            <div class="mobilesite-footer">
                                <div class="container">
                                    <style media="screen">
                                        .left-custom-livechat-code {
                                            bottom: 58px !important;
                                        }

                                        #chat-widget-container {
                                            bottom: 51px !important;
                                        }
                                    </style>

                                    <div class="menu-bottom">
                                        <nav class="navbar-inverse navbar-fixed-bottom">
                                            <div class=" ">
                                                <div class="flex-row  text-center">
                                                    <div class=" footericon-single">
                                                        <a href="{{ URL::to('/') }}"><i class="icon-home"></i>
                                                            <div>HOME</div>
                                                        </a>
                                                    </div>
                                                    <div class="  footericon-single">
                                                        <a href="/promotion"><i class="icon-gift"></i>
                                                            <div>PROMOSI</div>
                                                        </a>
                                                    </div>

                                                    <div class=" footericon-single" style="position: relative">
                                                        <a href="javascript:void(0)"
                                                            class="text-uppercase togglemenu-trigger"
                                                            data-showID="#livechathover_menu"><i class="icon-chat1"></i>
                                                            <div>LIVE CHAT</div>
                                                        </a>
                                                        <ul class="list-inline vertical-hover togglemenu-content"
                                                            id="livechathover_menu">
                                                            <li>
<a href="{{ $setting->live_chat }}" target="_blank" rel="noopener noreferrer">
    <i class="icon-chat1"></i>
</a>

                                                            </li>
                                                            <li>
                                                                <a href="https://wa.me/{{ $setting->wa }}"
                                                                    target="_blank "><i class="icon-whatsapp"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="https://t.me/{{ $setting->tele }}"
                                                                    target="_blank "><i class="icon-telegram"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                    <button class="btn btn-link" id="btn-wrap--goToTop" onclick="topFunction()">
                                        <i class="i-collapse icon-chevron-thin-up"></i>
                                    </button>
                                    <script type="text/javascript">
                                        $(".togglemenu-trigger").click(function() {
                                            var currentToggle = $(this).attr("data-showID");
                                            if ($(currentToggle).hasClass("show")) {
                                                $(currentToggle).removeClass("show");
                                            } else {
                                                $(".togglemenu-content").removeClass("show");
                                                $(currentToggle).addClass("show");
                                            }

                                        });
                                    </script>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
                @include('layouts.sidebar')
            </div>

        </div>
        </div>


        <!--loading modal -->
        <div class="nifty-modal fade-in-scale" id="loading--layout" style="z-index:1000001;"
            data-isnotcloseoverlay="true">
            <div class="md-content">
                <div class='md-body'>

                    <div class="loader-b large"></div>
                </div>
            </div>
        </div>
        <div class='md-overlay' style="z-index:1000000;"></div>
        <!--END loading modal -->

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
                        <form action="" method="post" id="tw_transfer_form" class="tw_transfer_form">
                            <input type="hidden" name="_token" value="RATzFnH6qSWkknnJndb4pH0v5glsdIJZkh1MurC4">
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
                                                        class="minus-icon custom-icon">-</span>
                                                </div>

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
                                        class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
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
                                <img alt="" class="img-fluid"
                                    src="https://{{ $setting->nama_web }}.cfd/assets/images/log_html5.png"
                                    alt="play-in-browser">
                                <div class="download-caption text-center">
                                    Play now in your browser
                                </div>
                                <div class="download-linkbtn text-center">
                                    <img alt="" class="img-fluid"
                                        src="  https://{{ $setting->nama_web }}.cfd/assets/images/btn_playnow.png"
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
                            <img alt="" src="" class="draw_img" id='draw_img'>
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


        <!--<script src="/js/sweetalert.js"></script>  -->


        <script type="text/javascript">
            $(document).ready(function() {
                $("#mainContentContainer").click(function() {
                    $("#sideNav").removeClass("navContentOpen");
                    $("#sideNav").removeClass("open");
                    $("#mainContent").removeClass("navContentOpen");
                    $("#mainContent").removeClass("sideNavOpen");
                    $("#mainContent").removeClass("rightSideBarOpen");
                    $("#r-side-bar").removeClass("open");
                });

                //this is mobile version of btn close login modal
                $(document).on('click', '#btn-close--login-modal', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    $('#r-side-bar').removeClass('open');
                    $("#mainContent").removeClass("rightSideBarOpen");
                    return false;

                });

                $(document).on('click', '.btn-collapse-balances', function() {
                    if (!$('#other-game-bals').is(':visible')) {
                        $('#other-game-bals').slideDown();
                        window.getAllGameBal();
                    } else {
                        $('#other-game-bals').slideUp();
                    }
                    return false;
                });
            });
        </script>

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
                var dateNow = "2023-12-06 11:36:00";

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
                // $.ajax({
                //     url: "https://{{ $setting->nama_web }}.cfd/getPokerJackpotAmt",
                //     type: 'post',
                //     data: { _token: $('meta[name=csrf-token]').attr('content') },
                //     success: function (data) {
                //         prize = (data / 2000.000) * 2000.000;
                //         $('.jackpot_numbers_home').html(`IDR <span id="jackpot_amount">${commaSeparateNumber(prize)}</span>`)

                //$('.jackpot_numbers_home').html(`IDR ` + commaSeparateNumber(data.prize));
                //     }
                //  });
            }

            $.ajax({
                url: "{{ url('saldo-refresh') }}",
                timeout: 3000 // sets timeout to 3 seconds
            });

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

                $(".game-mode-locked").click(function(e) {
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
        </script>

        <script type="text/javascript"
            src="{{ asset('assets/js/ugsports/app-mobileee98.js?id=2cb3345d515ed5db54955fd50280e2fa') }}"></script>
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

        <script type="text/javascript">
            $(document).ready(function() {
                if (window.location.href.indexOf('reLogin=yes') >= 0 && !window.isAuth) {
                    $("#btnToggleRSideNav").trigger('click');
                }
            });
        </script>

        <!-- Start of LiveChat (www.livechat.com) code -->
        <script>
            window.__lc = window.__lc || {};
            window.__lc.license = 19421276;
            window.__lc.integration_name = "manual_channels";
            window.__lc.product_name = "livechat";
            ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};!n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
        </script>
        <noscript><a href="https://www.livechat.com/chat-with/19421276/" rel="nofollow">Chat with us</a>, powered by <a href="https://www.livechat.com/?welcome" rel="noopener noreferrer" target="_blank">LiveChat</a></noscript>
        <!-- End of LiveChat code -->


    </body>

    </html>
@endif
