<div class="container pt-2 ">
    <div class="scroll-wrapper row games-slider-menu">
        <div class="slider" style="overflow:hidden;">
            <div class="left"><button class="prev-btn btn" id="left-button"><i
                        class="icon-keyboard_arrow_left"></i></button></div>

            <div class="row no-gutters text-center slider-content">
                <!--//hardcoded links.......-->



                <div class="col">

                    <a class="btn-box {{ Request::is('/slots/game_list/pragmatic') ? 'active' : '' }}"
                        href="{{ URL::to('/slots/game_list/pragmatic') }}" rel="noopener noreferrer">
                        <img alt="" src="https://files.sitestatic.net/images/ppslot.gif?v=1"
                            data-src="https://files.sitestatic.net/images/ppslot.gif?v=1" *ngif="showEle"
                            height="70">
                        <div class="text-center fs-md game-title">PRAGMATIC</div>
                    </a>
                </div>



                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/pgsoft') ? 'active' : '' }}"
                        href="{{ URL::to('/slots/game_list/pgsoft') }}" rel="noopener noreferrer">
                        <img alt="" src="https://files.sitestatic.net/images/pgsoft.gif?v=0.2"
                            data-src="https://files.sitestatic.net/images/pgsoft.gif?v=0.2" *ngif="showEle"
                            height="70">
                        <div class="text-center fs-md game-title">PGSOFT</div>
                    </a>
                </div>

                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/habanero') ? 'active' : '' }}"
                        href="{{ URL::to('/slots/game_list/habanero') }}" rel="noopener noreferrer">
                        <img alt=""
                            src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hb_slot.png?v=0.1"
                            data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hb_slot.png?v=0.1"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">HABANERO</h5>
                    </a>
                </div>



                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/cq9') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/cq9') }}" rel="noopener noreferrer">
                        <img alt=""
                            src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/cq9_slot.png?v=0.1"
                            data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/cq9_slot.png?v=0.1"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">CQ9</h5>
                    </a>
                </div>

                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/evoplay') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/evoplay') }}" rel="noopener noreferrer">
                        <img alt=""
                            src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/evoplay_slot.png?v=0.1"
                            data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/evoplay_slot.png?v=0.1"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">evoplay</h5>
                    </a>
                </div>

                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/qqkeno') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/qqkeno') }}" rel="noopener noreferrer">
                        <img alt="" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCuWaCvYtTOf2n733Z_crMfz_iyRA7SXH2vdHKV1Ha0yQB_O8H2lssPrtZdJQbKf5KkA&usqp=CAU" data-src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCuWaCvYtTOf2n733Z_crMfz_iyRA7SXH2vdHKV1Ha0yQB_O8H2lssPrtZdJQbKf5KkA&usqp=CAU" ngif="showEle"
                            height="70" />

                        <h5 class="text-center fs-md game-title">QQ Keno</h5>
                    </a>
                </div>

                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/toptrend') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/toptrend') }}" rel="noopener noreferrer">
                        <img alt="" src="../../assets/top.jpeg" data-src="../../assets/top.jpeg" ngif="showEle"
                            height="70" />

                        <h5 class="text-center fs-md game-title">TOPTREND</h5>
                    </a>
                </div>
                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/dreamtech') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/dreamtech') }}" rel="noopener noreferrer">
                        <img alt="" src="../../assets/dream.png" data-src="../../assets/dream.png"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">DREAMTECH</h5>
                    </a>
                </div>
                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/booongo') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/booongo') }}" rel="noopener noreferrer">
                        <img alt="" src="../../assets/booongo.png" data-src="../../assets/booongo.png"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">BOOONGO</h5>
                    </a>
                </div>
                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/playson') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/playson') }}" rel="noopener noreferrer">
                        <img alt="" src="../../assets/playson.png" data-src="../../assets/playson.png"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">PLAYSON</h5>
                    </a>
                </div>

                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/spadegaming') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/spadegaming') }}" rel="noopener noreferrer">
                        <img alt=""
                            src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sg_slot.png?v=0.1"
                            data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/sg_slot.png?v=0.1"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">spadegaming</h5>
                    </a>
                </div>

                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/microgaming') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/microgaming') }}" rel="noopener noreferrer">
                        <img alt=""
                            src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/mg_slot.png?v=0.1"
                            data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/mg_slot.png?v=0.1"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">Microgaming</h5>
                    </a>
                </div>

                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/playstar') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/playstar') }}" rel="noopener noreferrer">
                        <img alt=""
                            src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/playstar_slot.png?v=0.1"
                            data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/playstar_slot.png?v=0.1"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">Playstar</h5>
                    </a>
                </div>



                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/playngo') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/playngo') }}" rel="noopener noreferrer">
                        <img alt=""
                            src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/playngo_slot.png?v=0.1"
                            data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/playngo_slot.png?v=0.1"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">Playngo</h5>
                    </a>
                </div>

                <div class="col">
                    <a class="btn-box {{ Request::is('/slots/game_list/nolimitcity') ? 'active' : '' }}"
                        href="{{ url('/slots/game_list/nolimitcity') }}" rel="noopener noreferrer">
                        <img alt=""
                            src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/nolimitcity_slot.png?v=0.1"
                            data-src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/nolimitcity_slot.png?v=0.1"
                            ngif="showEle" height="70" />

                        <h5 class="text-center fs-md game-title">Nolimit City</h5>
                    </a>
                </div>


            </div>

            <div class="right"><button class="next-btn btn" id="right-button"><i
                        class="icon-keyboard_arrow_right"></i></button></div>
        </div>

    </div>
</div>
