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
<div colspan="4" align="center">ㅤ</div>
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
                                <th width="5%">Created At</th>
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
                                <td width="5%">{{ substr($log->created_at, 0,10) }}</td>

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
            <div class="card-body" style="height: 650px; width:1000px;">
                {{-- <div class="container-md"> --}}
                    <div id="piechart" style="width: 100%; height: 100%;"></div>
                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>
<div colspan="4" align="center">ㅤ</div>
{{-- row 2 --}}
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header w-100">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Quantity Inventory (pcs)</h3>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="col-md-12 text-end"></div>
            </div>
            <div class="card-body" >
                <div class="container-md">
                    <div id="columnchart" style="width: 100%; height: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header w-100">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Amount Inventory (KUSD)</h3>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="col-md-12 text-end"></div>
            </div>
		<div class="card-header w-100">
                <div class="row">
                    <div class="col-md-6">
 		@foreach ($labels as $partCategoryId => $label)
		<h1>{{ $label }}</h1>
<h1>{{ $thsqty[$partCategoryId] }}</h1>
               <h1>lastqty {{ $qty[$partCategoryId] }}</h1>       
            @endforeach

                        <h3 class="h3">Amount Inventory (KUSD)</h3>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="col-md-12 text-end"></div>
            </div>
            <div class="card-body">
                <div class="container-md">
                    <div id="barchart" style="width: 100%; height: 100%;"></div>
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
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            var pieChartData = [['Label', 'Quantity']];
            var barChartData = [['Label', 'Last Month', 'This Month']];
            var columnChartData = [['Label', 'Last Month', 'This Month']];

            @foreach ($labels as $partCategoryId => $label)
                pieChartData.push(['{{ $label }}', {{ $qty[$partCategoryId] }}]);
                barChartData.push([
                    '{{ $label }}',
                    {{ $lstamounts[$partCategoryId] }},
                    {{ $thsamounts[$partCategoryId] }}
                ]);
                columnChartData.push([
                    '{{ $label }}',
                    {{ $lstqty[$partCategoryId] }},
                    {{ $thsqty[$partCategoryId] }}
                ]);
            @endforeach

            var pieData = google.visualization.arrayToDataTable(pieChartData);
            var barData = google.visualization.arrayToDataTable(barChartData);
            var columnData = google.visualization.arrayToDataTable(columnChartData);

            var pieOptions = {
                title: '',
                legend: { position: 'right' },
                backgroundColor: 'transparent',
                pieSliceText: 'percentage', // Show percentage text on slices
                pieSliceTextStyle: { color: 'black' }, // Color of percentage text
                sliceVisibilityThreshold: 0,
                is3D: true,
                colors: ['#33d4be', '#43e686', '#9fe643', '#dead28', '#a772f2']
            };

            const columnOptions = {
                title: '',
                legend: { position: 'right' },
                bar: { groupWidth: '95%' },
                backgroundColor: 'transparent',
                colors: ['#a772f2', '#33d4be'],
                annotations: {
                    textStyle: {
                        fontSize: 12,
                        color: 'black',
                    },
                },
            };

            var pieChart = new google.visualization.PieChart(document.getElementById('piechart'));
            var barChart = new google.visualization.BarChart(document.getElementById('barchart'));
            var columnChart = new google.visualization.ColumnChart(document.getElementById('columnchart'));

            pieChart.draw(pieData, pieOptions);
            barChart.draw(barData, columnOptions);
            columnChart.draw(columnData, columnOptions);
        }
    </script>
@endsection
