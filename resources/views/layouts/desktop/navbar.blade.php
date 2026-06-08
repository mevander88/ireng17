<div class="main nav-wrapper">
    <div>
        <div class="main-nav nav nav-pills nav-fill ">
            <div class="nav-item">
                <div class="nav-item-content ">
                    <div class="container">
                        <div class="flex-row">
                            <div class="auto-box text-center active  " style="flex: 0 0 15%;">
                                <a href="{{ URL::to('/') }}" target="_blank" rel="noopener noreferrer">
                                    <div class="text-center  ">
                                        <img src="{{ asset('assets/images/nav_imgs/Sub-InfoCentre.png') }}"
                                            class="  img-fluid   " alt="info">
                                    </div>
                                    <div class="menu-item-title ">Pusat Info</div>
                                </a>
                            </div>
                            <div class="auto-box text-center active  " style="flex: 0 0 15%;">
                                <a href="{{ URL::to('/') }}" target="_blank" rel="noopener noreferrer">
                                    <div class="text-center  ">
                                        <img src="{{ asset('assets/images/nav_imgs/Sub-ContactUs.png') }}"
                                            class="  img-fluid  " alt="Hubungi kami">
                                    </div>
                                    <div class="menu-item-title">Hubungi kami</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item ">
                <!--*ngFor="let menuItem of arrMenu"-->
                <a class="navlink {{ Request::is('slots') ? 'active' : '' }}" href="{{ URL::to('/slots') }}">
                    <!--[routerLink]="['/games/slots',menuItem.MenuTitle]"-->
                    <div class="nav-icon ">
                        <span>
                            <i *ngif="menuItem.MenuTitleCode==MenuTitleCode.SLOTS" class="icon-slot"></i>
                        </span>
                        <span class="hot">HOT</span>
                    </div>
                    <div class="nav-title">
                        slots </div>
                </a>

                <div class="nav-item-content ">
                    <div class="container">
                        <div class="flex-row">
                            <div class="auto-box text-center active pragmatic-play"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots/game_list/pragmatic') }}">
                                    <img alt="" src="https://files.sitestatic.net/images/ppslot.gif?v=1"
                                        data-src="https://files.sitestatic.net/images/ppslot.gif?v=1" *ngif="showEle"
                                        height="90">
                                    <div class="menu-item-title">PRAGMATIC</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active reel-kingdom"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/reelkingdom_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/reelkingdom_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">REEL KINGDOM</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active pgsoft"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt="" src="https://files.sitestatic.net/images/pgsoft.gif?v=0.2"
                                        data-src="https://files.sitestatic.net/images/pgsoft.gif?v=0.2" *ngif="showEle"
                                        height="90">
                                    <div class="menu-item-title">PGSOFT</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active joker-gaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <div class="hot-tag"></div>
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jk_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jk_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">JOKER</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active habanero"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <div class="hot-tag"></div>
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hb_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hb_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">HABANERO</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active playtech"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="/slots/game_list/playtech">
                                    <div class="hot-tag"></div>
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pt_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pt_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">PLAYTECH</div>

                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active microgaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <div class="hot-tag"></div>
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/mg_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/mg_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">MICRO GAMING</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hacksaw"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hacksaw_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hacksaw_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">HACKSAW</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active relax"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/relax_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/relax_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">RELAX GAMING</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active playson"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ttg_playson_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ttg_playson_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">PLAYSON</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active booming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ttg_booming_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ttg_booming_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">BOOMING</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active cq9"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/cq9_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/cq9_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">CQ9</div>

                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active booongo"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <div class="hot-tag"></div>
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/booongo_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/booongo_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">BNG</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active spadegaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sg_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sg_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">SPADE GAMING</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active toptrend-gaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ttg_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ttg_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">TOPTREND GAMING</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active playngo"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/playngo_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/playngo_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">PLAYNGO</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active fastspin"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <div class="hot-tag"></div>
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/fastspin_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/fastspin_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">FASTSPIN</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active skywind"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/skywind_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/skywind_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">SKYWIND</div>

                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active playstar"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/playstar_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/playstar_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">PLAYSTAR</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active redtiger"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/redtiger_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/redtiger_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">REDTIGER</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active evoplay"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/evoplay_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/evoplay_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">EVOPLAY</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active netent"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/redtiger_net_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/redtiger_net_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">NETENT</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active nolimitcity"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/nolimitcity_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/nolimitcity_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">NOLIMITCITY</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active mancalagaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/mancalagaming_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/mancalagaming_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">MANCALA GAMING</div>

                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active kagaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/kagaming_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/kagaming_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">KA GAMING</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active sbo"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sbo_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sbo_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">SBO</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active nagagames"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/nagagames_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/nagagames_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">NAGA GAMES</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active ais"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <div class="a-disabledLink bg-um maintenance-alert">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ais_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ais_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">AIS GAMING</div>
                                </div>


                            </div>
                            <div class="auto-box text-center active dragoonsoft"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/dragoon_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/dragoon_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">DRAGOON SOFT</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active reevo"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/reevo_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/reevo_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">REEVO</div>

                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active live22"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/live22_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/live22_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">LIVE22</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active fachai"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/fachai_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/fachai_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">FACHAI</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active apollo777"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/apollo777_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/apollo777_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">APOLLO777</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active advantplay"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/advantplay_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/advantplay_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">ADVANTPLAY</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active bgaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/bgaming_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/bgaming_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">BGAMING</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active jdb"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jdb_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jdb_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">JDB</div>

                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active jili"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jili_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jili_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">JILI</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active 568win"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sbo_568win_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sbo_568win_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">568 WIN</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active i8"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/i8_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/i8_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">i8</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active gmw"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/slots') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/gmw_slot.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/gmw_slot.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">GMW</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <div class="a-disabledLink  login-alert">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </div>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="//">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item a">
                <!--*ngFor="let menuItem of arrMenu"-->
                <a class="navlink {{ Request::is('sports') ? 'active' : '' }}" href="{{ URL::to('/sports') }}">
                    <!--[routerLink]="['/games/slots',menuItem.MenuTitle]"-->
                    <div class="nav-icon ">
                        <span>
                            <i *ngif="menuItem.MenuTitleCode==MenuTitleCode.SPORTS" class="icon-soccer"></i>
                        </span>
                    </div>
                    <div class="nav-title">
                        sports </div>
                </a>

                <div class="nav-item-content ">
                    <div class="container">
                        <div class="flex-row">
                            <div class="auto-box text-center active cmd"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">

                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">
                                    <div class="hot-tag"></div>
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/cmds_sport.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/cmds_sport.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">CMD SPORTS</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active wbet"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/wbet_sport.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/wbet_sport.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">WBET Sport</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active sbo"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sbo_sport_new.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sbo_sport_new.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">SBO SPORTS</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active ibc"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ibc_sport.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ibc_sport.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">SABA SPORTS</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active united-gaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_sport.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_sport.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">UNITED GAMING</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active bti"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/bti_sport.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/bti_sport.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">BTI SPORTS</div>
                                </a>


                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active beter"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/beter_sport.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/beter_sport.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">BETER ESPORT</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/sports') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item ">
                <!--*ngFor="let menuItem of arrMenu"-->
                <a class="navlink {{ Request::is('casino') ? 'active' : '' }}" href="{{ url('casino') }}">
                    <!--[routerLink]="['/games/slots',menuItem.MenuTitle]"-->
                    <div class="nav-icon ">
                        <span>
                            <i *ngif="menuItem.MenuTitleCode==MenuTitleCode.CASINO" class="icon-casino"></i>
                        </span>
                    </div>
                    <div class="nav-title">
                        casino </div>
                </a>

                <div class="nav-item-content ">
                    <div class="container">
                        <div class="flex-row">

                            <div class="auto-box text-center active pragmatic-play"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt="" src="https://files.sitestatic.net/images/ppslot.gif?v=1"
                                        data-src="https://files.sitestatic.net/images/ppslot.gif?v=1" *ngif="showEle"
                                        height="90">
                                    <div class="menu-item-title">PRAGMATIC</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active welive"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/we_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/we_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">WE</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active playtech"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <div class="hot-tag"></div>
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pt_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pt_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">PLAYTECH</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active allbet"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/allbet_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/allbet_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">ALLBET</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active beter"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/beter_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/beter_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">BETER</div>
                                </a>
                            </div>
                            <div class="auto-box text-center active microgaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">
                                    <div class="hot-tag"></div>
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/mg_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/mg_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">MICROGAMING</div>
                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active evo"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/evo_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/evo_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">EVO</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active sa-gaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sa_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sa_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">SA</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active sexy-baccarat"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sb_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sb_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">AE</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active asia-gaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ag_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ag_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">AG</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active 568win"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sbo_casino_new.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sbo_casino_new.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">568win</div>
                                </a>
                            </div>
                            <div class="auto-box text-center active n2live"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/n2live_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/n2live_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">N2LIVE</div>
                                </a>


                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active opus"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/opus_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/opus_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">OPUS</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active wm"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/wm_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/wm_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">WM</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active w"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/w_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/w_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">W</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active dreamgaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/dream_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/dream_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">DREAM GAMING</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active ezugi"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ezugi_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ezugi_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">EZUGI</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active skywind"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/skywind_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/skywind_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">SKYWIND</div>
                                </a>


                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active lg88"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/lg88_casino.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/lg88_casino.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">LG88</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/casino') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item ">
                <!--*ngFor="let menuItem of arrMenu"-->
                <a class="navlink" href="/p2p">
                    <!--[routerLink]="['/games/slots',menuItem.MenuTitle]"-->
                    <div class="nav-icon ">
                        <span>
                            <i *ngif="menuItem.MenuTitleCode==MenuTitleCode.P2P" class="icon-menu-poker-01"></i>
                        </span>
                    </div>
                    <div class="nav-title">
                        p2p </div>
                </a>

                <div class="nav-item-content ">
                    <div class="container">
                        <div class="flex-row">

                            <div class="auto-box text-center active hkb"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/p2p') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkb_poker.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkb_poker.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">HKB POKER</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/p2p') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/p2p') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/p2p') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/p2p') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/p2p') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item ">
                <!--*ngFor="let menuItem of arrMenu"-->
                <a class="navlink" href="/fish-hunter">
                    <!--[routerLink]="['/games/slots',menuItem.MenuTitle]"-->
                    <div class="nav-icon ">
                        <span>
                            <i *ngif="menuItem.MenuTitleCode==MenuTitleCode.FISHHUNTER" class="icon-fish_hunter"></i>
                        </span>
                    </div>
                    <div class="nav-title">
                        tembak ikan </div>
                </a>

                <div class="nav-item-content ">
                    <div class="container">
                        <div class="flex-row">

                            <div class="auto-box text-center active joker-gaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jk_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jk_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">JOKER</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active playstargame"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/playstar_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/playstar_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">PLAYSTAR</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active spadegaming"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sg_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sg_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">SPADE GAMING</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active cq9"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/cq9_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/cq9_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">CQ9</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active skywind"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/skywind_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/skywind_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">SKYWIND</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active dragoonsoft_fishing"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/dragoon_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/dragoon_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">DRAGOON SOFT</div>

                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active kagaming_fishing"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/kagaming_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/kagaming_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">KA GAMING</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active fastspin_fishing"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/fastspin_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/fastspin_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">FASTSPIN</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active live22_fishing"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/live22_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/live22_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">LIVE22</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active fachai_fishing"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/fachai_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/fachai_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">FACHAI</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active jdb_fishing"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jdb_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jdb_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">JDB</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active jili"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jili_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jili_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">JILI</div>

                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active i8"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/i8_fishing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/i8_fishing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">i8</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/fish-hunter') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>

                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item ">
                <!--*ngFor="let menuItem of arrMenu"-->
                <a class="navlink" href="/lottery">
                    <!--[routerLink]="['/games/slots',menuItem.MenuTitle]"-->
                    <div class="nav-icon ">
                        <span>
                            <i class="icon-lottery"></i>
                        </span>
                        <span class="hot new">NEW</span>

                    </div>
                    <div class="nav-title">
                        LOTRE </div>
                </a>

                <div class="nav-item-content ">
                    <div class="container">
                        <div class="flex-row">

                            <div class="auto-box text-center active hkb"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/lottery') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkb_lottery.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkb_lottery.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">HKB TOGEL</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hkb/live"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/lottery') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkb_live.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkb_live.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">HKB LIVE</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active live-virtual-4d"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/lottery') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkgp_togel.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkgp_togel.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Togel</div>
                                </a>


                            </div>
                            <div class="auto-box text-center active hkgp-bingo"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/lottery') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkgp_number.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkgp_number.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Number Games</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active racing-car"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/lottery') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkgp_racing.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hkgp_racing.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Racing Car</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/lottery') }}">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item ">
                <!--*ngFor="let menuItem of arrMenu"-->
                <a class="navlink {{ Request::is('e-games') ? 'active' : '' }}" href="{{ URL::to('e-games') }}">
                    <!--[routerLink]="['/games/slots',menuItem.MenuTitle]"-->
                    <div class="nav-icon ">
                        <span>
                            <i class="icon-others"></i>
                        </span>
                    </div>
                    <div class="nav-title">
                        e-games </div>
                </a>

                <div class="nav-item-content ">
                    <div class="container">
                        <div class="flex-row">
                            <div class="auto-box text-center active gemini"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('/e-games') }}">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/gemini_rng.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/gemini_rng.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">GEMINI</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active jili"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jili_rng.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/jili_rng.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">JILI</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active classic-bola-tangkas"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/classic_bola_blind_1.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/classic_bola_blind_1.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Classic Bola Tangkas</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active baccarat"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/baccarat_1.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/baccarat_1.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Baccarat</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active stud-poker"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/poker_1.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/poker_1.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Caribbean Stud Poker</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active classic-15-keno"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/keno_3.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/keno_3.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Classic Keno 10</div>

                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active classic-8-keno"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/keno_2.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/keno_2.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Classic Keno 8</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active ultimate-keno"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/keno_1.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/keno_1.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Ultimate Keno</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active bola-tangkas"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/bola_blind_1.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ug_rng/bola_blind_1.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Bola Tangkas</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active multihand-blackjack"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/bjma.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/bjma.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Multihand Blackjack</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active big-bass-crash"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/1320.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/1320.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Big Bass Crash</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active spaceman"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/1302.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/1302.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Spaceman</div>

                                </a>

                            </div>
                        </div>
                        <div class="flex-row">

                            <div class="auto-box text-center active american-blackjack"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/bjmb.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/bjmb.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">American Blackjack</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active roulette"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/rla.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/rla.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Roulette</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active dragon-bonus-baccarat"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/bnadvanced.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/bnadvanced.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Dragon Bonus Baccarat</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active dragon-tiger"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/bndt.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/bndt.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Dragon Tiger</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active pp-baccarat"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/bca.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/pp_rng/bca.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">Baccarat</div>

                                </a>

                            </div>
                            <div class="auto-box text-center active hide_this_sec"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('e-games') }}" target="_blank">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item ">
                <!--*ngFor="let menuItem of arrMenu"-->
                <a class="navlink {{ Request::is('cockfight') ? 'active' : '' }}"
                    href="{{ URL::to('cockfight') }}">
                    <!--[routerLink]="['/games/slots',menuItem.MenuTitle]"-->
                    <div class="nav-icon ">
                        <span>
                            <i *ngif="menuItem.MenuTitleCode==MenuTitleCode.COCKFIGHT" class="icon-cockfight"></i>
                        </span>
                    </div>
                    <div class="nav-title">
                        sabung ayam </div>
                </a>
                <div class="nav-item-content ">
                    <div class="container">
                        <div class="flex-row">
                            <div class="auto-box text-center active sv388"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <a rel="noopener noreferrer" href="{{ URL::to('cockfight') }}" target="_blank">
                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sv388_cf.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sv388_cf.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">SV388</div>
                                </a>
                            </div>
                            <div class="auto-box text-center active ws168"
                                [ngclass]="{'flex-grow-2' : item.FlexGrow =='2'}">
                                <div class="a-disabledLink  maintenance-alert">

                                    <img alt=""
                                        src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ws168_cf.png"
                                        data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/ws168_cf.png"
                                        *ngif="showEle" height="90">
                                    <div class="menu-item-title">WS168</div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item ">
                <a class="navlink {{ Request::is('promotion') ? 'active' : '' }}"
                    href="{{ URL::to('promotion') }}">
                    <div class="nav-icon">
                        <span><i class="icon-gift"></i></span>
                    </div>
                    <div class="nav-title" i18n="@PROMOS">PROMOSI</div>
                </a>
            </div>
            <div class="nav-item">
                <a class="navlink " href="https://rtphijau.fun/" target="_blank" rel="noopener noreferrer">
                    <div class="nav-icon">
                        <span>
                            <i></i>
                            <img alt="" src="https://files.sitestatic.net/ImageFile/64704116d79f5_RTP slot.png"
                                style="max-width: 75px; height: 40px; margin-bottom:0;">
                        </span>
                    </div>
                    <div class="nav-title">RTP GACOR</div>
                </a>
            </div>
        </div>
    </div>
</div>
