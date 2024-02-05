@extends('layouts.app')
@section('title', 'Gambar Part Request')

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
                            <h3 class="h3">Detail Gambar Part Request</h3>
                            {{ date('Y-m-d') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header w-100">
                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <img style="max-width: 100px; max-height: 100px; display: inline-block;" src="/storage/uploads/images/{{$partrequests->part_req_pic_filename}}">
                            </div>
                        </div>
                        <div class="modal-footer">
                        {{-- <button type="button"  class="text-white btn btn-success" onclick="window.history.back()">Kembali</button> --}}

                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add -->

@endsection

@section('scripts')
    <script>
        document.getElementById('btnBack').addEventListener('click', function() {
            // Kembali ke halaman sebelumnya
            window.history.back();
        });
    </script>
@endsection

