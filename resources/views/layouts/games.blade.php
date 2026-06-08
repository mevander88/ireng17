<h3 class="title">SLOTS PROVIDERS</h3>

<!-- PROVIDER SLIDER -->
<div class="scroll-wrapper row" style="height:72px;">
    <div class="left">
        <button class="prev-btn btn" id="left-button">
            <i class="icon-keyboard_arrow_left"></i>
        </button>
    </div>

    <div class="scroller" style="overflow:hidden;width:100%;">
        <div class="row no-gutters text-center slider-content">

            <div class="col" style="height:72px;">
                <a class="btn-box" href="{{ url('/slots/game_list/pragmatic') }}">
                    <img alt="" src="https://files.sitestatic.net/images/ppslot.gif" style="width:70px;height:50px;">
                    <div class="text-center game-title">Pragmatic</div>
                </a>
            </div>

            <div class="col" style="height:72px;">
                <a class="btn-box" href="{{ url('/slots/game_list/pgsoft') }}">
                    <img alt="" src="https://files.sitestatic.net/images/pgsoft.gif" style="width:70px;height:50px;">
                    <div class="text-center game-title">PG Soft</div>
                </a>
            </div>

            <div class="col" style="height:72px;">
                <a class="btn-box" href="{{ url('/slots/game_list/habanero') }}">
                    <img alt="" src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/hb_slot.png" style="width:70px;height:50px;">
                    <div class="text-center game-title">Habanero</div>
                </a>
            </div>

            <div class="col" style="height:72px;">
                <a class="btn-box" href="{{ url('/slots/game_list/cq9') }}">
                    <img alt="" src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/cq9_slot.png" style="width:70px;height:50px;">
                    <div class="text-center game-title">CQ9</div>
                </a>
            </div>

            <div class="col" style="height:72px;">
                <a class="btn-box" href="{{ url('/slots/game_list/evoplay') }}">
                    <img alt="" src="https://files.sitestatic.net/assets/imgs/game_logos/100x70/evoplay_slot.png" style="width:70px;height:50px;">
                    <div class="text-center game-title">Evoplay</div>
                </a>
            </div>

        </div>
    </div>

    <div class="right">
        <button class="next-btn btn" id="right-button">
            <i class="icon-keyboard_arrow_right"></i>
        </button>
    </div>
</div>

<!-- SEARCH BAR MINI (LEBIH KECIL & RAPAPI) -->
<div class="mobile-search-wrap">
    <input type="text" id="mobileSearchInput" placeholder="Cari game...">
</div>

<style>
.mobile-search-wrap {
    padding: 6px 14px 10px;
}

.mobile-search-wrap input {
    width: 100%;
    height: 34px;                 /* LEBIH KECIL */
    background: #000000;
    border: 1px solid #ffffff;
    border-radius: 8px;
    padding: 0 12px;
    color: #f5d37a;
    font-size: 13px;
    line-height: 34px;
    outline: none;
}

.mobile-search-wrap input::placeholder {
    color: #f5d37a;
    opacity: 0.9;
}
</style>

<!-- GAME LIST -->
<div class="row games no-gutters" id="mobileGamesContainer">
@foreach ($game as $games)
    <a class="col-xs-4 game-box text-center"
       data-title="{{ strtolower($games->game_name) }}"
       onclick="window.open('/game_process/{{ $games->id }}','_blank')">

        <div class="content-wrapper">
            <img alt="" src="{{ $games->game_image }}" style="width:100%;">
        </div>

        <h5>{{ $games->game_name }}</h5>
    </a>
@endforeach
</div>

<!-- SEARCH SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('mobileSearchInput');
    const games = document.querySelectorAll('#mobileGamesContainer .game-box');

    input.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();

        games.forEach(game => {
            const title = game.getAttribute('data-title');
            game.style.display = title.includes(keyword) ? '' : 'none';
        });
    });
});
</script>
