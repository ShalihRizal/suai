

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
            <div class="card-header">
                @if (session('message'))
                    <strong id="msgId" hidden>{{ session('message') }}</strong>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Stock Opname</h3>
                        {{ date('Y-m-d') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="card-body">
                        <div class="addData">
                            <a href="/stockopname/scan" class="btn btn-success btnAdd text-white mb-3">
                                <i data-feather="plus" width="16" height="16" class="me-2"></i> STO
                            </a>
                        </div>
                        <div class="addData">
                            <a href="/monthlyreport" class="btn btn-success btnAdd text-white mb-3">
                                <i data-feather="plus" width="16" height="16" class="me-2"></i> Monthly Report
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-body">
                        <div class="addData">
                            <a href="/stockopname/hassto" class="btn btn-success btnAdd text-white mb-3">
                                <i data-feather="plus" width="16" height="16" class="me-2"></i> Sudah STO
                            </a>
                        </div>
                        <div class="addData">
                            <a href="/stockopname/nosto" class="btn btn-success btnAdd text-white mb-3">
                                <i data-feather="plus" width="16" height="16" class="me-2"></i> Belum STO
                            </a>
                        </div>
                        <div class="addData">
                            <a href="/stockopname/updateall" class="btn btn-success btnReset text-white mb-3">
                                <i data-feather="x" width="16" height="16" class="me-2"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <canvas id="pieChart" width="100%" height="100%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal and other code remains unchanged -->
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

    $.ajax({
        $('.addReset .modal-title').text('Reset');
        $('.addReset').modal('show');
    });

});

<script function reloadPage() {
    location.reload();
}
</script>

<script>
    $(document).ready(function () {
        // Click event handler for the "Reset" button
        $('.btnReset').click(function () {
            // Show the confirmation modal
            $('#resetConfirmationModal').modal('show');
        });

        // Click event handler for the "Reset" confirmation button
        $('#confirmReset').click(function () {
            // Close the confirmation modal
            $('#resetConfirmationModal').modal('hide');

            // Perform the reset action here (you can add your logic)

            // After performing the reset action, you can reload the page
            reloadPage();
        });

        function reloadPage() {
            location.reload();
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/chart.min.js') }}"></script>
<script>
    var ctx = document.getElementById('pieChart').getContext('2d');
    
var sudahSTOCount = {{ $yesCount }};
var belumSTOCount = {{ $noCount }};
var totalData = sudahSTOCount + belumSTOCount;

// Hitung persentase Sudah STO dan Belum STO
var persentaseSudahSTO = ((sudahSTOCount / totalData) * 100).toFixed(2);
var persentaseBelumSTO = ((belumSTOCount / totalData) * 100).toFixed(2);

var data = {
    labels: [
        'Sudah STO-' + sudahSTOCount + '  (' + persentaseSudahSTO + '%)',
        'Belum STO-' + belumSTOCount + '  (' + persentaseBelumSTO + '%)'
    ],
    datasets: [{
        data: [sudahSTOCount, belumSTOCount],
        backgroundColor: ['#36A2EB', '#FF6384'],
    }]
};

var options = {
    tooltips: {
        mode: 'index',
        intersect: true,
    },
    legend: {
        display: true,
        position: 'bottom',
    }
};

var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: options
});


</script>



@endsection
