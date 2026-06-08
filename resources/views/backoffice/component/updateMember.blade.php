@foreach ($data_member as $item)
    
    <div class="modal fade" id="update-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdate{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('update.member', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUpdate{{ $item->id }}">Update Member: {{ $item->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Username</label>
                                <input id="nama" type="text" class="form-control" name="nama" value="{{ $item->name }}" required pattern="^\S+$" title="Username tidak boleh mengandung spasi.">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="text" class="form-control" name="password" value="">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ $item->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="telp">Whatsapp</label>
                                <input id="telp" type="number" class="form-control" name="telp" value="{{ $item->telp }}" required>
                            </div>
                            <div class="form-group">
                                <label for="ref_code">Reff Code</label>
                                <input id="ref_code" type="text" class="form-control" name="ref_code" value="{{ $item->ref_code }}">
                            </div>
                            <div class="form-group">
                                <label for="nama_rek">Nama Rek</label>
                                <input id="nama_rek" type="text" class="form-control" name="nama_rek" value="{{ $item->nama_rek }}" required>
                            </div>
                            <div class="form-group">
                                <label for="bank">Bank</label>
                                <select id="bank" name="bank" class="form-control" required>
                                    @foreach ($data_bank as $bank)
                                    <option value="{{ $bank->nama_bank }}" {{ $item->bank == $bank->nama_bank ? 'selected' : '' }}>
                                        {{ $bank->nama_bank }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="no_rek">No Rek</label>
                                <input id="no_rek" type="number" class="form-control" name="no_rek" value="{{ $item->no_rek }}" required>
                            </div>
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
@endforeach
