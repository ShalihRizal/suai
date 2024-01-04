@extends('layouts.app')
@section('title', 'Car Name')

@section('nav')
    <div class="row align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
                Car Name
            </div>
            <h2 class="page-title">
                Car Name
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('') }}"><i data-feather="home"
                                class="breadcrumb-item-icon"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Car Name</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Car Name</li>
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
                            <h3 class="h3">Car Name</h3>
                            {{ date('Y-m-d') }}
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="addData">
                        <a href="javascript:void(0)" class="btn btn-success btnAdd text-white mb-3">
                            <i data-feather="plus" width="16" height="16" class="me-2"></i>
                            Tambah Car Name
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="table-data" class="table card-table table-vcenter text-nowrap table-data">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="80%">Car Name</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($carnames) == 0)
                                    <tr>
                                        <td colspan="4" align="center">Data kosong</td>
                                    </tr>
                                @else
                                    @foreach ($carnames as $carname)
                                        <tr>
                                            <td width="5%">{{ $loop->iteration }}</td>
                                            <td width="80%">{{ $carname->carname_name }}</td>
                                            <td width="15%">
                                                @if ($carname->carname_id > 0)
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-icon btnEdit btn-warning text-white"
                                                        data-id="{{ $carname->carname_id }}" data-toggle="tooltip"
                                                        data-placement="top" title="Ubah">
                                                        <i data-feather="edit" width="16" height="16"></i>
                                                    </a>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-icon btn-danger text-white btnDelete"
                                                        data-url="{{ url('carname/delete/' . $carname->carname_id) }}"
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
    <div class="modal fade addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Car Name</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ url('carname/store') }}" method="POST" id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Car Name Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="carname_name" id="carname_name"
                                            placeholder="Masukan Car Name Name" value="{{ old('carname_name') }}">
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
        $('.btnAdd').click(function() {
            $('#carname_name').val('');
            $('#carname_id').val('');
            $('.addModal form').attr('action', "{{ url('carname/store') }}");
            $('.addModal .modal-title').text('Tambah Car Name');
            $('.addModal').modal('show');
        });

        // check error
        @if (count($errors))
            $('.addModal').modal('show');
        @endif

        $('.btnEdit').click(function() {

            var id = $(this).attr('data-id');
            var url = "{{ url('carname/getdata') }}";

            $('.addModal form').attr('action', "{{ url('carname/update') }}" + '/' + id);

            $.ajax({
                type: 'GET',
                url: url + '/' + id,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);

                    if (data.status == 1) {
                        $('#carname_name').val(data.result.carname_name);
                        $('#carname_id').val(data.result.carname_id);
                        $('.addModal .modal-title').text('Ubah Car Name');
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
                carname_name: "required",
            },
            messages: {
                carname_name: "Car Name Name Tidak Boleh Kosong",
            },
            errorElement: "em",
            errorClass: "invalid-feedback",
            errorPlacement: function(error, element) {
                // Add the `help-block` class to the error element
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
    </script>
@endsection
