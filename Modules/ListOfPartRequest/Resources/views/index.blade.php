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
<style>
    .open-text {
        color: red;
    }

    .open-text2 {
        color: yellow;
    }

    .open-text3 {
        color: green;
    }
</style>
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
                </div>
            </div>
            <div class="card-header w-100">
    <div class="row">
        <div class="col-md-6">
            <form action="{{route('exportlistofpartreq')}}" method="GET">
                <div class="row align-items-center">
                    <!-- Jika ingin input tanggal kembali, bisa aktifkan bagian ini -->
                    <!--
                    <div class="col-md-5">
                        <input type="date" name="start_date" class="form-control" placeholder="Start Date">
                    </div>
                    <div class="col-md-5">
                        <input type="date" name="end_date" class="form-control" placeholder="End Date">
                    </div>
                    -->
                    <div class="col-auto">
                        <a href="{{ route('downloadtemplatetransaksiout') }}" class="btn btn-success text-white me-2">
                            <i data-feather="download" width="16" height="16" class="me-1"></i> Template
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('download.data') }}" class="btn btn-primary text-white me-2">
                            <i data-feather="download" width="16" height="16" class="me-1"></i> Data
                        </a>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-info text-white" data-toggle="modal" data-target="#uploadModal">
                            <i data-feather="upload" width="16" height="16" class="me-1"></i> Upload
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="5%">Part Req Number</th>
                                <th width="5%">Waktu</th>
                                <th width="5%">Waktu</th>
                                <th width="5%">Carname</th>
                                <th width="5%">Car Model</th>
                                <th width="5%">Alasan</th>
                                <th width="5%">Order</th>
                                <th width="5%">Shift</th>
                                <th width="5%">Machine No</th>
                                <th width="5%">Applicator No</th>
                                <th width="5%">Applicator No Input</th>
                                <th width="5%">Wear And Tear Code</th>
                                <th width="5%">Serial No</th>
                                <th width="5%">Side No</th>
                                <th width="5%">Stroke</th>
                                <th width="5%">Pic</th>
                                <!-- <th width="5%">Remarks</th> -->
                                <th width="5%">Remarks</th>
                                <th width="5%">Part Qty</th>
                                <th width="5%">Status</th>
                                <th width="5%">Approved By</th>
                                <th width="5%">Part No</th>
                                <th width="5%">Wear And Tear Status</th>
                                <th width="5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($partrequests) == 0)
                            <tr>
                                <td colspan="14" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($partrequests as $partrequest)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $partrequest->part_req_number }}</td>
                                <td width="20%">{{ Str::substr($partrequest->part_request_created_at, 10, 18) }}</td>
                                <td>{{ $partrequest->part_request_created_at }}</td>
                                <td>{{ $partrequest->carname_name }}</td>
                                <td>{{ $partrequest->carline_name }}</td>
                                <td>{{ $partrequest->alasan }}</td>
                                <td>{{ $partrequest->kategori }}</td>
                                <td>{{ $partrequest->shift }}</td>
                                <td>{{ $partrequest->machine_no }}</td>
                                <td>{{ $partrequest->applicator_no }}</td>
                                <td>{{ $partrequest->applicator_no2 }}</td>
                                <td>{{ $partrequest->wear_and_tear_code }}</td>
                                <td>{{ $partrequest->serial_no }}</td>
                                <td>{{ $partrequest->side_no }}</td>
                                <td>{{ $partrequest->stroke }}</td>
                                <td>{{ $partrequest->pic }}</td>
                                <!-- <td>{{ $partrequest->remarks }}</td> -->
                                <td>{{ $partrequest->remarks2 }}</td>
                                <td>{{ $partrequest->part_qty }}</td>
                                <td>{{ $partrequest->status }}</td>
                                <td>{{ $partrequest->user_name ? $partrequest->user_name : 'Belum Di Approve' }}</td>
                                <td>{{ $partrequest->part_no }}</td>
                                <td>
                                    @if ($partrequest->wear_and_tear_status == 'Open')
                                    <a data-id="{{ $partrequest->wear_and_tear_status }}"
                                        data-toggle="tooltip" data-placement="top" title="Ubah">
                                        <i width="16" height="16" class="open-text">Open</i>
                                    </a>
                                    @elseif($partrequest->wear_and_tear_status == 'On Progress')
                                    <a data-id="{{ $partrequest->wear_and_tear_status }}"
                                        data-toggle="tooltip" data-placement="top" title="On Progress">
                                        <i width="16" height="16" class="open-text2">On Progress</i>
                                    </a>
                                    @elseif($partrequest->wear_and_tear_status == 'Closed')
                                    <a data-id="{{ $partrequest->wear_and_tear_status }}"
                                        data-toggle="tooltip" data-placement="top" title="Closed">
                                        <i width="16" height="16" class="open-text3">Closed</i>
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($partrequest->partlist_id > 0)
                                    <a href="javascript:void(0)"
                                        class="btn btn-icon btnEdit btn-success text-white"
                                        data-id="{{ $partrequest->partlist_id }}" data-toggle="tooltip"
                                        data-placement="top" title="Details">
                                        <i data-feather="list" width="16" height="16">Details</i>
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
                                    <label class="form-label disabled">Part Req Number <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="part_req_number"
                                        id="part_req_number" value="{{ old('part_req_number') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Carline <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="carline" id="carline"
                                        value="{{ old('carline') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Car Name <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="carname_name" id="carname"
                                        value="{{ old('carline') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Alasan <span
                                            class="text-danger"></span></label>
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
                                    <label class="form-label disabled">Machine Number <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="machine_no" id="machine_no"
                                        value="{{ old('machine_no') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Applicator Number <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="applicator_no"
                                        id="applicator_no" value="{{ old('applicator_no') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Wear and Tear Code <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_code"
                                        id="wear_and_tear_code" value="{{ old('wear_and_tear_code') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Serial Number <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="serial_no" id="serial_no"
                                        value="{{ old('serial_no') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Side Number <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="side_no" id="side_no"
                                        value="{{ old('side_no') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Stroke <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="stroke" id="stroke"
                                        value="{{ old('stroke') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Person in Charge <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="pic" id="pic"
                                        value="{{ old('pic') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Remarks <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="remarks" id="remarks"
                                        value="{{ old('remarks') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Part Quantity <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="part_qty" id="part_qty"
                                        value="{{ old('part_qty') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label disabled">Wear and Tear Status <span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_status"
                                        id="wear_and_tear_status" value="{{ old('wear_and_tear_status') }}" readonly>
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

<!-- Modal Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('partrequest/allstore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file_upload">Pilih File</label>
                        <input type="file" name="file_upload" class="form-control" id="file_upload" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Upload -->

@endsection

@section('script')
<script type="text/javascript">
    // Inisialisasi DataTable
    $(document).ready(function() {
        $('#table-data').DataTable({
            // Opsi tambahan dapat ditambahkan di sini
            "language": {
                "emptyTable": "Tidak ada data tersedia",
                "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "search": "Cari:",
                "zeroRecords": "Tidak ada hasil ditemukan"
            }
        });
    });

    // check error
    @if(count($errors))
    $('.addModal').modal('show');
    @endif

    $('.btnEdit').click(function() {

        var id = $(this).attr('data-id');
        var url = "{{ url('listofpartrequest/getdata') }}";

        // $('.addModal form').attr('action', "{{ url('listofpartrequest/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function(data) {
                console.log(data);

                if (data.status == 1) {

                    $('#part_req_number').val(data.result.part_req_number);
                    $('#carline').val(data.result.carline_name); // car model
                    $('#carname').val(data.result.carname_part_request);
                    $('#alasan').val(data.result.alasan);
                    $('#order').val(data.result.kategori);
                    $('#shift').val(data.result.shift);
                    $('#machine_no').val(data.result.machine_no);
                    $('#applicator_no').val(data.result.applicator_no);
                    $('#wear_and_tear_code').val(data.result.wear_and_tear_code);
                    $('#wear_and_tear_status').val(data.result.wear_and_tear_status);
                    $('#serial_no').val(data.result.serial_no);
                    $('#side_no').val(data.result.side_no);
                    $('#stroke').val(data.result.stroke);
                    $('#pic').val(data.result.pic);
                    $('#remarks').val(data.result.part_request_remarks);
                    $('#part_qty').val(data.result.part_qty);
                    $('#status').val(data.result.status);
                    $('#approved_by').val(data.result.approved_by);
                    $('.addModal .modal-title').text('Details');
                    $('.addModal').modal('show');

                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : Gagal mengambil data');
            }
        });

    });

    $('.btnDelete').click(function() {
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
                    success: function(data) {
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
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
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
        errorPlacement: function(error, element) {
            // Add the help-block class to the error element
            $(element).parents('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass, validClass) {
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

    // Script untuk menangani tampilan modal
    $(document).ready(function() {
        $('#uploadModal').on('show.bs.modal', function (e) {
            // Reset form ketika modal dibuka
            $('#file_upload').val('');
        });
    });
</script>
@endsection
