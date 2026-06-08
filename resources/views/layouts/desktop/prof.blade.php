  <div class="flex-row text-right mid">
      <a class="enlarge" href="#">
          <div class="member_leavel">
              <p class="member_leavel_name">New</p>
          </div>
      </a>
      <div class="line"></div>
      <a href="/profile" class="enlarge user-account">
          <div>
              <i class="icon-user-o" style="font-size:1.2rem;"></i>
          </div>
          <div class="text-center">
              <br>
              <span>{{ Auth::user()->name }}</span>
          </div>
      </a>
      <div class="line"></div>
      <a class="pointer button icon" href="/memo" data-toggle="tooltip" data-placement="top" title="Pesan">
          <i class="icon-mail_outline"></i>
          <div class="mail_icon" style="display:none;">0</div>
      </a>
      <div class="line"></div>
      <a class="pointer" href="javascript:void(0)"
          onclick="openLiveChat('https://lc.chat/now/13787301/' , 'akukasep9090@mail.com')" data-toggle="tooltip"
          data-placement="top" title="Obrolan Langsung">
          <i class="icon-chat1"></i>
      </a>
      <div class="  line"></div>

      <div class="social-icons info_toggle fade-in" id="blk-helpIcons--nexttop-bar" style="flex-wrap:nowrap;">
          <a class="pointer button twitter icon circle" href="/sports" data-toggle="tooltip"
              data-placement="top" title="Cara bermain">
              <i class="icon-help-circle"></i>
          </a>
          <a class="pointer button twitter icon circle" href="/contact-us" data-toggle="tooltip"
              data-placement="top" title="Pusat Info">
              <i class="icon-info"></i>
          </a>
      </div>
      <button class="btn button icon circle share" style="" id="btn-showhelpIcons--nexttop-bar">
          <i class="icon-bars"></i>
          <i class="icon-close hide"></i>
      </button>
      <a href="{{ route('logout') }}" class="btn btn-primary"
          onclick="event.preventDefault();
  document.getElementById('logout-form').submit();">KELUAR</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>
  </div>
  <div class="acc-panel flex-row last">
      <div class="dropdown">
          @include('content.navdesktop')
      </div>
      <div class="dropdown enlarge">
          <button class="btn btn-clear btn-collapse-balances pull-right animation" id="transaction-dropdown"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Transaksi &nbsp; <i class="icon-chevron-thin-down"></i>
          </button>
          <div class="dropdown-menu transaction-dropdown" aria-labelledby="transaction-dropdown">
              <ul class="drop_link" style="margin-bottom:0">

                  <li><a href="{{ URL::to('/account/deposit') }}"> <i class="icon-pig"></i> <span>Deposit</span></a>
                  </li>

                  <li><a href="{{ URL::to('/account/withdrawal') }}"><i class="icon-transfer"></i>
                          <span>Withdraw</span></a></li>

                  <li><a href="{{ URL::to('/account/history') }}"><i class="icon-history"></i> <span
                              i18n="@History">Pernyataan</span></a></li>
              </ul>
          </div>
      </div>
      <a href="/promo/saya" class="enlarge"><i class="icon-gift" style="font-size:1.2rem;"></i><span> Promo
              Saya</span></a>

  </div>
