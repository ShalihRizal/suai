@extends('layouts.app')
@section('title', 'Part Consumption List')

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
                            <h3 class="h3">Part Consumption List || Detail</h3>
                            {{ date('Y-m-d') }}
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap table-data">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="5%">End Drawing</th>
                                    <th width="5%">No.Accessories</th>
                                    <th width="5%">Part Name</th>
                                    <th width="5%">Part No</th>
                                    <th width="5%">Type</th>
                                    <th width="5%">Tiang</th>
                                    <th width="5%">Qty Per J/B</th>
                                    <th width="5%">Qty Total</th>
                                    <th width="5%">Molts No</th>
                                    <th width="5%">Status</th>
                                    <th width="5%">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($partconsumptionlistsdetails) == 0)
                                    <tr>
                                        <td colspan="3" align="center">Data kosong</td>
                                    </tr>
                                @else
                                    @foreach ($partconsumptionlistsdetails as $partconsumptionlistsdetail)
                                        <tr class="part-row">
                                            <td width="5%">{{ $loop->iteration }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->end_drawing }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->no_accessories }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->part_name }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->part_no }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->type }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->tiang }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->qty_per_jb }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->qty_total }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->molts_no }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->status }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->remarks }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-2">
                        <form action="{{ url('partconsumptionlist/upload/' . $partconsumptionlists->pcl_id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Upload <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="csv" id="csv">
                            </div>
                            <button type="submit" class="btn btn-success mb-3" style="width: 175px">
                                <i data-feather="upload" class="me-2"></i>
                                Upload & Import
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
