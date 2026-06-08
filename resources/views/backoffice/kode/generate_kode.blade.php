<?php

use Illuminate\Support\Facades\Auth;

$user_level = Auth::user()->level;
$is_developer = (int) $user_level === 2;
$is_admin = (int) $user_level <= 2;

?>
@extends('backoffice.layouts.main')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <button id="generate-voucher-btn" type="button" class="btn btn-primary">Generate Voucher</button>
            <p class="mt-2 mb-0 text-muted" id="voucher-code-display"></p>
        </div>

        <div class="card-header">

        </div>

        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th scope="col">Tanggal</th>
                        <th>Code</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($Voucher as $item)
                        <tr>
                            <td>{{ $Voucher->firstItem() + $loop->index }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->code }}</td>
                            @if ($item->is_valid == true)
                                <td>Belum Terpakai</td>
                            @else
                                <td>Sudah Terpakai</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Voucher belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="admin-pagination">
                {{ $Voucher->links() }}
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#generate-voucher-btn').click(function() {
                $.ajax({
                    url: '/generate-voucher',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#voucher-code-display').text('Kode voucher dibuat: ' + data.voucher_code);
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 700);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' ' + error);
                    }
                });
            });
        });
    </script>
@endsection
