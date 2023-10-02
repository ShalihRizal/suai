

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
<!-- Container fluid  -->
<!-- ============================================================== -->
<!-- <div class="container-fluid"> -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                @if (session('message'))

                <strong id="msgId" hidden>{{ session('message') }}</strong>

                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">STO</h3>
                        {{ date('Y-m-d') }}
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label class="form-label">Part No<span class="text-danger">*</span></label>
                        <input type="text" class="form-control part_no" name="part_no" id="part_no" autofocus>
                        <div class="card">
                            <div class="card-body">
                                <div class="container-md"> <!-- Wrap in a container that takes half the screen width -->
                                    <div id="piechart" style="width: 700px; height: 500px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="javascript:void(0)" class="btn btn-warning btnReset text-white mb-3">
                        <i data-feather="x-square" width="16" height="16" class="me-2"></i>
                        Reset
                    </a>
                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Part Name</th>
                                <th width="15%">Part Number</th>
                                <th width="20%">Stock</th>
                                <th width="20%">QR Code</th>
                                <th width="15%">Last STO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($parts) == 0)
                            <tr>
                                <td colspan="4" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($parts as $part)
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="20%">{{ $part->part_name }}</td>
                                <td width="15%">{{ $part->part_no }}</td>
                                <td width="20%">{{ $part->qty_end }}</td>
                                <td width="20%">{{ QrCode::size(75)->generate($part->part_no);}}</td>
                                <td width="15%">{{ $part->last_sto }}</td>
                                {{-- <td width="15%">{{ substr($part->updated_at, 0,10) }}</td> --}}
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

<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->
<!-- </div> -->
<!-- ============================================================== -->
<!-- End Container fluid  -->

<!-- Reset Modal -->
<div class="modal fade addReset" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Apakah anda yakin?</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('notification/store') }}" method="POST" id="addForm">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="text-white btn btn-success">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Reset Modal -->
@endsection

@section('script')

<script>
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
</script>

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

$.ajax({
    $('.addReset .modal-title').text('Reset');
    $('.addReset').modal('show');
});

});


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var chartData = [['Label', 'Quantity']];

            @foreach ($labels as $partCategoryId => $label)
                chartData.push(['{{ $label }}', {{ $qty[$partCategoryId] }}]);
            @endforeach

            var data = google.visualization.arrayToDataTable(chartData);

            var options = {
                title: ''
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</script>
@endsection
