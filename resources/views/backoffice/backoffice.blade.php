@extends('backoffice.layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><sup style="font-size: 20px">Deposit (Harian)</sup></h3>

                    <p>IDR {{ number_format($deposit->trans_now, 2) }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <a href="{{ URL::to('deposit') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><sup style="font-size: 20px">Agent Balance</sup></h3>

                    <p id="balance">Loading...</p>
                </div>
                <div class="icon">
                    <i class="fas fa-skull-crossbones"></i>
                </div>
                <a href="{{ URL::to('pengaturan_saldo') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><sup style="font-size: 20px">BLAST TERUS!</sup></h3>

                    <p>Member Baru</p>
                </div>
                <div class="icon">
                    <i class="fas fa-id-card-alt"></i>
                </div>
                <a href="{{ URL::to('data_member') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3><sup style="font-size: 20px">Game</sup></h3>

                    <p>All Provider</p>
                </div>
                <div class="icon">
                    <i class="fas fa-gamepad"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <!-- TOTAL -->

            <div class="small-box bg-light">
                <div class="inner">
                    <h6 style="color:blue;">Member (Harian)</h6>

                    <p>{{ number_format($member->trans_now) }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-venus-mars" style="
                        font-size: 50px;"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h6 style="color:blue;">Member (Kemarin)</h6>


                    <p>{{ number_format($member->trans_yesterday) }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-venus-mars" style="
                        font-size: 50px;"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h6 style="color:blue;">Member (Bulanan)</h6>

                    <p>{{ number_format($member->trans_month) }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-venus-mars" style="
                        font-size: 50px;"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h6 style="color:blue;">Member (Total)</h6>

                    <p>{{ number_format($member->trans_all) }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-venus-mars" style="
                        font-size: 50px;"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div> <br>
        <!-- large box -->
        <div class="col-sm-12 p-2">
            <div class="small-box bg-light">
                <div class="inner">
                    <h3 style="color:light;">Total Bersih (Harian)</h3>

                    <h4 id="total_bersih"></h4>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill" style="
                        font-size: 80px;"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>

        <div class="col-lg-3 col-6">

            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h6 style="color:green;">Total Deposit</h6>

                    <p>{{ number_format($deposit->trans_count, 0) }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar" style="
                        font-size: 50px;"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h6 style="color:green;">Nominal (Kemarin)</h6>

                    <p>IDR {{ number_format($deposit->trans_yesterday, 0) }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar" style="
                        font-size: 50px;"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h6 style="color:green;">Nominal (Bulanan)</h6>

                    <p>IDR {{ number_format($deposit->trans_month, 2) }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar" style="
                        font-size: 50px;"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h6 style="color:green;">Nominal (Total)</h6>

                    <p>IDR {{ number_format($deposit->trans_all, 2) }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar" style="
                        font-size: 50px;"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/get-balance')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('balance').innerText = new Intl.NumberFormat().format(data.balance);
                })
                .catch(error => {
                    console.error('Error fetching balance:', error);
                    document.getElementById('balance').innerText = 'Error loading balance';
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/total-bersih-harian',
                method: 'GET',
                success: function(data) {
                    var formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 2
                    });

                    $('#total_bersih').text(formatter.format(data.total_bersih));
                },
                error: function() {
                    $('#total_bersih').text('Error fetching data');
                }
            });
        });
    </script>
@endsection
