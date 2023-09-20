@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-body">
      <h1 class="card-title">Halo, {{ Auth::user()->user_name }}</h1>
      <a class="btn btn-success text-white mb-3">
        <i data-feather="calendar" width="17" height="17" class="me-2"> </i> {{ date('Y-m-d') }}

    </a>
    </div>
  </div>

  <!DOCTYPE html>
<html>
<head>
    <title>Pie Chart Example</title>
</head>
<body>
    <div style="width: 50%;">
        <canvas id="myPieChart"></canvas>
    </div>
</body>
</html>


  {{-- <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" href="#">Active</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled">Disabled</a>
    </li>
  </ul> --}}

@endsection
@section('script')

@endsection
