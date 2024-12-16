@extends('layouts.app')
@section('title', 'Part Request')

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
                        <h3 class="h3">Part Request - Sparepart Machine</h3>
                        {{ date('Y-m-d') }}
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
            <div class="card-body">
                <a href="createsp/" class="btn btn-success text-white mb-3">
                    <i data-feather="plus" width="16" height="16" class="me-2"></i>
                    Tambah Part Request
                </a>
                <div class="row">
                    <div class="col-md-6">
                        <form method="GET" action="{{ url('partrequest/sp') }}">
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" name="start_date" placeholder="Tanggal Dari" value="{{ request()->get('start_date') }}">
                                <input type="date" class="form-control" name="end_date" placeholder="Tanggal Hingga" value="{{ request()->get('end_date') }}">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Part Request Number</th>
                                <th width="15%">Part Number</th>
                                <th width="15%">Date</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($partrequests) == 0)
                            <tr class="part-row">
                                <td colspan="3" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($partrequests as $partrequest)
                            <tr class="part-row" data-category="{{ $partrequest->part_req_number }}" data-created-at="{{ $partrequest->created_at }}">
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="15%">{{ $partrequest->part_req_number }}</td>
                                <td width="15%">{{ $partrequest->part_no }}</td>
                                <td width="15%">{{ $partrequest->created_at }}</td>
                                <td width="15%">
                                    @if ($partrequest->part_req_id > 0)
                                    {{-- <a href="javascript:void(0)"
                                                        class="btn btn-icon btnEdit btn-warning text-white"
                                                        data-id="{{ $partrequest->part_req_id }}" data-toggle="tooltip"
                                    data-placement="top" title="Ubah">
                                    <i data-feather="edit" width="16" height="16"></i>
                                    </a> --}}
                                    <a href="javascript:void(0)" class="btn btn-icon btn-danger text-white btnDelete" data-url="{{ url('partrequest/sp/delete/' . $partrequest->part_req_id) }}" data-toggle="tooltip" data-placement="top" title="Hapus">
                                        <i data-feather="trash-2" width="16" height="16"></i>
                                    </a>
                                    <a href="gambar/{{ $partrequest->part_req_id }}" class="btn btn-icon btn-info text-white" data-id="{{ $partrequest->part_req_id }}" data-toggle="tooltip" data-placement="top" title="Ubah">
                                        <i data-feather="eye" width="16" height="16"></i>
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

<!-- Modal Add -->
<div class="modal fade addModal" tabindex="-1" role="dialog" style="margin-top: 1%;" id="addModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Part Request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('partrequest/sp/store') }}" method="POST" id="addForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Date <span class="text-danger"></span></label>
                                    <input type="date" class="form-control" value={{ date('Y-m-d') }} name="date" id="date" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Car Model <span class="text-danger">*</span></label>
                                    <select class="form-control" name="car_model" id="car_model">
                                        <option value="">- Pilih Car Model -</option>
                                        @if (sizeof($carlines) > 0)
                                        @foreach ($carlines as $carline)
                                        <option value="{{ $carline->carline_id }}" data-carline-category="{{ $carline->carline_category_id }}">
                                            {{ $carline->carline_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Carline <span class="text-danger">*</span></label>
                                    <select class="form-control" name="carname" id="carname">
                                        <option value="">- Pilih Carline -</option>
                                        @if (sizeof($carnames) > 0)
                                        @foreach ($carnames as $carname)
                                        <option value="{{ $carname->carname_id }}">
                                            {{ $carname->carname_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Shift <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="shift" id="shift">
                                        <option value="">- Pilih Shift -</option>
                                        <option value="A">Shift A</option>
                                        <option value="B">Shift B</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Side No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="side_no" id="side_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Serial No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="serial_no" id="serial_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Applicator No Remarks<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="applicator_no" id="applicator_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine <span class="text-danger">*</span></label>
                                    <select class="form-control" name="machine_id" id="machine_id">
                                        <option value="">- Pilih Machine -</option>
                                        @if (sizeof($machines) > 0)
                                        @foreach ($machines as $machine)
                                        <option value="{{ $machine->machine_id }}" data-machine-name="{{ $machine->machine_name }}" data-machine-number="{{ $machine->machine_no }}">
                                            {{ $machine->machine_no }} - {{ $machine->machine_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part <span class="text-danger">*</span></label>
                                    <select class="form-control" name="part_id" id="part_id">
                                        <option value="">- Pilih Part -</option>
                                        @if (sizeof($parts) > 0)
                                        @foreach ($parts as $part)
                                        <option value="{{ $part->part_id }}" data-part-name="{{ $part->part_name }}" data-part-asal="{{ $part->asal }}" data-part-number="{{ $part->part_no }}">{{ $part->part_no }} -
                                            {{ $part->part_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="machine_name" id="machine_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="machine_no" id="machine_no" readonly>
                                </div>
                            </div>

                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="status" id="status" placeholder="Masukan Status" value="0" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">PIC <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pic" id="pic" placeholder="Masukan Nama">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Alasan <span class="text-danger">*</span></label>
                                    <select class="form-control" name="alasan" id="alasan">
                                        <option value="" disabled selected>- Pilih Alasan -</option>
                                        <option value="Replacement">- Replacement -</option>
                                        <option value="New Project">- New Project -</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Order <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="order" id="order" value="" disabled>
                                </div>
                            </div>

                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Wear and Tear Status <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_status" id="wear_and_tear_status" placeholder="Masukan Wear and Tear Status" value="Open" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_qty" id="part_qty" placeholder="Masukan Part Quantity">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Remarks <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Masukan Remarks" value="{{ old('remarks') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Upload PNG File (Max 2MB) <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="image_part">
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
{{-- Detail Modal --}}
<div class="modal fade detailModal" tabindex="-1" role="dialog" style="margin-top: 1%;" id="detailModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Part Request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('partrequest/sp/store') }}" method="POST" id="addForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Car Model <span class="text-danger">*</span></label>
                                    <select class="form-control" name="car_model" id="car_model">
                                        <option value="">- Pilih Car Model -</option>
                                        @if (sizeof($carlines) > 0)
                                        @foreach ($carlines as $carline)
                                        <option value="{{ $carline->carline_id }}" data-carline-category="{{ $carline->carline_category_id }}">
                                            {{ $carline->carline_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Carline <span class="text-danger">*</span></label>
                                    <select class="form-control" name="carname" id="carname">
                                        <option value="">- Pilih Carline -</option>
                                        @if (sizeof($carlinecategories) > 0)
                                        @foreach ($carlinecategories as $carlinecategory)
                                        <option value="{{ $carlinecategory->carline_category_id }}">
                                            {{ $carlinecategory->carline_category_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Shift <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="shift" id="shift">
                                        <option value="">- Pilih Shift -</option>
                                        <option value="A">Shift A</option>
                                        <option value="B">Shift B</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine <span class="text-danger">*</span></label>
                                    <select class="form-control" name="machine_id" id="machine_id">
                                        <option value="">- Pilih Machine -</option>
                                        @if (sizeof($machines) > 0)
                                        @foreach ($machines as $machine)
                                        <option value="{{ $machine->machine_id }}" data-machine-name="{{ $machine->machine_name }}" data-machine-number="{{ $machine->machine_no }}">
                                            {{ $machine->machine_no }} - {{ $machine->machine_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="machine_name" id="machine_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="machine_no" id="machine_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Stroke <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="stroke" id="stroke" placeholder="Masukan Stroke" value="{{ old('stroke') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part <span class="text-danger">*</span></label>
                                    <select class="form-control" name="part_id" id="part_id">
                                        <option value="">- Pilih Part -</option>
                                        @if (sizeof($parts) > 0)
                                        @foreach ($parts as $part)
                                        <option value="{{ $part->part_id }}" data-part-name="{{ $part->part_name }}" data-part-number="{{ $part->part_no }}">{{ $part->part_no }} -
                                            {{ $part->part_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_name" id="part_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_no" id="part_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_qty" id="part_qty" placeholder="Masukan Part Quantity" value="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Person in Charge <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pic" id="pic" placeholder="Masukan Person in Charge" value="{{ old('pic') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Remarks <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Masukan Remarks" value="{{ old('remarks') }}">
                                </div>
                            </div>
                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="status" id="status" placeholder="Masukan Status" value="0" readonly>
                                </div>
                            </div>
                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Wear and Tear Status <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_status" id="wear_and_tear_status" placeholder="Masukan Wear and Tear Status" value="Open" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Upload PNG File (Max 2MB) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="image_part">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="text-white btn btn-success">Simpan</button>
                    {{-- <input type="file" id="fileInput" style="display: none;" onchange="document.getElementById('submitButton').disabled = false;"> --}}
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->
<!-- Modal Add -->
<div class="modal fade detailModal" tabindex="-1" role="dialog" style="margin-top: 1%;" id="detailModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Part Request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('partrequest/sp/store') }}" method="POST" id="addForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Carline <span class="text-danger">*</span></label>
                                    <select class="form-control" name="carname" id="carname">
                                        <option value="">- Pilih Carline -</option>
                                        @if (sizeof($carlinecategories) > 0)
                                        @foreach ($carlinecategories as $carlinecategory)
                                        <option value="{{ $carlinecategory->carline_category_id }}">
                                            {{ $carlinecategory->carline_category_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Car Model <span class="text-danger">*</span></label>
                                    <select class="form-control" name="car_model" id="car_model">
                                        <option value="">- Pilih Car Model -</option>
                                        @if (sizeof($carlines) > 0)
                                        @foreach ($carlines as $carline)
                                        <option value="{{ $carline->carline_id }}" data-carline-category="{{ $carline->carline_category_id }}">
                                            {{ $carline->carline_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Shift <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="shift" id="shift">
                                        <option value="">- Pilih Shift -</option>
                                        <option value="A">Shift A</option>
                                        <option value="B">Shift B</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine <span class="text-danger">*</span></label>
                                    <select class="form-control" name="machine_id" id="machine_id">
                                        <option value="">- Pilih Machine -</option>
                                        @if (sizeof($machines) > 0)
                                        @foreach ($machines as $machine)
                                        <option value="{{ $machine->machine_id }}" data-machine-name="{{ $machine->machine_name }}" data-machine-number="{{ $machine->machine_no }}">
                                            {{ $machine->machine_no }} - {{ $machine->machine_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="machine_name" id="machine_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="machine_no" id="machine_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Stroke <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="stroke" id="stroke" placeholder="Masukan Stroke" value="{{ old('stroke') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part <span class="text-danger">*</span></label>
                                    <select class="form-control" name="part_id" id="part_id">
                                        <option value="">- Pilih Part -</option>
                                        @if (sizeof($parts) > 0)
                                        @foreach ($parts as $part)
                                        <option value="{{ $part->part_id }}" data-part-name="{{ $part->part_name }}" data-part-number="{{ $part->part_no }}">{{ $part->part_no }} -
                                            {{ $part->part_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_name" id="part_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_no" id="part_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Part Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_qty" id="part_qty" placeholder="Masukan Part Quantity" value="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Person in Charge <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pic" id="pic" placeholder="Masukan Person in Charge" value="{{ old('pic') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Remarks <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Masukan Remarks" value="{{ old('remarks') }}">
                                </div>
                            </div>
                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="status" id="status" placeholder="Masukan Status" value="0" readonly>
                                </div>
                            </div>
                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Wear and Tear Status <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_status" id="wear_and_tear_status" placeholder="Masukan Wear and Tear Status" value="Open" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Upload PNG File (Max 2MB) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="image_part">
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

{{-- Detail Modal --}}
<div class="modal fade detailModal" tabindex="-1" role="dialog" style="margin-top: 1%;" id="detailModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Part Request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('partrequest/sp/store') }}" method="POST" id="addForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Carline <span class="text-danger">*</span></label>
                                    <select class="form-control" name="carname" id="carname">
                                        <option value="">- Pilih Carline -</option>
                                        @if (sizeof($carlinecategories) > 0)
                                        @foreach ($carlinecategories as $carlinecategory)
                                        <option value="{{ $carlinecategory->carline_category_id }}">
                                            {{ $carlinecategory->carline_category_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Car Model <span class="text-danger">*</span></label>
                                    <select class="form-control" name="car_model" id="car_model">
                                        <option value="">- Pilih Car Model -</option>
                                        @if (sizeof($carlines) > 0)
                                        @foreach ($carlines as $carline)
                                        <option value="{{ $carline->carline_id }}" data-carline-category="{{ $carline->carline_category_id }}">
                                            {{ $carline->carline_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Shift <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="shift" id="shift">
                                        <option value="">- Pilih Shift -</option>
                                        <option value="A">Shift A</option>
                                        <option value="B">Shift B</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine <span class="text-danger">*</span></label>
                                    <select class="form-control" name="machine_id" id="machine_id">
                                        <option value="">- Pilih Machine -</option>
                                        @if (sizeof($machines) > 0)
                                        @foreach ($machines as $machine)
                                        <option value="{{ $machine->machine_id }}" data-machine-name="{{ $machine->machine_name }}" data-machine-number="{{ $machine->machine_no }}">
                                            {{ $machine->machine_no }} - {{ $machine->machine_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="machine_name" id="machine_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Machine Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="machine_no" id="machine_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Stroke <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="stroke" id="stroke" placeholder="Masukan Stroke" value="{{ old('stroke') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part <span class="text-danger">*</span></label>
                                    <select class="form-control" name="part_id" id="part_id">
                                        <option value="">- Pilih Part -</option>
                                        @if (sizeof($parts) > 0)
                                        @foreach ($parts as $part)
                                        <option value="{{ $part->part_id }}" data-part-name="{{ $part->part_name }}" data-part-number="{{ $part->part_no }}">{{ $part->part_no }} -
                                            {{ $part->part_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_name" id="part_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Part Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_no" id="part_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Part Quantity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="part_qty" id="part_qty" placeholder="Masukan Part Quantity" value="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Person in Charge <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pic" id="pic" placeholder="Masukan Person in Charge" value="{{ old('pic') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Remarks <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Masukan Remarks" value="{{ old('remarks') }}">
                                </div>
                            </div>
                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="status" id="status" placeholder="Masukan Status" value="0" readonly>
                                </div>
                            </div>
                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Wear and Tear Status <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_status" id="wear_and_tear_status" placeholder="Masukan Wear and Tear Status" value="Open" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Upload PNG File (Max 2MB) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="image_part">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="text-white btn btn-success">Simpan</button>
                    {{-- <input type="file" id="fileInput" style="display: none;" onchange="document.getElementById('submitButton').disabled = false;"> --}}
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->
<!-- Modal Add -->
<div class="modal fade detailModal" tabindex="-1" role="dialog" style="margin-top: 1%;" id="detailModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Part Request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('partrequest/sp/store') }}" method="POST" id="addForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Carline <span class="text-danger">*</span></label>
                                    <select class="form-control" name="carname" id="carname">
                                        <option value="">- Pilih Carline -</option>
                                        @if (sizeof($carlinecategories) > 0)
                                        @foreach ($carlinecategories as $carlinecategory)
                                        <option value="{{ $carlinecategory->carline_category_id }}">
                                            {{ $carlinecategory->carline_category_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Car Model <span class="text-danger">*</span></label>
                                    <select class="form-control" name="car_model" id="car_model">
                                        <option value="">- Pilih Car Model -</option>
                                        @if (sizeof($carlines) > 0)
                                        @foreach ($carlines as $carline)
                                        <option value="{{ $carline->carline_id }}" data-carline-category="{{ $carline->carline_category_id }}">
                                            {{ $carline->carline_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Alasan <span class="text-danger">*</span></label>
                                    <select class="form-control" name="alasan" id="alasan">
                                        <option value="">Pilih Alasan</option>
                                        <option value="Option1">Cacat</option>
                                        <option value="Option2">Caulking</option>
                                        <option value="Option3">Scratch</option>
                                        <option value="Option4">Other</option>
                                    </select>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6" id="otherReasonDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Alasan lainnya</label>
                                    <input type="text" class="form-control" name="other_reason" id="other_reason" placeholder="Masukkan alasan">
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6">
                                <div class="form-group" hidden>
                                    <label class="form-label">Order <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="order" id="order"
                                        placeholder="Masukan Order" value="{{ old('order') }}">
                        </div>
                    </div> --}}

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Shift <span class="text-danger">*</span> </label>
                            <select class="form-control" name="shift" id="shift">
                                <option value="">- Pilih Shift -</option>
                                <option value="A">Shift A</option>
                                <option value="B">Shift B</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Machine <span class="text-danger">*</span></label>
                            <select class="form-control" name="machine_id" id="machine_id">
                                <option value="">- Pilih Machine -</option>
                                @if (sizeof($machines) > 0)
                                @foreach ($machines as $machine)
                                <option value="{{ $machine->machine_id }}" data-machine-name="{{ $machine->machine_name }}" data-machine-number="{{ $machine->machine_no }}">
                                    {{ $machine->machine_no }} - {{ $machine->machine_name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Machine Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="machine_name" id="machine_name" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Machine Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="machine_no" id="machine_no" readonly>
                        </div>
                    </div>
                    {{-- <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Serial Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="serial_no" id="serial_no"
                                        placeholder="Masukan Serial Number" value="{{ old('serial_no') }}">
                </div>
        </div> --}}
        {{-- <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Applicator Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="applicator_no" id="applicator_no"
                                        placeholder="Masukan Applicator Number" value="{{ old('applicator_no') }}">
    </div>
</div>
<div class="col-md-6" hidden>
    <div class="form-group">
        <label class="form-label">Wear and Tear Code <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="wear_and_tear_code" id="wear_and_tear_code" placeholder="Masukan Wear and Tear Code" value="{{ old('wear_and_tear_code') }}">
    </div>
</div>
<div class="col-md-6" hidden>
    <div class="form-group">
        <label class="form-label">Side Number <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="side_no" id="side_no" placeholder="Masukan Side Number" value="{{ old('side_no') }}">
    </div>
</div> --}}
<div class="col-md-6">
    <div class="form-group">
        <label class="form-label">Stroke <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="stroke" id="stroke" placeholder="Masukan Stroke" value="{{ old('stroke') }}">
    </div>
</div>
{{-- <div class="col-md-6">
                                <div class="form-group" hidden>
                                    <label class="form-label">Order <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="order" id="order"
                                        placeholder="Masukan Order" value="{{ old('order') }}">
</div>
</div> --}}
<div class="col-md-6">
    <div class="form-group">
        <label class="form-label">Part <span class="text-danger">*</span></label>
        <select class="form-control" name="part_id" id="part_id">
            <option value="">- Pilih Part -</option>
            @if (sizeof($parts) > 0)
            @foreach ($parts as $part)
            <option value="{{ $part->part_id }}" data-part-name="{{ $part->part_name }}" data-part-number="{{ $part->part_no }}">{{ $part->part_no }} -
                {{ $part->part_name }}
            </option>
            @endforeach
            @endif
        </select>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label class="form-label">Part Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="part_name" id="part_name" readonly>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label class="form-label">Part Number <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="part_no" id="part_no" readonly>
    </div>
</div>
<div class="col-md-6" hidden>
    <div class="form-group">
        <label class="form-label">Part Quantity <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="part_qty" id="part_qty" placeholder="Masukan Part Quantity" value="1">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label class="form-label">Person in Charge <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="pic" id="pic" placeholder="Masukan Person in Charge" value="{{ old('pic') }}">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label class="form-label">Remarks <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Masukan Remarks" value="{{ old('remarks') }}">
    </div>
</div>
<div class="col-md-6" hidden>
    <div class="form-group">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="status" id="status" placeholder="Masukan Status" value="0" readonly>
    </div>
</div>
<div class="col-md-6" hidden>
    <div class="form-group">
        <label class="form-label">Wear and Tear Status <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="wear_and_tear_status" id="wear_and_tear_status" placeholder="Masukan Wear and Tear Status" value="Open" readonly>
    </div>
</div>
{{-- <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="form-label">Anvil <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="anvil" id="anvil"
                                        placeholder="Masukan Anvil" value="{{ old('anvil') }}">
</div>
</div>
<div class="col-md-6" hidden>
    <div class="form-group">
        <label class="form-label">Approved By <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="approved_by" id="approved_by" placeholder="Masukan Approved" value="-">
    </div>
</div>
<div class="col-md-6" hidden>
    <div class="form-group">
        <label class="form-label">Insulation Crimper <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="insulation_crimper" id="insulation_crimper" placeholder="Masukan Insulation Crimper" value="{{ old('insulation_crimper') }}">
    </div>
</div>
<div class="col-md-6" hidden>
    <div class="form-group">
        <label class="form-label">Wire Crimper <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="wire_crimper" id="wire_crimper" placeholder="Masukan Wire Crimper" value="{{ old('wire_crimper') }}">
    </div>
</div>
<div class="col-md-6" hidden>
    <div class="form-group">
        <label class="form-label">Other <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="other" id="other" placeholder="Masukan Other" value="{{ old('other') }}">
    </div>
</div> --}}
{{-- <div class="col-md-6"hidden>
                                <div class="form-group">
                                    <label class="form-label">Wear and Tear Status <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="wear_and_tear_status" id="wear_and_tear_status"
                                        placeholder="Masukan Wear and Tear Status" value="Open">
                                </div>
                            </div> --}}
</div>
</div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label class="form-label">Upload PNG File (Max 2MB) <span class="text-danger">*</span></label>
        <input type="file" class="form-control" name="image_part">
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Batal</button>
    <button type="submit" class="text-white btn btn-success">Simpan</button>
    {{-- <input type="file" id="fileInput" style="display: none;" onchange="document.getElementById('submitButton').disabled = false;"> --}}
</div>
</form>
</div>
</div>
</div>
<!-- Modal Add -->
<div class="modal fade viewModal" tabindex="-1" role="dialog" style="margin-top: 1%;" id="viewModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Gambar</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('partrequest/sp/store') }}" method="POST" id="addForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">

                        </div>
                    </div>
                </div>

                <div class="col-md-12 d-flex justify-content-center">
                    <div class="form-group">
                        <div id="view_image"></div>
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
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#part_id').select2({
            placeholder: "- Pilih Part -",
            allowClear: true // Untuk membolehkan pengguna menghapus pilihan yang sudah dipilih
        });

        // Fungsi pencarian saat pengguna mengetik di input
        $('#part_id').on('select2:open', function(e) {
            $('.select2-search__field').attr('placeholder', 'Cari Part...');
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#carname').select2({
            placeholder: "- Pilih Car -",
            allowClear: true // Untuk membolehkan pengguna menghapus pilihan yang sudah dipilih
        });

        // Fungsi pencarian saat pengguna mengetik di input
        $('#carname').on('select2:open', function(e) {
            $('.select2-search__field').attr('placeholder', 'Cari Car...');
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#car_model').select2({
            placeholder: "- Pilih Model -",
            allowClear: true // Untuk membolehkan pengguna menghapus pilihan yang sudah dipilih
        });

        // Fungsi pencarian saat pengguna mengetik di input
        $('#car_model').on('select2:open', function(e) {
            $('.select2-search__field').attr('placeholder', 'Cari Model...');
        });
    });
</script>
<script type="text/javascript">
    $('.btnAdd').click(function() {
        $('#part_req_number').val('');
        $('#carname').val('');
        $('#car_model').val('');
        $('#alasan').val('');
        $('#order').val('');
        $('#shift').val('');
        $('#machine_no').val('');
        $('#applicator_no').val('');
        $('#part_req_pic_filenames').val('');
        $('#part_req_pic_paths').val('');
        $('#image_part').val('');
        $('#wear_and_tear_code').val('');
        $('#wear_and_tear_status').val('Open');
        $('#serial_no').val('');
        $('#part_id').val('');
        $('#status').val('0');
        $('#side_no').val('');
        $('#stroke').val('');
        $('#pic').val('');
        $('#part_qty').val('');
        $('#remarks').val('');
        $('#part_no').val('');
        $('#anvil').val('');
        $('#insulation_crimper').val('');
        $('#has_sto');
        $('#wire_crimper').val('');
        $('#other').val('');
        $('.addModal form').attr('action', "{{ url('partrequest/sp/store') }}");
        $('.addModal .modal-title').text('Tambah Part Request - Sparepart Machine');
        $('.addModal').modal('show');
    })
    // check error
    @if(count($errors))
    $('.addModal').modal('show');
    @endif

    $('.btnEdit').click(function() {

        var id = $(this).attr('data-id');
        var url = "{{ url('partrequest/getdata') }}";

        $('.detailModal form').attr('action', "{{ url('partrequest/sp/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function(data) {
                console.log(data);

                if (data.status == 1) {
                    $('#part_req_number').val(data.result.part_req_number);
                    $('#carname').val(data.result.carname);
                    $('#car_model').val(data.result.car_model);
                    $('#alasan').val(data.result.alasan);
                    $('#order').val(data.result.order);
                    $('#shift').val(data.result.shift);
                    $('#machine_no').val(data.result.machine_no);
                    $('#machine_name').val(data.result.machine_name);
                    $('#applicator_no').val(data.result.applicator_no);
                    $('#wear_and_tear_code').val(data.result.wear_and_tear_code);
                    $('#wear_and_tear_status').val(data.result.wear_and_tear_status);
                    $('#serial_no').val(data.result.serial_no);
                    $('#side_no').val(data.result.side_no);
                    $('#stroke').val(data.result.stroke);
                    $('#part_req_pic_filenames').val(data.result.part_req_pic_filenames);
                    $('#part_req_pic_paths').val(data.result.part_req_pic_paths);
                    $('#pic').val(data.result.pic);
                    $('#part_id').val(data.result.part_id);
                    $('#image_part').val(data.result.image_part);
                    $('#remarks').val(data.result.remarks);
                    $('#part_qty').val(data.result.part_qty);
                    $('#part_name').val(data.result.part_name);
                    $('#status').val(data.result.status);
                    $('#approved_by').val(data.result.approved_by);
                    $('#part_no').val(data.result.part_no);
                    $('.addModal .modal-title').text('Ubah Part Request');
                    $('.addModal').modal('show');
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : Gagal mengambil data');
            }
        });

    });

    $('.btnView').click(function() {

        var id = $(this).attr('data-id');
        var url = "{{ url('partrequest/sp/getdata') }}";


        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function(data) {
                console.log(data);

                if (data.status == 1) {
                    $('.viewModal .modal-title').text('Detail Gambar');
                    $('.viewModal').modal('show');

                    document.getElementById('view_image').innerHTML =
                        `<img src="/storage/${data.result.part_req_pic_path}${data.result.part_req_pic_filename}" alt="" width="200">`

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

    $('#detailModal').on('hidden.bs.modal', function(e) {
        // You can save the form values in localStorage
        localStorage.setItem('car_model', $('#car_model').val());
        localStorage.setItem('carname', $('#carname').val());
        localStorage.setItem('part_id', $('#part_id').val());
        localStorage.setItem('part_no', $('#part_no').val());
        localStorage.setItem('shift', $('#shift').val());
        localStorage.setItem('machine_name', $('#machine_name').val());
        localStorage.setItem('machine_no', $('#machine_no').val());
        localStorage.setItem('machine_id', $('#machine_id').val());
        localStorage.setItem('stroke', $('#stroke').val());
        localStorage.setItem('pic', $('#pic').val());
        localStorage.setItem('remarks', $('#remarks').val());
    });

    // Function to resp/store form values when modal is shown
    $('#detailModal').on('shown.bs.modal', function(e) {
        // Retrieve the saved values from localStorage and set them in the form fields
        $('#car_model').val(localStorage.getItem('car_model'));
        $('#carname').val(localStorage.getItem('carname'));
        $('#shift').val(localStorage.getItem('shift'));
        $('#machine_id').val(localStorage.getItem('machine_id'));
        $('#stroke').val(localStorage.getItem('stroke'));
        $('#part_id').val(localStorage.getItem('part_id'));
        $('#machine_name').val(localStorage.getItem('machine_name'));
        $('#part_no').val(localStorage.getItem('part_no'));
        $('#machine_no').val(localStorage.getItem('machine_no'));
        $('#pic').val(localStorage.getItem('pic'));
        $('#remarks').val(localStorage.getItem('remarks'));
    });

    // Clear the saved values when the form is submitted
    $('#addForm').on('submit', function(e) {
        localStorage.clear();
    });


    $("#addForm").validate({
        rules: {
            module_name: "required",
        },
        messages: {
            module_name: "Modul tidak boleh kosong",
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

    $('.addRow').on('click', function(event) {
        event.preventDefault();
        addRow();
    });

    function addRow() {
        var tr = '<tr>' +
            '<tr>' +
            '<td>' +
            '<select class="form-control" name="carname[]" id="carname">' +
            '<option value="">- Pilih Carline -</option>' +
            '@if (sizeof($carnames) > 0)' +
            '@foreach ($carnames as $carname)' +
            '<option value="{{ $carname->carname_id }}">' +
            '{{ $carname->carname_name }}</option>' +
            '@endforeach' +
            '@endif' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select class="form-control" name="car_model[]" id="car_model">' +
            '<option value="">- Pilih Car Model -</option>' +
            '@if (sizeof($carlines) > 0)' +
            '@foreach ($carlines as $carline)' +
            '<option value="{{ $carline->carline_id }}"' +
            'data-carline-category="{{ $carline->carline_category_id }}">' +
            '{{ $carline->carline_name }}</option>' +
            '@endforeach' +
            '@endif' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select class="form-control" name="shift[]" id="shift">' +
            '<option value="">- Pilih Shift -</option>' +
            '<option value="A">Shift A</option>' +
            '<option value="B">Shift B</option>' +
            '</select>' +
            '</td>' +
            '<td><input type="text" name="machine_no[]" placeholder="machine no" class="form-control" value="{{ old('
        machine_no ') }}"></td>' +
            '<td><input type="text" name="stroke[]" placeholder="stroke" class="form-control" value="{{ old('
        stroke ') }}"></td>' +
            '<td>' +
            '<select class="form-control" name="part_id[]" id="part_id">' +
            '<option value="">- Pilih Part -</option>' +
            '@if (sizeof($parts) > 0)' +
            '@foreach ($parts as $part)' +
            '<option value="{{ $part->part_id }}"' +
            'data-part-name="{{ $part->part_name }}"' +
            'data-part-number="{{ $part->part_no }}">{{ $part->part_no }} -' +
            '{{ $part->part_name }}</option>' +
            '@endforeach' +
            '@endif' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select class="form-control" name="alasan[]" id="alasan">' +
            '<option value=""disabled selected>- Pilih Alasan -</option>' +
            '<option value="New Project">- New Project -</option>' +
            '<option value="Replacement">- Replacement -</option>' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select class="form-control" name="order[]" id="order">' +
            '<option value=""disabled selected>- Pilih Order -</option>' +
            '<option value="Lokal"> Lokal </option>' +
            '<option value="Import"> Import </option>' +
            '</select>' +
            '</td>' +
            '<td><input type="text" name="part_no[]" placeholder="part no" class="form-control" value="{{ old('
        part_no ') }}"></td>' +
            '<td><input type="number" name="part_qty[]" placeholder="Jumlah" class="form-control" value="{{ old('
        part_qty ') }}"></td>' +
            '<td><input type="text" name="pic[]" placeholder="pic" class="form-control" value="{{ old('
        pic ') }}"></td>' +
            '<td><input type="text" name="remarks[]" placeholder="remarks" class="form-control" value="{{ old('
        remarks ') }}"></td>' +
            '<td><input type="text" name="wear_and_tear_status[]" hidden placeholder="wt status" class="form-control" value="Open"></td>' +
            '<td><input type="file" name="image_part[]" placeholder="wt status" class="form-control" value="{{ old('
        image_part ') }}"></td>' +
            '<td><a href="#" class="btn btn-danger remove">-</a></td>' +
            '</tr>';
        $('.table-body1').append(tr);
    };
    $('.table-body1').on('click', '.remove', function(event) {
        event.preventDefault();
        $(this).parent().parent().remove();
    });
</script>

<script>
    // JavaScript code to update the "Car Model" dropdown based on the selected "Carline"
    document.getElementById("carname").addEventListener("change", function() {
        var selectedCarlineCategory = this.value;
        var carlineDropdown = document.getElementById("car_model");

        // Reset the "Car Model" dropdown
        carlineDropdown.innerHTML = '<option value="">- Pilih Car Model -</option>';

        // Filter and add options based on the selected "Carline Category"
        @foreach($carlines as $carline)
        if ({
                {
                    $carline - > carline_category_id
                }
            } == selectedCarlineCategory) {
            var option = document.createElement("option");
            option.value = {
                {
                    $carline - > carline_id
                }
            };
            option.textContent = "{{ $carline->carline_name }}";
            carlineDropdown.appendChild(option);
        }
        @endforeach
    });
</script>

<script>
    // JavaScript code to populate Part Name and Part Number based on the selected Part
    document.getElementById("part_id").addEventListener("change", function() {
        var selectedOption = this.options[this.selectedIndex];
        var partNameInput = document.getElementById("part_name");
        var partNoInput = document.getElementById("part_no");

        // Check if a valid option is selected
        if (selectedOption.value !== "") {
            // Get the data attributes from the selected option
            var partName = selectedOption.getAttribute("data-part-name");
            var partNumber = selectedOption.getAttribute("data-part-number");

            // Set the values in the input fields
            partNameInput.value = partName;
            partNoInput.value = partNumber;
        } else {
            // Clear the input fields if no option is selected
            partNameInput.value = "";
            partNoInput.value = "";
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Inisialisasi select2 untuk machine_id
        $('#machine_id').select2({
            placeholder: "- Pilih Machine -",
            allowClear: true // Untuk membolehkan pengguna menghapus pilihan yang sudah dipilih
        });

        // Fungsi pencarian saat pengguna mengetik di input
        $('#machine_id').on('select2:open', function(e) {
            $('.select2-search__field').attr('placeholder', 'Cari Machine...');
        });

        // Event listener untuk mengupdate Machine Name dan Machine Number
        $('#machine_id').on('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var machineNameInput = document.getElementById("machine_name");
            var machineNoInput = document.getElementById("machine_no");

            // Check if a valid option is selected
            if (selectedOption.value !== "") {
                // Get the data attributes from the selected option
                var machineName = selectedOption.getAttribute("data-machine-name");
                var machineNumber = selectedOption.getAttribute("data-machine-number");

                // Set the values in the input fields
                machineNameInput.value = machineName;
                machineNoInput.value = machineNumber;
            } else {
                // Clear the input fields if no option is selected
                machineNameInput.value = "";
                machineNoInput.value = "";
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#table-data').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false, // Disable DataTables search
            "ordering": true,
            "info": true,
            "autoWidth": false
        });

        // Add event listeners to the date range input fields
        $('#start_date, #end_date').on('change', function() {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();

            // Iterate through each row
            table.rows().every(function() {
                var row = this.node();
                var rowData = this.data();

                // Get the date column value (adjust the index accordingly)
                var dateValue = rowData[2]; // Assuming the date is in the third column

                // Check if the date is within the selected range
                if (isDateInRange(dateValue, startDate, endDate)) {
                    $(row).show(); // Show the row
                } else {
                    $(row).hide(); // Hide the row
                }
            });
        });

        // Function to check if a date is within a given range
        function isDateInRange(dateStr, start, end) {
            var date = new Date(dateStr);
            var startDate = new Date(start);
            var endDate = new Date(end);

            return date >= startDate && date <= endDate;
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Add change event listener to the dropdown
        $('#part_id').change(function() {
            // Get the selected part number from the data attribute
            var selectedPartNumber = $(this).find(':selected').data('part-asal');

            // Update the value of the order input field
            $('#order').val(selectedPartNumber);
        });
    });
</script>
@endsection