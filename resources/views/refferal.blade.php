@extends('layouts.main')
@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <style>
        /* Mengubah warna teks pada label input search menjadi putih */
        .dataTables_length label {
            display: none;

        }

        .dataTables_wrapper {
            display: inline-block;
            width: 100%;
        }

        .dataTables_filter {
            display: flex;
            width: 100%;
        }

        .dataTables_filter label {
            color: var(--boray-text);
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 66%;
        }

        .paginate_button {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 4px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            color: #261a00;
            background: linear-gradient(180deg, var(--boray-gold), var(--boray-gold-2));
            border: 1px solid rgba(255, 223, 159, 0.7);
            border-radius: 999px;
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s, color 0.3s;
        }

        /* Hover state */
        .paginate_button:hover {
            background: linear-gradient(180deg, var(--boray-gold), var(--boray-gold-2));
            border-color: rgba(255, 223, 159, 0.7);
        }

        /* Disabled state */
        .paginate_button.disabled {
            cursor: not-allowed;
            opacity: 0.5;
            background: rgba(255, 255, 255, 0.055);
            border-color: var(--boray-line);
        }

        /* Disabled state for anchor elements */
        .paginate_button.disabled:hover {
            background: rgba(255, 255, 255, 0.055);
            border-color: var(--boray-line);
        }

        /* Active state */
        .paginate_button.active {
            background: linear-gradient(180deg, var(--boray-gold), var(--boray-gold-2));
            border-color: rgba(255, 223, 159, 0.7);
        }
    </style>
    <div class="container">
        <h2 class="title" style="margin-bottom:2.6rem; margin-top: 2.6rem;text-align: center;">Referral Downline</h2>
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
        <div class="box-wrapper plr-15">
            <div class="row d-flex align-items-center">
                <div class="col-md-3 col-xs-4 ">
                    <div class="">Tanggal </div>
                </div>
                <div class="col-md-9 col-xs-8 d-flex flex-wrap">
                    <input type="text" id="reffHistory" class="form-control text-center" name="daterange">
                </div>
            </div>
        </div>

        <div class="mt-2">
            <div class="dataTables_wrapper no-footer">
                <table
                    class="table table-bordered table-hover toggle-circle dataTable no-footer table-striped table-responsive"
                    role="grid" aria-describedby="referral-table_info" id="reffHistoryTable">
                    <thead>
                        <tr role="row">
                            <th class="text-center">No</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Join Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            var dataTable = $("#reffHistoryTable").DataTable({
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100],
                ],
                pageLength: 10,
            });

            $("#showEntries").on("change", function() {
                var selectedValue = $(this).val();
                dataTable.page.len(selectedValue).draw();
            });

            // Inisialisasi daterangepicker
            $("#reffHistory").daterangepicker({
                opens: "left",
                locale: {
                    format: "MM/DD/YYYY",
                    separator: " - ",
                    applyLabel: "Apply",
                    cancelLabel: "Cancel",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Custom",
                    daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                    monthNames: [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ],
                    firstDay: 1,
                },
                ranges: {
                    "Hari ini": [moment(), moment()],
                    Kemarin: [moment().subtract(2, "days"), moment()],
                    "7 Hari Terakhir": [moment().subtract(6, "days"), moment()],
                    "30 Hari Terakhir": [moment().subtract(29, "days"), moment()],
                },
            }, function(start, end, label) {
                // Fungsi callback untuk daterangepicker
                const payloads = {
                    _token: "{{ csrf_token() }}",
                    startDate: start.format("YYYY-MM-DD") + " 00:00:00",
                    endDate: end.format("YYYY-MM-DD") + " 23:59:59",
                };
                $.ajax({
                    type: "GET",
                    url: "/search-history",
                    data: payloads,
                    success: function(response) {
                        // Memperbarui tabel saat mendapatkan respons
                        updateTable(response.data);
                    },
                });
            });

            // Memuat data pada saat halaman pertama dimuat
            $.ajax({
                url: "/search-history-today",
                type: "GET",
                success: function(response) {
                    if (response.length > 0) {
                        updateTable(response);
                    } else {
                        $("#reffHistoryTable tbody").empty();
                    }
                },
                error: function(error) {
                    console.error(error);
                },
            });

            // Fungsi untuk memperbarui tabel dengan data baru
            function updateTable(data) {
                $("#reffHistoryTable tbody").empty();
                for (var i = 0; i < data.length; i++) {
                    var history = data[i];
                    var formattedDate = moment(history.created_at).format(
                        "DD MMM YYYY, HH:mm:ss"
                    );
                    var nomerUrut = i + 1;
                    var newRow =
                        "<tr>" +
                        "<td>" +
                        nomerUrut +
                        "</td>" +
                        "<td>" +
                        history.username +
                        "</td>" +
                        "<td>" +
                        formattedDate +
                        "</td>" +
                        "</tr>";
                    $("#reffHistoryTable tbody").append(newRow);
                }
            }
        });
    </script>
@endsection
