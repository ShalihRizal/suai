@extends('layouts.app')
@section('title', 'Role')

@section('nav')
<div class="row align-items-center">
    <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
            Hak Akses
        </div>
        <h2 class="page-title">
            Role
        </h2>
    </div>
    <!-- Page title actions -->
    <div class="col-auto ms-auto d-print-none">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                <li class="breadcrumb-item"><a href="{{ url('') }}"><i data-feather="home" class="breadcrumb-item-icon"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Hak Akses</a></li>
                <li class="breadcrumb-item active" aria-current="page">Role</li>
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
<!-- basic table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                @if (session('message'))
                    <strong id="msgId" hidden>{{ session('message') }}</strong>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Role</h3>
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
                                <th width="80%">Grup</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($groups) == 0)
                            <tr>
                                <td colspan="3" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($groups as $group)
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="80%">{{ $group->group_name }}</td>
                                <td width="15%">
                                    <a href="{{ url('sysrole/edit/'. $group->group_id ) }}" class="text-white btn btn-warning btn-icon btnEdit" data-toggle="tooltip" data-placement="top" title="Ubah">
                                        <i data-feather="edit" width="16" height="16"></i>
                                    </a>
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
{{-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif
<div class="table-responsive">
    <table id="table-data" class="table table-striped table-bordered no-wrap">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="80%">Grup</th>
                <th width="15%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (sizeof($groups) == 0)
            <tr>
                <td colspan="3" align="center">Data kosong</td>
            </tr>
            @else
            @foreach ($groups as $group)
            <tr>
                <td width="5%">{{ $loop->iteration }}</td>
                <td width="80%">{{ $group->group_name }}</td>
                <td width="15%">
                    <a href="{{ url('sysrole/edit/'. $group->group_id ) }}" class="btn btn-sm btn-outline-default btnEdit" data-toggle="tooltip" data-placement="top" title="Ubah">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    </a>
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
</div> --}}
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->
<!-- </div> -->
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
@section('script')
<script type="text/javascript">
var notyf = new Notyf({
        duration: 5000,
        position:{
            x:'right',
            y:'top'
        }
    });
    var msg = $('#msgId').html()
    if (msg !== undefined) {
        notyf.success(msg)
    }

</script>
@endsection
