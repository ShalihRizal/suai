@extends('layouts.app')
@section('title', 'Ubah Role')

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
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<!-- <div class="container-fluid"> -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- basic table -->
<style type="text/css">
.switch {
  display: inline-block;
  height: 34px;
  position: relative;
  width: 60px;
}
.switch input {
  display:none;
}
.slider {
  background-color: #FF0000;
  bottom: 0;
  cursor: pointer;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  transition: .4s;
}
.slider:before {
  background-color: #fff;
  bottom: 4px;
  content: "";
  height: 26px;
  left: 4px;
  position: absolute;
  transition: .4s;
  width: 26px;
}
input:checked + .slider {
  background-color: #66bb6a;
}
input:checked + .slider:before {
  transform: translateX(26px);
}
.slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
}
</style>
<div class="row">
    <ol class="breadcrumb bg-transparent">

                                <li class="breadcrumb-item"><a href="/sysrole">Role</a></li>
                                <li class="breadcrumb-item active"><a disabled>Ubah Role</a></li>
                            </ol>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                @if (session('successMessage'))
                <strong id="successMessage" hidden>{{ session('successMessage') }}</strong>
                @elseif(session('errorMessage'))
                <strong id="errorMessage" hidden>{{ session('errorMessage') }}</strong>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Daftar Role</h3>
                    </div>
                    <div class="col-md-6">

                    </div>

                </div>


            </div>
            <div class="card-body">

                <form action="{{ url('sysrole/update/'. $id) }}" method="POST">
                    @csrf
                    <div class="col-md-6 text-end">
                        <label>
                            <input type="checkbox" name="" class="checkall checkbox">
                        </label>
                        Pilih semua
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped card-table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="45%">Modul</th>
                                    <th width="10%">Index</th>
                                    <th width="10%">Create</th>
                                    <th width="10%">View</th>
                                    <th width="10%">Edit</th>
                                    <th width="10%">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($modules) == 0)
                                <tr>
                                    <td colspan="7" align="center">Data modul kosong</td>
                                </tr>
                                @else
                                @foreach ($modules as $module)
                                @php
                                $tasks = explode(',', $module->task);
                                $ids = explode(',', $module->taskid);
                                @endphp
                                <tr>
                                    <td width="5%">{{ $loop->iteration }}</td>
                                    <td width="40%">{{ $module->module_name }}</td>
                                    <td>
                                        @if (in_array('index', $tasks))
                                        @php
                                        $checked = "";
                                        $index = array_search('index', $tasks);
                                        if(in_array($ids[$index], $roleTasks)) $checked = "checked='checked'";
                                        @endphp

                                        <label class="switch" for="checkboxindex{{$ids[$index]}}">
                                            <input class="check" id="checkboxindex{{$ids[$index]}}" type="checkbox"
                                                value="{{ $ids[$index] }}" name="task[]" {{ $checked }}>
                                            <div class="slider round"></div>
                                        </label>
                    </div>
                    @else
                    -
                    @endif
                    </td>
                    <td>
                        @if (in_array('create', $tasks))
                        @php
                        $checked = "";
                        $index = array_search('create', $tasks);
                        if(in_array($ids[$index], $roleTasks)) $checked = "checked='checked'";
                        @endphp

                        <label class="switch" for="checkboxcreate{{ $ids[$index] }}">
                            <input class="check" type="checkbox" id="checkboxcreate{{ $ids[$index] }}"
                                value="{{ $ids[$index] }}" name="task[]" {{ $checked }}>
                            <div class="slider round"></div>
                        </label>
            </div>
            @else
            -
            @endif
            </td>
            <td>
                @if (in_array('view', $tasks))
                @php
                $checked = "";
                $index = array_search('view', $tasks);
                if(in_array($ids[$index], $roleTasks)) $checked = "checked='checked'";
                @endphp
                <label class="switch" for="checkboxview{{ $ids[$index] }}">
                    <input class="check" id="checkboxview{{ $ids[$index] }}" type="checkbox" value="{{ $ids[$index] }}"
                        name="task[]" {{ $checked }}>
                    <div class="slider round"></div>
                </label>
        </div>
        @else
        -
        @endif
        </td>
        <td>
            @if (in_array('edit', $tasks))
            @php
            $checked = "";
            $index = array_search('edit', $tasks);
            if(in_array($ids[$index], $roleTasks)) $checked = "checked='checked'";
            @endphp
            <label class="switch" for="checkboxedit{{ $ids[$index] }}">
                <input class="check" id="checkboxedit{{ $ids[$index] }}" type="checkbox" value="{{ $ids[$index] }}"
                    name="task[]" {{ $checked }}>
                <div class="slider round"></div>
            </label>
    </div>
    @else
    -
    @endif
    </td>
    <td>
        @if (in_array('delete', $tasks))
        @php
        $checked = "";
        $index = array_search('delete', $tasks);
        if(in_array($ids[$index], $roleTasks)) $checked = "checked='checked'";
        @endphp
        <label class="switch" for="checkboxdelete{{ $ids[$index] }}">
            <input class="check" id="checkboxdelete{{ $ids[$index] }}" type="checkbox" value="{{ $ids[$index] }}"
                name="task[]" {{ $checked }}>
            <div class="slider round"></div>
        </label>
</div>
@else
-
@endif
</td>
</tr>
@endforeach
@endif
</tbody>
</table>
</div>

<div class="row px-3 py-3">
    <div class="col-md-12 text-end">
        <button type="submit" class="btn btn-success text-white"><i class="fe fe-edit fe-16"></i> Simpan</button>
    </div>
</div>

</form>
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
@endsection

@section('script')
<script type="text/javascript">
    $('.checkall').click(function () {
        if ($(this).is(':checked')) {
            $('.check').prop('checked', true);
        } else {
            $('.check').prop('checked', false);
        }
    });
</script>
@endsection
