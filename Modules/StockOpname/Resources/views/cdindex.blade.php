@extends('layouts.app')
@section('title', 'Stock Opname')

@section('nav')
<div class="row align-items-center">
    <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
            Stock Opname
        </div>
        <h2 class="page-title">
            Stock Opname Crimping Dies
        </h2>
    </div>
    <!-- Page title actions -->
    <div class="col-auto ms-auto d-print-none">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                <li class="breadcrumb-item"><a href="{{ url('') }}"><i data-feather="home"
                            class="breadcrumb-item-icon"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Stock Opname</a></li>
                <li class="breadcrumb-item active" aria-current="page">Stock Opname</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Stock Opname Crimping Dies</h3>
                        {{ date('Y-m-d') }}
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
            <div colspan="4" align="center">ㅤ</div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <a href="/stockopname" class="btn btn-success btnAdd text-white mb-3">
                        <i data-feather="arrow-left" width="16" height="16" class="me-2"></i> Kembali
                    </a>
                    <div colspan="4" align="center">ㅤ</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label class="form-label">Part No<span class="text-danger">*</span></label>
                    <input type="text" class="form-control part_no" name="part_no"
                        id="part_no" autofocus>
                    <div colspan="4" align="center">ㅤ</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <div class="form-group">
                        <label class="form-label">Lokasi <span class="text-danger">*</span> </label>
                        <select class="form-control" name="filter-select" id="filter-select">
                            <option value="">- Semua Lokasi -</option>
                            @if (sizeof($racks) > 0)
                            @foreach ($racks as $rack)
                            <option value="{{ $rack->rack_name }}">{{ $rack->rack_name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="table-cd" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Stocks</h3>
                    </div>
                </div>
                <div class="col-md-12 text-end"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-data" class="table-data table card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="5%">Part Name</th>
                                <th width="5%">Part Number</th>
                                <th width="5%">Stock</th>
                                <th width="10%">Lokasi</th>
                                <th width="5%">Last STO</th>
                                <!-- <th width="5%">QR Code</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($crimpingdies) == 0)
                            <tr>
                                <td colspan="4" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($crimpingdies as $part)
                            <tr style="margin-bottom: 50px;">
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="5%">{{ $part->part_name }}</td>
                                <td width="5%">{{ $part->part_no }}</td>
                                <td width="5%">{{ $part->qty_end }}</td>
                                <td width="10%">{{ $part->loc_ppti }}</td>
                                <td width="5%">{{ $part->last_sto }}</td>
                                {{-- <td width="5%">{{ QrCode::size(75)->generate($part->part_id) }}</td> --}}
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade partModal" id="partModal" tabindex="-1" role="dialog" aria-labelledby="partModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('stockopname/update/cd') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="form-label">Part Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="part_name_hidden" name="part_name_hidden" disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Part No<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="part_no_hidden" name="part_no_hidden" disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">QTY<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="qty_no_hidden" name="qty_no_hidden" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Qty Adjust<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="adjust_hidden" name="adjust_hidden" value="" disabled>
                        </div>
                        <div class="form-group" hidden>
                            <label class="form-label">Status<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="has_sto" name="has_sto" value="yes">
                        </div>
                        <div class="form-group" hidden>
                            <label class="form-label">Status<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="last_sto" name="last_sto" value="{{ date('Y-m-d') }}">
                        </div>
                        <!-- <div class="form-group">
                            <label class="form-label">QTY Actual<span class="text-danger"></span></label>
                            <input type="number" class="form-control" id="adjusting" name="adjusting" value="">
                        </div>
                        <div class="form-group" hidden>
                            <label class="form-label">Part No<span class="text-danger"></span></label>
                            <input type="text" class="form-control" id="part_nos" name="part_nos" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Part No<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="part_no_hidden" name="part_no_hidden" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label">QTY<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="qty_no_hidden" name="qty_no_hidden" value="" disabled>
                    </div> -->
                        <!-- <div class="form-group">
                            <label class="form-label">QTY End<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="qty_end" name="qty_end" value="" disabled>
                        </div> -->
                        <div class="form-group" hidden>
                            <label class="form-label">Status<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="has_sto" name="has_sto" value="yes">
                        </div>
                        <div class="form-group" hidden>
                            <label class="form-label">Status<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="last_sto" name="last_sto" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Actual<span class="text-danger"></span></label>
                            <input type="number" class="form-control" id="adjusting" name="adjust" value="" required>
                        </div>
                        <div class="form-group" hidden>
                            <label class="form-label">Part No<span class="text-danger"></span></label>
                            <input type="text" class="form-control" id="part_nos" name="part_nos" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="text-white btn btn-success submitButton">STO</button>
                        <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    // Function to show/hide tables based on dropdown selection
    function showTable(selectedValue) {
        // Hide all tables
        $('#table-cd').show();
        $('#table-af').hide();
        $('#table-spm').hide();
        $('#table-cf').hide();

        // Show the selected table based on the dropdown value
        if (selectedValue === '1') {
            $('#table-cd').show();
        } else if (selectedValue === '4') {
            $('#table-spm').show();
        } else if (selectedValue === '5') {
            $('#table-af').show();
        } else if (selectedValue === '6') {
            $('#table-cf').show();
        }
    }

    // Attach an event handler to the dropdown change event
    $('#part_category').on('change', function() {
        var selectedValue = $(this).val();
        showTable(selectedValue);
    });

    // Call showTable initially to set the initial table visibility
    showTable($('#part_category').val());
</script>

<script>
    document.getElementById("filter-select").addEventListener("change", function() {
        const selectedValue = this.value;
        const tables = document.querySelectorAll(
            ".table-data"); // Select all tables with the class "table-data"

        tables.forEach(function(table) {
            const rows = table.querySelectorAll("tbody tr");
            rows.forEach(function(row) {
                const lokasi = row.querySelector("td:nth-child(5)").textContent;
                if (selectedValue === "" || lokasi === selectedValue) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
</script>

{{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const partNoInput = document.getElementById("part_no");

            // Add an event listener to the input field
            partNoInput.addEventListener("input", function() {
                const inputValue = partNoInput.value;
                // Set the data-id attribute based on the input value
                partNoInput.setAttribute("data-id", inputValue);
            });
        });
    </script> --}}

<script>
    $(document).ready(function() {
        $('.part_no').on('keyup', function(event) {
            if (event.key === "Enter") {
                var partNo = $(this).val();
                var url = "{{ url('stockopname/getdatabyparam') }}/" + partNo;
                var url2 = "{{ url('stockopname/getdatabypartno') }}/" + partNo;

                console.log('Fetching data for partNo:', partNo);

                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'JSON',
                    success: function(data) {
                        console.log('Response from first AJAX call:', data);
                        if (data.status === 1) {
                            console.log('Result:', data.result); // Log the result object
                            if (data.result) {
                                $('#part_name_hidden').val(data.result[0].part_name);
                                $('#adjust_hidden').val(data.result[0].adjust);
                                $('#part_no_hidden').val(data.result[0].part_no);
                                $('#has_sto').val('yes');
                                $('#part_nos').val(data.result[0].part_no);

                                var lastStoInput = document.getElementById("last_sto");
                                var currentDateTime = new Date();
                                var formattedDate = currentDateTime.toISOString().split('T')[0];
                                lastStoInput.value = formattedDate;

                                $('.partModal form').attr('action', "{{ url('stockopname/update/cd') }}/" + data.result[0].part_id);
                                $('.partModal .modal-title').text('Approve');
                                $('.partModal').modal('show');

                                if (data.result[0].has_sto === 'yes') {
                                    alert('Part ini telah di STO.');
                                }
                            } else {
                                console.error('Result is undefined');
                            }
                        } else {
                            console.log('Data status is not 1');
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.error('Error during first AJAX call:', textStatus, errorThrown);
                        alert('Error: Gagal mengambil data');
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: url2,
                    dataType: 'JSON',
                    success: function(data) {
                        console.log('Response from second AJAX call:', data);
                        if (data.status === 1) {
                            $('#qty_no_hidden').val(data.total);
                            // $('#qty_end').val(data.total);
                        } else {
                            console.log('Data status is not 1');
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.error('Error during second AJAX call:', textStatus, errorThrown);
                        alert('Error: Gagal mengambil data');
                    }
                });
            }
        });
    });
</script>
@endsection