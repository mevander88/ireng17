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
            <form method="POST" action="{{ route('register') }}" class="register-form form form-horizontal" id="registerForm1" onsubmit="return validateForm()">
                @csrf
                <input type='hidden' name='stage_val' value="0" id='stage_val'>
                <input type="hidden" name="ip_register" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                <input type="hidden" name="bank_name" id="hidden_bank_name_desktop" value="">

                <!-- Form One -->
                <div class="register_form_one" id="registerFormStep1">
                    <div class="sub-title">Rincian Akun</div>

                    <!-- Username -->
                    <div class="form-group">
                        <div class="col-md-5">
                            <label>Username/ID</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" placeholder="" name="name" id="username" required onkeyup="validateInput(this)">
                            <small class="text-left" id="username-error">* Nama akun harus 6-12 karakter, hanya menggunakan huruf dan/atau angka (0-9) dan tidak ada simbol (@#$~%&amp;) <br> cth: <b>akun1234</b></small>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <div class="col-md-5">
                            <label>Kata sandi</label>
                        </div>
                        <div class="col-md-7">
                            <input type="password" class="form-control" name="password" id="password_1" placeholder="" required autocomplete="new-password" onkeyup="validateInput(this)">
                            <small class="text-left" id="password-error">* Minimal 8 karakter, dapat berisi alfabet dan angka <br> cth: <b>katasandi1 </b></small>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <div class="col-md-5">
                            <label>Konfirmasi Sandi</label>
                        </div>
                        <div class="col-md-7">
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="" required autocomplete="new-password" onkeyup="validateInput(this)">
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
                            <input type="email" class="form-control" placeholder="" name="email" id="email" value="" required onkeyup="validateInput(this)">
                            <small class="text-left" id="email-error">* Silakan isi alamat email yang benar </small>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="form-group">
                        <div class="col-md-5">
                            <label>Nomor telepon</label>
                        </div>
                        <div class="col-md-7">
                            <input type="tel" class="form-control" placeholder="" id="mobile_no" name="mobile_no" required maxlength="20" onkeyup="validateInput(this)">
                            <small class="text-left" id="phone-error"></small>
                        </div>
                    </div>

                    <!-- Referral Code -->
                    <div class="form-group" id="refCode_formgrp">
                        <div class="col-xs-5 col-md-5">
                            <label>Kode Referensi / Afiliasi</label>
                        </div>
                        <div class="col-xs-7 col-md-7">
                            <input type="text" class="form-control" id="refCodeInput" name="ref_code" maxlength="50" autocomplete="off">
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
                            <input type="text" class="form-control" id="accBankName" placeholder="" name="acc_name" maxlength="100" required>
                            <small class="text-left">* Nama yang terdaftar harus sesuai dengan nama rekening bank yang digunakan untuk menyetor dan menarik dana.</small>
                        </div>
                    </div>

                    <!-- Transaction Account Type -->
                    <div class="form-group">
                        <div class="col-md-5">
                            <label for="method" style="padding-top: 7.5px;">Jenis Akun Transaksi<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-xs-6 radio_2">
                                    <input class=" " name="method" id="radioBank" checked="" type="radio" value="5">
                                    <label class=" " for="radioBank">
                                        <span class="radio-title">Bank</span>
                                        <span class="marked"><i class="icon-checkmark"></i></span>
                                    </label>
                                </div>
                                <div class="col-xs-6 radio_2">
                                    <input class=" " name="method" id="radioEwallet" type="radio" value="7">
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
                            <select class="form-control" id="bankOpts--register" name="bank_name">
    <option selected value="">- Silahkan pilih -</option>
    <option value="BRI" data-bcode="002">BRI</option>
    <option value="BCA" data-bcode="014">BCA</option>
    <option value="SEABANK" data-bcode="535">SEABANK</option>
    <option value="Mandiri" data-bcode="008">Mandiri</option>
    <option value="BNI" data-bcode="009">BNI</option>
    <option value="BSI" data-bcode="427">BSI</option>
    <option value="Bank JAGO" data-bcode="542">Bank JAGO</option>
    <option value="CIMB NIAGA" data-bcode="022">CIMB NIAGA</option>
    <option value="Bank Permata" data-bcode="013">Bank Permata</option>
    <option value="Bank OCBC" data-bcode="028">Bank OCBC</option>
    <option value="BANK RAYA" data-bcode="494">BANK RAYA</option>
    <option value="BANK PANIN" data-bcode="019">BANK PANIN</option>
    <option value="BANK ALADIN" data-bcode="947">BANK ALADIN</option>
    <option value="BANK LAINNYA" data-bcode="00">BANK LAINNYA</option>

</select>
                        </div>
                    </div>

                    <!-- E-wallet Options -->
                    <div class="form-group" id="isShowEwalletOptions" style="display:none;">
                        <div class="col-md-5">
                            <label>E-wallet</label>
                        </div>
                        <div class="col-md-7">
                            <label for="ewalletOpts--register">Pilih E-Wallet</label>
                            <select class="form-control" data-plugin="ewallet_list" id="ewalletOpts--register" name="ewallet_name">
                                <option selected="" value="">- Silahkan pilih E-Wallet -</option>

                                @foreach($ewallet as $ew)
                                <option value="{{ $ew->nama_bank }}" data-bcode="{{ $ew->code }}">{{ $ew->nama_bank }}</option>
                                @endforeach

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
                        <input type="tel" class="form-control" placeholder="" name="acc_no" id="acc_no" required="" autocomplete="off" minlength="8" maxlength="20">
                        <div class="loader-b" id="accno-validate-loader" style="position: absolute; display: block; top: 3px; right: 23px; width: 10px; height: 10px; left: inherit; display:none;"></div>
                        <small class="text-left">* Pastikan rekening anda Valid, Aktif, dan belum terdaftar di situs ini</small>
                    </div>
                </div>

                <!-- Captcha -->
                <div class="form-group row no-gutters">
                    <div class="col-xs-4 col-md-5" style="margin-left:15px;">
                        <label>Captcha</label>
                    </div>
                    <div class="col-xs-3 col-md-2">
                        <input type="tel" id="captcha" class="form-control" name="captcha" maxlength="4" autocomplete="off" style="height: 38px;">
                    </div>
                    <img src="{{ captcha_src('mini') }}" onclick="this.src='/captcha/mini?'+Math.random()" id="captchaCode" alt="" class="captcha">
                    <a rel="nofollow" href="javascript:;" onclick="document.getElementById('captchaCode').src='captcha/mini?'+Math.random()" class="refresh btn btn-sm btn-info">
                        <i class="icon-refresh"></i>
                    </a>
                </div>

                <!-- Terms and Conditions -->
                <div class="form-group form-check submit-box">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label><input type="checkbox" id="terms" name="terms" value="on">
                                &nbsp;Dengan memilih tombol DAFTAR, saya menyatakan bahwa saya berusia 18 tahun atau lebih. Saya telah membaca dan menyetujui Syarat &amp; Ketentuan. Lihat <a href="#" target="_blank" rel="noopener noreferrer">Syarat &amp; Ketentuan </a>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit and Previous Buttons -->
                <div class="form-group">
                    <div class="col-xs-4 text-right" style="padding-top:15px" id="registerFormStep2PrevBtn">
                        <button type="button" class="btn btn-tertiery" onclick="showFormOne()">Sebelumnya</button>
                    </div>
                    <div class="col-xs-8 text-right" style="padding-top:15px;">
                        <button type="submit" class="btn btn-secondary">Daftar</button>
                    </div>
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
                            errorElement.textContent = "* Nama pengguna harus terdiri dari 6-12 karakter dan hanya huruf dan/atau angka (0-9).";
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
                document.getElementById('hidden_bank_name_desktop').value = '';
            });

            document.getElementById('radioEwallet').addEventListener('change', function() {
                document.getElementById('isShowBankOptions').style.display = 'none';
                document.getElementById('isShowEwalletOptions').style.display = 'block';
                document.getElementById('isShowBankLable').style.display = 'none';
                document.getElementById('isShowEwalletLable').style.display = 'block';
                document.getElementById('ewalletOpts--register').disabled = false;
                document.getElementById('bankOpts--register').disabled = true;
                document.getElementById('hidden_bank_name_desktop').value = '';
            });
            
            // Update hidden input ketika bank atau e-wallet dipilih (desktop)
            document.getElementById('bankOpts--register')?.addEventListener('change', function() {
                document.getElementById('hidden_bank_name_desktop').value = this.value;
            });
            document.getElementById('ewalletOpts--register')?.addEventListener('change', function() {
                // Untuk desktop, e-wallet menggunakan name="ewallet_name", tapi kita juga set hidden untuk konsistensi
                document.getElementById('hidden_bank_name_desktop').value = this.value;
            });
            
            // Pastikan hidden input terisi saat form submit (desktop)
            document.getElementById('registerForm1')?.addEventListener('submit', function() {
                var bankValue = document.getElementById('bankOpts--register')?.value || '';
                var ewalletValue = document.getElementById('ewalletOpts--register')?.value || '';
                document.getElementById('hidden_bank_name_desktop').value = bankValue || ewalletValue;
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

                <form method="POST" action="{{ route('register') }}" class="register-form form form-horizontal "
                    id="registerForm1">
                    @csrf

                    <input type='hidden' name='stage_val' value="0" id='stage_val'>
                    <input type="hidden" name="ip_register" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                    <input type="hidden" name="bank_name" id="hidden_bank_name" value="">
                    <div class="register_form_one" id="form_satu">
                        <div class="sub-title">Rincian Akun</div>
                        <div class="form-group  ">
                            <div class="col-md-5">
                                <label>Username/ID</label>
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
                                    maxlength="50" autocomplete="off">
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
                                <input type="text" class="form-control" id="accBankName" placeholder=""
                                    name="acc_name" maxlength="100" required>
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
                                <select class="form-control" id="bankOpts--register" name="bank_name">
    <option selected value="">- Silahkan pilih -</option>
    <option value="BRI" data-bcode="002">BRI</option>
    <option value="BCA" data-bcode="014">BCA</option>
    <option value="SEABANK" data-bcode="535">SEABANK</option>
    <option value="Mandiri" data-bcode="008">Mandiri</option>
    <option value="BNI" data-bcode="009">BNI</option>
    <option value="BSI" data-bcode="427">BSI</option>
    <option value="Bank JAGO" data-bcode="542">Bank JAGO</option>
    <option value="CIMB NIAGA" data-bcode="022">CIMB NIAGA</option>
    <option value="Bank Permata" data-bcode="013">Bank Permata</option>
    <option value="Bank OCBC" data-bcode="028">Bank OCBC</option>
    <option value="BANK RAYA" data-bcode="494">BANK RAYA</option>
    <option value="BANK PANIN" data-bcode="019">BANK PANIN</option>
    <option value="BANK ALADIN" data-bcode="947">BANK ALADIN</option>
    <option value="BANK LAINNYA" data-bcode="00">BANK LAINNYA</option>

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
                                    @foreach($ewallet as $ew)
                                    <option value="{{ $ew->nama_bank }}" data-bcode="{{ $ew->code }}">{{ $ew->nama_bank }}</option>
                                    @endforeach
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
        $('#hidden_bank_name').val('');

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
    
    // Update hidden input ketika bank atau e-wallet dipilih
    $('#bankOpts--register, #ewalletOpts--register').on('change', function() {
        $('#hidden_bank_name').val($(this).val());
    });
    const nextButton = document.querySelector('.next_btn');
    const formOne = document.getElementById('form_satu');
    const formTwo = document.getElementById('form_dua');

nextButton.addEventListener('click', function () {
    const error = validateFormOne();
    if (error === true) {
        formOne.style.display = 'none';
        formTwo.style.display = 'block';
    } else {
        alert(error);   // ← alert langsung tampil pesan spesifik
    }
});

function validateFormOne() {
    const name = document.querySelector('[name="name"]').value.trim();
    const password = document.querySelector('[name="password"]').value.trim();
    const confirmPassword = document.querySelector('[name="password_confirmation"]').value.trim();
    const email = document.querySelector('[name="email"]').value.trim();
    const mobileNo = document.querySelector('[name="mobile_no"]').value.trim();

    if (!name) return "Username tidak boleh kosong!";
    if (!password) return "Password tidak boleh kosong!";
    if (!confirmPassword) return "Konfirmasi password tidak boleh kosong!";
    if (password !== confirmPassword) return "Konfirmasi password tidak sama!";
    if (!email) return "Email wajib diisi!";
    if (!mobileNo) return "Nomor HP wajib diisi!";

    return true;
}

</script>

@endsection
@enddesktop

<script>
document.getElementById('registerForm1').addEventListener('submit', function(e) {
    // Pastikan hidden bank_name terisi sebelum submit (mobile)
    var bankValue = document.getElementById('bankOpts--register')?.value || '';
    var ewalletValue = document.getElementById('ewalletOpts--register')?.value || '';
    var hiddenBankName = document.getElementById('hidden_bank_name');
    if (hiddenBankName) {
        hiddenBankName.value = bankValue || ewalletValue;
    }
    
    var form2 = document.getElementById('registerFormStep2');
    if (form2 && form2.style.display !== 'none') {
        var accName = document.getElementById('accBankName')?.value.trim();
        var accNo   = document.getElementById('acc_no')?.value.trim();
        var captcha = document.getElementById('captcha')?.value.trim();

        if (!accName) {
            alert("Nama sesuai rekening harus diisi!");
            e.preventDefault();
            return false;
        }
        if (!accNo) {
            alert("Nomor rekening wajib diisi!");
            e.preventDefault();
            return false;
        }
        if (!captcha) {
            alert("Captcha wajib diisi!");
            e.preventDefault();
            return false;
        }
    }
});
</script>

{{-- Include Alert Popup Component --}}
@include('components.alert-popup')
