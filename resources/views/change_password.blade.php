<div class="row chg-pass">
    <div class="col-xs-12 offset-lg-3 col-lg-6">
        <form id="chgPwdForm" class="needs-validation" action="{{ URL::to('ajaxchgPass') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group row no-gutters">
                <label for="CurrentPwd" class="col-md-12 col-form-label text-left" i18n="">Kata sandi saat
                    ini<span class="text-danger">&nbsp;*&nbsp;</span></label>
                <div class="col-md-12">
                    <input class="form-control" id="currentPwd" name="currentPwd" type="Password">
                </div>
            </div>
            <div class="form-group row no-gutters">
                <label for="newPwd" class="col-xs-12 col-md-12 col-form-label  text-left" i18n="">Kata Sandi
                    Baru<span class="text-danger">&nbsp;*&nbsp;</span></label>
                <div class="col-xs-12 col-md-12">
                    <input class="form-control" id="newPwd" name="newPwd" type="password" required="">
                    <small class="text-left">* Minimal 8 karakter, dapat berisi alfabet dan angka </small>
                    <i class="icon-eye toggle-password" input_id="#newPwd"></i>
                </div>
            </div>
            <div class="form-group row no-gutters">
                <label for="ConfirmPwd" class="col-xs-12  col-md-12 col-form-label  text-left">Konfirmasi Sandi<span
                        class="text-danger">&nbsp;*&nbsp;</span></label>
                <div class="col-xs-12  col-md-12">
                    <input class="form-control" id="confirmPwd" name="confirmPwd" type="password" required="">
                    <i class="icon-eye toggle-password" input_id="#confirmPwd"></i>
                </div>
            </div>
            <div class="alert alert-success message--chg-pass" style="display:none;">
                Berhasil mengubah kata sandi </div>
            <div class="form-group row no-gutters mt-12">
                <div class="col-xs-12  col-6"></div>
                <div class="col-xs-12 col-6 text-center">
                    <button type="submit" class="btn btn-primary" i18n="">Kirimkan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        bindChgPassFormJS(pwd_regex = /^[A-Za-z\d!@#$%^&*()_+]{8,20}$/);
    });
</script>
