
<!-- Tambah User  -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modalUserBaru" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('create.member') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('POST')
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_member"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input id="id" type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="judul">Username</label>
                        <input id="nama" type="text" class="form-control" name="nama" value="" required pattern="^\S+$" title="Username tidak boleh mengandung spasi.">
                    </div>
                    <div class="form-group">
                        <label for="judul">Password</label>
                        <input id="password" type="text" class="form-control" name="password" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Email</label>
                        <input id="email" type="email" class="form-control" name="email" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Whatsapp</label>
                        <input id="telp" type="number" class="form-control" name="telp" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Reff Code</label>
                        <input id="ref_code" type="text" class="form-control" name="ref_code" value="">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Nama Rek</label>
                        <input id="nama_rek" type="text" class="form-control" name="nama_rek" value=""
                            id="keterangan" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Bank</label>
                        <select id="bank" name="bank" class="form-control" required>
                            @foreach ($data_bank as $item)
                            <option value="{{ $item->nama_bank }}" readonly>{{ $item->nama_bank }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">No Rek</label>
                        <input id="no_rek" type="number" class="form-control" name="no_rek" value=""
                            id="keterangan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>