@extends('layouts.main')

@php
    $gameItems = collect($game ?? []);
@endphp

@desktop
    @section('desktop')
        <script type="text/javascript">
            var windowNames = JSON.parse('{"lottery":"lottery","live":"king4d","togel":"king4d"}');
        </script>
        @include('content.gameSlider')
        <div class="container sub-games">
            <div class="g_category-nav fixed nav nav-pills nav-fill clearfix">
                <div class="nav-item search_filter">
                    <span class="srch_icon"><i class="icon-magnifier"></i></span>
                    <input type="text" matinput="" placeholder="Cari game" id="searchInput" maxlength="255"
                        class="search" i18n-placeholder="@Search">
                    <button matsuffix="" class="btn srch_button" id="clearSearchButton" type="button">
                        <i class="icon-x-square"></i>
                    </button>
                </div>
                <div class="nav-item active" data-filter="ALL">
                    <a class="navlink" href="javascript:void(0);" i18n="@ALL">SEMUA</a>
                </div>
                <div class="nav-item" data-filter="TOP">
                    <a class="navlink" href="javascript:void(0);" i18n="@TOP">TOP</a>
                </div>
                <div class="nav-item" data-filter="NEW">
                    <a class="navlink" href="javascript:void(0);" i18n="@NEW">BARU</a>
                </div>
                <div class="nav-item" data-filter="MORE">
                    <a class="navlink" href="javascript:void(0);">LEBIH</a>
                </div>
            </div>

            <div class="flex-row flex-wrap games pragmatic-play pp_slots" id="gamesContainer">
                @forelse ($gameItems as $games)
                    @php($launchKey = $games->launch_key ?? $games->id)
                    <div class="game-box text-center" data-title="{{ $games->game_name }}"
                        data-filter="ALL,Video Slots,TOP,Buy Bonus Feature" id="game-{{ $games->id }}">
                        <div class="daily-wins-tag"></div>
                        <div class="image">
                            <img alt="{{ $games->game_name }}" src="{{ $games->game_image }}"
                                data-src="{{ $games->game_image }}" class="unveiled lazyloaded">
                        </div>
                        <div class="name">
                            <div class="opacity_content">
                                <div class="opacity_background"></div>
                                <div class="title-wrap">
                                    <div class="game-title fs-lg">{{ $games->game_name }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="amount_box" style="display:none;"></div>
                        <div class="game-overlay game-has-try">
                            @auth
                                <a class="btn game_button_play"
                                    onClick="window.open('{{ url('/game_process/' . $launchKey) }}', '_blank')"
                                    target="_blank" rel="noopener noreferrer" i18n="@PlayNow">MAIN SEKARANG</a>
                                <a class="btn game_button_try">DEMO</a>
                            @else
                                <a class="btn game_button_play login-alert" href="{{ url('/game_process/' . $launchKey) }}"
                                    target="_blank" rel="noopener noreferrer" i18n="@PlayNow">MAIN SEKARANG</a>
                                <a class="btn game_button_try login-alert">DEMO</a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="game-empty-state">Game belum tersedia.</div>
                @endforelse
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var searchInput = document.getElementById('searchInput');
                var clearSearchButton = document.getElementById('clearSearchButton');
                var gamesContainer = document.getElementById('gamesContainer');

                if (!searchInput || !clearSearchButton || !gamesContainer) {
                    return;
                }

                var gameBoxes = gamesContainer.getElementsByClassName('game-box');

                function search() {
                    var filterInput = searchInput.value.toLowerCase();

                    for (var i = 0; i < gameBoxes.length; i++) {
                        var gameTitle = gameBoxes[i].getElementsByClassName('game-title')[0].innerText.toLowerCase();
                        gameBoxes[i].style.display = gameTitle.includes(filterInput) ? 'block' : 'none';
                    }
                }

                clearSearchButton.addEventListener('click', function() {
                    searchInput.value = '';
                    search();
                });
                searchInput.addEventListener('input', search);
            });
        </script>
    @endsection
@elsedesktop
    @section('content')
        <div class="container pt-1 sub-games">
            <div>
                @include('layouts.games')
                <div class="row games no-gutters">
                    @forelse ($gameItems as $games)
                        @php($launchKey = $games->launch_key ?? $games->id)
                        @auth
                            <a class="col-xs-4 col-md-3 game-box text-center" data-title="{{ $games->game_name }}"
                                data-filter="ALL,Video Slots,TOP,Buy Bonus Feature" target="_blank" rel="noopener noreferrer"
                                onClick="window.open('{{ url('/game_process/' . $launchKey) }}', '_blank')">
                                <div class="content-wrapper">
                                    <img alt="{{ $games->game_name }}" class="lazy" data-src="{{ $games->game_image }}"
                                        src="{{ $games->game_image }}">
                                </div>
                                <h5 data-title="{{ $games->game_name }}">{{ $games->game_name }}</h5>
                            </a>
                        @else
                            <a class="col-xs-4 col-md-3 game-box text-center login-alert"
                                data-title="{{ $games->game_name }}" data-filter="ALL,Video Slots,TOP,Buy Bonus Feature"
                                target="_blank" rel="noopener noreferrer">
                                <div class="content-wrapper">
                                    <img alt="{{ $games->game_name }}" class="lazy" data-src="{{ $games->game_image }}"
                                        src="{{ $games->game_image }}">
                                </div>
                                <h5 data-title="{{ $games->game_name }}">{{ $games->game_name }}</h5>
                            </a>
                        @endauth
                    @empty
                        <div class="col-12 game-empty-state">Game belum tersedia.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endsection
@enddesktop
