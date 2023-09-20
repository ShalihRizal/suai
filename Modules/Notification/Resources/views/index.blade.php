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
                                <th width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($notifications) == 0)
                            <tr>
                                <td colspan="4" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($notifications as $notification)
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="20%">{{ $notification->part_req_number }}</td>
                                <td width="20%">{{ $notification->pic }}</td>
                                <td width="15%">{{ $notification->part_no }}</td>
                                <td width="15%">{{ $notification->part_qty }}</td>
                                <td width="20%">
                                    @if($notification->part_req_id > 0)
                                    <a href="javascript:void(0)" class="btn btn-icon btnEdit btn-warning text-white"
                                        data-id="{{ $notification->part_req_id }}" data-toggle="tooltip" data-placement="top"
                                        title="Approve">
                                        <i data-feather="check" width="16" height="16"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-icon btnDetail btn-success text-white "
                                        data-url="{{ url('notification/edit/'. $notification->part_req_id) }}"
                                        data-toggle="tooltip" data-placement="top" title="Hapus">
                                        <i data-feather="list" width="16" height="16"></i>
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
<div class="modal fade addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve?</h5>
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
                    <button type="submit" class="text-white btn btn-success">Approve</button>
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
        $('#part_req_id').val('');
        $('#part_req_number').val('');
        $('#pic').val('');
        $('#part_name').val('');
        $('#part_qty').val('');
        $('.addModal form').attr('action', "{{ url('notification/store') }}");
        $('.addModal .modal-title').text('Tambah Notifikasi');
        $('.addModal').modal('show');
    });

    // check error
    @if(count($errors))
    $('.addModal').modal('show');
    @endif

    $('.btnEdit').click(function () {

        var id = $(this).attr('data-id');
        var url = "{{ url('notification/getdata') }}";

        $('.addModal form').attr('action', "{{ url('notification/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                if (data.status == 1) {
                    $('#part_req_id').val(data.result.part_req_id);
                    $('#part_req_number').val(data.result.part_req_number);
                    $('#pic').val(data.result.pic);
                    $('#part_name').val(data.result.part_name);
                    $('#part_qty').val(data.result.part_qty);
                    $('.addModal .modal-title').text('Approve');
                    $('.addModal').modal('show');
                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : Gagal mengambil data');
            }
        });

    });

    $('.btnDetail').click(function () {

        var id = $(this).attr('data-id');
        var url = "{{ url('notification/getdata') }}";

        $('.addModal form').attr('action', "{{ url('notification/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                if (data.status == 1) {
                    $('#part_req_id').val(data.result.part_req_id);
                    $('#part_req_number').val(data.result.part_req_number);
                    $('#pic').val(data.result.pic);
                    $('#part_name').val(data.result.part_name);
                    $('#part_qty').val(data.result.part_qty);
                    $('.addModal .modal-title').text('Approve');
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
            part_req_id: "required",
            part_req_number: "required",
            pic: "required",
            part_name: "required",
            part_qty: "required"

        },
        messages: {
            part_req_id: "Notification ID Tidak Boleh Kosong",
            part_req_number: "Part Request Number Tidak Boleh Kosong",
            pic: "PIC Tidak Boleh Kosong",
            part_name: "Part Name Tidak Boleh Kosong",
            part_qty: "Part Quantity Tidak Boleh Kosong"
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
