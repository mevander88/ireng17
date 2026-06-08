<div id="modalBank{{ $b->id }}" style="display: none">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12 content-form">
                <style>
                    * {
                        -webkit-backface-visibility: visible;
                    }

                    select>option.disble {
                        background-color: #d4d4d4;
                    }
                </style>
                <form id="depositForm" class="needs-validation" action="{{ URL::to('account/deposit') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="1">
                    <input type="hidden" name="status" value="1">
                    <input type="hidden" name="bank_id" value="253698742">
                    <input type="hidden" name="bonus_persentase" id="bonus_persentase_bca">
                    <div class="box-wrapper plr-15">
                        <div class="row d-flex">
                            <div class="col-md-3 col-xs-4  ">
                                <div class="font-weight-bold">
                                    Metode Penyetoran<span class="text-danger">*</span>
                                </div>
                            </div>
                            <div class="col-md-9 col-xs-8 d-flex flex-wrap">
                                <div class="radio_2 m-15 mt-2">
                                    <input id="radioBank5" checked="" type="radio" value="5">
                                    <label class=" " for="radioBank5">
                                        <span class="radio-title">{{ $b->nama_bank }}</span>
                                        <span class="marked">
                                            <i class="icon-checkmark"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="row d-flex">
                                <div class="col-md-3 col-xs-4  ">
                                    <div class="font-weight-bold">
                                        Rekening Pengirim<span class="text-danger">*</span>
                                    </div>
                                </div>
                                <div class="col-md-9 col-xs-8  d-flex flex-wrap">
                                    <select class="form-control m-15" name="rek_pengirim" required>
                                        <option disabled selected>-
                                            Silakan Pilih -</option>
                                        <option value="{{ Auth::user()->bank . ' - ' . Auth::user()->no_rek }}">
                                            {{ Auth::user()->bank . ' - ' . Auth::user()->no_rek }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex">
                                <div class="col-md-3 col-xs-4  ">
                                    <div class="font-weight-bold">
                                        Bank Penerima<span class="text-danger">*</span>
                                    </div>
                                </div>
                                <div class="col-md-9 col-xs-8 d-flex flex-wrap">
                                    <select class="form-control bank_list m-15 has-feedback has-success"
                                        data-plugin="bank_list" id="bank_name_5" name="bank_name">
                                        <option selected value="{{ $b->nama_bank . ' - ' . $b->nama_penerima }}">
                                            {{ $b->nama_bank . ' - ' . $b->nama_penerima }}
                                            <!-- next bank -->
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="row info-lst" id="bankInfo_de001" style="">
                                <div class="col-xs-12 col-md-9">
                                    <div class="bankInfo-box" id="bankList">
                                        <div class="box-title">
                                            <i class="icon-invoice i-invoice"></i>
                                            Rincian Deposit Akun
                                            <div class="pull-right acc_status">
                                                STATUS : <span class="text-success">ONLINE</span>
                                            </div>
                                            <input type="hidden" id="depo_acc_status" value="ONLINE" />
                                        </div>

                                        <table class="table table-borderless text-right info-box--001">
                                            <tbody>
                                                <tr class="text-left first">
                                                    <td class="col-xs-12 col-md-6" colspan="2">
                                                        <small> Nama Akun bank
                                                        </small>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td class="col-xs-12 col-md-6" colspan="2">
                                                        <input id="info-bca" value="{{ $b->nama_penerima }}"
                                                            class="copy-input" />

                                                        <a href="javascript:void(0);" data-sel="info-bca"
                                                            class="btn btn-link btn-copy lbl">
                                                            <span class=" ">
                                                                {{ $b->nama_penerima }}
                                                            </span>
                                                            <i class="icon-copy"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr class="text-left first">
                                                    <td class="col-xs-12 col-md-6" colspan="2">
                                                        <small> Rekening Bank No
                                                        </small>
                                                    </td>
                                                </tr>

                                                <tr class=" ">
                                                    @if (empty($b->image_qr))
                                                    <td class="col-xs-12 col-md-6" colspan="2"
                                                        style="padding-bottom: 10px">
                                                        <input id="info-copy-2" value="{{ $b->no_rek }}"
                                                            class="copy-input" />

                                                        <a href="javascript:void(0);" data-sel="info-copy-2"
                                                            class="btn btn-link btn-copy lbl">
                                                            <span class=" "
                                                                style="white-space: normal; word-break: break-word">
                                                                {{ $b->no_rek }}
                                                            </span>
                                                            <i class="icon-copy"></i>
                                                        </a>
                                                    </td>
                                                    @else
                                                    <td class="col-xs-12 col-md-6" colspan="2"
                                                        style="padding-bottom: 10px;">
                                                        <a href="{{ asset('storage/' . $b->image_qr) }}"
                                                            target="_blank" rel="noopener noreferrer">
                                                            <img alt="" src="{{ asset('storage/' . $b->image_qr) }}"
                                                                alt="Qris"
                                                                style="display:flex; margin:auto; height: 200px;">
                                                        </a>
                                                    </td>
                                                    @endif
                                                </tr>
                                                <tr class="text-left tr_type2">
                                                    <td class="col-xs-6 col-md-6">
                                                        <small>Min Deposit</small>
                                                    </td>
                                                    <td class="col-xs-6 col-md-6 text-right">
                                                        <span class="lbl">
                                                            IDR50,000.00 </span>
                                                        <input type="hidden" id="bank_min_deposit"
                                                            class="min_deposit" value="10000" />
                                                    </td>
                                                </tr>

                                                <tr class="text-left tr_type2">
                                                    <td class="col-xs-6 col-md-6">
                                                        <small i18n="">Max
                                                            Deposit</small>
                                                    </td>
                                                    <td class="col-xs-6 col-md-6 text-right">
                                                        <span class="lbl">
                                                            IDR1,000,000,000.00
                                                        </span>
                                                        <input type="hidden" id="bank_max_deposit"
                                                            class="max_deposit" value="1000000000" />
                                                    </td>
                                                </tr>

                                                <tr class="text-left tr_type2">
                                                    <td class="col-xs-6 col-md-6">
                                                        <small i18n="">Komisi
                                                            Bank / Transaksi</small>
                                                    </td>
                                                    <td class="col-xs-6 col-md-6 text-right">
                                                        <span class="lbl"> IDR
                                                            0.00 </span>
                                                    </td>
                                                </tr>

                                                <input type="hidden" id="admin_fee" value="IDR 0.00" />
                                                <input type="hidden" id="percent_check" value="" />
                                                <tr class="text-left tr_type2">
                                                    <td class="col-xs-6 col-md-6">
                                                        <small i18n="">Subsidi
                                                            Bank / Transaksi</small>
                                                    </td>
                                                    <td class="col-xs-6 col-md-6 text-right">
                                                        <span class="lbl"> IDR 0
                                                        </span>
                                                    </td>
                                                </tr>

                                                <input type="hidden" id="subsidi" value="IDR 0" />
                                            </tbody>
                                        </table>

                                        <script>
                                            $(document).ready(function() {
                                                $('[data-toggle="tooltip"]').tooltip();
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex">
                                <div class="col-md-3 col-xs-4">
                                    <div class="font-weight-bold">
                                        Bonus </div>
                                </div>
                                <div class="col-md-9 col-xs-8 d-flex flex-wrap">
                                    <div class="m-15" style="width: 100%;">
                                        <div style="width: 100%;">
                                            <select class="form-control promoList" id="pilih_promo_bca"
                                                name="bonus_id">
                                                <option disabled selected value="0">
                                                    Pilih promo
                                                    tersedia</option>
                                                @foreach ($bonus as $b)
                                                <option value="{{ $b->id }}"
                                                    data-persentase="{{ $b->nominal }}">
                                                    {{ $b->keterangan }}
                                                    <!--
                                                                     data-min="@currency($b->minimal)"
                                                                    data-minin="{{ $b->minimal }}"   Minimal Transaksi:
                                                                    @currency($b->minimal) -->
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row info-lst" id="promoInfo_de001" style="">
                                <div class="col-md-3"></div>
                                <div class="col-xs-12 col-md-9 ">
                                    <div class="bankInfo-box" id="promoList">
                                        <div class="box-title">
                                            <i class="icon-invoice i-invoice"></i>
                                            Rincian Promosi

                                            <button class="btn btn-click pull-right" id="btn-clear-all-promo">CLEAR
                                                PROMO</button>
                                        </div>
                                        <table class="table table-borderless    text-right info-box--001">
                                            <tbody>
                                                <tr class="text-left tr_type2">
                                                    <td class="text-center" colspan="2">
                                                        <span class=""
                                                            style="font-weight: 700;  text-decoration:underline;">
                                                            BONUS NEW MEMBER SLOT
                                                            GAMES 20% </span>
                                                    </td>
                                                </tr>
                                                <tr class="text-left first">
                                                    <td class="col-xs-12 col-md-6 " colspan="2">


                                                        <small i18n="">Jenis
                                                            Bonus </small>
                                                    </td>

                                                </tr>
                                                <tr class=" ">

                                                    <td class="col-xs-12 col-md-6 " colspan="2">

                                                        <span class="lbl" style="display:inline-block">
                                                            Bonus Beri Depan </span>
                                                    </td>

                                                </tr>
                                                <tr class="text-left tr_type2">
                                                    <td class="col-xs-6 col-md-6">
                                                        <small i18n="">Min
                                                            Deposit </small>
                                                    </td>
                                                    <td class="col-xs-6 col-md-6 text-right ">
                                                        <span class="lbl">
                                                            IDR50,000.00 </span>
                                                        <input type="hidden" class="promo" id="promo_min_amount"
                                                            name="promo_min_amount" value="50000">

                                                    </td>
                                                </tr>
                                                <tr class=" ">

                                                </tr>
                                                <tr class="text-left tr_type2">
                                                    <td class="col-xs-9 col-md-6">
                                                        <small i18n="">Bonus
                                                            Maksimum Dihadiahkan
                                                        </small>
                                                    </td>
                                                    <td class="col-xs-9 col-md-6  text-right">
                                                        <span class="lbl">
                                                            IDR500,000.00
                                                            <input type="hidden" class="promo"
                                                                id="promo_max_amount" name="promo_max_amount"
                                                                value="500000">
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class=" ">


                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex">
                                <div class="col-md-3 col-xs-4 ">
                                    <div class="font-weight-bold">
                                        Jumlah Deposit<span class="text-danger">*</span>
                                    </div>
                                </div>
                                <div class="col-md-9 col-xs-8">
                                    <div class=" d-flex flex-wrap">
                                        <input type="text" id="min_in_bca" class="form-control m-15 price-tag"
                                            placeholder="Masukan Nominal Deposit" name="nominal" min="50000"
                                            required>
                                    </div>
                                    <p class="min-max-notes">
                                        Min Claim Bonus<span class="min-deposit-amount" style="padding-right: 5px;"><b
                                                id="min_bni">
                                                IDR 50,000.00</b></span><br>
                                        Max Claim Bonus<span class="max-deposit-amount"><b>
                                                IDR 500,000.00</b></span>
                                    </p>
                                    <div class=" d-flex flex-wrap">
                                        <input type="number" id="number" class="form-control m-15"
                                            placeholder="Kode Unik" name="" min="0" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex">
                                <div class="col-md-3 col-xs-4  ">
                                    <div class="font-weight-bold">
                                        Keterangan </div>
                                </div>
                                <div class="col-md-9 col-xs-8 d-flex flex-wrap">
                                    <input type="text" class="form-control m-15" id="ref_no" maxlength="35"
                                        minlength="5" name="keterangan" placeholder="No. Referensi / Nama Pengirim">
                                </div>
                            </div>
                            <div class="row d-flex">
                                <div class="col-md-3 col-xs-4 ">
                                    <div class="font-weight-bold">
                                        Bukti Transfer </div>
                                </div>
                                <div class="col-md-9 col-xs-8 d-flex flex-wrap">
                                    <div class="file-drop-area m-15">
                                        <span class="btn btn-secondary " i18n="">Pilih File</span>
                                        <span class="file-msg">
                                            atau seret dan taruh file di sini
                                        </span>
                                        <input class="file-input" name="bukti_transfer" id="receipt"
                                            type="file" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                </div>
                            </div>
                            <!--<div class="row d-flex">-->
                            <!--    <div class="col-md-12 d-flex flex-wrap">-->
                            <!--        <label>-->
                            <!--            <input type="checkbox" class="form-check-input" id="exampleCheck1"-->
                            <!--                name="termcondition">-->
                            <!--            Saya telah membaca dan menyetujui Syarat dan-->
                            <!--            Ketentuan Promosi. Kami tidak menerima jenis-->
                            <!--            setoran dalam bentuk cek. Semua jenis-->
                            <!--            pembayaran-->
                            <!--            dalam bentuk cek ke akun kami akan-->
                            <!--            diabaikan.-->
                            <!--        </label>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                        <!--- second Tab end----->
                        <div class="row d-flex">
                            <div class="col-md-3 col-xs-4  ">
                            </div>
                            <div class="col-md-9 col-xs-8 d-flex flex-wrap">
                                <div class="m-15">
                                    <button type="button" class="btn btn-primary" id="backBtn"
                                        onclick="tutup_bank()">Back</button>

                                    <button type="submit" class="btn btn-secondary" id="submitBtn">Deposit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
