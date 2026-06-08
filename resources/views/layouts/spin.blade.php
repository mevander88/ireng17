@extends('layouts.main')
@desktop
    @section('desktop')
        <style>
            body {
                font-family: var(--boray-font-body), Arial, sans-serif;
                background-color: var(--boray-bg);
                color: var(--boray-text);
            }

            #wheel {
                width: 70vw;
                max-width: 300px;
                height: 70vw;
                max-height: 300px;
                border-radius: 50%;
                position: relative;
                margin: 50px auto;
                box-shadow: var(--boray-shadow);
            }

            .segment {
                position: absolute;
                width: 50%;
                height: 50%;
                top: 0;
                left: 50%;
                transform-origin: 0 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--boray-text);
                font-weight: bold;
                text-align: center;
                padding: 10px;
                border-radius: 50%;
                border: 2px solid rgba(255, 255, 255, 0.16);
                box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
            }

            .segment:nth-child(1) {
                background: linear-gradient(135deg, var(--boray-danger), #93000a);
            }

            .segment:nth-child(2) {
                background: linear-gradient(135deg, var(--boray-purple), var(--boray-purple-soft));
                transform: rotate(72deg);
            }

            .segment:nth-child(3) {
                background: linear-gradient(135deg, var(--boray-success), #1f7f58);
                transform: rotate(144deg);
            }

            .segment:nth-child(4) {
                background: linear-gradient(135deg, var(--boray-surface-high), var(--boray-purple));
                transform: rotate(216deg);
            }

            .segment:nth-child(5) {
                background: linear-gradient(135deg, var(--boray-gold), var(--boray-gold-2));
                transform: rotate(288deg);
            }

            .centerDot {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(0deg);
                /* Adjust the rotation angle as needed */
                width: 0;
                height: 0;
                border-left: 5px solid transparent;
                border-right: 5px solid transparent;
                border-bottom: 30px solid var(--boray-gold);
                z-index: 10;
                transition: transform 4s cubic-bezier(0.33, 1, 0.68, 1);
            }

            .centerDot::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 50%;
                transform: translateX(-50%);
                width: 8px;
                height: 8px;
                background-color: var(--boray-danger);
                border-radius: 50%;
            }

            #voucherInput,
            #validateButton,
            #spinButton {
                display: block;
                width: 80%;
                max-width: 200px;
                margin: 20px auto;
                padding: 10px;
                font-size: 16px;
                text-align: center;
                border: 1px solid var(--boray-line);
                border-radius: 12px;
                color: var(--boray-text);
                background: rgba(18, 20, 21, 0.92);
            }

            #validateButton,
            #spinButton {
                background: linear-gradient(180deg, var(--boray-gold), var(--boray-gold-2));
                color: #261a00;
                border: 1px solid rgba(255, 223, 159, 0.7);
                cursor: pointer;
            }

            #validateButton:hover,
            #spinButton:hover {
                filter: brightness(1.06);
            }

            #spinButton {
                display: none;
            }

            .button-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin-top: 20px;
            }
        </style>
        <div id="wheel">
            <div class="segment">Free Saldo 10rb</div>
            <div class="segment">Free Saldo 50rb</div>
            <div class="segment">Silahkan coba lagi</div>
            <div class="segment">Free saldo 20 rb</div>
            <div class="segment">Free saldo 100rb</div>
            <div class="centerDot"></div>
        </div>
        <div class="button-container">
            <input type="text" id="voucherInput" placeholder="Masukkan kode voucher">
            <button id="validateButton">Validasi Kode</button>
            <button id="spinButton">Putar</button>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                var spinning = false;
                var voucherValid = false;

                $('#validateButton').on('click', function() {
                    var voucherCode = $('#voucherInput').val().trim();

                    if (voucherCode === "") {
                        alert('Silakan masukkan kode voucher.');
                        return;
                    }

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: '/validate-voucher',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            voucher: voucherCode
                        },
                        success: function(response) {
                            if (response.valid) {
                                alert('Kode voucher valid!');
                                voucherValid = true;
                                $('#spinButton').show();
                                $('#voucherInput, #validateButton').hide();
                            } else {
                                alert('Kode voucher tidak valid atau sudah digunakan.');
                                voucherValid = false;
                                $('#spinButton').hide();
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan: ' + error);
                            console.log(xhr.responseText);
                        }
                    });
                });

                $('#spinButton').on('click', function() {
                    if (!spinning && voucherValid) {
                        spinning = true;

                        var degrees = 360 * 5 + Math.floor(Math.random() * 360);

                        $('.centerDot').css({
                            'transform': 'translate(-50%, -50%) rotate(' + degrees + 'deg)'
                        });

                        setTimeout(function() {
                            var rotation = degrees % 360;
                            var segmentAngle = 360 / 5;
                            var adjustedRotation = rotation < 0 ? rotation + 360 : rotation;
                            var resultIndex = Math.floor(adjustedRotation / segmentAngle);
                            var prizes = [10000, 50000, 0, 20000, 100000];
                            var result = prizes[resultIndex];

                            var csrfToken = $('meta[name="csrf-token"]').attr('content');

                            $.ajax({
                                url: '/save-prize',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                data: {
                                    prize: result,
                                    prizeIndex: resultIndex
                                },
                                success: function(response) {
                                    alert('Prize berhasil disimpan!');
                                    console.log(response);
                                    spinning = false;
                                    $('#spinButton').hide();
                                    $('#voucherInput, #validateButton').show();
                                    voucherValid = false;
                                },
                                error: function(xhr, status, error) {
                                    alert('Terjadi kesalahan: ' + error);
                                    console.log(xhr.responseText);
                                    spinning = false;
                                    $('#spinButton').hide();
                                    $('#voucherInput, #validateButton').show();
                                    voucherValid = false;
                                }
                            });
                        }, 4000);
                    } else if (!voucherValid) {
                        alert('Silakan validasi kode voucher terlebih dahulu.');
                    }
                });
            });
        </script>
    @endsection
@elsedesktop
    @section('content')
        <style>
            body {
                font-family: var(--boray-font-body), Arial, sans-serif;
                background-color: var(--boray-bg);
                color: var(--boray-text);
            }

            #wheel {
                width: 70vw;
                max-width: 300px;
                height: 70vw;
                max-height: 300px;
                border-radius: 50%;
                position: relative;
                margin: 50px auto;
                box-shadow: var(--boray-shadow);
            }

            .segment {
                position: absolute;
                width: 50%;
                height: 50%;
                top: 0;
                left: 50%;
                transform-origin: 0 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--boray-text);
                font-weight: bold;
                text-align: center;
                padding: 10px;
                border-radius: 50%;
                border: 2px solid rgba(255, 255, 255, 0.16);
                box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
            }

            .segment:nth-child(1) {
                background: linear-gradient(135deg, var(--boray-danger), #93000a);
            }

            .segment:nth-child(2) {
                background: linear-gradient(135deg, var(--boray-purple), var(--boray-purple-soft));
                transform: rotate(72deg);
            }

            .segment:nth-child(3) {
                background: linear-gradient(135deg, var(--boray-success), #1f7f58);
                transform: rotate(144deg);
            }

            .segment:nth-child(4) {
                background: linear-gradient(135deg, var(--boray-surface-high), var(--boray-purple));
                transform: rotate(216deg);
            }

            .segment:nth-child(5) {
                background: linear-gradient(135deg, var(--boray-gold), var(--boray-gold-2));
                transform: rotate(288deg);
            }

            .centerDot {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(0deg);
                /* Adjust the rotation angle as needed */
                width: 0;
                height: 0;
                border-left: 5px solid transparent;
                border-right: 5px solid transparent;
                border-bottom: 30px solid var(--boray-gold);
                z-index: 10;
                transition: transform 4s cubic-bezier(0.33, 1, 0.68, 1);
            }

            .centerDot::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 50%;
                transform: translateX(-50%);
                width: 8px;
                height: 8px;
                background-color: var(--boray-danger);
                border-radius: 50%;
            }

            #voucherInput,
            #validateButton,
            #spinButton {
                display: block;
                width: 80%;
                max-width: 200px;
                margin: 20px auto;
                padding: 10px;
                font-size: 16px;
                text-align: center;
                border: 1px solid var(--boray-line);
                border-radius: 12px;
                color: var(--boray-text);
                background: rgba(18, 20, 21, 0.92);
            }

            #validateButton,
            #spinButton {
                background: linear-gradient(180deg, var(--boray-gold), var(--boray-gold-2));
                color: #261a00;
                border: 1px solid rgba(255, 223, 159, 0.7);
                cursor: pointer;
            }

            #validateButton:hover,
            #spinButton:hover {
                filter: brightness(1.06);
            }

            #spinButton {
                display: none;
            }

            .button-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin-top: 20px;
            }
        </style>

        <div id="wheel">
            <div class="segment">Free Saldo 10rb</div>
            <div class="segment">Free Saldo 50rb</div>
            <div class="segment">Silahkan coba lagi</div>
            <div class="segment">Free saldo 20 rb</div>
            <div class="segment">Free saldo 100rb</div>
            <div class="centerDot"></div>
        </div>
        <div class="button-container">
            <input type="text" id="voucherInput" placeholder="Masukkan kode voucher">
            <button id="validateButton">Validasi Kode</button>
            <button id="spinButton">Putar</button>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                var spinning = false;
                var voucherValid = false;

                // Prevent copy, paste, and cut
                $('#voucherInput').on('copy paste cut', function(e) {
                    e.preventDefault();
                });

                $('#validateButton').on('click', function() {
                    var voucherCode = $('#voucherInput').val().trim();

                    if (voucherCode === "") {
                        alert('Silakan masukkan kode voucher.');
                        return;
                    }

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: '/validate-voucher',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            voucher: voucherCode
                        },
                        success: function(response) {
                            if (response.valid) {
                                alert('Kode voucher valid!');
                                voucherValid = true;
                                $('#spinButton').show();
                                $('#voucherInput, #validateButton').hide();
                            } else {
                                alert('Kode voucher tidak valid atau sudah digunakan.');
                                voucherValid = false;
                                $('#spinButton').hide();
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan: ' + error);
                            console.log(xhr.responseText);
                        }
                    });
                });

                $('#spinButton').on('click', function() {
                    if (!spinning && voucherValid) {
                        spinning = true;

                        var degrees = 360 * 5 + Math.floor(Math.random() * 360);

                        $('.centerDot').css({
                            'transform': 'translate(-50%, -50%) rotate(' + degrees + 'deg)'
                        });

                        setTimeout(function() {
                            var rotation = degrees % 360;
                            var segmentAngle = 360 / 5;
                            var adjustedRotation = rotation < 0 ? rotation + 360 : rotation;
                            var resultIndex = Math.floor(adjustedRotation / segmentAngle);
                            var prizes = [10000, 50000, 0, 20000, 100000];
                            var result = prizes[resultIndex];

                            var csrfToken = $('meta[name="csrf-token"]').attr('content');

                            $.ajax({
                                url: '/save-prize',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                data: {
                                    prize: result,
                                    prizeIndex: resultIndex
                                },
                                success: function(response) {
                                    alert('Prize berhasil disimpan!');
                                    console.log(response);
                                    spinning = false;
                                    $('#spinButton').hide();
                                    $('#voucherInput, #validateButton').show();
                                    voucherValid = false;
                                },
                                error: function(xhr, status, error) {
                                    alert('Terjadi kesalahan: ' + error);
                                    console.log(xhr.responseText);
                                    spinning = false;
                                    $('#spinButton').hide();
                                    $('#voucherInput, #validateButton').show();
                                    voucherValid = false;
                                }
                            });
                        }, 4000);
                    } else if (!voucherValid) {
                        alert('Silakan validasi kode voucher terlebih dahulu.');
                    }
                });
            });
        </script>
    @endsection
@enddesktop
