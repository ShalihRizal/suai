@extends('layouts.app')
@section('title', 'Transaksi In')

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
                        <h3 class="h3">Transaksi OUT</h3>
                        {{ date('Y-m-d') }}
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- <div class="addData"> --}}
                <a href="javascript:void(0)" class="btn btn-success btnAdd text-white mb-3">
                    <i data-feather="plus" width="16" height="16" class="me-2"></i>
                    Tambah Transaksi OUT
                </a>
                {{-- </div> --}}

                <div class="table-responsive">
                    <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nomor Invoice</th>
                                <th width="20%">Part Number</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($transaksiouts) == 0)
                            <tr>
                                <td colspan="3" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($transaksiouts as $transaksiout)
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="20%">{{ $transaksiout->invoice_no }}</td>
                                {{-- <td width="20%">{{ $part->part_no }}</td> --}}
                                <td width="15%">
                                    @if($transaksiout->transaksi_in_id > 0)
                                    <a href="javascript:void(0)" class="btn btn-icon btnEdit btn-warning text-white"
                                        data-id="{{ $transaksiout->transaksi_in_id }}" data-toggle="tooltip" data-placement="top"
                                        title="Ubah">
                                        <i data-feather="edit" width="16" height="16"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-icon btn-danger text-white btnDelete"
                                        data-url="{{ url('transaksiout/delete/'. $transaksiout->transaksi_in_id) }}"
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
                <h5 class="modal-title">Tambah Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('transaksiout/store') }}" method="POST" id="addForm">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Sub Rak <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="invoice_no" id="invoice_no"
                                        placeholder="Masukan Sub Rak" value="{{ old('invoice_no') }}">
                                </div>
                            </div>
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
                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="po_no" id="po_no"
                                        placeholder="Masukan Quantity" value="{{ old('po_no') }}">
                                </div>
                            </div>
                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Tanggal PO <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="po_date" id="po_date"
                                        placeholder="Masukan Tanggal PO" value="{{ old('po_date') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Nomor Urut <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="no_urut" id="no_urut"
                                        placeholder="Masukan Nomor Urut" value="{{ old('no_urut') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_name" id="part_name"
                                        placeholder="Masukan Part Name" value="{{ old('part_name') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_no" id="part_no"
                                        placeholder="Masukan Part No" value="{{ old('part_no') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty" id="qty"
                                        placeholder="Masukan Quantity" value="{{ old('qty') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Loc Hib <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="loc_hib" id="loc_hib"
                                        placeholder="Masukan Loc Hib" value="{{ old('loc_hib') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Loc PPTI <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="loc_ppti" id="loc_ppti"
                                        placeholder="Masukan Loc PPTI" value="{{ old('loc_ppti') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Quantity End <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty_end" id="qty_end"
                                        placeholder="Masukan Quantity End" value="{{ old('qty_end') }}">
                                </div>
                            </div> --}}
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
        $('#invoice_no').val('');
        $('#ata_suai').val('');
        $('#po_no').val('');
        $('#po_date').val('');
        $('#no_urut').val('');
        $('#part_name').val('');
        $('#molts_no').val('');
        $('#part_no').val('');
        $('#qty').val('');
        $('#loc_hib').val('');
        $('#loc_ppti').val('');
        $('#qty_end').val('');
        $('.addModal form').attr('action', "{{ url('transaksiout/store') }}");
        $('.addModal .modal-title').text('Tambah Transaksi');
        $('.addModal').modal('show');
    });

    // check error
    @if(count($errors))
    $('.addModal').modal('show');
    @endif

    $('.btnEdit').click(function () {

        var id = $(this).attr('data-id');
        var url = "{{ url('transaksiout/getdata') }}";

        $('.addModal form').attr('action', "{{ url('transaksiout/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                if (data.status == 1) {
                    $('#invoice_no').val(data.result.invoice_no);
                    $('#ata_suai').val(data.result.ata_suai);
                    $('#po_no').val(data.result.po_no);
                    $('#po_date').val(data.result.po_date);
                    $('#no_urut').val(data.result.no_urut);
                    $('#part_name').val(data.result.part_name);
                    $('#molts_no').val(data.result.molts_no);
                    $('#part_no').val(data.result.part_no);
                    $('#qty').val(data.result.qty);
                    $('#loc_hib').val(data.result.loc_hib);
                    $('#loc_ppti').val(data.result.loc_ppti);
                    $('#qty_end').val(data.result.qty_end);
                    $('#module_name').val(data.result.module_name);
                    $('.addModal .modal-title').text('Ubah Transaksi');
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
            invoice_no: "required",
            ata_suai: "required",
            po_no: "required",
            po_date: "required",
            no_urut: "required",
            part_name: "required",
            molts_no: "required",
            part_no: "required",
            qty: "required",
            loc_hib: "required",
            loc_ppti: "required",
            qty_end: "required"
        },
        messages: {
            invoice_no: "Invoice No Tidak Boleh Kosong",
            ata_suai: "Ata Suai Tidak Boleh Kosong",
            po_no: "PO No Tidak Boleh Kosong",
            po_date: "PO Date Tidak Boleh Kosong",
            no_urut: "No Urut Tidak Boleh Kosong",
            part_name: "Part Name Tidak Boleh Kosong",
            molts_no: "Molts No Tidak Boleh Kosong",
            part_no: "Part No Tidak Boleh Kosong",
            qty: "Qty Tidak Boleh Kosong",
            loc_hib: "Loc HIB Tidak Boleh Kosong",
            loc_ppti: "Loc PPTI Tidak Boleh Kosong",
            qty_end: "Qty End Tidak Boleh Kosong",
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

<script>
    function playaudio(){
        docwnent.getElementById( "audio").play();
    }
</script>
@endsection
