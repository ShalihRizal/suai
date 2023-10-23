

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
            Stock Opname
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
                        <h3 class="h3">Stock Opname</h3>
                        {{ date('Y-m-d') }}
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
            <div colspan="4" align="center">ㅤ</div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label class="form-label">Part No<span class="text-danger">*</span></label>
                    <input type="text" class="form-control part_no" name="part_no" id="part_no" autofocus>
                    <div colspan="4" align="center">ㅤ</div>
                </div>
            </div>
            {{-- <div class="col-md-3 mb-3">
                <div class="form-group">
                    <select class="form-control" name="part_category" id="part_category" style="height: 100%;">
                        <option value="">- Semua Part Category -</option>
                            @if(sizeof($partcategories) > 0)
                                @foreach($partcategories as $partcategory)
                                    <option value="{{ $partcategory->part_category_id }}">{{ $partcategory->part_category_name }}</option>
                                @endforeach
                        @endif
                    </select>
                </div>
            </div> --}}
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <div class="form-group">
                        <label class="form-label">Lokasi <span class="text-danger">*</span> </label>
                        <select class="form-control" name="filter-select" id="filter-select">
                            <option value="">- Semua Lokasi -</option>
                            @if(sizeof($racks) > 0)
                            @foreach($racks as $rack)
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
                        <h3 class="h3">Stocks - Crimping Dies</h3>
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
                                <th width="20%">Part Name</th>
                                <th width="15%">Part Number</th>
                                <th width="20%">Stock</th>
                                <th width="10%">Lokasi</th>
                                <th width="15%">Last STO</th>
                                <th width="20%">QR Code</th>
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
                                <td width="20%">{{ $part->part_name }}</td>
                                <td width="15%">{{ $part->part_no }}</td>
                                <td width="20%">{{ $part->qty_end }}</td>
                                <td width="10%">{{ $part->loc_tapc }}</td>
                                <td width="15%">{{ $part->last_sto }}</td>
                                <td width="20%">{{ QrCode::size(150)->generate($part->part_no)}}</td>
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


{{--
<div class="row" id="table-spm" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Stocks - Sparepart Machine</h3>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="col-md-12 text-end"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-data" class="table card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Part Name</th>
                                <th width="15%">Part Number</th>
                                <th width="20%">Stock</th>
                                <th width="10%">Lokasi</th>
                                <th width="15%">Last STO</th>
                                <th width="20%">QR Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($sparepartmachine) == 0)
                            <tr>
                                <td colspan="4" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($sparepartmachine as $part)
                            <tr style="margin-bottom: 50px;">
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="20%">{{ $part->part_name }}</td>
                                <td width="15%">{{ $part->part_no }}</td>
                                <td width="20%">{{ $part->qty_end }}</td>
                                <td width="10%">{{ $part->loc_tapc }}</td>
                                <td width="15%">{{ $part->last_sto }}</td>
                                <td width="20%">{{ QrCode::size(150)->generate($part->part_id)}}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
{{-- <div class="row" id="table-af" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Stocks - Assembly Fixture</h3>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="col-md-12 text-end"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-data" class="table-data table  card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Part Name</th>
                                <th width="15%">Part Number</th>
                                <th width="20%">Stock</th>
                                <th width="10%">Lokasi</th>
                                <th width="15%">Last STO</th>
                                <th width="20%">QR Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($assemblyfixture) == 0)
                            <tr>
                                <td colspan="4" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($assemblyfixture as $part)
                            <tr style="margin-bottom: 50px;">
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="20%">{{ $part->part_name }}</td>
                                <td width="15%">{{ $part->part_no }}</td>
                                <td width="20%">{{ $part->qty_end }}</td>
                                <td width="10%">{{ $part->loc_tapc }}</td>
                                <td width="15%">{{ $part->last_sto }}</td>
                                <td width="20%">{{ QrCode::size(150)->generate($part->part_id)}}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
{{-- <div class="row" id="table-cf" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Stocks - Checker Fixture</h3>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="col-md-12 text-end"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-data" class="table card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Part Name</th>
                                <th width="15%">Part Number</th>
                                <th width="20%">Stock</th>
                                <th width="10%">Lokasi</th>
                                <th width="15%">Last STO</th>
                                <th width="20%">QR Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($checkerfixture) == 0)
                            <tr>
                                <td colspan="4" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($checkerfixture as $part)
                            <tr style="margin-bottom: 50px;">
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="20%">{{ $part->part_name }}</td>
                                <td width="15%">{{ $part->part_no }}</td>
                                <td width="20%">{{ $part->qty_end }}</td>
                                <td width="10%">{{ $part->loc_tapc }}</td>
                                <td width="15%">{{ $part->last_sto }}</td>
                                <td width="20%">{{ QrCode::size(150)->generate($part->part_id)}}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="modal fade addReset" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="form-label">Part No<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="part_no_hidden" name="part_no_hidden" disabled>
                            <div colspan="4" align="center">ㅤ</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">QTY<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="qty_no_hidden" name="qty_no_hidden" disabled>
                            <div colspan="4" align="center">ㅤ</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="text-white btn btn-success" onclick="reloadPage()">STO</button>
                </div>
        </div>
    </div>
</div
@endsection


@section('script')

{{-- <script>
    $(document).ready(function() {
        // Select the input field by its ID
        var inputField = $('#part_no');
        var delayTimer;

        // Add an event listener for the 'keyup' event
        inputField.on('keyup', function() {
            // Clear the previous timer
            clearTimeout(delayTimer);

            // Set a new timer to reload the page after 1000 milliseconds (1 second)
            delayTimer = setTimeout(function() {
                location.reload();
            }, 200);
        });
    });
</script> --}}

{{-- <script>
    $(document).ready(function() {
        // Select the input field by its ID
        var inputField = $('#part_no');
        var delayTimer;
        var url = "{{ url('part/getdata') }}";

        // Add an event listener for the 'keyup' event
        inputField.on('keyup', function() {
            // Clear the previous timer
            clearTimeout(delayTimer);

            // Set a new timer to update the database and reload the page after 200 milliseconds (0.2 seconds)
            delayTimer = setTimeout(function() {
                // Get the input value
                var inputValue = inputField.val();

                // Perform an AJAX request to update the field in the database
                $.ajax({
                    type: 'POST', // or 'GET' depending on your server-side implementation
                    url: "{{ url('part/update') }}" + '/' + inputValue, // replace with the actual URL to your server-side script
                    data: { part_no: inputValue }, // send the input value to the server
                    success: function(response) {
                        // The database update was successful, so reload the page
                        location.reload();
                    },
                    error: function() {
                        console.log('Error updating the database');
                    }
                });
            }, 200);
        });
    });
</script> --}}

<script type="text/javascript">
    $('.btnReset').click(function () {
        // Trigger the modal when the button is clicked
        $('.addReset').modal('show');
    });

    $(document).ready(function() {
        $('#part_no').on('keyup', function(event) {

            let part_no = document.getElementById('part_no');
            let part_no_hidden = document.getElementById('part_no_hidden');

            if (event.key === "Enter") {

                $('#part_no_hidden').val(part_no.value);

                // Show the modal when Enter key is pressed
                $('.addReset').modal('show');



            }
        });
    });

    // Modify the modal's JavaScript code to populate the Part No field
    $('#part_no_hidden').on('input', function() {
        var partNoValue = $(this).val();
        $('#part_no').val(partNoValue);
    });

    // Add this function to reload the page after resetting
    function reloadPage() {
        location.reload();
    }
</script>

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
        }else if (selectedValue === '5') {
            $('#table-af').show();
        }else if (selectedValue === '6') {
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
    const tables = document.querySelectorAll(".table-data"); // Select all tables with the class "table-data"

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


@endsection
