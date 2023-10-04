@extends('layouts.app')
@section('title', 'List Of Part Request')

@section('content')
<!-- Container fluid  -->
<!-- ============================================================== -->
<!-- <div class="container-fluid"> -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- basic table -->
@if (session('message'))

@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                @if (session('message'))

                <strong id="msgId" hidden>{{ session('message') }}</strong>


                @endif
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">List Of Part Request</h3>
                        {{ date('Y-m-d') }}
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="5%">Date Transaksi</th>
                                <th width="5%">Receiving</th>
                                <th width="5%">Status Stok</th>
                                <th width="5%">Molts No</th>
                                <th width="5%">Applicator No</th>
                                <th width="5%">Part Name</th>
                                <th width="5%">Qty</th>
                                <th width="5%">Machine</th>
                                <th width="5%">Serial Number</th>
                                <th width="5%">Shift</th>
                                <th width="5%">Stroke</th>
                                <th width="5%">Carline Maker</th>
                                <th width="5%">Remarks</th>
                                <th width="5%">PIC</th>
                                <th width="5%">Part Number</th>
                                <th width="5%">Approved By</th>
                                <th width="5%">Status</th>
                                <th width="5%">Aksi</th>
                                {{-- <th width="15%">Approved By</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($listofpartrequests) == 0)
                            <tr>
                                <td colspan="3" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($listofpartrequests as $listofpartrequest)
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="5%">{{ substr($listofpartrequest->updated_at, 0,10) }}</td>
                                <td width="5%">{{ $listofpartrequest->part_req_number }}</td>
                                <td width="5%">-</td>
                                <td width="5%">-</td>
                                <td width="5%">-</td>
                                <td width="5%">-</td>
                                {{-- <td width="5%">{{ $part->molts_no }}</td> --}}
                                {{-- <td width="5%">{{ $part->applicator_no }}</td> --}}
                                {{-- <td width="5%">{{ $part->part_name }}</td> --}}
                                <td width="15%">{{ $listofpartrequest->part_qty }}</td>
                                <td width="5%">{{ $listofpartrequest->machine_no }}</td>
                                <td width="5%">-</td>
                                <td width="5%">{{ $listofpartrequest->shift }}</td>
                                <td width="5%">{{ $listofpartrequest->stroke }}</td>
                                <td width="5%">{{ $listofpartrequest->carline }}</td>
                                <td width="5%">{{ $listofpartrequest->remarks }}</td>
                                <td width="5%">{{ $listofpartrequest->pic }}</td>
                                <td width="5%">{{ $listofpartrequest->part_no }}</td>
                                <td width="5%">{{ $listofpartrequest->approved_by }}</td>
                                {{-- <td width="15%">{{ $listofpartrequest->machine }}</td> --}}
                                {{-- <td width="5%">{{ $part->serial_number }}</td>
                                <td width="5%">{{ $listofpartrequest->shift }}</td>
                                <td width="5%">{{ $part->stroke }}</td> --}}
                                {{-- <td width="5%">{{ $listofpartrequest->carline_maker }}</td> --}}
                                {{-- <td width="5%">{{ $listofpartrequest->remarks }}</td> --}}
                                {{-- <td width="5%">{{ $listofpartrequest->part_number }}</td> --}}
                                <td width="5%">
                                    @if($listofpartrequest->wear_and_tear_status == "Open")
                                        <a href="javascript:void(0)" class="btn btn-icon btn-success text-white"
                                            data-id="{{ $listofpartrequest->wear_and_tear_status }}" data-toggle="tooltip" data-placement="top"
                                            title="Ubah">
                                            <i data-feather="check" width="16" height="16"></i>
                                        </a>
                                    @elseif($listofpartrequest->wear_and_tear_status == "On Progress")
                                        <a href="javascript:void(0)" class="btn btn-icon btn-warning text-white"
                                            data-id="{{ $listofpartrequest->wear_and_tear_status }}" data-toggle="tooltip" data-placement="top"
                                            title="On Progress">
                                            <i data-feather="clock" width="16" height="16"></i>
                                        </a>
                                    @elseif($listofpartrequest->wear_and_tear_status == "Closed")
                                        <a href="javascript:void(0)" class="btn btn-icon btn-danger text-white"
                                            data-id="{{ $listofpartrequest->wear_and_tear_status }}" data-toggle="tooltip" data-placement="top"
                                            title="Closed">
                                            <i data-feather="close" width="16" height="16"></i>
                                        </a>
                                    @endif
                                </td>
                                <td width="5%">
                                    @if($listofpartrequest->part_req_id > 0)
                                    <a href="javascript:void(0)" class="btn btn-icon btnEdit btn-success text-white"
                                        data-id="{{ $listofpartrequest->part_req_id }}" data-toggle="tooltip" data-placement="top"
                                        title="Details">
                                        <i data-feather="list" width="16" height="16"></i>
                                    </a>
                                    @endif
                                </td>
                                {{-- <td width="15%">{{ $listofpartrequest->approved_by }}</td> --}}
                                {{-- <td width="15%">
                                    @if($listofpartrequest->part_req_id > 0)
                                    <a href="javascript:void(0)" class="btn btn-icon btnEdit btn-warning text-white"
                                        data-id="{{ $listofpartrequest->part_req_id }}" data-toggle="tooltip" data-placement="top"
                                        title="Ubah">
                                        <i data-feather="edit" width="16" height="16"></i>
                                    </a>
                                    @endif
                                </td> --}}
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

<!-- Modal Add -->
<div class="modal addModal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Part Request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('partrequest/store') }}" method="POST" id="addForm">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Part Req Number <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="part_req_number" id="part_req_number"
                                         value="{{ old('part_req_number') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Carline <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="carline" id="carline"
                                         value="{{ old('carline') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Car Model <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="car_model" id="car_model"
                                         value="{{ old('car_model') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Alasan <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="alasan" id="alasan"
                                         value="{{ old('alasan') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Order <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="order" id="order"
                                         value="{{ old('order') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Shift <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="shift" id="shift"
                                         value="{{ old('shift') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Machine Number <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="machine_no" id="machine_no"
                                         value="{{ old('machine_no') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Applicator Number <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="applicator_no" id="applicator_no"
                                        value="{{ old('applicator_no') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Wear and Tear Code <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_code" id="wear_and_tear_code"
                                         value="{{ old('wear_and_tear_code') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Serial Number <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="serial_no" id="serial_no"
                                         value="{{ old('serial_no') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Side Number <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="side_no" id="side_no"
                                         value="{{ old('side_no') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Stroke <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="stroke" id="stroke"
                                         value="{{ old('stroke') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Person in Charge <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="pic" id="pic"
                                         value="{{ old('pic') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Remarks <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="remarks" id="remarks"
                                         value="{{ old('remarks') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Part Quantity <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="part_qty" id="part_qty"
                                         value="{{ old('part_qty') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Wear and Tear Status <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_status" id="wear_and_tear_status"
                                         value="{{ old('wear_and_tear_status') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->
@endsection

@section('script')
<script type="text/javascript">
    $('.btnAdd').click(function () {
        $('#part_req_number').val('');
        $('#carline').val('');
        $('#car_model').val('');
        $('#alasan').val('');
        $('#order').val('');
        $('#shift').val('');
        $('#machine_no').val('');
        $('#applicator_no').val('');
        $('#wear_and_tear_code').val('');
        $('#serial_no').val('');
        $('#side_no').val('');
        $('#stroke').val('');
        $('#pic').val('');
        $('#remarks').val('');
        $('#part_qty').val('');
        $('#status').val('');
        $('#approved_by').val('');
        $('.addModal form').attr('action', "{{ url('partrequest/store') }}");
        $('.addModal .modal-title').text('Tambah Modul');
        $('.addModal').modal('show');
    });

    // check error
    @if(count($errors))
    $('.addModal').modal('show');
    @endif

    $('.btnEdit').click(function () {

        var id = $(this).attr('data-id');
        var url = "{{ url('partrequest/getdata') }}";

        $('.addModal form').attr('action', "{{ url('partrequest/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                if (data.status == 1) {

                    $('#part_req_number').val(data.result.part_req_number);
                    $('#carline').val(data.result.carline);
                    $('#car_model').val(data.result.car_model);
                    $('#alasan').val(data.result.alasan);
                    $('#order').val(data.result.order);
                    $('#shift').val(data.result.shift);
                    $('#machine_no').val(data.result.machine_no);
                    $('#applicator_no').val(data.result.applicator_no);
                    $('#wear_and_tear_code').val(data.result.wear_and_tear_code);
                    $('#serial_no').val(data.result.serial_no);
                    $('#side_no').val(data.result.side_no);
                    $('#stroke').val(data.result.stroke);
                    $('#pic').val(data.result.pic);
                    $('#remarks').val(data.result.remarks);
                    $('#part_qty').val(data.result.part_qty);
                    $('#status').val(data.result.status);
                    $('#approved_by').val(data.result.approved_by);
                    $('.addModal .modal-title').text('Details');
                    $('.addModal').modal('show');

                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : Gagal mengambil data');
            }
        });

    });

    $('.btnDelete').click(function () {
        $('.btnDelete').attr('disabled', true)
        var url = $(this).attr('data-url');
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus data?',
            text: "Kamu tidak akan bisa mengembalikan data ini setelah dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya. Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Terhapus!',
                                'Data Berhasil Dihapus.',
                                'success'
                            ).then(() => {
                                location.reload()
                            })
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        Swal.fire(
                            'Gagal!',
                            'Gagal menghapus data.',
                            'error'
                        );
                    }
                });
            }
        })
    });

    $("#addForm").validate({
        rules: {

        },
        messages: {
            module_name: "Modul tidak boleh kosong",
        },
        errorElement: "em",
        errorClass: "invalid-feedback",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            $(element).parents('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        }
    });

    var notyf = new Notyf({
        duration: 5000,
        position: {
            x: 'right',
            y: 'top'
        }
    });
    var msg = $('#msgId').html()
    if (msg !== undefined) {
        notyf.success(msg)
    }

</script>
@endsection
