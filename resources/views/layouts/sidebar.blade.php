<?php
use App\Models\Saldo;
use App\Http\Api\fiver;
?>
<div id="r-side-bar">
    @if (Auth::check())
        @php
            $SG = new fiver();
            $act = json_decode($SG->userbalance(Auth()->user()->name));
            $saldos = $act->user->balance ?? 'x';
        @endphp
        <div class="side-bar-content container">
            <!--This Blade is just to cater for multiple extends -->
            <div class="container-wrapper profile-head">
                <div class="container container-box noSidePadding">
                    <div class="title fs-lg clearfix">
                        <button class="btn btn-link " id="btn-close--login-modal"> X
                        </button>&nbsp;&nbsp;
                        <span class="skew">
                            <span>Profil saya</span>
                        </span>
                        <a href="{{ route('logout') }}" class="btn-logout" *ngif="isMobile"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i
                                class="icon-logout"></i></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    </div>
                    <div class="head-content">
                        <div class="row no-gutters">
                            <div class="col-xs-12 col-sm-6 col-md-7">
                                <div class="row no-gutters">
                                    <div class="clearfix col-xs-12 col-md-7">

                                        <div class="acc_safety_info ">

                                            <div class="flex-row  text-center icon_menu">
                                                <div class="icon-single">
                                                    <a href="{{ URL::to('refferal') }}">
                                                        <i class="icon-user1"></i>
                                                        <div>Referral</div>
                                                    </a>
                                                </div>
                                                <div class="icon-single">
                                                    <a href="{{ URL::to('memo') }}" class="mail_link">
                                                        <i class="icon-envelope"></i>
                                                        <div>Memo</div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-5  mt-4  mt-md-2">

                            </div>
                            <div class="col-xs-12 swiper-initialized swiper-horizontal swiper-ios" id="wallet-slider">
                                <div class="swiper-wrapper" id="swiper-wrapper-f81e6694a31306d7" aria-live="polite"
                                    style="transition-duration: 0ms; transform: translate3d(31px, 0px, 0px);">
                                    <div class="bal-box swiper-slide swiper-slide-active" role="group"
                                        aria-label="1 / 2">
                                        <button class="btn btn-clear btn-refresh-wallet">
                                            <div class="row no-gutters">
                                                <!--<label for="inputWalletBal" class="col-2 col-form-label"><i class="icon-wallet"></i></label>-->
                                                <div class="col-xs-12">
                                                    <!--<i class="icon-wallet"></i>  &nbsp;-->
                                                    <div class="d-flex" style="align-items:center">
                                                        <span class="bal-txt fs-lg">IDR {{$saldos}}</span>
                                                        &nbsp;
                                                        <i class="i-refresh icon-refresh-2"></i>
                                                    </div>
                                                    <div class="bal-title">
                                                        Saldo Utama </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                </button>
                            </div>
                        </div>
                        <div class="col-xs-12  mt-3  ">
                            <div class="mdc-tab-bar" role="tablist">
                                <div class="mdc-tab-scroller">
                                    <div class="mdc-tab-scroller__scroll-area mdc-tab-scroller__scroll-area--scroll"
                                        style="margin-bottom: 0px;">
                                        <div class="mdc-tab-scroller__scroll-content">

                                            <a role="tab" href="#" data-tabname="edit"
                                                data-active="profileedit" class="mdc-tab active" aria-selected="false"
                                                tabindex="-1" id="goog_2098347606-FIXED-0">
                                                <span class="mdc-tab__content">
                                                    <span class="mdc-tab__text-label">Detail</span>
                                                </span>
                                                <span class="mdc-tab-indicator active">
                                                    <span
                                                        class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                                </span>
                                                <span class="mdc-tab__ripple mdc-ripple-upgraded"
                                                    style="--mdc-ripple-fg-size:91px; --mdc-ripple-fg-scale:1.8648; --mdc-ripple-fg-translate-start:76px, -10.5px; --mdc-ripple-fg-translate-end:30.6563px, -21.5px;"></span>
                                            </a>

                                            <a role="tab" href="#" data-tabname="change-password"
                                                data-active="profilechange-password" class="mdc-tab"
                                                aria-selected="true" tabindex="0" id="goog_2098347606-FIXED-1">
                                                <span class="mdc-tab__content">
                                                    <span class="mdc-tab__text-label">Tukar kata sandi</span>
                                                </span>
                                                <span class="mdc-tab-indicator">
                                                    <span
                                                        class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"
                                                        style=""></span>
                                                </span>
                                                <span class="mdc-tab__ripple mdc-ripple-upgraded"
                                                    style="--mdc-ripple-fg-size:93px; --mdc-ripple-fg-scale:1.85613; --mdc-ripple-fg-translate-start:48.6875px, -6.5px; --mdc-ripple-fg-translate-end:31.1875px, -22.5px;"></span>
                                            </a>

                                            <a role="tab" href="#" data-tabname="referral-downline"
                                                data-active="profilereferral-downline" class="mdc-tab ref_down"
                                                aria-selected="false" tabindex="-1" id="goog_2098347606-FIXED-3">
                                                <span class="mdc-tab__content">

                                                    <span class="mdc-tab__text-label">
                                                        <!---->Referral Downline
                                                        <!---->
                                                    </span>

                                                </span>

                                                <span class="mdc-tab-indicator">
                                                    <span
                                                        class="mdc-tab-indicator__content
                        mdc-tab-indicator__content--underline"
                                                        style=""></span>
                                                </span>

                                                <span class="mdc-tab__ripple mdc-ripple-upgraded"
                                                    style="--mdc-ripple-fg-size:102px; --mdc-ripple-fg-scale:1.83267; --mdc-ripple-fg-translate-start:-44.1875px, -35px; --mdc-ripple-fg-translate-end:34.1484px, -27px;"></span>
                                            </a>
                                            <!---->
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="outlet tab-content">
                        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">

                            <div class="container-b3">
                                <!--Outlet -->
                                @include('profile_edit')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $(".comingsoon").click(function(e) {
                    $("#btn-close--login-modal").trigger("click");
                    e.preventDefault();
                    sweetAlert(transMsgs.pageComingSoon);
                    return false;
                });
            });
        </script>
</div>
@else
<div class="side-bar-content container">
    <div class="modal-header text-center">
        <button class="btn btn-link pull-left" id="btn-close--login-modal"> X </button>
        <div style="width:100%;">
            <h4 class="text-center modal-title">Login</h4>
        </div>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group ">
                <label for="password" class="fs-lg" i18n>Nama pengguna</label>
                <div class="icon-input">
                    <input type="text" class="form-control input-l" maxlength="50" name="name"
                        autocomplete="off" required="required" id="UserName" aria-describedby="emailHelp"
                        placeholder="">
                    <i class="icon-user left"></i>

                </div>
            </div>
            <div class="form-group ">
                <label for="password" class="fs-lg" i18n>Kata sandi</label>
                <div class="icon-input">
                    <input type="password" class="form-control  input-l" maxlength="20" id="pwd--login"
                        name="password" required="required" autocomplete="current-password" />
                    <i class="icon-lock left"></i>
                    <i class="icon-eye toggle-password" input_id="#pwd--login"></i>
                </div>
            </div>
            <div class="row  alert alert-danger message" _login-modal>
            </div>

            <div class="form-group text-center">
                <button type="submit" *ngIf="!inProgress"
                    class="btn btn-block btn-primary fs-lg btn-submit">Login</button>
                <button type="button" *ngIf="!inProgress" class="btn btn-link" id="forgotPwd-btn--login-modal"
                    i18n>
                    Lupa kata sandi? &nbsp;<i class="icon-redo"></i>
                </button>

                <app-ellipsis *ngIf="inProgress"></app-ellipsis>
            </div>

        </form>

        <form class="form-horizontal" id="resetPwdForm" name="resetPwdForm" action="#" method="post">
            <input type="hidden" name="_token" value="dU4nr3xiTxFrQjyAStwrVhbk8pq9VALo3PyK4r6H">

            <div class="form-group">
                <label for="password" class="fs-lg" i18n>Alamat email</label>
                <div class="icon-input">
                    <input type="email" class="form-control input-l" name="email" required="required"
                        id="email" aria-describedby="emailHelp" placeholder="">
                    <i class="icon-envelope left"></i>
                </div>
            </div>
            <div class="form-group row no-gutters">
                <div class="col-xs-8 col-md-8">
                    <input type="tel" id='registerCaptchaimg' class="form-control" name="forgotPwCaptchaimg"
                        maxlength="4" autocomplete="off" style="height: 50px;" placeholder="Captcha">
                </div>
                <button class="btn btn-refresh col-xs-4 col-md-4 text-left" type="button" id="fogotrefreshCaptcha">
                    {{-- <img alt="" data-url="https://www.geo138.life/captcha-image-forgotpw?v=1685090819"
                                id="forgotPwCaptchaimgpath" class="captcha_img" autocomplete="off"> --}}
                    <i class="icon-refresh"></i>
                </button>
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
                    <input type="password" maxlength="1" name="pincode[0]" required class="form-control pincode"
                        style="width:16.66%">
                    <input type="password" maxlength="1" name="pincode[1]" required class="form-control pincode"
                        style="width:16.66%">
                    <input type="password" maxlength="1" name="pincode[2]" required class="form-control pincode"
                        style="width:16.66%">
                    <input type="password" maxlength="1" name="pincode[3]" required class="form-control pincode"
                        style="width:16.66%">
                    <input type="password" maxlength="1" name="pincode[4]" required class="form-control pincode"
                        style="width:16.66%">
                    <input type="password" maxlength="1" name="pincode[5]" required class="form-control pincode"
                        style="width:16.66%">
                </div>
            </div>
            <div class="form-group button-group">
                <div class="row">
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-round btn-block pinkey" type="button" value="0">
                    </div>
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-round btn-block pinkey" type="button" value="7">
                    </div>
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-round btn-block pinkey" type="button" value="1">
                    </div>
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-round btn-block pinkey" type="button" value="6">
                    </div>
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-round btn-block pinkey" type="button" value="2">
                    </div>
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-round btn-block pinkey" type="button" value="5">
                    </div>
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-round btn-block pinkey" type="button" value="4">
                    </div>
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-round btn-block pinkey" type="button" value="9">
                    </div>
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-round btn-block pinkey" type="button" value="8">
                    </div>
                    <div class="col-xs-4">
                        <input id='back_bt' class="btn btn-warning btn-block  btn-round" type="button"
                            value="RESET">
                    </div>
                    <div class="col-xs-4">
                        <input class="btn btn-primary btn-block  btn-round pinkey" type="button" value="3">
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-info btn-round btn-block waves-effect waves-light btn-submit"
                            type="submit">Kirimkan</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"></div>
                    <div class="col-xs-4"><a style="" class="btn btn-danger btn-round btn-block waves-effect "
                            href="#" i18n="@Logout">LOGOUT</a></div>
                    <div class="col-xs-4"></div>
                </div>
            </div>
            <div class="row  alert alert-danger message" _login-modal>
            </div>
        </form>
    </div>
    <div class="modal-footer text-center" id="footer--login-modal">
        <div class="footer-content">Tidak terdaftar? <a href="{{ URL::to('register') }}" i18n>Daftar</a></div>
    </div>
</div>
@endif

</div>
