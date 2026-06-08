<?php
use App\Models\Saldo;
use App\Http\Api\softgaming;
?>

@auth
    @php
        $SG = new softgaming();
        $act = json_decode($SG->userbalance(Auth()->user()->name));
        $saldos = $act->user->balance ?? '0';
    @endphp
    <button class="btn btn-link enlarge wallet">
        <i class="icon-wallet"></i>
        <span class="bal-txt">IDR @currency($saldos)</span>
        <a class="btn btn-clear btn-refresh-loadball btn-wallet-load pull-right"><i class="icon-refresh-2"></i></a>
    </button>
    <style>
        .btn-wallet-load {
            width: 29px !important;
            padding-left: 2px !important;
        }

        .icon-spin {
            animation: rotation 1s infinite linear;
        }

        @keyframes rotation {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(359deg);
            }
        }
    </style>
    <script>
        $(function() {
            $(document).on('click', '.btn-wallet-load', function(e) {
                e.preventDefault();

                $('.btn-wallet-load').addClass('icon-spin');
                const url = "{{ URL::to('saldo-refresh') }}";
                $.get(url, function(data) {
                    $('.btn-wallet-load').removeClass('icon-spin');
                    let datas = JSON.parse(data);
                    if (datas.error === false) {
                        $('.bal-txt').text('IDR ' + datas.balance.toString().replace(
                            /\B(?=(\d{3})+(?!\d))/g, ",") + '.00');
                    }
                })
            })
        })
    </script>
@endauth
