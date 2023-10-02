@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-header w-100">
        <div class="row">
            <div class="col-md-6">
                <h1 class="card-title">Halo, {{ Auth::user()->user_name }}</h1>
                {{ date('Y-m-d') }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header w-100">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Recent Activity</h3>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="col-md-12 text-end"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-data" class="table card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="50%">Deskripsi</th>
                                <th width="50%">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($logs) == 0)
                            <tr>
                                <td colspan="3" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($logs as $log)
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="50%">{{ $log->log_description }}</td>
                                <td width="50%">{{ substr($log->created_at, 0,10) }}</td>

                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header w-100">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Status Inventory</h3>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="col-md-12 text-end"></div>
            </div>
            <div class="card-body">
                <div class="container-md"> <!-- Wrap in a container that takes half the screen width -->
                    <div id="piechart" style="width: 700px; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var chartData = [['Label', 'Quantity']];

            @foreach ($labels as $partCategoryId => $label)
                chartData.push(['{{ $label }}', {{ $qty[$partCategoryId] }}]);
            @endforeach

            var data = google.visualization.arrayToDataTable(chartData);

            var options = {
                title: ''
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
@endsection

