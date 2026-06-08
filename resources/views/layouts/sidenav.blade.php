<div id="sideNav" class="side-nav">
    <nav class="nav-content">
        <ul class="side-nav-items">
            <li class="nav-item">
                <a class="navlink" href="{{ URL::to('/') }}" onclick="closeNav(-1);">
                    <div><i class="icon-home"></i></div> <!--routerLinkActiveOptions for root URL-->
                    <div class="nav-title" i18n="@HOME">HOME</div>
                </a>
            </li>
            @auth
            <li class="nav-item">
                <a href="javascript:void(0);" class="navlink has-sub" onclick="openNavItem(0);"
                    [ngclass]="{'active':isOpenNavContent[0], '':   !isOpenNavContent[0]}">
                    <div><i class="icon-coins"></i></div>
                    <div class="nav-title" i18n="@Funds">Dana</div>
                </a>
                <div class="nav-item-content" [ngclass]="{'open':isOpenNavContent[0], '':!isOpenNavContent[0]}">
                    <ul class="submenu account">
                        <li>
                            <a href="{{ URL::to('account/deposit') }}" (click)="closeNav($event);">
                                <div><span class="circle"><i class="icon-pig"></i></span></div>
                                <div class="fs-sm mt-1" i18n="">Deposit</div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('account/withdrawal') }}" (click)="closeNav;">
                                <div><span class="circle"><i class="icon-transfer"></i></span></div>
                                <div class="fs-sm mt-1" i18n="">Withdraw</div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('account/lastDirectTransfer') }}" (click)="closeNav;">
                                <div><span class="circle"><i class="icon-history"></i></span></div>
                                <div class="fs-sm mt-1" i18n="@History">Pernyataan &nbsp;</div>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            @endauth
            
            @guest
            <li class="nav-item" style="display: none">
                    <a href="javascript:void(0);" class="navlink has-sub" onclick="openNavItem(0);"
                        [ngClass]="{'active':isOpenNavContent[0], '':   !isOpenNavContent[0]}">
                        <div><i class="icon-coins"></i></div>
                        <div class="nav-title" i18n="@Funds">Dana</div>
                    </a>
                    <div class="nav-item-content" [ngClass]="{'open':isOpenNavContent[0], '':!isOpenNavContent[0]}">
                    </div>
            </li>
            @endguest

            <li class="nav-item">
                <a href="javascript:void(0);" class="navlink has-sub" onclick="openNavItem(1);"
                    [ngClass]="{'active':isOpenNavContent[1], '':   !isOpenNavContent[1]}">
                    <div><i class="icon-videogame_asset"></i></div>
                    <div class="nav-title" i18n>PERMAINAN</div>
                </a>
                <div class="nav-item-content games" [ngClass]="{'open':isOpenNavContent[1], '':!isOpenNavContent[1]}">
                    <ul class="submenu">
                        <!-- <i class="icon-lottery"></i>
                  <i  class="icon-others"></i>    -->
                        <li> <a href="{{ URL::to('/slots') }}" (click)="closeNav(-1);">
                                <div class="">
                                    <span class="circle">
                                        <i class="icon-slot"></i>

                                    </span>
                                    <span class='hot sub' style="">HOT</span>
                                </div>
                                <div class="fs-sm mt-1">SLOTS</div>
                            </a>
                        </li>
                        <li> <a href="{{ URL::to('/sports') }}" (click)="closeNav(-1);">
                                <div class="">
                                    <span class="circle">
                                        <i class="icon-soccer"></i>
                                    </span>
                                </div>
                                <div class="fs-sm mt-1">SPORTS</div>
                            </a>
                        </li>
                        <li> <a href="{{ URL::to('/casino') }}" (click)="closeNav(-1);">
                                <div class="">
                                    <span class="circle">
                                        <i class="icon-casino"></i>
                                    </span>
                                </div>
                                <div class="fs-sm mt-1">CASINO</div>
                            </a>
                        </li>
                        <li> <a href="{{ URL::to('/p2p') }}" (click)="closeNav(-1);">
                                <div class="">
                                    <span class="circle">
                                        <i class="icon-menu-poker-01"></i>
                                    </span>
                                </div>
                                <div class="fs-sm mt-1">P2P</div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('/fish-hunter') }}" (click)="closeNav(-1);">
                                <div class="">
                                    <span class="circle">
                                        <i class="icon-fish_hunter"></i>
                                    </span>
                                </div>
                                <div class="fs-sm mt-1">TEMBAK IKAN</div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('/lottery') }}" (click)="closeNav(-1);">
                                <div class="">
                                    <span class="circle">
                                        <i class="icon-lottery"></i>

                                    </span>
                                    <span class="hot sub new ">NEW</span>
                                </div>
                                <div class="fs-sm mt-1">LOTRE</div>
                            </a>
                        </li>
                        <li> <a href="{{ URL::to('/e-games') }}" (click)="closeNav(-1);">
                                <div class="">
                                    <span class="circle">
                                        <i class="icon-others"></i>
                                    </span>
                                </div>
                                <div class="fs-sm mt-1">E-GAMES</div>
                            </a>
                        </li>
                        <li> <a href="{{ URL::to('/cockfight') }}" (click)="closeNav(-1);">
                                <div class="">
                                    <span class="circle">
                                        <i class="icon-cockfight"></i>
                                    </span>
                                </div>
                                <div class="fs-sm mt-1">SABUNG AYAM</div>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="navlink" href="{{ URL::to('/promotion') }}" onclick="closeNav(-1);">
                    <div><i class="icon-gift"></i></div> <!--routerLinkActiveOptions for root URL-->
                    <div class="nav-title" i18n="@PROMOS">PROMOSI</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="navlink" href="{{ $setting->live_chat}}" onclick="closeNav(-1);">
                    <div><i class="icon-info"></i></div> <!--routerLinkActiveOptions for root URL-->
                    <div class="nav-title" i18n="@INFO">INFO</div>
                </a>
            </li>
            <li class="nav-item">
                <a class="navlink" href="{{ URL::to('/contact-us') }}" onclick="closeNav(-1);">
                    <div><i class="icon-address-book"></i></div> <!--routerLinkActiveOptions for root URL-->
                    <div class="nav-title" i18n>HUBUNGI KAMI</div>
                </a>
            </li>
            <li class="nav-item">
    <a class="navlink" href="https://jemuranbaru.shop/" target="_blank" rel="noopener noreferrer" onclick="closeNav(-1);">
        <div>
            <img alt="" src="https://files.sitestatic.net/ImageFile/64704116d79f5_RTP%20slot.png"
                 style="height:26px;width:auto;">
        </div>
        <div class="nav-title">RTP GACOR</div>
    </a>
</li>

            <li class="nav-item">
                <a href="javascript:void(0);" class="navlink" onclick="closeNav();" data-trigger='nifty'
                    data-target='#langModal-mobile'>
                    <div><i class="icon-language"></i></div>
                    Bahasa
                </a>
            </li>
            <li class="nav-item">
                <a class="navlink" href="{{ $setting->live_chat}}" onclick="closeNav(-1);">
                    <div><i class="icon-info"></i></div> <!--routerLinkActiveOptions for root URL-->
                    <div class="nav-title">Pengaduan Member</div>
                </a>
            </li>
            <li class="nav-item"><a href="javascript:void(0);" class="navlink" onclick="closeNav();"> <i
                        class="icon-double_arrow_l"></i></a></li>
        </ul>
    </nav>
    <script>
        var arr = [0, 0];

        function openNavItem(index) {
            $('.nav-item-content').removeClass('open');
            $('.navlink.has-sub').removeClass('active');
            if (index >= 0) {
                $('.nav-item-content').eq(index).addClass('open');
                $('.navlink.has-sub').eq(index).addClass('active');
                $("#mainContent").addClass("navContentOpen");
                $("#sideNav").addClass("navContentOpen");
            }
        }

        function closeNav() {
            $('.nav-item-content').removeClass('open');
            $('.navlink.has-sub').removeClass('active');

            $("#sideNav").removeClass("navContentOpen");
            $("#sideNav").removeClass("open");
            $("#mainContent").removeClass("navContentOpen");
            $("#mainContent").removeClass("sideNavOpen");

        }
    </script>
</div>
