@extends('backoffice.layouts.main')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        History Play
    </div>
    <div class="card-body">
        <form method="GET" class="admin-filter-bar">
            <div class="admin-filter-fields">
                <label for="user_search">Cari User</label>
                <input type="search" class="form-control" id="user_search" name="user_search"
                    value="{{ $userSearch ?? '' }}" placeholder="Username atau extplayer">
            </div>
            <div class="admin-filter-actions">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari User</button>
                @if (!empty($userSearch))
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
        <form id="searchForm" class="admin-filter-bar">
            <div class="admin-filter-fields admin-filter-inline">
                <label for="date_start">Tanggal Mulai</label>
                <input type="date" name="date_start" class="form-control" id="date_start">
            </div>
            <div class="admin-filter-fields admin-filter-inline">
                <label for="date_end">Tanggal Akhir</label>
                <input type="date" name="date_end" class="form-control" id="date_end">
            </div>
            <div class="admin-filter-fields admin-filter-inline">
                <label for="game_type">Game Type</label>
                <select name="game_type" class="form-control" id="game_type">
                    <option value="slot">Slot</option>
                    <option value="live">Live</option>
                    <option value="SB">Sportsbook</option>
                </select>
            </div>
            <div class="admin-filter-fields">
                <label for="extplayer">User</label>
                <select name="extplayer" class="form-control" id="extplayer">
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->extplayer }}">{{ $user->name }} ({{ $user->extplayer }})</option>
                    @endforeach
                </select>
            </div>
            <div class="admin-filter-actions">
                <button type="button" id="btn_search" class="btn btn-success">
                    <i class="fa fa-search"></i> Filter
                </button>
            </div>
        </form>

        <div id="historyMeta" class="text-muted mb-3"></div>
        <div id="results"></div>
    </div>
</div>

{{-- JS DataTables --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    $('#btn_search').on('click', function() {
        const formData = {
            date_start: $('#date_start').val(),
            date_end: $('#date_end').val(),
            extplayer: $('#extplayer').val(),
            game_type: $('#game_type').val(),
            _token: '{{ csrf_token() }}'
        };

        if (!formData.extplayer) {
            alert('Pilih user terlebih dahulu.');
            return;
        }

        $.ajax({
            url: '{{ route("fetch.game.history") }}',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#historyMeta').empty();
                $('#results').html('<p class="text-muted">Loading...</p>');
            },
            success: function(response) {
                const resultsDiv = $('#results');
                resultsDiv.empty();
                renderMeta(response.meta);

                if (response.status === 'success' && response.data.length > 0 && response.columns.length > 0) {
                    let table = '<div class="table-responsive"><table class="table table-bordered table-hover" id="example2"><thead><tr><th>No</th>';

                    $.each(response.columns, function(_, column) {
                        table += `<th>${escapeHtml(column.label)}</th>`;
                    });

                    table += '</tr></thead><tbody>';

                    $.each(response.data, function(index, entry) {
                        table += `<tr><td>${index + 1}</td>`;
                        $.each(response.columns, function(_, column) {
                            table += `<td>${formatValue(column.key, entry[column.key])}</td>`;
                        });
                        table += '</tr>';
                    });

                    table += '</tbody></table></div>';
                    resultsDiv.html(table);

                    if ($.fn.DataTable.isDataTable('#example2')) {
                        $('#example2').DataTable().destroy();
                    }

                    $('#example2').DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        info: true,
                        responsive: true,
                        autoWidth: false,
                        order: [[0, 'desc']]
                    });
                } else {
                    resultsDiv.html(`<p class="text-muted">${escapeHtml(response.message || 'Data riwayat tidak ditemukan untuk filter ini.')}</p>`);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Gagal mengambil data dari API.';
                renderMeta(xhr.responseJSON?.meta);
                $('#results').html(`<p class="text-danger">${escapeHtml(message)}</p>`);
            }
        });
    });

    function renderMeta(meta) {
        if (!meta) {
            $('#historyMeta').empty();
            return;
        }

        const rawKeys = Array.isArray(meta.raw_keys) ? meta.raw_keys.join(', ') : '-';
        $('#historyMeta').html(`
            <span class="badge badge-secondary">Source: ${escapeHtml(meta.source_key || '-')}</span>
            <span class="badge badge-secondary">Total API: ${escapeHtml(meta.total_count ?? 0)}</span>
            <span class="badge badge-secondary">Page: ${escapeHtml(meta.page ?? '-')}</span>
            <span class="badge badge-secondary">Keys: ${escapeHtml(rawKeys)}</span>
        `);
    }

    function formatValue(key, value) {
        if (value === null || value === undefined || value === '') {
            return '-';
        }

        const normalizedKey = String(key).toLowerCase();
        const numeric = Number(value);
        if (!Number.isNaN(numeric) && /(money|amount|balance|bet|win)/.test(normalizedKey)) {
            return new Intl.NumberFormat('id-ID').format(numeric);
        }

        return escapeHtml(value);
    }

    function escapeHtml(value) {
        return String(value ?? '-')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});
</script>
@endsection
