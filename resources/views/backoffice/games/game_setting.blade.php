@extends('backoffice.layouts.main')

@section('content')
    <style>
        .modal-body {
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>

    <div class="card mt-3">
        <div class="card-header">
            Games List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Provider</th>
                            <th class="text-center">Game Code</th>
                            <th class="text-center">Bet</th>
                            <th class="text-center">Balance</th>
                            <th class="text-center">Total Debit</th>
                            <th class="text-center">Total Kredit</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($x as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['user_code'] }}</td>
                                <td>{{ $data['provider_code'] }}</td>
                                <td>{{ $data['game_code'] }}</td>
                                <td>{{ $data['bet'] }}</td>
                                <td>{{ $data['balance'] }}</td>
                                <td>{{ $data['total_debit'] }}</td>
                                <td>{{ $data['total_credit'] }}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm open-modal"
                                        data-toggle="modal"
                                        data-id="{{ $data['id'] }}"
                                        data-provider="{{ $data['provider_code'] }}"
                                        data-game="{{ $data['game_code'] }}"
                                        data-user="{{ $data['user_code'] }}">
                                        Set
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Global -->
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newModalLabel">Set Perkalian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="newModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary apply-data">Apply</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            // ❌ Jangan reinit DataTables di sini
            // Layout utama sudah menginisialisasi #example2

            // ✅ Klik tombol "Set"
            $('.open-modal').on('click', function () {
                const provider = $(this).data('provider');
                const gamecode = $(this).data('game');
                const username = $(this).data('user');

                $.ajax({
                    url: '/call-list',
                    method: 'POST',
                    data: {
                        provider: provider,
                        game_code: gamecode,
                        username: username,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('#newModalBody').empty();

                        let html = `
                            <form id="formModal">
                                <div class="form-group">
                                    <label>User Code</label>
                                    <input type="text" class="form-control" id="userCode" value="${username}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Provider Code</label>
                                    <input type="text" class="form-control" id="providerCode" value="${provider}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Game Code</label>
                                    <input type="text" class="form-control" id="gameCode" value="${gamecode}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Select RTP</label>
                                    <select class="form-control" id="rtpSelect">
                        `;

                        if (response.calls && response.calls.length > 0) {
                            response.calls.forEach(function (call) {
                                html += `<option value="${call.rtp}">RTP: ${call.rtp}</option>`;
                            });
                        } else {
                            html += `<option value="">No RTP data</option>`;
                        }

                        html += `
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select Call Type</label>
                                    <select class="form-control" id="callTypeSelect">
                                        <option value="1">Common Free</option>
                                        <option value="2">Buy Bonus Free</option>
                                    </select>
                                </div>
                            </form>
                        `;

                        $('#newModalBody').html(html);
                        $('#newModal').modal('show');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Data belum bisa dimuat. Silakan coba lagi.');
                    }
                });
            });

            // ✅ Klik Apply
            $('.apply-data').on('click', function () {
                const provider = $('#providerCode').val();
                const gamecode = $('#gameCode').val();
                const username = $('#userCode').val();
                const rtp = $('#rtpSelect').val();
                const type = $('#callTypeSelect').val();

                if (!rtp) {
                    alert('Pilih nilai RTP terlebih dahulu.');
                    return;
                }

                $.ajax({
                    url: '/call-apply',
                    method: 'POST',
                    data: {
                        provider: provider,
                        game_code: gamecode,
                        username: username,
                        call_rtp: rtp,
                        call_type: type,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function () {
                        alert('RTP berhasil diterapkan.');
                        $('#newModal').modal('hide');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('RTP belum bisa diterapkan. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
@endsection
