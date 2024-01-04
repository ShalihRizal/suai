@extends('layouts.app')
@section('title', 'Kategori Part CIP')

@section('nav')
    <div class="row align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
                Kategori Part CIP
            </div>
            <h2 class="page-title">
                Kategori Part CIP
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('') }}"><i data-feather="home"
                                class="breadcrumb-item-icon"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Kategori Part CIP</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kategori Part CIP</li>
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
                            <h3 class="h3">Kategori Part CIP</h3>
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
                                    <th width="5%">Part Name</th>
                                    <th width="5%">Part Number</th>
                                    <th width="5%">L/I</th>
                                    <th width="5%">Molts Number</th>
                                    <th width="5%">Rec. Date</th>
                                    <th width="5%">Carline</th>
                                    <th width="5%">Carmodel</th>
                                    <th width="5%">Qty</th>
                                    <th width="5%">Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($cips) == 0)
                                    <tr>
                                        <td colspan="4" align="center">Data kosong</td>
                                    </tr>
                                @else
                                    @foreach ($cips as $notification)
                                        <tr>
                                            <td width="5%">{{ $loop->iteration }}</td>
                                            <td width="5%">{{ $notification->part_name }}</td>
                                            <td width="5%">{{ $notification->part_no }}</td>
                                            <td width="5%">{{ $notification->asal }}</td>
                                            <td width="5%">{{ $notification->molts_no }}</td>
                                            <td width="5%">{{ $notification->rec_date }}</td>
                                            <td width="5%">{{ $notification->carline_category_name }}</td>
                                            <td width="5%">{{ $notification->carname_name }}</td>
                                            <td width="5%">{{ $notification->qty_end }}</td>
                                            <td width="5%">{{ $notification->loc_ppti }}</td>
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
                        $('#pic').val(data.result.pic);
                        $('#part_name').val(data.result.part_name);
                        $('#part_qty').val(data.result.part_qty);
                        $('#part_no').val(data.result.part_no);
                        $('#loc_ppti').val(data.result.loc_ppti);
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
