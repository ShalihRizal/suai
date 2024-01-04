@extends('layouts.app')
@section('title', 'Material Non-Inventory')

@section('nav')
    <div class="row align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
                Material Non-Inventory
            </div>
            <h2 class="page-title">
                Material Non-Inventory
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('') }}"><i data-feather="home"
                                class="breadcrumb-item-icon"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Material Non-Inventory</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Material Non-Inventory</li>
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
                            <h3 class="h3">Material Non-Inventory</h3>
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
                            Tambah Part
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="table-data" class="table card-table table-vcenter text-nowrap table-data">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="5%">Part No</th>
                                    <th width="5%">Part Name</th>
                                    <th width="5%">Harga</th>
                                    <th width="5%">Minimum Stok</th>
                                    <th width="5%">QTY Stok</th>
                                    <th width="5%">Status</th>
                                    <th width="5%">Aksi</th>
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
                                            <td width="20%">{{ $part->part_no }}</td>
                                            <td width="20%">{{ $part->part_name }}</td>
                                            <td width="20%">${{ $part->price }}</td>
                                            <td width="20%">{{ $part->min_stock }}</td>
                                            <td width="20%">{{ $part->qty }}</td>
                                            <td width="20%">
                                                @php
                                                    if ($part->qty <= $part->min_stock) {
                                                        echo 'Shortage';
                                                    } else {
                                                        echo 'OK';
                                                    }
                                                @endphp
                                            </td>
                                            <td width="15%">
                                                @if ($part->part_id > 0)
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-icon btnEdit btn-warning text-white"
                                                        data-id="{{ $part->part_id }}" data-toggle="tooltip"
                                                        data-placement="top" title="Ubah">
                                                        <i data-feather="edit" width="16" height="16"></i>
                                                    </a>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-icon btn-danger text-white btnDelete"
                                                        data-url="{{ url('part/delete/' . $part->part_id) }}"
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
                    <h5 class="modal-title">Tambah Part</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ url('part/store') }}" method="POST" id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Part Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="part_name" id="part_name"
                                            placeholder="Masukan Part Name" value="{{ old('part_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Part Number<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="part_no" id="part_no"
                                            placeholder="Masukan Part Number" value="{{ old('part_no') }}">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Price | USD<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="price" id="price"
                                            placeholder="Masukan Price" value="{{ old('price') }}">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Minimum Stock<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="min_stock" id="min_stock"
                                            placeholder="Masukan Minimum Stock" value="{{ old('min_stock') }}">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Qty Stok<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="qty" id="qty"
                                            placeholder="Masukan Qty Stok" value="{{ old('qty') }}">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3"hidden>
                                    <div class="form-group">
                                        <label class="form-label">Type<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="type" id="type"
                                            placeholder="Masukan Type" value="NonInventory">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Satuan<span class="text-danger">*</span></label>
                                        <select class="form-control" name="satuan" id="satuan">
                                            <option value="" disabled selected>Pilih Satuan</option>
                                            <option value="PAK">PAK</option>
                                            <option value="KLG">KLG</option>
                                            <option value="BOX">BOX</option>
                                            <option value="DUS">DUS</option>
                                            <option value="ROL">ROL</option>
                                            <option value="PCS">PCS</option>
                                        </select>
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
            $('#part_name').val('');
            $('#part_no').val('');
            $('#price').val('');
            $('#min_stock').val('');
            $('#qty').val('');
            $('#satuan').val('');
            $('.addModal form').attr('action', "{{ url('noninventory/store') }}");
            $('.addModal .modal-title').text('Tambah Part');
            $('.addModal').modal('show');
        });

        // check error
        @if (count($errors))
            $('.addModal').modal('show');
        @endif

        $('.btnEdit').click(function() {

            var id = $(this).attr('data-id');
            var url = "{{ url('part/getdata') }}";

            $('.addModal form').attr('action', "{{ url('part/update') }}" + '/' + id);

            $.ajax({
                type: 'GET',
                url: url + '/' + id,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);

                    if (data.status == 1) {
                        $('#part_name').val(data.result.part_name);
                        $('#part_no').val(data.result.part_no);
                        $('#price').val(data.result.price);
                        $('#qty').val(data.result.qty);
                        $('#min_stock').val(data.result.min_stock);
                        $('.addModal .modal-title').text('Ubah Part');
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
                part_name: "required",
            },
            messages: {
                part_name: "Part Name Tidak Boleh Kosong",
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
