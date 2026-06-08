<aside class="ggr-account-sidebar">
    <div class="ggr-account-user">
        <span class="ggr-account-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
        <div class="ggr-account-user-copy">
            <span class="ggr-kicker">Akun</span>
            <strong>{{ Auth::user()->name }}</strong>
            <span>{{ Auth::user()->email }}</span>
        </div>
    </div>
    <nav class="ggr-account-menu" aria-label="Menu akun">
        <a class="{{ request()->is('profile') ? 'is-active' : '' }}" href="{{ url('/profile') }}">
            <span class="material-symbols-outlined">person</span>
            Profil
        </a>
        <a class="{{ request()->is('account/deposit') ? 'is-active' : '' }}" href="{{ url('/account/deposit') }}">
            <span class="material-symbols-outlined">add_circle</span>
            Deposit
        </a>
        <a class="{{ request()->is('account/withdrawal') ? 'is-active' : '' }}" href="{{ url('/account/withdrawal') }}">
            <span class="material-symbols-outlined">account_balance_wallet</span>
            Withdraw
        </a>
        <a class="{{ request()->is('promo/saya') ? 'is-active' : '' }}" href="{{ url('/promo/saya') }}">
            <span class="material-symbols-outlined">redeem</span>
            Promo Saya
        </a>
        <a class="{{ request()->is('account/lastDirectTransfer') ? 'is-active' : '' }}" href="{{ url('/account/lastDirectTransfer') }}">
            <span class="material-symbols-outlined">receipt_long</span>
            Transaksi
        </a>
        <a class="{{ request()->is('account/history') ? 'is-active' : '' }}" href="{{ url('/account/history') }}">
            <span class="material-symbols-outlined">history</span>
            Pernyataan
        </a>
        <form class="ggr-account-logout" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">
                <span class="material-symbols-outlined">logout</span>
                Logout
            </button>
        </form>
    </nav>
</aside>
