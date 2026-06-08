<div class="modal fade" id="qrisModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="depositForm" class="needs-validation" action="{{ route('create-payment') }}" method="POST"
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
                                Metode<span class="text-danger">*</span>
                            </div>
                        </div>
                        <div class="col-md-9 col-xs-8 d-flex flex-wrap">
                            <div class="radio_2 m-15 mt-2">
                                <input id="radioBank5" checked="" type="radio" value="5">
                                <label class=" " for="radioBank5">
                                    <span class="radio-title">QRIS</span>
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
                                    Pengirim<span class="text-danger">*</span>
                                </div>
                            </div>
                            <div class="col-md-9 col-xs-8  d-flex flex-wrap">
                                <select class="form-control m-15" name="rek_pengirim" required>
                                    <option value="{{ Auth::user()->bank . ' - ' . Auth::user()->no_rek }}">
                                        {{ Auth::user()->bank . ' - ' . Auth::user()->no_rek }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex">
                            <div class="col-md-3 col-xs-4  ">
                                <div class="font-weight-bold">
                                    Penerima<span class="text-danger">*</span>
                                </div>
                            </div>
                            <div class="col-md-9 col-xs-8 d-flex flex-wrap">
                                <select class="form-control bank_list m-15 has-feedback has-success"
                                    data-plugin="bank_list" id="bank_name_5" name="bank_name">
                                    <option selected value="QRIS">
                                        QRIS - Transaksi Detikan
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="row info-lst" id="bankInfo_de001" style="">
                            <div class="col-xs-13 col-md-12">
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
                                            <tr class="text-left tr_type2">
                                                <td class="col-xs-6 col-md-6">
                                                    <small>No Rek</small>
                                                </td>
                                                <td class="col-xs-6 col-md-6 text-right">
                                                    <a href="javascript:void(0);" data-sel="info-bca"
                                                        class="btn btn-link btn-copy lbl">
                                                        <span class=" ">
                                                            QRIS Otomatis
                                                        </span>
                                                        <i class="icon-copy"></i>
                                                    </a>
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
                        <input name="keterangan" type="text" value="Deposit Menggunakan QRIS Otomatis" hidden>
                        <div class="row d-flex">
                            <div class="col-md-3 col-xs-4 ">
                                <div class="font-weight-bold">
                                    Jumlah Deposit<span class="text-danger">*</span>
                                </div>
                            </div>
                            <div class="col-md-9 col-xs-8">
                                <div class=" d-flex flex-wrap">
                                    <input type="text" id="min_in_bni" class="form-control m-15 price-tag"
                                        placeholder="Minimal Rp {{ number_format($setting->minimal_depo, 0, ',', '.') }}" name="nominal" min="50000" required>
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
                                        <select class="form-control promoList" id="pilih_promo_bca" name="bonus_id">
                                            <option disabled selected value="0">
                                                Pilih promo
                                                tersedia</option>
                                            @foreach ($bonus as $e)
                                                <option value="{{ $e->id }}"
                                                    data-persentase="{{ $e->nominal }}">
                                                    {{ $e->keterangan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- second Tab end----->
                    <div class="row d-flex">
                        <div class="col-md-10 col-xs-4 ">
                        </div>
                        <div class="col-md-9 col-xs-8 d-flex flex-wrap">
                            <div class="m-15 ">
                                <button type="submit" class="btn btn-primary" data-dismiss="modal"
                                    aria-label="Close">Close</button>
                                <button type="submit" class="btn btn-secondary" id="submitBtn">Deposit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
