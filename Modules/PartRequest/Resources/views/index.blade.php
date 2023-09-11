@extends('layouts.app')
@section('title', 'Part Request')

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
                        <h3 class="h3">Part Request</h3>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- <div class="addData"> --}}
                <a href="javascript:void(0)" class="btn btn-success btnAdd text-white mb-3">
                    <i data-feather="plus" width="16" height="16" class="me-2"></i>
                    Tambah Part Request
                </a>
                {{-- </div> --}}

                <div class="table-responsive">
                    <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="80%">Part Request Number</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($partrequests) == 0)
                            <tr>
                                <td colspan="3" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($partrequests as $partrequest)
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="80%">{{ $partrequest->part_req_number }}</td>
                                <td width="15%">
                                    @if($partrequest->part_req_id > 0)
                                    <a href="javascript:void(0)" class="btn btn-icon btnEdit btn-warning text-white"
                                        data-id="{{ $partrequest->part_req_id }}" data-toggle="tooltip" data-placement="top"
                                        title="Ubah">
                                        <i data-feather="edit" width="16" height="16"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-icon btn-danger text-white btnDelete"
                                        data-url="{{ url('partrequest/delete/'. $partrequest->part_req_id) }}"
                                        data-toggle="tooltip" data-placement="top" title="Hapus">
                                        <i data-feather="trash-2" width="16" height="16"></i>
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
                                    <label class="form-label">Part <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="part_id" id="part_id">
                                        <option value="">- Pilih Part -</option>
                                        @if(sizeof($parts) > 0)
                                        @foreach($parts as $part)
                                        <option value="{{ $part->part_id }}">{{ $part->part_name }} - {{ $part->part_no }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Carline <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="carline" id="carline"
                                        placeholder="Masukan Carline" value="{{ old('carline') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Car Model <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="car_model" id="car_model"
                                        placeholder="Masukan Car Model" value="{{ old('car_model') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Alasan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="alasan" id="alasan"
                                        placeholder="Masukan Alasan" value="{{ old('alasan') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Order <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="order" id="order"
                                        placeholder="Masukan Order" value="{{ old('order') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Shift <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="shift" id="shift"
                                        placeholder="Masukan Shift" value="{{ old('shift') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Machine Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="machine_no" id="machine_no"
                                        placeholder="Masukan Machine Number" value="{{ old('machine_no') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Applicator Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="applicator_no" id="applicator_no"
                                        placeholder="Masukan Applicator Number" value="{{ old('applicator_no') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Wear and Tear Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_code" id="wear_and_tear_code"
                                        placeholder="Masukan Wear and Tear Code" value="{{ old('wear_and_tear_code') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Serial Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="serial_no" id="serial_no"
                                        placeholder="Masukan Serial Number" value="{{ old('serial_no') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Side Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="side_no" id="side_no"
                                        placeholder="Masukan Side Number" value="{{ old('side_no') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Stroke <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="stroke" id="stroke"
                                        placeholder="Masukan Stroke" value="{{ old('stroke') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Person in Charge <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pic" id="pic"
                                        placeholder="Masukan Person in Charge" value="{{ old('pic') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Remarks <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="remarks" id="remarks"
                                        placeholder="Masukan Remarks" value="{{ old('remarks') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_qty" id="part_qty"
                                        placeholder="Masukan Part Quantity" value="{{ old('part_qty') }}">
                                </div>
                            </div>

                            <div class="col-md-12" hidden>
                                <div class="form-group">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="status" id="status"
                                        placeholder="Masukan Status" value="0">
                                </div>
                            </div>
                            <div class="col-md-12" hidden>
                                <div class="form-group">
                                    <label class="form-label">Approved By <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="approved_by" id="approved_by"
                                        placeholder="Masukan Approved" value="-">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="text-white btn btn-success">Simpan</button>
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
        $('#part_no').val('');
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
                    $('#part_no').val(data.result.part_no);
                    $('.addModal .modal-title').text('Ubah Part Request');
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
            module_name: "required",
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
