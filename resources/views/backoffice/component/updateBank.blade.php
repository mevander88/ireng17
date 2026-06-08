<div class="modal fade" id="ubah{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/deposit_bank/{{ $item->id }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Bank</label>
                        <input type="text" class="form-control" name="nama_bank"
                            value="{{ $item->nama_bank }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama</label>
                        <input type="text" class="form-control" name="nama_penerima"
                            value="{{ $item->nama_penerima }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nomor</label>
                        <input type="text" class="form-control" name="no_rek"
                            value="{{ $item->no_rek }}">
                    </div>
                    <div>
                        <label for="type">Bank / E-Wallet</label>
                        <select class="form-control" name="type" id="" required>
                            <option value="{{ $item->type }}">{{ $item->nama_bank }}</option>
                            <option value="1">Bank</option>
                            <option value="2">E-Wallet</option>
                        </select>
                    </div>

                    <!-- 🆕 Tambahan baru: Upload Logo Bank -->
                    <div class="form-group mt-3">
                        <label for="exampleFormControlInput1">Logo Bank</label>
                        <input name="logo" type="file" class="form-control"
                            accept="image/png, image/jpg, image/jpeg">
                        @if($item->logo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo Bank" width="80" class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                    <!-- Akhir tambahan baru -->

                    <div class="form-group">
                        <label for="exampleFormControlInput1">QR</label>
                        <input name="image_qr" type="file" class="form-control"
                            accept="image/png, image/jpg, image/jpeg">
                        @if($item->image_qr)
                            <div class="mt-2">
                                <img alt="" src="{{ asset('storage/' . $item->image_qr) }}" alt="QR Code" width="80" class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
