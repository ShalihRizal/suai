@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="card">
    {{-- <div class="col-md-3 mb-3">
        <div class="form-group">
            <div class="form-group">
                <div colspan="4" align="center">ㅤ</div>
                <select class="form-control" name="filter-select" id="tabDropdown">
                    <option value="">- Semua Kategori -</option>
                    @if (sizeof($partcategories) > 0)
                        @foreach ($partcategories as $part_category)
                            <option value="{{ $part_category->part_category_name }}">
                                {{ $part_category->part_category_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div> --}}
    <div class="card-body">
        <div class="table-responsive">
            <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap table-data">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Part Number</th>
                        <th width="20%">Part Name</th>
                        <th width="20%">Part Kategori</th>
                        <th width="20%">No Urut</th>
                        <th width="20%">No Part.No Urut</th>
                        <th width="20%">Safety Stock</th>
                        <th width="20%">L/I</th>
                        <th width="20%">W & T Code</th>
                        <th width="20%">Invoice</th>
                        <th width="20%">PO</th>
                        <th width="20%">PO Date</th>
                        <th width="20%">Rec Date</th>
                        <th width="20%">Status</th>
                    </tr>
                </thead>
                <tbody id="part-table-body"> <!-- Add an id to the tbody -->
                    @if (sizeof($parts) == 0)
                        <!-- No data message -->
                        <tr>
                            <td colspan="4" align="center">Data kosong</td>
                        </tr>
                    @else
                        @foreach ($parts as $part)
                            <tr class="part-row" data-category="{{ $part->part_category_name }}">
                                <!-- Add a class and data-category attribute -->
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="15%">{{ $part->part_no }}</td>
                                <td width="20%">{{ $part->part_name }}</td>
                                <td width="20%">{{ $part->part_category_name }}</td>
                                <td width="20%">{{ $part->no_urut }}</td>
                                <td width="20%">{{ $part->part_no }}.{{ $part->no_urut }}</td>
                                <td width="20%">{{ $part->qty_end }}</td>
                                <td width="20%">{{ $part->asal }}</td>
                                <td width="20%">{{ $part->wear_and_tear_code }}</td>
                                <td width="20%">{{ $part->invoice }}</td>
                                <td width="20%">{{ $part->po }}</td>
                                <td width="20%">{{ $part->po_date }}</td>
                                <td width="20%">{{ $part->rec_date }}</td>
                                <td width="20%">
                                    @php
                                        $currentDate = now();
                                        $partDate = \Carbon\Carbon::parse($part->used_date);
                                        if ($partDate == "0000-00-00") {
                                            $ageInMonths = $currentDate ;
                                        } else {
                                            $ageInMonths = $currentDate->diffInMonths($partDate);
                                        }
                                        

                                        if ($ageInMonths > 24) {
                                            echo 'OBSOLOTE / Dead Stock';
                                        } elseif ($ageInMonths >= 6 && $ageInMonths <= 24) {
                                            echo 'Slow Moving';
                                        } else {
                                            echo 'Active';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<td colspan="4" align="center"></td>
<div class="card">
    <div class="card-body">
        <div id="columnchart" style="width: 100%; height: 100%;"></div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            var columnChartData = [
                ['Status', 'Quantity', { role: 'annotation' }]
            ];
            var parts = {!! json_encode($parts) !!}; // Get parts data from Blade to JavaScript

            var activeQty = 0;
            var slowMovingQty = 0;
            var deadStockQty = 0;

           
                parts.forEach(part => {
                let currentDate = new Date(); // Get current date
                let partDate = new Date(part.used_date); // Parse part used date

                if (partDate == "Invalid Date") {
                    ageInMonths = currentDate;
                } else {
                    ageInMonths = Math.floor((currentDate - partDate) / (1000 * 60 * 60 * 24 * 30)); // Calculate difference in months
                }

                if (ageInMonths > 24) {
                    status = 'OBSOLETE = Dead Stock';
                    deadStockQty += part.qty_end;
                } else if (ageInMonths >= 6 && ageInMonths <= 24) {
                    status = 'Slow Moving';
                    slowMovingQty += part.qty_end;
                } else {
                    status = 'Active';
                    activeQty += part.qty_end;
                }
            });  
            

            // Aggregate totals for each status
            columnChartData.push(['Active', activeQty, ${activeQty}]);
            columnChartData.push(['Slow Moving', slowMovingQty, ${slowMovingQty}]);
            columnChartData.push(['OBSOLETE = DeadStock', deadStockQty, ${deadStockQty}]);

            var columnData = google.visualization.arrayToDataTable(columnChartData);

            var columnOptions = {
                title: '',
                legend: {
                    position: 'none'
                },
                backgroundColor: 'transparent',
                bar: {
                    groupWidth: '50%'
                },
                annotations: {
                    textStyle: {
                        fontSize: 40,
                    },
                },
            };

            var columnChart = new google.visualization.ColumnChart(document.getElementById('columnchart'));
            columnChart.draw(columnData, columnOptions);
        }
    </script>
@endsection