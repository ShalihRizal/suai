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
                                    <th width="15%">Lokasi</th>
                                    <th width="15%">Wear And Tear Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($notifications) == 0)
                                    <tr>
                                        <td colspan="4" align="center">Data kosong</td>
                                    </tr>
                                @else
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td width="5%">{{ $loop->iteration }}</td>
                                            <td width="20%">{{ $notification->part_req_number }}</td>
                                            <td width="20%">{{ $notification->pic }}</td>
                                            <td width="20%">{{ $notification->part_no }}</td>
                                            <td width="15%">{{ $notification->part_qty }}</td>
                                            <td width="15%">{{ $notification->loc_ppti }}</td>
                                            <td width="15%">{{ $notification->wear_and_tear_status }}</td>
                                            <td width="15%"><a href="javascript:void(0)"
                                                    class="btn btn-icon btnEdit btn-warning text-white"
                                                    data-id="{{ $notification->part_req_id }}" data-toggle="tooltip"
                                                    data-placement="top" title="Approve">
                                                    <i data-feather="check" width="16" height="16"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-icon btnDetail btn-success text-white"
                                                    data-id="{{ $notification->part_req_id }}" data-toggle="tooltip"
                                                    data-placement="top" title="Approve">
                                                    <i data-feather="list" width="16" height="16"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                </table>
            </div>
        </div>

    </div>
    </div>
    </div>
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
                                    <label class="form-label">Part Req Number <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="part_req_number" id="part_req_number"
                                        placeholder="Masukan Approved" value="part_req_number" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Person In Charge <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="pic" id="pic"
                                        placeholder="Masukan Insulation Crimper" value="pic" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part Qty <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="part_qty" id="part_qty"
                                        placeholder="Masukan Part Qty" value="part_qty" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part Number <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="part_no" id="part_no"
                                        placeholder="Masukan Part Number" value="part_no" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part Name <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="part_name" id="part_name"
                                        placeholder="Masukan Part Name" value="part_name" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Lokasi <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="loc_ppti" id="loc_ppti"
                                        placeholder="Masukan Lokasi" value="loc_ppti" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Carline<span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="car_model" id="car_model"
                                            placeholder="Masukan Variable" value="car_model" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Alasan<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="alasan" id="alasan"
                                        placeholder="Masukan Variable" value="alasan" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Serial No<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="serial_no" id="serial_no"
                                        placeholder="Masukan Variable" value="serial_no" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Side No<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="side_no" id="side_no"
                                        placeholder="Masukan Variable" value="side_no" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part Applicator No<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="part_applicator_no"
                                        id="part_applicator_no" placeholder="Masukan Variable" value="part_applicator_no"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part Request Applicator No<span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="part_request_applicator_no"
                                        id="part_request_applicator_no" placeholder="Masukan Variable"
                                        value="part_request_applicator_no" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Order<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="order" id="order"
                                        placeholder="Masukan Variable" value="order" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Shift<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="shift" id="shift"
                                        placeholder="Masukan Variable" value="shift" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Machine No<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="machine_no" id="machine_no"
                                        placeholder="Masukan Variable" value="machine_no" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Wear and Tear Code<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_code"
                                        id="wear_and_tear_code" placeholder="Masukan Variable" value="wear_and_tear_code"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Stroke<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="stroke" id="stroke"
                                        placeholder="Masukan Variable" value="stroke" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Remarks<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="remarks" id="remarks"
                                        placeholder="Masukan Variable" value="remarks" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Status<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="status" id="status"
                                        placeholder="Masukan Variable" value="status" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Wear and Tear Status<span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_status"
                                        id="wear_and_tear_status" placeholder="Masukan Variable"
                                        value="wear_and_tear_status" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Part Picture <span class="text-danger"></span></label>
                                    <img id="part_req_pic" src="" alt="Part Picture" style="width: 100%; height: auto;">
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

    <!-- Modal Add -->
    <div class="modal fade addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve?</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ url('notification/store') }}" method="POST" id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Approved By <span class="text-danger"></span></label>
                                    <select class="form-control" name="approved_by" id="approved_by">
                                        <option value="" disableld selected>- Pilih Approved By -</option>
                                        @if (sizeof($users) > 0)
                                            @foreach ($users as $user)
                                                @if ($user->group_id == 11)
                                                    <option value="{{ $user->user_id }}">{{ $user->user_name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" hidden>
                                    <label class="form-label">Status<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_status"
                                        id="wear_and_tear_status" value="On Progres">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" hidden>
                                    <label class="form-label">Status<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="status" id="status"
                                        value="1">
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



@endsection

@section('script')
    <script type="text/javascript">
        $('.btnEdit').click(function() {

            var id = $(this).attr('data-id');
            var url = "{{ url('notification/getdata') }}";

            $('.addModal form').attr('action', "{{ url('notification/update') }}" + '/' + id);

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
                        $('#wear_and_tear_status').val();
                        $('#part_name').val(data.result.part_name);
                        $('#part_qty').val(data.result.part_qty);
                        $('.addModal .modal-title').text('Approve');
                        $('.addModal').modal('show');
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Error : Gagal mengambil data');
                }
            });

        });
    </script>

<script>
    $('.btnDetail').click(function() {

        var id = $(this).attr('data-id');
        var url = "{{ url('notification/getdata') }}";

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function(data) {
                console.log(data);

                if (data.status == 1) {
                    $('#part_req_number').val(data.result.part_req_number);
                    $('#carname').val(data.result.carname);
                    $('#loc_ppti').val(data.result.loc_ppti);
                    $('#alasan').val(data.result.alasan);
                    $('#order').val(data.result.order);
                    $('#part_name').val(data.result.part_name);
                    $('#car_model').val(data.result.carline_name);
                    $('#alasan').val(data.result.alasan);
                    $('#order').val(data.result.order);
                    $('#shift').val(data.result.shift);
                    $('#part_applicator_no').val(data.result.part_applicator_no);
                    $('#part_request_applicator_no').val(data.result.part_request_applicator_no);
                    $('#machine_no').val(data.result.machine_no);
                    $('#wear_and_tear_code').val(data.result.wear_and_tear_code);
                    $('#stroke').val(data.result.stroke);
                    $('#serial_no').val(data.result.serial_no);
                    $('#side_no').val(data.result.side_no);
                    $('#pic').val(data.result.pic);
                    $('#remarks').val(data.result.part_request_remarks);
                    $('#part_qty').val(data.result.part_qty);
                    $('#status').val(data.result.status);
                    $('#approved_by').val(data.result.approved_by);
                    $('#part_no').val(data.result.part_no);
                    $('#wear_and_tear_status').val(data.result.wear_and_tear_status);

                    // Update the image source
                    var imgPath = data.result.part_req_pic_path;
                    var imgFilename = data.result.part_req_pic_filename;
                    var imgUrl = "/storage/"+imgPath + '/' + imgFilename;
                    $('#part_req_pic').attr('src', imgUrl);

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
