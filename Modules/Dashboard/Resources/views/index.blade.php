@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-body">
      <h1 class="card-title">Halo, {{ Auth::user()->user_name }}</h1>

    </div>
  </div>
@endsection
@section('script')

@endsection
