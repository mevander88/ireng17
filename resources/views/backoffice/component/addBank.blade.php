<div class="modal fade" id="tambahBankModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/deposit_bank" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Bank Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bank">Bank</label>
                        <select class="form-control" name="nama_bank" id="" required>
                            <option value="">Pilih Bank</option>
                            <option value="DANA">DANA</option>
                            <option value="OVO">OVO</option>
                            <option value="GoPay">GoPay</option>
                            <option value="LinkAja">LinkAja</option>
                            <option value="Shopee Pay">Shopee Pay</option>
                            <option value="Bank Mandiri">Bank Mandiri</option>
                            <option value="Bank BNI">Bank BNI</option>
                            <option value="Bank BCA">Bank BCA</option>
                            <option value="Bank BCA Digital">Bank BCA Digital</option>
                            <option value="Bank BCA Syariah">Bank BCA Syariah</option>
                            <option value="Bank BRI">Bank BRI</option>
                            <option value="Bank CIMB">Bank CIMB</option>
                            <option value="Bank OCBC">Bank OCBC</option>
                            <option value="Bank JAGO">Bank JAGO</option>
                            <option value="Bank Permata">Bank Permata</option>
                            <option value="Bank BRI">Bank BRI</option>
                            <option value="Bank BSI">Bank BSI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama_penerima" required>
                    </div>
                    <div class="form-group">
                        <label for="no">Nomor Rekening</label>
                        <input type="text" class="form-control" name="no_rek" required>
                    </div>
                    <div>
                        <label for="type">Bank / E-Wallet</label>
                        <select class="form-control" name="type" id="" required>
                            <option value="">Bank atau E-Wallet ?</option>
                            <option value="1">Bank</option>
                            <option value="2">E-Wallet</option>
                        </select>
                    </div>

                    <!-- 🆕 Tambahan baru untuk upload logo bank -->
                    <div class="form-group mt-3">
                        <label for="logo">Logo Bank</label>
                        <input type="file" class="form-control" name="logo" accept="image/png, image/jpg, image/jpeg">
                    </div>
                    <!-- Akhir tambahan baru -->

                    <div class="form-group">
                        <label for="qr">QR Code</label>
                        <input type="file" class="form-control" name="image_qr" accept="image/png, image/jpg, image/jpeg">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
