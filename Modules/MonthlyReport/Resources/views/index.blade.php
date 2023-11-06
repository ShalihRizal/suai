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
        <div class="col-md-3 mb-3">
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
        </div>
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
                            <th width="20%">ROP</th>
                            <th width="20%">Forecast</th>
                            <th width="20%">Max Inv</th>
                            <th width="20%">L/I</th>
                            <th width="20%">W & T Code</th>
                            <th width="20%">Invoice</th>
                            <th width="20%">PO</th>
                            <th width="20%">PO Date</th>
                            <th width="20%">Rec Date</th>
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
                                    <td width="20%">-</td>
                                    <td width="20%">-</td>
                                    <td width="20%">-</td>
                                    <td width="20%">-</td>
                                    <td width="20%">{{ $part->asal }}</td>
                                    <td width="20%">{{ $part->wear_and_tear_code }}</td>
                                    <td width="20%">{{ $part->invoice }}</td>
                                    <td width="20%">{{ $part->po }}</td>
                                    <td width="20%">{{ $part->po_date }}</td>
                                    <td width="20%">{{ $part->rec_date }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-header w-100">
            <div class="row">
                <div class="col-md-6">
                    <div class="addData">
                        <a href="{{ route('exportExcel') }}" class="btn btn-success btnAdd text-white mb-3">
                            <i data-feather="download" width="16" height="16" class="me-2"></i>
                            Download Monthly Report - {{ date('F') }}
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Event listener for dropdown change
        $('#tabDropdown').change(function() {
            var selectedCategory = $(this).val(); // Get the selected category

            if (selectedCategory === "") {
                // Show all rows if "Pilih Part Category" is selected
                $('.part-row').show();
            } else {
                // Hide all rows and then show only the rows with the selected category
                $('.part-row').hide();
                $('.part-row[data-category="' + selectedCategory + '"]').show();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Event listener for dropdown change
        $('#tabDropdown').change(function() {
            var selectedCategory = $(this).val(); // Get the selected category

            // Hide all rows and then show only the rows with the selected category
            $('.part-row').hide();
            $('.part-row[data-category="' + selectedCategory + '"]').show();
        });
    });
</script>
