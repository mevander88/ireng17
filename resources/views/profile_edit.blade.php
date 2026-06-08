<div class="row profile-edit">
    <div class="col-lg-5 col-xs-12">
        <div class="row">
            <div class="col-xs-4 noSidePadding">
                <p class="_label" i18n="">Nama pengguna :</p>
            </div>
            <div class="col-xs-8 noSidePadding">
                <p>{{ Auth::user()->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 noSidePadding">
                <p class="_label" i18n="">Tingkat Anggota :</p>
            </div>
            <div class="col-xs-8 noSidePadding">
                <div class="memer_leavel">
                    <p class="d-flex">
                        @if (Auth::user()->level == null)
                            <p>NEW MEMBER <b style="color:gold;">VIP</b></p>
                        @else
                            Administrator
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 noSidePadding">
                <p class="_label" i18n="">Nama Sesuai Rekening :</p>
            </div>
            <div class="col-xs-8 noSidePadding">
                <p>{{ Auth::user()->nama_rek }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 noSidePadding">
                <p class="_label" i18n="">Alamat email :</p>
            </div>
            <div class="col-xs-8 noSidePadding">
                <p>{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-12 ">
        <div class="row">
            <div class="col-xs-4 noSidePadding">
                <p class="_label" i18n="">Nomor :</p>
            </div>
            <div class="col-xs-8 noSidePadding">
                <p>{{ Auth::user()->telp }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 noSidePadding">
                <p class="_label" i18n="">Refferal Kode :</p>
            </div>
            <div class="col-xs-4 noSidePadding">
                <p id="ref">
                    {{ Auth()->user()->ref_code }}
                </p>

            </div>
            <div class="col-xs-4 noSidePadding">
                <span class="input-icon" id="copy-icon" onclick="salinReferral()">
                    <i class="icon-copy"></i>
                </span>
            </div>
        </div>
        {{-- <div class="row d-none">
            <div class="col-xs-4 noSidePadding">
                <p class="_label" i18n="">Pin kedua :</p>
            </div>
            <div class="col-xs-8 noSidePadding">
                <p>
                    <span class="switch_lable">OFF</span>
                    <label class="switch">
                        <input type="checkbox" id="isOnSecondPin" name="is_on_second_pin" value="1">
                        <span class="slider round"></span>
                    </label>
                    <span class="switch_lable">ON</span>
                    <a href="#" class="btn btn-secondary" id="btn-reset2ndpin" style="display:none;">Reset
                        sini</a>
                </p>
            </div>
        </div> --}}
    </div>
</div>
<script>
    // Simpan link referral dalam variabel JavaScript
    var linkReferral = "{{ Auth()->User()->ref_link }}";

    function salinReferral() {
        /* Membuat elemen sementara untuk menyalin teks ke clipboard */
        var tempElem = document.createElement("textarea");
        tempElem.value = linkReferral;
        document.body.appendChild(tempElem);

        /* Memilih teks dalam elemen sementara */
        tempElem.select();
        tempElem.setSelectionRange(0, 99999); /* Untuk mendukung perangkat mobile */

        /* Menyalin teks ke clipboard */
        document.execCommand("copy");

        /* Menghapus elemen sementara */
        document.body.removeChild(tempElem);

        /* Menampilkan pesan sukses atau menggunakan notifikasi lainnya */
        alert('Link referral berhasil disalin: ' + linkReferral);
    }
</script>
