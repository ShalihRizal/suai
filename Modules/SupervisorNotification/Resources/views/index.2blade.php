@extends('layouts.app')
@section('title', 'Notifikasi')

@section('nav')
    <div class="row align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
                Notifikasi
            </div>
            <h2 class="page-title">
                Notifikasi
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('') }}"><i data-feather="home"
                                class="breadcrumb-item-icon"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Notifikasi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notifikasi</li>
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
                            <h3 class="h3">Notifikasi</h3>
                            {{ date('Y-m-d') }}
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-data" class="table card-table table-vcenter text-nowrap table-data">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Nomor Part Request</th>
                                    <th width="20%">PIC</th>
                                    <th width="20%">Part Number</th>
                                    <th width="15%">Part Quantity</th>
                                    <th width="15%">Lokasi</th>
                                    <th width="15%">Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($supervisornotifications) == 0)
                                    <tr>
                                        <td colspan="4" align="center">Data kosong</td>
                                    </tr>
                                @else
                                    @foreach ($supervisornotifications as $notification)
                                        <tr>
                                            <td width="5%">{{ $loop->iteration }}</td>
                                            <td width="20%">{{ $notification->part_req_number }}</td>
                                            <td width="20%">{{ $notification->pic }}</td>
                                            <td width="20%">{{ $notification->part_no }}</td>
                                            <td width="15%">{{ $notification->part_qty }}</td>
                                            <td width="15%">{{ $notification->loc_ppti }}</td>
                                            <td width="15%">{{ $notification->wear_and_tear_status }}</td>
                                            <td width="15%">
                                                @if ($notification->part_req_id > 0)
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-icon btnDetail btn-success text-white"
                                                        data-id="{{ $notification->part_req_id }}" data-toggle="tooltip"
                                                        data-placement="top" title="Approve">
                                                        <i data-feather="camera" width="16" height="16"></i>
                                                    </a>
                                                @endif
                                            </td>
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


    <!-- Modal Details -->
    <div class="modal fade detailModal" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('supervisornotification/update') }}" method="POST" id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="loc_tapc" id="loc_tapc"
                                            value="loc_tapc" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class="form-control" name="kategori_inventory" id="tabDropdown">
                                            <option value=""disabled selected>- Out To -</option>
                                            <option value="Expense">Expense</option>
                                            <option value="CIP">CIP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Part No <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="part_no" id="part_no"
                                            autofocus onkeyup="checkEnter(event)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Details -->



@endsection

@section('script')
    <script type="text/javascript">
        $('.btnDetail').click(function() {

            var id = $(this).attr('data-id');
            var url = "{{ url('supervisornotification/getdata') }}";

            $.ajax({
                type: 'GET',
                url: url + '/' + id,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);

                    if (data.status == 1) {
                        $('#part_req_number').val(data.result.part_req_number);
                        $('#pic').val(data.result.pic);
                        $('#part_name').val(data.result.part_name);
                        // $('#part_no').val(data.result.part_no);
                        $('#loc_tapc').val(data.result.loc_tapc);
                        $('#kategori_inventory').val(data.result.kategori_inventory);
                        $('#part_qty').val(data.result.part_qty);
                        $('.detailModal .modal-title').text('Details');
                        $('.detailModal').modal('show');
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Error : Gagal mengambil data');
                }
            });
        });
    </script>

    {{-- <script type="text/javascript">
        $('.btnEdit').click(function() {

            var id = $(this).attr('data-id');
            var url = "{{ url('notification/getdata') }}";

            $('.addModal form').attr('action', "{{ url('notification/update') }}" + '/' + id);

            $.ajax({
                type: 'GET',
                url: url + '/' + id,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);

                    if (data.status == 1) {
                        $('#part_req_id').val(data.result.part_req_id);
                        $('#part_req_number').val(data.result.part_req_number);
                        $('#pic').val(data.result.pic);
                        $('#wear_and_tear_status').val();
                        $('#part_name').val(data.result.part_name);
                        $('#part_qty').val(data.result.part_qty);
                        $('.addModal .modal-title').text('Approve');
                        $('.addModal').modal('show');
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Error : Gagal mengambil data');
                }
            });

        });
    </script> --}}

    {{-- <script type="text/javascript">
        $('.part_no').on('keyup', function(event) {
            if (event.key === "Enter") {
                var id = $(this).attr('data-id');
                var url = "{{ url('stockopname/getdata') }}";

                $('.addReset form').attr('action', "{{ url('stockopname/update') }}" + '/' + id);

                $.ajax({
                    type: 'GET',
                    url: url + '/' + id,
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data);

                        if (data.status == 1) {
                            $('#part_no_hidden').val(data.result.part_no);
                            $('#qty_no_hidden').val(data.result.qty_end);
                            $('#Status').val('yes');
                            $('.addReset .modal-title').text('Approve');
                            $('.addReset').modal('show');
                        }

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('Error : Gagal mengambil data');
                    }
                });
            }
        });
    </script> --}}



    <script>
        function checkEnter(event) {
            if (event.key === 'Enter') {
                var id = $('#part_no').val() // Assuming data-id is set on the element
                var url = "{{ url('supervisornotification/getdata') }}";

                // Move this line inside the 'Enter' key check
                $('.detailModal form').attr('action', "{{ url('supervisornotification/update') }}" + '/' + id);

                $.ajax({
                    type: 'GET',
                    url: url + '/' + id,
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data);

                        if (data.status == 1) {
                            var inputValue = $('#part_no').val();
                            var expectedValue = data.result.part_no;

                            if (inputValue === expectedValue) {
                                $('#part_no').val(data.result.part_no);
                                $('#kategori_inventory').val(data.result.kategori_inventory);
                                $('.detailModal .modal-title').text('Approve');
                                $('.detailModal').modal('show');
                            } else {
                                alert('Input is not equal to the expected value');
                            }
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('Error : Gagal mengambil data');
                    }
                });
            }
        }




        // $('.btnEdit').click(function() {

        //     var id = $(this).attr('data-id');
        //     var url = "{{ url('notification/getdata') }}";

        //     $('.addModal form').attr('action', "{{ url('notification/update') }}" + '/' + id);

        //     $.ajax({
        //         type: 'GET',
        //         url: url + '/' + id,
        //         dataType: 'JSON',
        //         success: function(data) {
        //             console.log(data);

        //             if (data.status == 1) {
        //                 $('#part_req_id').val(data.result.part_req_id);
        //                 $('#part_req_number').val(data.result.part_req_number);
        //                 $('#pic').val(data.result.pic);
        //                 $('#wear_and_tear_status').val();
        //                 $('#part_name').val(data.result.part_name);
        //                 $('#part_qty').val(data.result.part_qty);
        //                 $('.addModal .modal-title').text('Approve');
        //                 $('.addModal').modal('show');
        //             }

        //         },
        //         error: function(XMLHttpRequest, textStatus, errorThrown) {
        //             alert('Error : Gagal mengambil data');
        //         }
        //     });

        // });
    </script>
@endsection
