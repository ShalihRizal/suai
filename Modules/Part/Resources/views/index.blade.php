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
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Kategori Part Inventory</h3>
                        <h3 class="h5">All Part</h5>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                        {{ date('Y-m-d') }}
                    </div>
                    <div class="col-md-6 text-end">
                        <!-- Tambahkan tombol download di sini -->

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="addData d-flex gap-3">
                    <a href="javascript:void(0)" class="btn btn-success btnAdd text-white" data-toggle="modal"
                        data-target=".addModal">
                        <i data-feather="plus" width="16" height="16" class="me-2"></i>
                        Tambah Part
                    </a>
                    <label for="">ㅤ</label>
                    <div class="btn-group ms-2">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i data-feather="download" width="16" height="16" class="me-2"></i>
                            Download Data
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('part.download') }}">Semua Data</a>
                            @foreach ($partcategories as $category)
                            <a class="dropdown-item"
                                href="{{ route('part.download', ['category' => $category->part_category_id]) }}">
                                {{ $category->part_category_name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Part No</th>
                                <th>Part Name</th>
                                <th>Lokasi PPTI</th>
                                <th>Lokasi HIB</th>
                                <th>Lokasi TAPC</th>
                                <th>Begin</th>
                                <th>Qty In</th>
                                <th>Qty Out</th>
                                <th>Qty STO</th>
                                <th>Qty End</th>
                                <th>used date</th>
                                <th>rcv date</th>
                                <th>Status</th>
                                <th>Safety Stock</th>
                                <th>ROP</th>
                                <th>Forecast</th>
                                <th>Max</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
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
<!-- ============================================================== -->
<!-- End Container fluid  -->

<!-- Modal Add -->
<div class="modal fade addModal" tabindex="-1" role="dialog" style="margin-top: 1%;">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Part No<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_no" id="part_no"
                                        placeholder="Masukan Part No" value="{{ old('part_no') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Part Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_name" id="part_name"
                                        placeholder="Masukan Part Name" value="{{ old('part_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part Category <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control" name="part_category_id" id="part_category_id">
                                        <option value="">- Pilih Part Category -</option>
                                        @if (sizeof($partcategories) > 0)
                                        @foreach ($partcategories as $partcategory)
                                        <option value="{{ $partcategory->part_category_id }}">
                                            {{ $partcategory->part_category_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3" hidden>
                                <div class="form-group">
                                    <label class="form-label">No Urut<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="no_urut" id="no_urut"
                                        placeholder="Masukan No Urut" value="{{ old('no_urut') }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3" hidden>
                                <div class="form-group">
                                    <label class="form-label">No Urut<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="has_sto" id="has_sto"
                                        placeholder="Masukan No Urut" value="no" disabled>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">No Applicator<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="applicator_no"
                                        id="applicator_no" placeholder="Masukan No Applicator"
                                        value="{{ old('applicator_no') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Tipe Applicator<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="applicator_type"
                                        id="applicator_type" placeholder="Masukan Tipe Applicator"
                                        value="{{ old('applicator_type') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Molts Number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="molts_no" id="molts_no"
                                        placeholder="Masukan Molts Number" value="{{ old('molts_no') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Kuantitas Applicator<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="applicator_qty"
                                        id="applicator_qty" placeholder="Masukan Kuantitas Applicator"
                                        value="{{ old('applicator_qty') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Kode Tooling BC<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="kode_tooling_bc"
                                        id="kode_tooling_bc" placeholder="Masukan Kode Tooling BC"
                                        value="{{ old('kode_tooling_bc') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Asal <span class="text-danger">*</span></label>
                                    <select class="form-control" name="asal" id="asal">
                                        <option value="">Pilih Asal</option>
                                        <option value="Lokal"
                                            {{ old('asal') == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                                        <option value="Import"
                                            {{ old('asal') == 'Import' ? 'selected' : '' }}>Import
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Invoice<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="invoice" id="invoice"
                                        placeholder="Masukan Invoice" value="{{ old('invoice') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">PO<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="po" id="po"
                                        placeholder="Masukan PO" value="{{ old('po') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">PO Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="po_date" id="po_date"
                                        placeholder="Masukan PO Date" value="{{ old('po_date') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Rec Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="rec_date" id="rec_date"
                                        placeholder="Masukan Rec Date" value="{{ old('rec_date') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Use Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="used_date" id="used_date"
                                        placeholder="Masukan Use Date" value="{{ old('used_date') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Rcv Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="rcv_date" id="rcv_date"
                                        placeholder="Masukan Rcv Date" value="{{ old('rcv_date') }}">
                                </div>
                            </div>

                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Loc TAPC <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="loc_tapc" id="loc_tapc">
                                        <option value="">- Pilih Loc TAPC -</option>
                                        @if (sizeof($racks) > 0)
                                        @foreach ($racks as $rack)
                                        <option value="{{ $rack->rack_name }}">{{ $rack->rack_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Rak <span class="text-danger">*</span></label>
                                    <select class="form-control" name="rack" id="rack">
                                        <option value="">- Pilih Rak -</option>
                                        @if (sizeof($racks) > 0)
                                        @foreach ($racks as $rack)
                                        <option value="{{ $rack->rack_id }}">{{ $rack->rack_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Sub Rak <span class="text-danger">*</span></label>
                                    <select class="form-control" name="subrack" id="sub_rack">
                                        <option value="">- Pilih Sub Rak -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Loc Hib <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="lokasi_hib" id="lokasi_hib">
                                        <option value="">- Pilih Loc Hib -</option>
                                        @if (sizeof($racks) > 0)
                                        @foreach ($racks as $rack)
                                        <option value="{{ $rack->rack_name }}">{{ $rack->rack_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Qty Begin<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty_begin" id="qty_begin"
                                        placeholder="Masukan Qty Begin" value="{{ old('qty_begin') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Qty in<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty_in" id="qty_in"
                                        placeholder="Masukan Qty in" value="{{ old('qty_in') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Qty out<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty_out" id="qty_out"
                                        placeholder="Masukan Qty out" value="{{ old('qty_out') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Adjust<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="adjust" id="adjust"
                                        placeholder="Masukan Adjust" value="{{ old('adjust') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Qty end<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="qty_end" id="qty_end"
                                        placeholder="Masukan Qty end" value="{{ old('qty_end') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
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
    $(document).ready(function() {
        // Server-side DataTable
        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('part/datatable') }}",
                data: function(d) {
                    // No category filter for 'all' view
                }
            },
            columns: [
                { data: null, orderable: false, searchable: false, render: function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } },
                { data: 'part_id' },
                { data: 'part_no' },
                { data: 'part_name' },
                { data: 'loc_ppti', defaultContent: '' },
                { data: 'lokasi_hib', defaultContent: '' },
                { data: 'loc_tapc', defaultContent: '' },
                { data: 'qty_begin', defaultContent: '0' },
                { data: 'qty_in', defaultContent: '0' },
                { data: 'qty_out', defaultContent: '0' },
                { data: 'adjust', defaultContent: '0' },
                { data: 'qty_end_calc', defaultContent: '0' },
                { data: 'used_date', defaultContent: '-' },
                { data: 'rcv_date', defaultContent: '-' },
                { data: 'inventory_status', defaultContent: '' },
                { data: 'ss', defaultContent: '' },
                { data: 'rop', defaultContent: '' },
                { data: 'forecast', defaultContent: '' },
                { data: 'max', defaultContent: '' },
                { data: null, orderable: false, searchable: false, render: function(data) {
                    if (data.part_id > 0) {
                        return '<a href="javascript:void(0)" class="btn btn-icon btnEdit btn-warning text-white" data-toggle="modal" data-target=".addModal" data-id="' + data.part_id + '" title="Ubah"><i data-feather="edit" width="16" height="16"></i></a> ' +
                               '<a href="javascript:void(0)" class="btn btn-icon btn-danger text-white btnDelete" data-url="{{ url("part/delete") }}/' + data.part_id + '" title="Hapus"><i data-feather="trash-2" width="16" height="16"></i></a>';
                    }
                    return '';
                }}
            ],
            pageLength: 25,
            order: [[1, 'asc']],
            language: {
                processing: "Memuat data...",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Data kosong",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                search: "Cari:",
                paginate: { first: "Pertama", last: "Terakhir", next: "›", previous: "‹" }
            },
            drawCallback: function() {
                if (typeof feather !== 'undefined') feather.replace();

                // Rebind edit buttons
                $('.btnEdit').off('click').on('click', function() {
                    var id = $(this).attr('data-id');
                    var url = "{{ url('part/getdata') }}";
                    $('.addModal form').attr('action', "{{ url('part/update') }}" + '/' + id);
                    $.ajax({
                        type: 'GET', url: url + '/' + id, dataType: 'JSON',
                        success: function(data) {
                            if (data.status == 1) {
                                $('#part_no').val(data.result.part_no);
                                $('#no_urut').val(data.result.no_urut);
                                $('#applicator_no').val(data.result.applicator_no);
                                $('#applicator_type').val(data.result.applicator_type);
                                $('#applicator_qty').val(data.result.applicator_qty);
                                $('#kode_tooling_bc').val(data.result.kode_tooling_bc);
                                $('#part_name').val(data.result.part_name);
                                $('#molts_no').val(data.result.molts_no);
                                $('#asal').val(data.result.asal);
                                $('#po').val(data.result.po);
                                $('#po_date').val(data.result.po_date);
                                $('#rec_date').val(data.result.rec_date);
                                $('#used_date').val(data.result.used_date);
                                $('#rcv_date').val(data.result.rcv_date);
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
                        error: function() { alert('Error : Gagal mengambil data'); }
                    });
                });

                // Rebind delete buttons
                $('.btnDelete').off('click').on('click', function() {
                    var url = $(this).attr('data-url');
                    Swal.fire({
                        title: 'Apakah anda yakin ingin menghapus data?',
                        text: "Kamu tidak akan bisa mengembalikan data ini setelah dihapus!",
                        icon: 'warning', showCancelButton: true,
                        confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya. Hapus'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'GET', url: url,
                                success: function() {
                                    Swal.fire('Terhapus!', 'Data Berhasil Dihapus.', 'success').then(() => { table.ajax.reload(); });
                                },
                                error: function() { Swal.fire('Gagal!', 'Gagal menghapus data.', 'error'); }
                            });
                        }
                    });
                });
            }
        });

        // Add button
        $('.btnAdd').click(function() {
            $('#addForm')[0].reset();
            $('#part_category_id').val('');
            $('.addModal form').attr('action', "{{ url('part/store') }}");
            $('.addModal .modal-title').text('Tambah Part');
            $('.addModal').modal('show');
        });

        // Store the subrack data
        const subracks = @json($subrack);

        // Select2 for Rak
        $('#rack').select2({
            placeholder: "- Pilih Rak -", allowClear: true, width: '100%',
            dropdownParent: $('.addModal'),
            language: { noResults: function() { return "Tidak ada hasil"; }, searching: function() { return "Mencari..."; } }
        });

        // Select2 for Sub Rak
        $('#sub_rack').select2({
            placeholder: "- Pilih Sub Rak -", allowClear: true, width: '100%',
            dropdownParent: $('.addModal'),
            language: { noResults: function() { return "Tidak ada hasil"; }, searching: function() { return "Mencari..."; } }
        });

        // Rack change -> filter sub racks
        $('#rack').on('change', function() {
            const selectedRackId = this.value;
            const subRackDropdown = $('#sub_rack');
            subRackDropdown.empty().append('<option value="">- Pilih Sub Rak -</option>');
            subracks.forEach(subrack => {
                if (subrack.rack_id == selectedRackId) {
                    subRackDropdown.append(new Option(`${subrack.rack_name}.${subrack.sub_rack_name}`, subrack.sub_rack_id, false, false));
                }
            });
            subRackDropdown.trigger('change');
        });

        // Check errors
        @if(count($errors))
        $('.addModal').modal('show');
        @endif

        // Notification
        var notyf = new Notyf({ duration: 5000, position: { x: 'right', y: 'top' } });
        var msg = $('#msgId').html();
        if (msg !== undefined) { notyf.success(msg); }
    });
</script>
@endsection
