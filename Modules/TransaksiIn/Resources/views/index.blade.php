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
                        <h3 class="h3">Transaksi IN</h3>
                        {{ date('Y-m-d') }}
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
            <div class="card-body">
                <a href="javascript:void(0)" class="btn btn-success btnAdd text-white mb-3">
                    <i data-feather="plus" width="16" height="16" class="me-2"></i>
                    Tambah Transaksi IN
                </a>
                <a href="javascript:void(0)" class="btn btn-success btnUpload text-white mb-3" style="height: 100%;" data-toggle="modal" data-target="#uploadModal">
                    <i data-feather="plus" width="16" height="16" class="me-2"></i>
                    Upload
                </a>
                <a href="{{ route('downloadtemplate') }}" class="btn btn-info text-white mb-3">
                    <i data-feather="download" width="16" height="16" class="me-2"></i> Download
                </a>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                    </div>
                </div>

                <a href="javascript:void(0)" class="btn btn-success btnFilter text-white mb-3">
                    <i data-feather="plus" width="16" height="16" class="me-2"></i>
                    Filter
                </a>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="part_category_filter">Filter by Part Category:</label>
                        <select class="form-control" id="part_category_filter" name="part_category_filter">
                            <option value="">All</option>
                            @foreach ($partcategories as $partCategory)
                            <option value="{{ $partCategory->part_category_name }}">
                                {{ $partCategory->part_category_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="1%">ID</th>
                                <th width="5%">Nomor Invoice</th>
                                <th width="5%">Po Number</th>
                                <th width="5%">PO Date</th>
                                <th width="5%">Part No Urut</th>
                                <th width="5%">Part Name</th>
                                <th hidden width="5%">Part Category</th>
                                <th width="5%">Molts No</th>
                                <th width="5%">Price</th>
                                <th width="5%">Part No</th>
                                <th width="5%">Qty</th>
                                <th width="5%">Loc PPTI</th>
                                <th width="5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="part-table-body">
                            @if (sizeof($transaksiins) == 0)
                            <tr>
                                <td colspan="3" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($transaksiins as $transaksiin)
                            <tr class="part-row" data-category="{{ $transaksiin->part_category_name }}" data-created-at="{{ $transaksiin->transaksi_created_at }}">
                                <td width="1%">{{ $loop->iteration }}</td>
                                <td width="5%">{{ $transaksiin->transaksi_in_id }}</td>
                                <td width="5%">{{ $transaksiin->invoice_no }}</td>
                                <td width="5%">{{ $transaksiin->po_no }}</td>
                                <td width="5%">{{ $transaksiin->po_date2 }}</td>
                                <td width="5%">{{ $transaksiin->part_no }}.{{ $transaksiin->no_urut }}</td>
                                <td width="5%">{{ $transaksiin->part_name }}</td>
                                <td hidden width="5%">{{ $transaksiin->part_category_name }}</td>
                                <td width="5%">{{ $transaksiin->molts_no }}</td>
                                <td width="5%">${{ $transaksiin->price2 }}</td>
                                <td width="5%">{{ $transaksiin->part_no }}</td>
                                <td width="5%">{{ $transaksiin->qty2 }}</td>
                                <!-- <td width="5%">{{ $transaksiin->qty_end }}</td> -->
                                <td width="5%">{{ $transaksiin->loc_ppti }}</td>
                                <td hidden width="5%">{{ $transaksiin->transaksi_created_at }}</td>
                                <td width="5%">
                                    @if ($transaksiin->transaksi_in_id > 0)
                                    <a href="javascript:void(0)" class="btn btn-icon btnEdit btn-warning text-white" data-id="{{ $transaksiin->transaksi_in_id }}" data-toggle="tooltip" data-placement="top" title="Ubah">
                                        <i data-feather="edit" width="16" height="16"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-icon btn-danger text-white btnDelete" data-url="{{ url('transaksiin/delete/' . $transaksiin->transaksi_in_id) }}" data-toggle="tooltip" data-placement="top" title="Hapus">
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
                <a href="javascript:void(0)" class="btn btn-success text-white mb-3" style="width: 175px" id="printButton">
                    <i data-feather="printer" class="me-2"></i>
                    Print/Save
                </a>
                <a href="{{ url('transaksiin/download-data') }}" class="btn btn-info text-white mb-3" style="width: 175px">
                    <i data-feather="download" class="me-2"></i>
                    Download Data
                </a>
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
            <form action="{{ url('transaksiin/store') }}" method="POST" id="addForm">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Sub Rak <span class="text-danger">*</span> </label>
                                    <br>
                                    <select class="form-control select2" name="rack_name" id="rack_name" style="width: 100%;">
                                        <option value="">- Pilih Sub Rak -</option>
                                        @if (sizeof($subracks) > 0)
                                        @foreach ($subracks as $subrack)
                                        <option value="{{ $subrack->sub_rack_id }}">{{ $subrack->rack_name }}.{{ $subrack->sub_rack_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Invoice Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="invoice_no" id="invoice_no" placeholder="Masukan Invoice Number" value="{{ old('invoice_no') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">PO Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="po_no" id="po_no" placeholder="Masukan PO Number" value="{{ old('po_no') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">PO Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="po_date" id="po_date" placeholder="Masukan PO Date" value="{{ old('po_date') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Receive Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="rec_date" id="rec_date" placeholder="Masukan Receive Date" value="{{ old('rec_date') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty" id="qty" placeholder="Masukan Quantity" value="{{ old('qty') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part <span class="text-danger">*</span></label>
                                    <div class="addData">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <select class="form-control" name="part_id" id="part_id" style="width: 100%;">
                                                    <option value="">- Pilih Part -</option>
                                                    @if (sizeof($parts) > 0)
                                                    @foreach ($parts as $part)
                                                    <option value="{{ $part->part_id }}">
                                                        {{ $part->part_name }} - {{ $part->part_no }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="ml-3">
                                                <a href="{{ url('part') }}" class="btn btn-success btnAdd text-white">
                                                    <i data-feather="plus" width="16" height="16" class="me-2"></i>
                                                    Tambah Part Baru
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Price | <span class="text-danger" style="font-size: 75%;">USD</span></label>
                                    <input type="text" class="form-control" name="price" id="price" placeholder="Masukan Price" value="{{ old('price') }}">
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


<!-- Modal Upload -->
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
                <form action="{{ url('transaksiin/create') }}" method="POST" id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="form-group">
                                    <label for="fileinput">Choose a file:</label>
                                    <input type="file" class="form-control-file" id="fileinput" name="file">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="text-white btn btn-success btnUpload">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Upload -->
@endsection

@section('script')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $('.btnAdd').click(function() {
        $('#invoice_no').val('');
        $('#ata_suai').val('');
        $('#po_no').val('');
        $('#po_date').val('');
        $('#rec_date').val('');
        $('#no_urut').val('');
        $('#part_name').val('');
        $('#molts_no').val('');
        $('#part_no').val('');
        $('#price').val('');
        $('#qty').val('');
        $('#loc_hib').val('');
        $('#loc_ppti').val('');
        $('#qty_end').val('');
        $('.addModal form').attr('action', "{{ url('transaksiin/store') }}");
        $('.addModal .modal-title').text('Tambah Transaksi');
        $('.addModal').modal('show');
    });

    // check error
    @if(count($errors))
    $('.addModal').modal('show');
    @endif

    $('.btnEdit').click(function() {

        var id = $(this).attr('data-id');
        var url = "{{ url('transaksiin/getdata') }}";

        $('.addModal form').attr('action', "{{ url('transaksiin/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function(data) {
                console.log(data);

                if (data.status == 1) {
                    $('#invoice_no').val(data.result.invoice_no);
                    $('#ata_suai').val(data.result.ata_suai);
                    $('#po_no').val(data.result.po_no);
                    $('#po_date').val(data.result.po_date);
                    $('#rec_date').val(data.result.rec_date);
                    $('#no_urut').val(data.result.no_urut);
                    $('#part_name').val(data.result.part_name);
                    $('#molts_no').val(data.result.molts_no);
                    $('#part_no').val(data.result.part_no);
                    $('#price').val(data.result.price);
                    $('#qty').val(data.result.qty);
                    $('#loc_hib').val(data.result.loc_hib);
                    $('#loc_ppti').val(data.result.loc_ppti);
                    $('#qty_end').val(data.result.qty_end);
                    $('.addModal .modal-title').text('Ubah Transaksi');
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

    document.querySelector('.btnFilter').addEventListener('click', function() {
        const startDate = new Date(document.getElementById('start_date').value);
        const endDate = new Date(document.getElementById('end_date').value);
        const rows = document.querySelectorAll('.part-row');

        rows.forEach(function(row) {
            const createdAt = new Date(row.getAttribute('data-created-at'));

            if (
                (!startDate || createdAt >= startDate) &&
                (!endDate || createdAt <= endDate)
            ) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<script>
    function downloadFile() {
        // URL file yang ingin didownload
        var fileUrl = 'https://drive.google.com/uc?id=17tmgUGRcHoQgitv1Bbng8FENvd7jLb6U';

        // Nama file yang ingin ditampilkan saat diunduh
        var fileName = 'Template Transaksi';

        // Membuat elemen <a> untuk mendownload file
        var link = document.createElement('a');
        link.href = fileUrl;
        link.download = fileName;

        // Menambahkan elemen <a> ke dalam dokumen
        document.body.appendChild(link);

        // Simulasi klik pada elemen <a> untuk memulai proses unduhan
        link.click();

        // Menghapus elemen <a> setelah proses unduhan selesai
        document.body.removeChild(link);
    }
</script>
<script>
    $(document).ready(function() {
        $('#part_id').select2({
            placeholder: "- Pilih Part -",
            allowClear: true
        });
    });
</script>


<script>
    document.getElementById("printButton").addEventListener("click", function() {
        // Buka jendela baru untuk mencetak
        var newWindow = window.open("", "", "width=800,height=600");
        newWindow.document.write("<html><head><title>Transaksi In</title></head><body>");
        newWindow.document.write("<style>@page { size: landscape; }</style>");

        // Tabel header
        newWindow.document.write("<table border='1' style='width:100%;'><thead><tr>");
        newWindow.document.write("<th>No</th>");
        newWindow.document.write("<th width='20%'>Nomor Invoice</th>"); <
        !-- < th width = '20%' > ATA SUAI < /th> -->
        newWindow.document.write("<th width='20%'>Po Number</th>");
        newWindow.document.write("<th width='20%'>PO Date</th>"); <
        !-- < th width = '20%' > No.Urut < /th> -->
        newWindow.document.write("<th width='20%'>Part No Urut</th>");
        newWindow.document.write("<th width='20%'>Part Name</th>");
        newWindow.document.write("<th width='20%'>Molts No</th>");
        newWindow.document.write("<th width='20%'>Price</th>");
        newWindow.document.write("<th width='20%'>Part No</th>");
        newWindow.document.write("<th width='20%'>Qty</th>");
        newWindow.document.write("<th width='20%'>Loc Hib</th>");
        newWindow.document.write("<th width='20%'>Loc PPTI</th>");
        newWindow.document.write("</tr></thead><tbody>");

        // Masukkan data dari Blade template ke dalam tabel
        @foreach($transaksiins as $transaksiin)
        newWindow.document.write("<tr>");
        newWindow.document.write("<td>{{ $loop->iteration }}</td>");
        newWindow.document.write("<td>{{ $transaksiin->invoice_no }}</td>"); <
        !-- < td > {
            {
                $transaksiin - > ata_suai
            }
        } < /td> -->
        newWindow.document.write("<td>{{ $transaksiin->po_no }}</td>");
        newWindow.document.write("<td>{{ $transaksiin->po_date }}</td>"); <
        !-- < td > {
            {
                $transaksiin - > no_urut
            }
        } < /td> -->
        newWindow.document.write("<td>{{ $transaksiin->part_no }}{{ $transaksiin->no_urut }}</td>");
        newWindow.document.write("<td>{{ $transaksiin->part_name }}</td>");
        newWindow.document.write("<td>{{ $transaksiin->molts_no }}</td>");
        newWindow.document.write("<td>{{ $transaksiin->price }}</td>");
        newWindow.document.write("<td>{{ $transaksiin->part_no }}</td>");
        newWindow.document.write("<td>{{ $transaksiin->qty_end }}</td>");
        newWindow.document.write("<td>{{ $transaksiin->lokasi_hib }}</td>");
        newWindow.document.write("<td>{{ $transaksiin->loc_ppti }}</td>");
        newWindow.document.write("</tr>");
        @endforeach

        newWindow.document.write("</tbody></table>");
        newWindow.document.write("</body></html>");
        newWindow.print();
        newWindow.close();
    });
</script>

<script>
    $(document).ready(function() {
        // Function to filter table rows based on selected category
        function filterTableByCategory(category) {
            // Show all rows initially
            $(".part-row").show()

            // Hide rows that don't match the selected category
            if (category !== "") {
                $(".part-row").not("[data-category='" + category + "']").hide();
            }
        }

        // Event handler for dropdown change
        $("#part_category_filter").on("change", function() {
            var selectedCategory = $(this).val();
            filterTableByCategory(selectedCategory);
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk dropdown Sub Rak
        $('#rack_name').select2({
            placeholder: "- Pilih Sub Rak -",
            allowClear: true
        });

        // Inisialisasi Select2 untuk dropdown Part
        $('#part_id').select2({
            placeholder: "- Pilih Part -",
            allowClear: true
        });
    });
</script>



@endsection
