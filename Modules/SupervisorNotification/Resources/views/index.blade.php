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
                                    <th width="20%">PIC</th>
                                    <th width="20%">Part Number</th>
                                    <th width="15%">Part Quantity</th>
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
                                            <td width="20%">{{ $notification->pic }}</td>
                                            <td width="20%">{{ $notification->part_no }}</td>
                                            <td width="15%">{{ $notification->part_qty }}</td>
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

    <!-- Modal Add -->
    <div class="modal fade addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve?</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ url('supervisornotifications/store') }}" method="POST" id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Approved By <span class="text-danger">*</span></label>
                                    <select class="form-control" name="approved_by" id="approved_by">
                                        <option value="">- Pilih Approved By -</option>
                                        @if (sizeof($users) > 0)
                                            @foreach ($users as $user)
                                                @if ($user->group_id == 7)
                                                    <option value="{{ $user->user_id }}">{{ $user->user_name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
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

    <!-- Modal Details -->
    <div class="modal detailModal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part Req Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_req_number"
                                        id="part_req_number" value="part_req_number"readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Details -->



@endsection

@section('script')
    <script type="text/javascript">
        $('.btnEdit').click(function() {

            var id = $(this).attr('data-id');
            var url = "{{ url('supervisornotifications/getdata') }}";

            $('.addModal form').attr('action', "{{ url('supervisornotifications/update') }}" + '/' + id);

            $.ajax({
                type: 'GET',
                url: url + '/' + id,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);

                    if (data.status == 1) {
                        $('#part_req_id').val(data.result.part_req_id);
                        $('#part_req_number').val(data.result.part_req_number);
                        $('#pic').val(data.result.pic);
                        $('#part_name').val(data.result.part_name);
                        $('#part_no').val(data.result.part_no);
                        $('#part_qty').val(data.result.part_qty);
                        $('#loc_tapc').val(data.result.loc_tapc);
                        $('.addModal .modal-title').text('Approve');
                        $('.addModal').modal('show');
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Error : Gagal mengambil data');
                }
            });

        });

        $('.btnAdd').click(function() {

            $('.addModal .modal-title').text('Approve');
            $('.addModal').modal('show');

        });

        $('.btnDetail').click(function() {

            var id = $(this).attr('data-id');
            var url = "{{ url('supervisornotifications/getdata') }}";

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
                        $('#part_no').val(data.result.part_no);
                        $('#loc_tapc').val(data.result.loc_tapc);
                        $('#part_qty').val(data.result.part_qty);
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
