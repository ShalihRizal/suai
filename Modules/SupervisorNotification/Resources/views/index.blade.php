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
                        {{ date('Y-m-d') }}
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
                                <!-- <th width="20%">Waktu</th> -->
                                <th width="20%">Tanggal</th>
                                <th width="20%">PIC</th>
                                <th width="20%">Approved By</th>
                                <th width="20%">Part Number</th>
                                <th width="15%">Part Quantity</th>
                                <th width="15%">Lokasi PPTI</th>
                                <th width="15%">Lokasi HIB</th>
                                <th width="15%">Lokasi TAPC</th>
                                <th width="15%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($supervisornotifications) == 0)
                            <tr>
                                <td colspan="4" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($supervisornotifications as $notification)
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="20%">{{ $notification->part_req_number }}</td>
                                <!-- <td width="20%">{{ Str::substr($notification->created_at, 10, 18) }}</td> -->
                                <td width="20%">{{ $notification->created_at }}</td>
                                <td width="20%">{{ $notification->pic }}</td>
                                <td width="20%">{{ $notification->user_name }}</td>
                                <td width="20%">{{ $notification->part_no }}</td>
                                <td width="15%">{{ $notification->part_qty }}</td>
                                <td width="15%">{{ $notification->loc_ppti }}</td>
                                <td width="15%">{{ $notification->lokasi_hib }}</td>
                                <td width="15%">{{ $notification->loc_tapc }}</td>
                                <td width="15%">{{ $notification->wear_and_tear_status }}</td>
                                <td width="15%">
                                    @if ($notification->part_req_id > 0)
                                    <a href="javascript:void(0)"
                                        class="btn btn-icon btnDetail btn-success text-white"
                                        data-id="{{ $notification->part_req_id }}" data-toggle="tooltip"
                                        data-placement="top" title="Approve">
                                        <i data-feather="camera" width="16" height="16"></i>
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


<!-- Modal Details -->
<div class="modal detailModal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="detailForm" method="POST" action="{{ url('supervisornotification/update') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part Req Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_req_number"
                                        id="part_req_number" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Lokasi PPTI<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="loc_ppti" id="loc_ppti" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Lokasi TAPC<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="loc_tapc" id="loc_tapc" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Lokasi HIB<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="lokasi_hib" id="lokasi_hib" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Out To <span class="text-danger">*</span></label>
                                    <select class="form-control" name="kategori_inventory" id="tabDropdown">
                                        <option value="" disabled selected>- Out To -</option>
                                        <option value="Expense">Expense</option>
                                        <option value="CIP">CIP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_no" id="part_no">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label"> ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="id" id="id">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="text-white btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Details -->



@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#part_no').keypress(function(event) {
            if (event.which === 13) {
                event.preventDefault();
                yourCustomFunction();
            }
        });
    });

    function yourCustomFunction() {
        var url = "{{ url('partrequest/getdata') }}";
        var id = $('#id').val();

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function(data) {
                console.log(data);

                if (data.status == 1) {
                    var inputValue = $('#part_no').val();
                    var expectedValue = data.result.part_no;

                    if (inputValue === expectedValue) {
                        $('#kategori_inventory').val(data.result.kategori_inventory);
                        $('#status').val('Closed');
                        $('#part_req_number').val(data.result.part_req_number);
                        $('#pic').val(data.result.pic);
                        $('#part_name').val(data.result.part_name);
                        $('#part_no').val(data.result.part_no);
                        $('#loc_tapc').val(data.result.loc_tapc);
                        $('#lokasi_hib').val(data.result.lokasi_hib);
                        $('#loc_ppti').val(data.result.loc_ppti);
                        $('#part_qty').val(data.result.part_qty);
                        $('.detailModal form').attr('action', "{{ url('supervisornotification/update') }}" + '/' + id);
                        alert('Berhasil');
                    } else {
                        $('#part_no').val(data.result.part_no);
                        alert('Part Tidak Sesuai dengan yang di-Request');
                    }
                } else {
                    alert('Gagal mendapatkan data atau data tidak ditemukan');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert('Error: Gagal mengambil data atau terjadi kesalahan server');
            }
        });
    }
</script>


<script type="text/javascript">
    $('.btnDetail').click(function() {

        var id = $(this).attr('data-id');
        var url = "{{ url('partrequest/getdata') }}";

        $('.detailModal form').attr('action', "{{ url('supervisornotification/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function(data) {
                console.log(data);

                if (data.status == 1) {
                    $('#part_req_number').val(data.result.part_req_number);
                    $('#pic').val(data.result.pic);
                    $('#part_name').val(data.result.part_name);
                    $('#part_no').val('');
                    $('#id').val(data.result.part_req_id);
                    $('#loc_ppti').val(data.result.loc_ppti);
                    $('#lokasi_hib').val(data.result.lokasi_hib);
                    $('#loc_tapc').val(data.result.loc_tapc);
                    $('#part_qty').val(data.result.part_qty);
                    $('#kategori_inventory').val(data.result.kategori_inventory);
                    $('.detailModal .modal-title').text('Details');
                    $('.detailModal').modal('show');
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : Gagal mengambil data');
            }
        });

    });
</script>
@endsection