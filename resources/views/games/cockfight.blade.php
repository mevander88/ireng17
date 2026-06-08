@extends('layouts.main')

@section('desktop')
    <div class="container pt-4 games-category">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-lg-3 box gamecategory-singleitem">
                <a target="_blank" rel="noopener noreferrer" class="game maintenance-alert">
                    <div class="g-card">
                        <!-- <div class="loader-b" *ngIf="!showEle"></div> -->
                        <div class="card-img" *ngif="showEle" _games_category="">
                            <!--Game Content (repeated below)-->
                            <div class="g-overlay"></div>
                            <img src="https://files.sitestatic.net/GameImage/CFProviders/desktop/normal/cock_sv388.jpg?v=1.0"
                                alt=" SV388">
                            <div class="card-title" _games_category="">
                                <div class="logo">
                                    <span style=" width: 200px; height: 60px; ">
                                        <img alt=""
                                            src="https://files.sitestatic.net/assets/imgs/game_logos/200x60/sv388_cf.png?v=0.31">
                                    </span>
                                </div>
                            </div>
                            <div class="btn-wrapper" _games_category="">
                                <button class="btn btn-hvrplay clearfix">
                                    <div class="inner">
                                        <div class="p1">

                                            MAIN SEKARANG </div>
                                        <div class="p2"><i class="icon-play-solid "></i>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <!--END Game Content (repeated below)-->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-4 col-lg-3 box gamecategory-singleitem">
                <a target="_blank" rel="noopener noreferrer" class="game maintenance-alert">
                    <div class="g-card">
                        <!-- <div class="loader-b" *ngIf="!showEle"></div> -->
                        <div class="card-img" *ngif="showEle" _games_category="">
                            <!--Game Content (repeated below)-->
                            <div class="g-overlay"></div>
                            <img src="https://files.sitestatic.net/GameImage/CFProviders/desktop/normal/ws168_cf.jpg?v=1.0"
                                alt=" WS168">
                            <div class="card-title" _games_category="">
                                <div class="logo">
                                    <span style=" width: 200px; height: 60px; ">
                                        <img alt=""
                                            src="https://files.sitestatic.net/assets/imgs/game_logos/200x60/ws168_cf.png?v=0.31">
                                    </span>
                                </div>
                            </div>
                            <div class="btn-wrapper" _games_category="">
                                <button class="btn btn-hvrplay clearfix">
                                    <div class="inner">
                                        <div class="p1">

                                            MAIN SEKARANG </div>
                                        <div class="p2"><i class="icon-play-solid "></i>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <!--END Game Content (repeated below)-->
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container pt-1 games-category">
        <h2 class="title">sabung ayam</h2>
        <div class="row">
            <script type="text/javascript">
                var windowNames = JSON.parse('{"lottery":"lottery","live":"king4d","togel":"king4d"}');
            </script>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 image-grid">
                    <div class="col-xs-4 col-sm-3 col-md-2 box">
                        <div class="game-wrapper ">
                            <a target="_blank" rel="noopener noreferrer" class="game maintenance-alert">
                                <img class="img-fluid lazy" alt="SV388"
                                    data-src="https://files.sitestatic.net/GameImage/CFProviders/mobile/normal/cock_sv388.jpg?v=1.0"
                                    src ="" />
                                <div class="loader-b" *ngIf="!showEle"></div>
                                <div class="g-title">SV388</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2 box">
                        <div class="game-wrapper ">
                            <a target="_blank" rel="noopener noreferrer" class="game maintenance-alert">
                                <img class="img-fluid lazy" alt="WS168"
                                    data-src="https://files.sitestatic.net/GameImage/CFProviders/mobile/normal/ws168_cf.jpg?v=1.0"
                                    src ="" />
                                <div class="loader-b" *ngIf="!showEle"></div>
                                <div class="g-title">WS168</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
