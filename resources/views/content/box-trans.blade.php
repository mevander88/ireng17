<div class="title" style="padding: 5px 0">
    <div class="d-inline-block" i18n>Keamanan Akun: Normal</div>
    <div class="d-inline-block text-right" style="float:right;padding-right:15px">Anda memiliki <span
            class="txt_mail_cnt">0</span> pesan baru yang belum dibaca dari kami.</div>
</div>
<div class="box-wrapper plr-15">
    <div class="row   align-items-center">
        <div class="col-md-12 col-xs-12 text-center pay-title">
            <div class="mdc-wrapper">
                <a href="{{ URL::to('/account/deposit') }}"
                    class="mdc-items {{ Request::is('account/deposit') ? 'active' : '' }}">Deposit</a>
                <a href="{{ URL::to('/account/withdrawal') }}"
                    class="mdc-items {{ Request::is('account/withdrawal') ? 'active' : '' }}">Withdraw</a>
                <a href="{{ URL::to('/account/lastDirectTransfer') }}"
                    class="mdc-items {{ Request::is('account/lastDirectTransfer') ? 'active' : '' }}">5 Transaksi
                    Terakhir </a>
                <a href="{{ URL::to('/account/lastDirectTransfer') }}" class="mdc-items">Pernyataan</a>
            </div>
        </div>
    </div>
</div>
