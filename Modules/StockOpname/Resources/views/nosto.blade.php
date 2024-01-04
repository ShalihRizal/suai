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
                            <h3 class="h3">Stock Opname</h3>
                            {{ date('Y-m-d') }}
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <div colspan="4" align="center">ㅤ</div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header w-100">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="h3">Stocks - Belum STO</h3>
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
                                                <tr style="margin-bottom: 50px;">
                                                    <td width="5%">{{ $loop->iteration }}</td>
                                                    <td width="20%">{{ $part->part_name }}</td>
                                                    <td width="15%">{{ $part->part_no }}</td>
                                                    <td width="20%">{{ $part->qty_end }}</td>
                                                    <td width="20%">{{ QrCode::size(150)->generate($part->part_id) }}
                                                    </td>
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
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- </div> -->
    <!-- ============================================================== -->
    <!-- End Container fluid  -->

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
                            <!-- Add a hidden input field to store the value -->
                            <input type="hidden" class="form-control" id="part_no_hidden" name="part_no_hidden">
                            <!-- Display the Part No in a read-only input field -->
                            <input type="text" class="form-control" id="part_no" name="part_no" disabled>
                            <div colspan="4" align="center">ㅤ</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="text-white btn btn-success" onclick="reloadPage()">STO</button>
                </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
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
        $('.btnReset').click(function() {
            // Trigger the modal when the button is clicked
            $('.addReset').modal('show');
        });

        $(document).ready(function() {
            $('#part_no').on('keyup', function(event) {
                if (event.key === "Enter") {
                    // Get the input value
                    var inputValue = $(this).val();

                    // Set the hidden input field's value
                    $('#part_no_hidden').val(inputValue);

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

@endsection
