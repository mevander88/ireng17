<?php
use App\Models\Saldo;
use App\Http\Api\fiver;
?>

@auth
    @php
        $SG = new fiver();
        $act = json_decode($SG->userbalance(Auth()->user()->name));
        $saldos = $act->user->balance ?? '0';
    @endphp
    <div class="container wallet-bal">
        <div class="row text-left-w">
            <div class="col-xs-6">
                <button class="btn btn-clear ">
                    <i class="icon-currency-dollar fs-lg i-dollar"></i>
                    &nbsp;&nbsp;
                    <span class="bal-txt">IDR @currency($saldos)</span>
                </button>
            </div>
            <div class="col-xs-6 noSidePadding i-refresh">
                <a href="#" class="btn btn-clear btn-refresh-wallet btn-wallet-load pull-right"><i class="icon-refresh-2"></i></a>
            </div>
        </div>

        <div class="row game-bals" id="other-game-bals" style="display:none;">
            <div class="">
                <table class="table">
                    <tr>
                        <td class="col-xs-4"><button class="btn btn-clear btn-refresh-IDN">IDR <i
                                    class="icon-refresh"></i></button></td>
                        <td class="col-xs-7"><span class="bal-IDN">@currency($saldos)</span></td>
                        <td class="col-xs-1"><button class="btn btn-clear btn-tran-IDN" data-toggle="tooltip"
                                data-placement="bottom" title="Transfer ALL to Wallet"><i
                                    class="icon-arrow-bold-up"></i></button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

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
