@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-header w-100">
        <div class="row">
            <div class="col-md-6">
                <h1 class="card-title">Monthly Report</h1>
                {{ date('Y-m-d') }}
            </div>
        </div>
    </div>
    <div class="card-header w-100">
        <div class="row">
            <div class="col-md-6">
                <div class="addData">
                    <a href="{{ route('exportExcel') }}" class="btn btn-success btnAdd text-white mb-3">
                        <i data-feather="download" width="16" height="16" class="me-2"></i>
                        Download Monthly Report - {{date('F')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div colspan="4" align="center">ㅤ</div>
<div class="row">
</div>
@endsection

