<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ URL::to('backoffice') }}" class="brand-link" aria-label="Dashboard backoffice">
        <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ $setting->nama_web ?? 'ireng17' }}" class="brand-image-admin">
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Dashboard</li>
                <li class="nav-item">
                    <a href="{{ URL::to('backoffice') }}" class="nav-link {{ request()->is('backoffice') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if (Auth()->User()->level != 1)
                    <li class="nav-item">
                        <a href="{{ URL::to('deposit_bank') }}" class="nav-link {{ request()->is('deposit_bank*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-credit-card"></i>
                            <p>Data Bank</p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">Payment</li>
                <li class="nav-item {{ request()->is('deposit*') || request()->is('withdraw*') || request()->is('pernyataan*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('deposit*') || request()->is('withdraw*') || request()->is('pernyataan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-balance-scale-left"></i>
                        <p>
                            Payment
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('deposit') }}" class="nav-link {{ request()->is('deposit*') ? 'active' : '' }}">
                                <i class="fas fa-donate nav-icon"></i>
                                <p>Deposit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('withdraw') }}" class="nav-link {{ request()->is('withdraw*') ? 'active' : '' }}">
                                <i class="fas fa-wallet nav-icon"></i>
                                <p>Withdraw</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('pernyataan') }}" class="nav-link {{ request()->is('pernyataan*') ? 'active' : '' }}">
                                <i class="fas fa-receipt nav-icon"></i>
                                <p>Pernyataan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Member</li>
                <li class="nav-item {{ request()->is('data_member*') || request()->is('inject-saldo*') || request()->is('histori_transaksi*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('data_member*') || request()->is('inject-saldo*') || request()->is('histori_transaksi*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-id-card"></i>
                        <p>
                            Member Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('data_member') }}" class="nav-link {{ request()->is('data_member*') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Data Member</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('inject-saldo') }}" class="nav-link {{ request()->is('inject-saldo*') ? 'active' : '' }}">
                                <i class="fas fa-coins nav-icon"></i>
                                <p>Inject Saldo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('histori_transaksi') }}" class="nav-link {{ request()->is('histori_transaksi*') ? 'active' : '' }}">
                                <i class="fas fa-eye nav-icon"></i>
                                <p>Histori Transaksi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @if (Auth()->User()->level != 1)
                    <li class="nav-header">Setting</li>
                    <li class="nav-item {{ request()->is('setting*') || request()->is('banner*') || request()->is('banner_promosi*') || request()->is('bonus*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('setting*') || request()->is('banner*') || request()->is('banner_promosi*') || request()->is('bonus*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-fingerprint"></i>
                            <p>
                                Setting View
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ URL::to('setting') }}" class="nav-link {{ request()->is('setting*') ? 'active' : '' }}">
                                    <i class="fas fa-cog nav-icon"></i>
                                    <p>Setting Web</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL::to('banner') }}" class="nav-link {{ request()->is('banner') || request()->is('banner/*') ? 'active' : '' }}">
                                    <i class="fas fa-film nav-icon"></i>
                                    <p>Banner</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL::to('banner_promosi') }}" class="nav-link {{ request()->is('banner_promosi*') ? 'active' : '' }}">
                                    <i class="fas fa-bullhorn nav-icon"></i>
                                    <p>Promosi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL::to('bonus') }}" class="nav-link {{ request()->is('bonus*') ? 'active' : '' }}">
                                    <i class="fas fa-gift nav-icon"></i>
                                    <p>Bonus</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">Permainan</li>
                    <li class="nav-item">
                        <a href="{{ URL::to('backoffice/ggr') }}" class="nav-link {{ request()->is('backoffice/ggr*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>Katalog GGR</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a target="_blank" rel="noopener noreferrer" href="{{ URL::to('voucher-lucky-spin') }}" class="nav-link">
                            <i class="nav-icon fas fa-dice"></i>
                            <p>Generate Voucher</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a target="_blank" rel="noopener noreferrer" href="{{ URL::to('history-play/user') }}" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p>History Play</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('game_setting') }}" class="nav-link {{ request()->is('game_setting*') ? 'active' : '' }}">
                            <i class="fas fa-gamepad nav-icon"></i>
                            <p>Setting Scatter</p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">Profile</li>
                <li class="nav-item">
                    <a href="{{ URL::to('profil_admin') }}" class="nav-link {{ request()->is('profil_admin*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Profil Admin</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
