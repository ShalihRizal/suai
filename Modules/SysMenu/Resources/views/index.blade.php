@extends('layouts.app')
@section('title', 'Menu')

@section('nav')
<div class="row align-items-center">
    <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
            Hak Akses
        </div>
        <h2 class="page-title">
            Menu
        </h2>
    </div>
    <!-- Page title actions -->
    <div class="col-auto ms-auto d-print-none">

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
<!-- basic table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                @if (session('successMessage'))
                <strong id="successMessage" hidden>{{ session('successMessage') }}</strong>
                @elseif(session('errorMessage'))
                <strong id="errorMessage" hidden>{{ session('errorMessage') }}</strong>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Menu</h3>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="addData">
                    <a href="javascript:void(0)" class="btn btn-success btnAdd text-white mb-3">
                        <i data-feather="plus" width="16" height="16" class="me-2"></i>
                        Tambah Menu
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped card-table table-hover text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Menu</th>
                                <th width="15%">Modul</th>
                                <th width="20%">URL</th>
                                <th width="15%">Parent</th>
                                <th width="10%">Posisi</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($menus) == 0)
                            <tr>
                                <td colspan="7" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($menus as $menu)
                            @php
                            $parent = "-";

                            if(!empty($menu->menu_name_parent)) $parent = $menu->menu_name_parent;

                            $module = "-";

                            if(!empty($menu->module_name)) $module = $menu->module_name;

                            @endphp

                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="20%">{{ $menu->menu_name }}</td>
                                <td width="20%">{{ $module }}</td>
                                <td width="20%">{{ $menu->menu_url }}</td>
                                <td width="15%">{{ $parent }}</td>
                                <td width="15%">{{ $menu->menu_position }}</td>
                                <td width="15%">
                                    @if($menu->menu_id > 0)
                                    <a href="javascript:void(0)" class="btn btn-icon btnEdit btn-warning text-white"
                                        data-id="{{ $menu->menu_id }}" data-toggle="tooltip" data-placement="top"
                                        title="Ubah">
                                        <i data-feather="edit" width="16" height="16"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-icon btn-danger text-white btnDelete"
                                        data-url="{{ url('sysmenu/delete/'. $menu->menu_id) }}" data-toggle="tooltip"
                                        data-placement="top" title="Hapus">
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Menu</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('sysmenu/store') }}" method="POST" id="addForm">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="menu_name" id="menu_name"
                                        placeholder="Masukan nama menu">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Modul </label>
                                    <select class="form-control" name="module_id" id="module_id">
                                        <option value="">- Pilih Modul -</option>
                                        @if(sizeof($modules) > 0)
                                        @foreach($modules as $module)
                                        <option value="{{ $module->module_id }}">{{ $module->module_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">URL <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="menu_url" id="menu_url"
                                        placeholder="Masukan alamat URL">
                                    <small>Untuk menu parent diisi: javascript:void(0)</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Sub menu ? <span class="text-danger">*</span></label>
                                    <select name="menu_is_sub" id="menu_is_sub" class="form-control">
                                        <option value="0">Bukan</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Ikon</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="menu_icon" id="menu_icon"
                                            placeholder="Masukan kode ikon">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Menu Parent</label>
                                    <select class="form-control" name="menu_parent_id" id="menu_parent_id"
                                        disabled="disabled">
                                        <option value="">- Pilih Menu -</option>
                                        @if(sizeof($parents) > 0)
                                        @foreach($parents as $parent)
                                        <option value="{{ $parent->menu_id }}">{{ $parent->menu_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Posisi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="menu_position" id="menu_position"
                                        placeholder="Masukan posisi">
                                    <small>Semakin kecil, semakin atas (0)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-white btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="text-white btn btn-primary">Simpan</button>
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
        $('#menu_name').val('');
        $('#module_id').val('');
        $('#menu_url').val('');
        $('#menu_is_sub').val('0');
        $('#menu_icon').val('');
        $('#menu_parent_id').val('');
        $('#menu_position').val('');
        $('.addModal form').attr('action', "{{ url('sysmenu/store') }}");
        $('.addModal .modal-title').text('Tambah Menu');
        $('.addModal').modal('show');
    });

    $('.btnEdit').click(function () {

        var id = $(this).attr('data-id');
        var url = "{{ url('sysmenu/getdata') }}";

        $('.addModal form').attr('action', "{{ url('sysmenu/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                if (data.status == 1) {

                    $('#menu_name').val(data.result.menu_name);
                    $('#module_id').val(data.result.module_id);
                    $('#menu_url').val(data.result.menu_url);
                    $('#menu_is_sub').val(data.result.menu_is_sub);
                    $('#menu_icon').val(data.result.menu_icon);
                    $('#menu_parent_id').val(data.result.menu_parent_id);
                    $('#menu_position').val(data.result.menu_position);
                    $('.addModal .modal-title').text('Ubah Menu');
                    $('.addModal').modal('show');

                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : Gagal mengambil data');
            }
        });

    });

    $('#menu_is_sub').change(function () {

        var val = $(this).val();

        if (val == 0) {
            $('#menu_parent_id').val('');
            $('#menu_parent_id').attr('disabled', 'disabled');
        } else {
            $('#menu_parent_id').removeAttr('disabled');
        }

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
            menu_name: "required",
            menu_url: "required",
            menu_position: {
                required: true,
                number: true
            },
        },
        messages: {
            menu_name: "Nama tidak boleh kosong",
            menu_position: "Posisi tidak boleh kosong dan hanya boleh angka",
            menu_url: "URL tidak boleh kosong",
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
