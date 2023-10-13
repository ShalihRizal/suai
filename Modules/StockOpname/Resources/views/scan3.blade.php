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
                </div>
            </div>
            <div class="card-body">
                <div class="addData">
                    <div class="btn-group" style="height: 40px;">
                        {{-- Your Blade view content --}}
                        <a href="javascript:void(0)" class="btn btn-success btnAdd text-white mb-3" style="height: 100%;" data-toggle="modal" data-target="#uploadModal">
                            <i data-feather="plus" width="20" height="13" class="me-2"></i>
                            Upload
                        </a>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control" name="car_model" id="tabDropdown" style="height: 100%; margin-left: 25px;">
                                    <option value="">- Semua Rak -</option>
                                    @if(sizeof($racks) > 0)
                                        @foreach($racks as $rack)
                                            <option value="{{ $rack->rack_name }}">{{ $rack->rack_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div colspan="4" align="center">ㅤ</div>
                <div class="table-responsive">
                    <table id="table-data" class="table card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Part Name</th>
                                <th width="15%">Part Number</th>
                                <th width="20%">Stock</th>
                                <th width="10%">Lokasi</th>
                                <th width="15%">Last STO</th>
                                <th width="20%">QR Code</th>
                            </tr>
                        </thead>
                        <tbody id="part-table-body"> <!-- Add an id to the tbody -->
                            @if (sizeof($parts) == 0)
                                <!-- No data message -->
                                <tr>
                                    <td colspan="4" align="center">Data kosong</td>
                                </tr>
                            @else
                                @foreach ($parts as $part)
                                    <tr class="part-row" data-category="{{ $part->loc_ppti }}"> <!-- Add a class and data-category attribute -->
                                        <td width="5%">{{ $loop->iteration }}</td>
                                        <td width="20%">{{ $part->part_name }}</td>
                                        <td width="15%">{{ $part->part_no }}</td>
                                        <td width="20%">{{ $part->qty_end }}</td>
                                        <td width="10%">{{ $part->loc_tapc }}</td>
                                        <td width="15%">{{ $part->last_sto }}</td>
                                        <td width="20%">{{ QrCode::size(150)->generate($part->part_id)}}</td>
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

{{-- Modal --}}
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Your file upload form can go here --}}
                <form>
                    <div class="form-group">
                        <label for="fileInput">Choose a file:</label>
                        <input type="file" class="form-control-file" id="fileInput">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Upload</button>
            </div>
        </div>
    </div>
</div>

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
        $('#part_category_id').val('');
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
                    $('#part_category_id').val(data.result.part_category_id);
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // Event listener for dropdown change
        $('#tabDropdown').change(function () {
            var selectedCategory = $(this).val(); // Get the selected category

            if (selectedCategory === "") {
                // Show all rows if "Pilih Part Category" is selected
                $('.part-row').show();
            } else {
                // Hide all rows and then show only the rows with the selected category
                $('.part-row').hide();
                $('.part-row[data-category="' + selectedCategory + '"]').show();
            }
        });
    });
</script>
@endsection
