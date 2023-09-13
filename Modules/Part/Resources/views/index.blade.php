use SimpleSoftwareIO\QrCode\Facades\QrCode;

@extends('layouts.app')
@section('title', 'Part')

@section('nav')
<div class="row align-items-center">
    <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
            Part
        </div>
        <h2 class="page-title">
            Part
        </h2>
    </div>
    <!-- Page title actions -->
    <div class="col-auto ms-auto d-print-none">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                <li class="breadcrumb-item"><a href="{{ url('') }}"><i data-feather="home"
                            class="breadcrumb-item-icon"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Part</a></li>
                <li class="breadcrumb-item active" aria-current="page">Part</li>
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
                        <h3 class="h3">Part</h3>
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
                                <th width="20%">Part Name</th>
                                <th width="15%">Part Number</th>
                                <th width="20%">Stock</th>
                                <th width="20%">QR Code</th>
                                <th width="15%">Aksi</th>
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
                                <td width="20%">{{ $part->part_name }}</td>
                                <td width="15%">{{ $part->part_no }}</td>
                                <td width="20%">{{ $part->qty_end }}</td>
                                <td width="20%">{{ QrCode::size(75)->generate($part->part_no);}}</td>
                                <td width="15%">
                                    @if($part->part_id > 0)
                                    <a href="javascript:void(0)" class="btn btn-icon btnEdit btn-warning text-white"
                                        data-id="{{ $part->part_id }}" data-toggle="tooltip" data-placement="top"
                                        title="Ubah">
                                        <i data-feather="edit" width="16" height="16"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-icon btn-danger text-white btnDelete"
                                        data-url="{{ url('part/delete/'. $part->part_id) }}" data-toggle="tooltip"
                                        data-placement="top" title="Hapus">
                                        <i data-feather="trash-2" width="16" height="16"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-icon btn-success text-white btnGenerate"
                                        data-url="{{ url('part/generate/') }}" data-toggle="tooltip"
                                        data-placement="top" title="QR Code">
                                        <i data-feather="code" width="16" height="16"></i>
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
                                    <label class="form-label">Part No<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_no" id="part_no"
                                    placeholder="Masukan Part No" value="{{ old('part_no') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Part Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_name" id="part_name"
                                        placeholder="Masukan Part Name" value="{{ old('part_name') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">No Urut<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="no_urut" id="no_urut"
                                        placeholder="Masukan No Urut" value="{{ old('no_urut') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">No Applicator<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="applicator_no" id="applicator_no"
                                        placeholder="Masukan No Applicator" value="{{ old('applicator_no') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Tipe Applicator<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="applicator_type" id="applicator_type"
                                        placeholder="Masukan Tipe Applicator" value="{{ old('applicator_type') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Kuantitas Applicator<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="applicator_qty" id="applicator_qty"
                                        placeholder="Masukan Kuantitas Applicator" value="{{ old('applicator_qty') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Kode Tooling BC<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="kode_tooling_bc" id="kode_tooling_bc"
                                        placeholder="Masukan Kode Tooling BC" value="{{ old('kode_tooling_bc') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Asal<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="asal" id="asal"
                                        placeholder="Masukan Asal" value="{{ old('asal') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Invoice<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="invoice" id="invoice"
                                        placeholder="Masukan Invoice" value="{{ old('invoice') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">PO<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="po" id="po"
                                        placeholder="Masukan PO" value="{{ old('po') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">PO Date<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="po_date" id="po_date"
                                        placeholder="Masukan PO Date" value="{{ old('po_date') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Rec Date<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="rec_date" id="rec_date"
                                        placeholder="Masukan Rec Date" value="{{ old('rec_date') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Loc PPTI<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="loc_ppti" id="loc_ppti"
                                        placeholder="Masukan Loc PPTI" value="{{ old('loc_ppti') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Loc Tapc<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="loc_tapc" id="loc_tapc"
                                        placeholder="Masukan Loc Tapc" value="{{ old('loc_tapc') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Loc Hib<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="lokasi_hib" id="lokasi_hib"
                                        placeholder="Masukan Loc Hib" value="{{ old('lokasi_hib') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Qty Begin<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty_begin" id="qty_begin"
                                        placeholder="Masukan Qty Begin" value="{{ old('qty_begin') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Qty in<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty_in" id="qty_in"
                                        placeholder="Masukan Qty in" value="{{ old('qty_in') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Qty out<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty_out" id="qty_out"
                                        placeholder="Masukan Qty out" value="{{ old('qty_out') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Adjust<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="adjust" id="adjust"
                                        placeholder="Masukan Adjust" value="{{ old('adjust') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Qty end<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty_end" id="qty_end"
                                        placeholder="Masukan Qty end" value="{{ old('qty_end') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Remarks<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="remarks" id="remarks"
                                        placeholder="Masukan Remarks" value="{{ old('remarks') }}">
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
        $('#part_no').val('');
        $('#no_urut').val('');
        $('#applicator_no').val('');
        $('#applicator_type').val('');
        $('#applicator_qty').val('');
        $('#kode_tooling_bc').val('');
        $('#part_name').val('');
        $('#asal').val('');
        $('#po').val('');
        $('#po_date').val('');
        $('#rec_date').val('');
        $('#loc_ppti').val('');
        $('#loc_tapc').val('');
        $('#lokasi_hib').val('');
        $('#qty_begin').val('');
        $('#qty_in').val('');
        $('#qty_out').val('');
        $('#adjust').val('');
        $('#qty_end').val('');
        $('#remarks').val('');
        $('.addModal form').attr('action', "{{ url('part/store') }}");
        $('.addModal .modal-title').text('Tambah Part');
        $('.addModal').modal('show');
    });

    // check error
    @if(count($errors))
    $('.addModal').modal('show');
    @endif

    $('.btnEdit').click(function () {

        var id = $(this).attr('data-id');
        var url = "{{ url('part/getdata') }}";

        $('.addModal form').attr('action', "{{ url('part/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                if (data.status == 1) {
                    $('#part_no').val(data.result.part_no);
                    $('#no_urut').val(data.result.no_urut);
                    $('#applicator_no').val(data.result.applicator_no);
                    $('#applicator_type').val(data.result.applicator_type);
                    $('#applicator_qty').val(data.result.applicator_qty);
                    $('#kode_tooling_bc').val(data.result.kode_tooling_bc);
                    $('#part_name').val(data.result.part_name);
                    $('#asal').val(data.result.asal);
                    $('#po').val(data.result.po);
                    $('#po_date').val(data.result.po_date);
                    $('#rec_date').val(data.result.rec_date);
                    $('#loc_ppti').val(data.result.loc_ppti);
                    $('#loc_tapc').val(data.result.loc_tapc);
                    $('#invoice').val(data.result.invoice);
                    $('#lokasi_hib').val(data.result.lokasi_hib);
                    $('#qty_begin').val(data.result.qty_begin);
                    $('#qty_in').val(data.result.qty_in);
                    $('#qty_out').val(data.result.qty_out);
                    $('#adjust').val(data.result.adjust);
                    $('#qty_end').val(data.result.qty_end);
                    $('#remarks').val(data.result.remarks);
                    $('.addModal .modal-title').text('Ubah Part');
                    $('.addModal').modal('show');
                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : Gagal mengambil data');
            }
        });

    });

    $('.btnGenerate').click(function () {

var id = $(this).attr('data-id');
var url = "{{ url('part/getdata') }}";

$('.addModal form').attr('action', "{{ url('part/update') }}" + '/' + id);

$.ajax({
    type: 'GET',
    url: url + '/' + id,
    dataType: 'JSON',
    success: function (data) {
        console.log(data);

        if (data.status == 1) {
            $('#part_no').val(data.result.part_no);
            $('.addModal .modal-title').text('Ubah Part');
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
            part_no: "required",
            no_urut: "required",
            applicator_no: "required",
            applicator_type: "required",
            applicator_qty: "required",
            kode_tooling_bc: "required",
            part_name: "required",
            asal: "required",
            invoice: "required",
            po: "required",
            po_date: "required",
            rec_date: "required",
            loc_ppti: "required",
            loc_tapc: "required",
            lokasi_hib: "required",
            qty_begin: "required",
            qty_in: "required",
            qty_out: "required",
            adjust: "required",
            qty_end: "required",
            remarks: "required",

        },
        messages: {
            part_no: "Part No Tidak Boleh Kosong",
            no_urut: "No Urut Tidak Boleh Kosong",
            applicator_no: "Nomor Applicator Tidak Boleh Kosong",
            applicator_type: "Tipe Apllikator Tidak Boleh Kosong",
            applicator_qty: "Qty Applikator Tidak Boleh Kosong",
            kode_tooling_bc: "Kode Tooling BC Tidak Boleh Kosong",
            part_name: "Part Name Tidak Boleh Kosong",
            asal: "Asal Tidak Boleh Kosong",
            invoice: "Invoice Tidak Boleh Kosong",
            po: "PO Tidak Boleh Kosong",
            po_date: "PO Date Tidak Boleh Kosong",
            rec_date: "Rec Date Tidak Boleh Kosong",
            loc_ppti: "Loc PPTI Tidak Boleh Kosong",
            loc_tapc: "Loc Tapc Tidak Boleh Kosong",
            lokasi_hib: "Loc Hib Tidak Boleh Kosong",
            qty_begin: "Qty Begin Tidak Boleh Kosong",
            qty_in: "Qty In Tidak Boleh Kosong",
            qty_out: "Qty Out Tidak Boleh Kosong",
            adjust: "Adjust Tidak Boleh Kosong",
            qty_end: "Qty End Tidak Boleh Kosong",
            remarks: "Remarks Tidak Boleh Kosong",
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
