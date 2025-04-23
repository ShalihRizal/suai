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

        <div class="col-md-3">
            <div class="form-group">
                <br>
                <label class="form-label">Pencarian<span class="text-danger"></span></label>
                <select class="form-control mb-3" name="filter-select" id="tabDropdown">
                    <option value="">- Semua Kategori -</option>
                    @if (sizeof($partcategories) > 0)
                        @foreach ($partcategories as $part_category)
                            <option value="{{ $part_category->part_category_name }}">
                                {{ $part_category->part_category_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <input type="text" class="form-control" id="searchInput" placeholder="Cari...">
            </div>
        </div>
        <div class="card-header w-100">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('exportExcel') }}" method="GET" id="export">
                        <div class="form-group">
                            <label class="form-label">Date Begin<span class="text-danger"></span></label>
                            <input type="date" class="form-control" name="date_begin" id="date_begin">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Date End<span class="text-danger"></span></label>
                            <input type="date" class="form-control" name="date_end" id="date_end">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="text-white btn btn-success">Export Excel</button>
                        </div>
                    </form>
                    <div class="addData">
                        <!-- <a href="{{ url('monthlyreport/exportExcel') }}" class="btn btn-success btnAdd text-white mb-3">
                            <i data-feather="download" width="16" height="16" class="me-2"></i>
                            Download Monthly Report - {{ date('F') }}
                        </a> -->
                    </div>
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
                            <th width="20%">Status</th>
                        </tr>
                    </thead>
                    <tbody id="part-table-body">
                        @php
                            $totalQtyEnd = 0; // Initialize total quantity end
                        @endphp
                        @if (sizeof($parts) == 0)
                            <tr>
                                <td colspan="4" align="center">Data kosong</td>
                            </tr>
                        @else
                            @foreach ($parts as $part)
                                @php
                                    $totalQtyEnd += $part->qty_end; // Accumulate quantity end
                                @endphp
                                <tr class="part-row" data-category="{{ $part->part_category_name }}">
                                    <td width="5%">{{ $loop->iteration }}</td>
                                    <td width="15%">{{ $part->part_no }}</td>
                                    <td width="20%">{{ $part->part_name }}</td>
                                    <td width="20%">{{ $part->part_category_name }}</td>
                                    <td width="20%">{{ $part->no_urut }}</td>
                                    <td width="20%">{{ $part->part_no }}.{{ $part->no_urut }}</td>
                                    <td width="20%">{{ $part->qty_end }}</td>
                                    <td width="20%">{{ $part->rop }}</td>
                                    <td width="20%">{{ $part->forecast }}</td>
                                    <td width="20%">{{ $part->max }}</td>
                                    <td width="20%">{{ $part->asal }}</td>
                                    <td width="20%">{{ $part->wear_and_tear_code }}</td>
                                    <td width="20%">{{ $part->invoice }}</td>
                                    <td width="20%">{{ $part->po }}</td>
                                    <td width="20%">{{ $part->po_date }}</td>
                                    <td width="20%">{{ $part->rec_date }}</td>
                                    <td width="20%">
                                        @php
                                            $currentDate = now();
                                            $partDate = \Carbon\Carbon::parse($part->created_at);
                                            $ageInMonths = $currentDate->diffInMonths($partDate);

                                            if ($ageInMonths > 24) {
                                                echo 'Dead Stock';
                                            } elseif ($ageInMonths >= 6 && $ageInMonths <= 24) {
                                                echo 'Slow Moving';
                                            } else {
                                                echo 'Active';
                                        } @endphp </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6"></td>
                                <td colspan="2"><strong>Total Qty End:</strong></td>
                                <td colspan="2">{{ $totalQtyEnd }}</td>
                                <td colspan="9"></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div colspan="4" align="center">ㅤ</div>
    <div class="row">
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.
0.min.js"></script>

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
        // Inisialisasi DataTable
        var table = $('#table-data').DataTable();

        // Hanya filter berdasarkan Part No (kolom ke-2, indeks 1)
        $('#table-data_filter input').unbind().bind('keyup', function() {
            table.column(1).search(this.value).draw();
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

<script type="text/javascript">
    $(document).ready(function() {
        function filterData() {
            var selectedCategory = $('#tabDropdown').val().toLowerCase();
            var searchQuery = $('#searchInput').val().toLowerCase();

            $('.part-row').each(function() {
                var row = $(this);
                var categoryMatch = (selectedCategory === "") || row.data('category').toLowerCase() ===
                    selectedCategory;
                var textMatch = row.text().toLowerCase().includes(searchQuery);

                if (categoryMatch && textMatch) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        }

        $('#tabDropdown').change(filterData);
        $('#searchInput').on('keyup', filterData);
    });
</script>
