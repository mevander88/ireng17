<?php
use App\Models\Bonus;
?>

@extends('layouts.main')
@desktop
    @section('desktop')
        <div class="register container">
            <div class="row">
                @php
                    $bonus = Bonus::all();
                @endphp
                <div class="col-md-3">
                    <div class="promo-box">
                        <div class="text-center text-primary">
                            <h4 i18n="@member-benefits">MANFAAT ANGGOTA!</h4>
                        </div>
                        @foreach ($bonus as $b)
                            <ul class="fs-md">
                                <li>
                                    <div class="s"> {{ $b->keterangan }}</div>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 clearfix">
                    <div class="p-title">
                        <span id="step_title" class="skew" data-title="Daftar Akun"> <span>Daftar Akun </span></span>
                    </div>
                    <form method="POST" action="{{ Route('register') }}" class="register-form form form-horizontal"
                        id="registerForm1" onsubmit="return validateForm()">
                        @csrf
                        <input type='hidden' name='stage_val' value="0" id='stage_val'>
                        <input type="hidden" name="ip_register" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">

                        <!-- Form One -->
                        <div class="register_form_one" id="registerFormStep1">
                            <div class="sub-title">Rincian Akun</div>

                            <!-- Username -->
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label>Nama pengguna</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" placeholder="" name="name" id="username"
                                        required onkeyup="validateInput(this)">
                                    <small class="text-left" id="username-error">* Nama akun harus 6-12 karakter, hanya
                                        menggunakan huruf dan/atau angka (0-9) dan tidak ada simbol (@#$~%&amp;) <br> cth:
                                        <b>akun1234</b></small>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label>Kata sandi</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="password" class="form-control" name="password" id="password_1" placeholder=""
                                        required autocomplete="new-password" onkeyup="validateInput(this)">
                                    <small class="text-left" id="password-error">* Minimal 8 karakter, dapat berisi alfabet dan
                                        angka <br> cth: <b>katasandi1 </b></small>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label>Konfirmasi Sandi</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" placeholder="" required autocomplete="new-password"
                                        onkeyup="validateInput(this)">
                                    <small class="text-left" id="confirm-password-error"></small>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="sub-title">Contact info</div>
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label>Alamat email</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="email" class="form-control" placeholder="" name="email" id="email"
                                        value="" required onkeyup="validateInput(this)">
                                    <small class="text-left" id="email-error">* Silakan isi alamat email yang benar </small>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label>Nomor telepon</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="tel" class="form-control" placeholder="" id="mobile_no" name="mobile_no"
                                        required maxlength="20" onkeyup="validateInput(this)">
                                    <small class="text-left" id="phone-error"></small>
                                </div>
                            </div>

                            <!-- Referral Code -->
                            <div class="form-group" id="refCode_formgrp">
                                <div class="col-xs-5 col-md-5">
                                    <label>Kode Referensi / Afiliasi</label>
                                </div>
                                <div class="col-xs-7 col-md-7">
                                    <input type="text" class="form-control" id="refCodeInput" name="ref_code"
                                        value="{{ $refferal }}" maxlength="50" autocomplete="off">
                                    <small class="text-left">(Optional) Kosongkan jika tidak ada </small>
                                </div>
                            </div>

                            <!-- Next Button -->
                            <div class="form-group">
                                <div class="col-xs-4 text-right" style="padding-top:15px"></div>
                                <input type="hidden" value="1" name="isRegHasBank">
                                <div class="col-xs-8 text-right" style="padding-top:15px" id="registerFormStep1NextBtn">
                                    <button type="button" class="btn btn-secondary" onclick="showFormTwo()">Lanjut</button>
                                </div>
                            </div>
                        </div>

                        <!-- Form Two -->
                        <div class="register_form_two" id="registerFormStep2" style="display:none;">
                            <input type="hidden" value="1" name="isRegHasBank">
                            <div class="sub-title">Informasi bank</div>

                            <!-- Account Name -->
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label>Nama Sesuai Rekening</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="name1" placeholder=""
                                        name="acc_name" maxlength="100">
                                    <small class="text-left">* Nama yang terdaftar harus sesuai dengan nama rekening bank yang
                                        digunakan untuk menyetor dan menarik dana.</small>
                                </div>
                            </div>

                            <!-- Transaction Account Type -->
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="method" style="padding-top: 7.5px;">Jenis Akun Transaksi<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-xs-6 radio_2">
                                            <input class=" " name="method" id="radioBank" checked=""
                                                type="radio" value="5">
                                            <label class=" " for="radioBank">
                                                <span class="radio-title">Bank</span>
                                                <span class="marked"><i class="icon-checkmark"></i></span>
                                            </label>
                                        </div>
                                        <div class="col-xs-6 radio_2">
                                            <input class=" " name="method" id="radioEwallet" type="radio"
                                                value="7">
                                            <label class="" for="radioEwallet">
                                                <span class="radio-title">E-wallet</span>
                                                <span class="marked"><i class="icon-checkmark"></i></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Options -->
                            <div class="form-group" id="isShowBankOptions">
                                <div class="col-md-5">
                                    <label>Bank</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control" data-plugin="bank_list" id="bankOpts--register"
                                        name="bank_name">
                                        <option selected="" value="">- Silahkan pilih -</option>
                                        <option value="Bank Central Asia" data-bcode="BCA">Bank Central Asia</option>
                                        <option value="MANDIRI" data-bcode="MDR">MANDIRI</option>
                                        <option value="Bank Negara Indonesia" data-bcode="BNI">Bank Negara Indonesia</option>
                                        <option value="Bank Rakyat Indonesia" data-bcode="BRI">Bank Rakyat Indonesia</option>
                                        <option value="DANAMON" data-bcode="DMN">DANAMON</option>
                                        <option value="CIMB NIAGA" data-bcode="CIMBN">CIMB NIAGA</option>
                                        <option value="PERMATA BANK" data-bcode="BPMT">PERMATA BANK</option>
                                    </select>
                                </div>
                            </div>

                            <!-- E-wallet Options -->
                            <div class="form-group" id="isShowEwalletOptions" style="display:none;">
                                <div class="col-md-5">
                                    <label>E-wallet</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control" data-plugin="bank_list" id="ewalletOpts--register"
                                        name="bank_name" disabled="">
                                        <option selected="" value="">- Silahkan pilih -</option>
                                        <option value="DANA">DANA</option>
                                        <option value="GOPAY">GOPAY</option>
                                        <option value="SHOPEEPAY">SHOPEEPAY</option>
                                        <option value="sakuku">sakuku</option>
                                        <option value="link aja">link aja</option>
                                        <option value="ovo">ovo</option>
                                        <option value="jenius">jenius</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Account Number -->
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label id="isShowBankLable">No. Rekening Bank</label>
                                    <label id="isShowEwalletLable" style="display:none;">No. E-Wallet</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="tel" class="form-control" placeholder="" name="acc_no" id="acc_no"
                                        required="" autocomplete="off" minlength="8" maxlength="20">
                                    <div class="loader-b" id="accno-validate-loader"
                                        style="position: absolute; display: block; top: 3px; right: 23px; width: 10px; height: 10px; left: inherit; display:none;">
                                    </div>
                                    <small class="text-left">* Pastikan rekening anda Valid, Aktif, dan belum terdaftar di
                                        situs ini</small>
                                </div>
                            </div>

                            <!-- Captcha -->
                            <div class="form-group row no-gutters">
                                <div class="col-xs-4 col-md-5" style="margin-left:15px;">
                                    <label>Captcha</label>
                                </div>
                                <div class="col-xs-3 col-md-2">
                                    <input type="tel" id="captcha" class="form-control" name="captcha" maxlength="4"
                                        autocomplete="off" style="height: 38px;">
                                </div>
                                <img src="{{ captcha_src('mini') }}" onclick="this.src='/captcha/mini?'+Math.random()"
                                    id="captchaCode" alt="" class="captcha">
                                <a rel="nofollow" href="javascript:;"
                                    onclick="document.getElementById('captchaCode').src='captcha/mini?'+Math.random()"
                                    class="refresh btn btn-sm btn-info">
                                    <i class="icon-refresh"></i>
                                </a>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-group form-check submit-box">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="terms" name="terms" value="on">
                                            &nbsp;Dengan memilih tombol DAFTAR, saya menyatakan bahwa saya berusia 18 tahun atau
                                            lebih. Saya telah membaca dan menyetujui Syarat &amp; Ketentuan. Lihat <a
                                                href="#" target="_blank" rel="noopener noreferrer">Syarat &amp; Ketentuan </a>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit and Previous Buttons -->
                            <div class="form-group">
                                <div class="col-xs-4 text-right" style="padding-top:15px" id="registerFormStep2PrevBtn">
                                    <button type="button" class="btn btn-tertiery"
                                        onclick="showFormOne()">Sebelumnya</button>
                                </div>
                                <div class="col-xs-8 text-right" style="padding-top:15px;">
                                    <button type="submit" class="btn btn-secondary">Daftar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <script>
                        function validateInput(input) {
                            var id = input.id;
                            var value = input.value;
                            var errorElement = document.getElementById(id + "-error");

                            switch (id) {
                                case "username":
                                    if (value.length < 6 || value.length > 12 || !/^[a-zA-Z0-9]+$/.test(value)) {
                                        errorElement.textContent =
                                            "* Nama pengguna harus terdiri dari 6-12 karakter dan hanya huruf dan/atau angka (0-9).";
                                    } else {
                                        errorElement.textContent = "";
                                    }
                                    break;
                                case "password_1":
                                    // Validasi kata sandi
                                    if (value.length < 8 || !/^(?=.*[a-zA-Z])(?=.*\d).*$/.test(value)) {
                                        errorElement.textContent = "* Minimal 8 karakter, dapat berisi alfabet dan angka";
                                    } else {
                                        errorElement.textContent = "";
                                    }
                                    break;
                                case "password_confirmation":
                                    // Validasi konfirmasi kata sandi
                                    var password = document.getElementById("password_1").value;
                                    if (value !== password) {
                                        errorElement.textContent = "* Konfirmasi kata sandi tidak cocok.";
                                    } else {
                                        errorElement.textContent = "";
                                    }
                                    break;
                                case "email":
                                    // Validasi alamat email
                                    if (!/^\S+@\S+\.\S+$/.test(value)) {
                                        errorElement.textContent = "* Alamat email tidak valid.";
                                    } else {
                                        errorElement.textContent = "";
                                    }
                                    break;
                                case "mobile_no":
                                    // Validasi nomor telepon
                                    if (!/^\d{10,}$/.test(value)) {
                                        errorElement.textContent = "* Nomor telepon harus berisi setidaknya 10 digit.";
                                    } else {
                                        errorElement.textContent = "";
                                    }
                                    break;
                                    // Anda dapat menambahkan case lain untuk input lainnya di sini
                            }
                        }

                        function validateForm() {
                            // Validasi nama pengguna
                            var username = document.forms["registerForm1"]["name"].value;
                            if (username.length < 6 || username.length > 12 || !/^[a-zA-Z0-9]+$/.test(username)) {
                                alert("Nama pengguna harus terdiri dari 6-12 karakter dan hanya huruf dan/atau angka (0-9).");
                                return false;
                            }

                            // Validasi kata sandi
                            var password = document.forms["registerForm1"]["password"].value;
                            if (password.length < 8 || !/^(?=.*[a-zA-Z])(?=.*\d).*$/.test(password)) {
                                alert("Kata sandi harus minimal 8 karakter dan berisi setidaknya satu huruf dan satu angka.");
                                return false;
                            }

                            // Validasi konfirmasi kata sandi
                            var confirmPassword = document.forms["registerForm1"]["password_confirmation"].value;
                            if (password !== confirmPassword) {
                                alert("Konfirmasi kata sandi tidak cocok.");
                                return false;
                            }

                            // Validasi alamat email
                            var email = document.forms["registerForm1"]["email"].value;
                            if (!/^\S+@\S+\.\S+$/.test(email)) {
                                alert("Alamat email tidak valid.");
                                return false;
                            }

                            // Validasi nomor telepon
                            var phoneNumber = document.forms["registerForm1"]["mobile_no"].value;
                            if (!/^\d{10,}$/.test(phoneNumber)) {
                                alert("Nomor telepon harus berisi setidaknya 10 digit.");
                                return false;
                            }

                            // Validasi nama sesuai rekening (form 2)
                            var accountName = document.forms["registerForm1"]["acc_name"].value;
                            if (accountName.length === 0) {
                                alert("Nama sesuai rekening harus diisi.");
                                return false;
                            }

                            // Validasi nomor rekening bank atau e-wallet (form 2)
                            var accountNumber = document.forms["registerForm1"]["acc_no"].value;
                            if (!/^\d{8,20}$/.test(accountNumber)) {
                                alert("Nomor rekening bank atau e-wallet tidak valid.");
                                return false;
                            }

                            // Validasi checkbox Syarat & Ketentuan
                            var termsChecked = document.getElementById("terms").checked;
                            if (!termsChecked) {
                                alert("Anda harus menyetujui Syarat & Ketentuan.");
                                return false;
                            }

                            return true;
                        }
                    </script>
                    <script>
                        function showFormTwo() {
                            document.getElementById('registerFormStep1').style.display = 'none';
                            document.getElementById('registerFormStep2').style.display = 'block';

                            // Menghapus atribut 'disabled' dari tombol submit
                            document.querySelector('[type="submit"]').removeAttribute('disabled');
                        }

                        function showFormOne() {
                            document.getElementById('registerFormStep2').style.display = 'none';
                            document.getElementById('registerFormStep1').style.display = 'block';
                        }

                        // Additional JavaScript to handle the radio button selection and display the corresponding form fields
                        document.getElementById('radioBank').addEventListener('change', function() {
                            document.getElementById('isShowBankOptions').style.display = 'block';
                            document.getElementById('isShowEwalletOptions').style.display = 'none';
                            document.getElementById('isShowBankLable').style.display = 'block';
                            document.getElementById('isShowEwalletLable').style.display = 'none';
                            document.getElementById('ewalletOpts--register').disabled = true;
                            document.getElementById('bankOpts--register').disabled = false;
                        });

                        document.getElementById('radioEwallet').addEventListener('change', function() {
                            document.getElementById('isShowBankOptions').style.display = 'none';
                            document.getElementById('isShowEwalletOptions').style.display = 'block';
                            document.getElementById('isShowBankLable').style.display = 'none';
                            document.getElementById('isShowEwalletLable').style.display = 'block';
                            document.getElementById('ewalletOpts--register').disabled = false;
                            document.getElementById('bankOpts--register').disabled = true;
                        });
                    </script>

                </div>

            </div>

        </div>
    @endsection

    {{-- THIS MOBILE --}}
@elsedesktop
    @section('content')
        <div class="container  ">
            <div class="row">
                <div class="col-xs-12">
                    <div class="mb-1">
                        <h3 class="d-inline-block" style="text-align: center">Daftar Akun
                            {{-- <sup class="sup">
                                <a tabindex="0" id="Pop_my001" class="btn btn-clear" role="button" data-toggle="popover"
                                    data-trigger="focus" title="Member Benefits">
                                    MANFAAT ANGGOTA<i class="fas fa-question-circle"></i>
                                </a>
                            </sup> --}}
                        </h3>

                        <form method="POST" action="{{ Route('register') }}" class="register-form form form-horizontal "
                            id="registerForm1">
                            @csrf

                            <input type='hidden' name='stage_val' value="0" id='stage_val'>
                            <input type="hidden" name="ip_register" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                            <div class="register_form_one" id="form_satu">
                                <div class="sub-title">Rincian Akun</div>
                                <div class="form-group  ">
                                    <div class="col-md-5">
                                        <label>Nama pengguna</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" placeholder="" name="name" required>
                                        <small class="text-left">* Nama akun harus 6-12 karakter, hanya menggunakan huruf
                                            dan/atau
                                            angka (0-9) dan tidak ada simbol (@#$~%&) <br> cth: <b>akun1234</b>
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group  ">
                                    <div class="col-md-5">
                                        <label>Kata sandi</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="password" class="form-control" name="password" id="password_1"
                                            placeholder="" required autocomplete="new-password">
                                        <small class="text-left">* Minimal 8 karakter, dapat berisi alfabet dan angka <br>
                                            cth:
                                            <b>katasandi1 </b> </small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <label>Konfirmasi Sandi</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="password" class="form-control input_text" name="password_confirmation"
                                            id="password_confirmation" placeholder="" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="sub-title">Contact info</div>
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <label>Alamat email</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="email" class="form-control " placeholder="" name="email"
                                            value="" required>
                                        <div class="loader-b" id="email-validate-loader"
                                            style="position: absolute; display: block; top: 3px; right: 23px; width: 10px; height: 10px; left: inherit; display:none;">
                                        </div>
                                        <small class="text-left">* Silakan isi alamat email yang benar </small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <label>Nomor telepon</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="tel" class="form-control" placeholder="" id="mobile_no"
                                            name="mobile_no" required maxlength="20">
                                        <div class="loader-b" id="mobile-validate-loader"
                                            style="position: absolute; display: block; top: 3px; right: 23px; width: 10px; height: 10px; left: inherit; display:none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="refCode_formgrp">
                                    <div class="col-xs-5  col-md-5">
                                        <label>Kode Referensi / Afiliasi</label>
                                    </div>
                                    <div class="col-xs-7  col-md-7">
                                        <input type="text" class="form-control" id="refCodeInput" name="ref_code"
                                            maxlength="50" autocomplete="off" value="{{ $refferal }}">
                                        <small class="text-left">(Optional) Kosongkan jika tidak ada </small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-4 text-right" style="padding-top:15px">
                                    </div>
                                    <input type="hidden" value="1" name="isRegHasBank">
                                    <div class="col-xs-8 text-right" style="padding-top:15px">
                                        <button type="button" class="btn btn-secondary next_btn">Lanjut</button>
                                        {{-- <button type="button" onclick="satu()"
                                            class="btn btn-secondary next_btn">Lanjut</button> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="register_form_two" id="form_dua" style="display: none">
                                <div class="sub-title">Informasi bank</div>
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <label>Nama Sesuai Rekening</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="name1" placeholder=""
                                            name="acc_name" maxlength="100">
                                        <small class="text-left">* Nama yang terdaftar harus sesuai dengan nama rekening
                                            bank yang
                                            digunakan untuk menyetor dan menarik dana.</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5 ">
                                        <label for="method" style="padding-top: 7.5px;">Jenis Akun Transaksi<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-xs-6 radio_2">
                                                <input class=" " name="method" id="radioBank5" checked type="radio"
                                                    value="5">
                                                <label class=" " for="radioBank5">
                                                    <span class="radio-title">
                                                        Bank </span>
                                                    <span class="marked">
                                                        <i class="icon-checkmark"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="col-xs-6 radio_2">
                                                <input class=" " name="method" id="radioEwallet7" type="radio"
                                                    value="7">
                                                <label class="" for="radioEwallet7">
                                                    <span class="radio-title">
                                                        E-wallet </span>
                                                    <span class="marked">
                                                        <i class="icon-checkmark"></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="isShowBankOptions">
                                    <div class="col-md-5">
                                        <label>Bank</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control" data-plugin="bank_list" id="bankOpts--register"
                                            name="bank_name">
                                            <option selected="" value="">- Silahkan pilih -</option>
                                            <option value="Bank Central Asia" data-bcode="BCA">Bank Central Asia</option>
                                            <option value="MANDIRI" data-bcode="MDR">MANDIRI</option>
                                            <option value="Bank Negara Indonesia" data-bcode="BNI">Bank Negara Indonesia
                                            </option>
                                            <option value="Bank Rakyat Indonesia" data-bcode="BRI">Bank Rakyat Indonesia
                                            </option>
                                            <option value="DANAMON" data-bcode="DMN">DANAMON</option>
                                            <option value="CIMB NIAGA" data-bcode="CIMBN">CIMB NIAGA</option>
                                            <option value="PERMATA BANK" data-bcode="BPMT">PERMATA BANK</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="isShowEwalletOptions" style="display:none;">
                                    <div class="col-md-5">
                                        <label>E-wallet</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control" data-plugin="bank_list" id="ewalletOpts--register"
                                            name="bank_name" disabled="">
                                            <option selected="" value="">- Silahkan pilih -</option>
                                            <option value="DANA">DANA</option>
                                            <option value="GOPAY">GOPAY</option>
                                            <option value="SHOPEEPAY">SHOPEEPAY</option>
                                            <option value="sakuku">sakuku</option>
                                            <option value="link aja">link aja</option>
                                            <option value="ovo">ovo</option>
                                            <option value="jenius">jenius</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <label id="isShowBankLable">No. Rekening Bank</label>
                                        <label id="isShowEwalletLable" style="display:none;">No. E-Wallet</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="tel" class="form-control " placeholder="" name="acc_no"
                                            id="acc_no" required autocomplete="off" minlength="8" maxlength="20">
                                        <div class="loader-b" id="accno-validate-loader"
                                            style="position: absolute; display: block; top: 3px; right: 23px; width: 10px; height: 10px; left: inherit; display:none;">
                                        </div>
                                        <small class="text-left">* Pastikan rekening anda Valid, Aktif, dan belum terdaftar
                                            di situs
                                            ini</small>
                                    </div>
                                </div>
                                <div class="form-group row no-gutters">
                                    <div class="col-xs-4 col-md-5" style="margin-left:15px;">
                                        <label>Captcha</label>
                                    </div>
                                    <div class="col-xs-3 col-md-2">
                                        <input type="text" id="captcha" class="form-control" name="captcha"
                                            maxlength="4" autocomplete="off" style="height: 38px;">
                                    </div>
                                    <img src="{{ captcha_src('mini') }}" onclick="this.src='/captcha/mini?'+Math.random()"
                                        id="captchaCode" alt="" class="captcha">
                                    <a rel="nofollow" href="javascript:;"
                                        onclick="document.getElementById('captchaCode').src='captcha/mini?'+Math.random()"
                                        class="refresh btn btn-sm btn-info">

                                        <i class="fa-sharp fa-solid fa-arrows-rotate">
                                        </i>

                                    </a>
                                </div>
                                <div class="form-group form-check submit-box">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label><input type="checkbox" id="terms" name="terms" value="on">
                                                &nbsp;Dengan memilih
                                                tombol DAFTAR, saya menyatakan bahwa saya berusia 18 tahun atau lebih. Saya
                                                telah membaca
                                                dan menyetujui Syarat & Ketentuan. Lihat <a href="#"
                                                    target="_blank" rel="noopener noreferrer">Syarat &
                                                    Ketentuan </a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4 text-right" style="padding-top:15px">
                                        <button onclick="dua()" type="button"
                                            class="btn btn-tertiery prev_btn">Sebelumnya</button>
                                    </div>
                                    <div class="col-xs-8 text-right" style="padding-top:15px">
                                        <button type="submit" class="btn btn-secondary">Daftar</button>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>

            </div>

        </div>


        </div>
        <script>
            $('input[name=method]').change(function() {
                $('#bankOpts--register').val(null);
                $('#ewalletOpts--register').val(null);
                $("#acc_no").val(null);

                if ($(this).val() == '7') {
                    $('#isShowBankOptions,#isShowBankLable').hide();
                    $('#isShowEwalletOptions,#isShowEwalletLable').show();

                    $('#bankOpts--register').prop('disabled', true);
                    $('#ewalletOpts--register').prop('disabled', false);
                    $("#acc_no").attr("minlength", '1');
                    $("#acc_no").attr("maxlength", "20");
                } else {
                    $('#isShowBankOptions,#isShowBankLable').show();
                    $('#isShowEwalletOptions,#isShowEwalletLable').hide();
                    $('#bankOpts--register').prop('disabled', false);
                    $('#ewalletOpts--register').prop('disabled', true);
                    $("#acc_no").attr("minlength", window.accLength);
                }
            });
            const nextButton = document.querySelector('.next_btn');
            const formOne = document.getElementById('form_satu');
            const formTwo = document.getElementById('form_dua');

            nextButton.addEventListener('click', function() {

                if (validateFormOne()) {
                    formOne.style.display = 'none';
                    formTwo.style.display = 'block';
                } else {

                    alert('Please fill out all required fields in form 1 correctly.');
                }
            });

            function validateFormOne() {

                const name = document.querySelector('[name="name"]').value;
                const password = document.querySelector('[name="password"]').value;
                const confirmPassword = document.querySelector('[name="password_confirmation"]').value;
                const email = document.querySelector('[name="email"]').value;
                const mobileNo = document.querySelector('[name="mobile_no"]').value;

                if (!name || !password || !confirmPassword || !email || !mobileNo) {
                    return false;
                }


                return true;
            }
        </script>
    @endsection
@enddesktop
