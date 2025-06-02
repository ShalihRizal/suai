@extends('layouts.app')
@section('title', 'Barang')

@section('content')
<div colspan="4" align="center">ㅤ</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">

                <div class="row">
                    <div class="col-md-6">
                        <h1 class="h3">Part Request - Assembly Fixture</h1>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('partrequest/af/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 500px;">
                            <table id="table-data-modal" class="table table-stripped card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nama Car Model</th>
                                        <th>Nama Carline</th>
                                        <th>Shift Bagian</th>
                                        <th>Machine</th>
                                        <th>Nama Stroke</th>
                                        <th>Serial No</th>
                                        <th>Side No</th>
                                        <th>Part</th>
                                        <th>Alasan</th>
                                        <th>Order</th>
                                        <th>Part Quantity</th>
                                        <th>Person in Charge</th>
                                        <th>Applicator No Remarks</th>
                                        <th>Remarks</th>
                                        <th>Upload PNG File (Max 2MB)</th>
                                        <th><a href="#" class="btn btn-success addRow" id="addRow">+</a></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="table-body1">
                                    <tr>
                                        <td style="padding-right: 10px;">
                                            <select class="form-control carname" name="carname[]" id="carname" required>
                                                <option value="">- Pilih Carline -</option>
                                                @if (sizeof($carnames) > 0)
                                                @foreach ($carnames as $carname)
                                                <option value="{{ $carname->carname_id }}">
                                                    {{ $carname->carname_name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td style="padding-right: 10px;">
                                            <select class="form-control car_model" name="car_model[]" id="car_model" required>
                                                <option value="">- Pilih Car Model -</option>
                                                @if (sizeof($carlines) > 0)
                                                @foreach ($carlines as $carline)
                                                <option value="{{ $carline->carline_id }}" data-carline-category="{{ $carline->carline_category_id }}">
                                                    {{ $carline->carline_name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="shift[]" id="shift" required>
                                                <option value="">- Pilih Shift -</option>
                                                <option value="A">Shift A</option>
                                                <option value="B">Shift B</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="machine_no[]" id="machine_no[]" required>
                                                <option value="" disabled selected>- Pilih Machine -</option>
                                                @if (sizeof($machines) > 0)
                                                @foreach ($machines as $machine)
                                                <option value="{{ $machine->machine_no }}">{{ $machine->machine_no }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td><input type="text" name="stroke[]" placeholder="stroke" class="form-control" value="{{ old('stroke') }}" required></td>

                                        <td><input type="text" name="serial_no[]" placeholder="Serial No" class="form-control" value="{{ old('serial_no') }}" required></td>

                                        <td><input type="text" name="side_no[]" placeholder="Side No" class="form-control" value="{{ old('side_no') }}" required></td>
                                        <td>
                                            <select class="form-control" name="part_id[]" id="part_id" required>
                                                <option value="">- Pilih Part -</option>
                                                @if (sizeof($parts) > 0)
                                                @foreach ($parts as $part)
                                                @if ($part->qty_begin + $part->qty_in- $part->qty_out > 0)
                                                <option value="{{ $part->part_id }}" data-part-name="{{ $part->part_name }}" data-part-asal="{{ $part->asal }}" data-part-number="{{ $part->part_no }}" data-qty-end="{{ $part->qty_end }}" data-created-at="{{ $part->created_at }}">{{ $part->part_no }}
                                                    -
                                                    {{ $part->part_name }}
                                                    (Qty: {{ $part->qty_begin + $part->qty_in- $part->qty_out }}, Dibuat: {{ substr($part->created_at, 0, 10) }})
                                                </option>
                                                @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="alasan[]" id="alasan" required>
                                                <option value="" disabled selected>- Pilih Alasan -</option>
                                                <option value="New Project">- New Project -</option>
                                                <option value="Replacement">- Replacement -</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="order[]" id="order" required>
                                                <option value="" disabled selected>- Pilih Order -</option>
                                                <option value="LOKAL"> LOKAL </option>
                                                <option value="IMPORT"> IMPORT </option>
                                            </select>
                                        </td>
                                        <td><input type="number" name="part_qty[]" placeholder="Jumlah" class="form-control" value="{{ old('part_qty') }}" required></td>
                                        <td><input type="text" name="pic[]" placeholder="pic" class="form-control" value="{{ old('pic') }}" required></td>
                                        <td><input type="text" name="applicator_no[]" placeholder="applicator no" class="form-control" value="{{ old('applicator_no') }}" required></td>
                                        <td><input type="text" name="remarks[]" placeholder="remarks" class="form-control" value="{{ old('remarks') }}" required></td>
                                        <td>
                                            <input type="text" name="image_part_display[]" class="form-control" readonly>
                                            <input type="file" name="image_part[]" class="form-control" onchange="updateImagePartDisplay(this)">
                                        </td>
                                        <td><a href="#" class="btn btn-danger remove">-</a></td>
                                        <td><input type="text" hidden name="wear_and_tear_status[]" placeholder="wt status" class="form-control" value="Open" required></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div colspan="4" align="center"></div>
                    <div class="row">
                        <div class="col-md-12 text-end" style="margin: left 50%;">
                            <button type="button" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.carname').select2({
            placeholder: "- Pilih Carline -",
            allowClear: true
        });
        $('.carname').on('select2:open', function(e) {
            $('.select2-search__field').attr('placeholder', 'Cari Carline...');
        });

        $('.car_model').select2({
            placeholder: "- Pilih Car Model -",
            allowClear: true
        });
        $('.car_model').on('select2:open', function(e) {
            $('.select2-search__field').attr('placeholder', 'Cari Car Model...');
        });

        $('select[name="machine_no[]"]').select2({
            placeholder: "- Pilih Machine -",
            allowClear: true
        });
        $('select[name="machine_no[]"]').on('select2:open', function(e) {
            $('.select2-search__field').attr('placeholder', 'Cari Machine...');
        });
          // Ubah konfigurasi select2 untuk field part
          $('select[name="part_id[]"]').select2({
            placeholder: "- Pilih Part -",
            allowClear: true,
            language: {
                noResults: function() {
                    return "Tidak ada hasil yang ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                }
            }
        });
        $('select[name="part_id[]"]').on('select2:open', function(e) {
            $('.select2-search__field').attr('placeholder', 'Cari Part...');
        });
    });
</script>
<script type="text/javascript">
    $('#addForm').on('submit', function(e) {
        localStorage.clear();
    });
    $(document).on('change', '.carname', function() {
        var selectedCarlineCategory = $(this).val();
        var carlineDropdown = $(this).closest('tr').find('.car_model');
        carlineDropdown.html('<option value="">- Pilih Car Model -</option>');

        @foreach($carlines as $carline)
        if ("{{ $carline->carline_category_id }}" == selectedCarlineCategory) {
            carlineDropdown.append(
                '<option value="{{ $carline->carline_id }}">{{ $carline->carline_name }}</option>');
        }
        @endforeach
    });

    // Function to add new row
    $('.addRow').on('click', function(event) {
        event.preventDefault();
        addRow();
    });

    function addRow() {
        // Ambil nilai dari baris terakhir
        var lastRow = $('.table-body1 tr:last');
        var lastRemarks = lastRow.find('input[name="remarks[]"]').val();
        var lastPic = lastRow.find('input[name="pic[]"]').val();
        var lastCarname = lastRow.find('select[name="carname[]"]').val();
        var lastStroke = lastRow.find('input[name="stroke[]"]').val();
        var lastSerialNo = lastRow.find('input[name="serial_no[]"]').val();
        var lastSideNo = lastRow.find('input[name="side_no[]"]').val();
        var lastApplicatorNo = lastRow.find('input[name="applicator_no[]"]').val();
        var lastJumlah = lastRow.find('input[name="part_qty[]"]').val();
        var lastOrder = lastRow.find('select[name="order[]"]').val();
        var lastAlasan = lastRow.find('select[name="alasan[]"]').val();
        var lastPartId = lastRow.find('select[name="part_id[]"]').val();
        var lastMachineNo = lastRow.find('select[name="machine_no[]"]').val();
        var lastShift = lastRow.find('select[name="shift[]"]').val();
        var lastCarModel = lastRow.find('select[name="car_model[]"]').val();
        var lastImagePartDisplay = lastRow.find('input[name="image_part_display[]"]').val();

        var tr = '<tr>' +
            '<td style="padding-right: 10px;">' +
            '<select class="form-control carname" name="carname[]" id="carname" required>' +
            '<option value="">- Pilih Carline -</option>' +
            '@if (sizeof($carnames) > 0)' +
            '@foreach ($carnames as $carname)' +
            '<option value="{{ $carname->carname_id }}"' + (lastCarname == "{{ $carname->carname_id }}" ? ' selected' : '') + '>{{ $carname->carname_name }}</option>' +
            '@endforeach' +
            '@endif' +
            '</select>' +
            '</td>' +
            '<td style="padding-right: 10px;">' +
            '<select class="form-control car_model" name="car_model[]" id="car_model" required>' +
            '<option value="">- Pilih Car Model -</option>' +
            '@if (sizeof($carlines) > 0)' +
            '@foreach ($carlines as $carline)' +
            '<option value="{{ $carline->carline_id }}" data-carline-category="{{ $carline->carline_category_id }}"' + (lastCarModel == "{{ $carline->carline_id }}" ? ' selected' : '') + '>{{ $carline->carline_name }}</option>' +
            '@endforeach' +
            '@endif' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select class="form-control" name="shift[]" id="shift" required>' +
            '<option value="">- Pilih Shift -</option>' +
            '<option value="A"' + (lastShift == 'A' ? ' selected' : '') + '>Shift A</option>' +
            '<option value="B"' + (lastShift == 'B' ? ' selected' : '') + '>Shift B</option>' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select class="form-control" name="machine_no[]" id="machine_no[]" required>' +
            '<option value="" disabled selected>- Pilih Machine -</option>' +
            '@if (sizeof($machines) > 0)' +
            '@foreach ($machines as $machine)' +
            '<option value="{{ $machine->machine_no }}"' + (lastMachineNo == "{{ $machine->machine_no }}" ? ' selected' : '') + '>{{ $machine->machine_no }}</option>' +
            '@endforeach' +
            '@endif' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<input type="text" name="stroke[]" placeholder="stroke" class="form-control" value="' + lastStroke + '" required></td>' +
            '<td><input type="text" name="serial_no[]" placeholder="Serial No" class="form-control" value="' + lastSerialNo + '" required></td>' +
            '<td><input type="text" name="side_no[]" placeholder="Side No" class="form-control" value="' + lastSideNo + '" required></td>' +
            '<td>' +
            '<select class="form-control" name="part_id[]" id="part_id" required>' +
            '<option value="">- Pilih Part -</option>' +
            '@if (sizeof($parts) > 0)' +
            '@foreach ($parts as $part)' +
            '@if ($part->qty_begin + $part->qty_in- $part->qty_out > 0)' +
            '<option value="{{ $part->part_id }}" data-part-name="{{ $part->part_name }}" data-part-asal="{{ $part->asal }}" data-part-number="{{ $part->part_no }}" data-qty-end="{{ $part->qty_end }}" data-created-at="{{ $part->created_at }}">{{ $part->part_no }}' +
            '-' +
            '{{ $part->part_name }}' +
            '(Qty: {{ $part->qty_begin + $part->qty_in- $part->qty_out }}, Dibuat: {{ substr($part->created_at, 0, 10) }})' +
            '</option>' +
            '@endif' +
            '@endforeach' +
            '@endif' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select class="form-control" name="alasan[]" id="alasan" required>' +
            '<option value="" disabled' + (lastAlasan == '' ? ' selected' : '') + '>- Pilih Alasan -</option>' +
            '<option value="New Project"' + (lastAlasan == 'New Project' ? ' selected' : '') + '>- New Project -</option>' +
            '<option value="Replacement"' + (lastAlasan == 'Replacement' ? ' selected' : '') + '>- Replacement -</option>' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select class="form-control" name="order[]" id="order" required>' +
            '<option value="">- Pilih Order -</option>' +
            '<option value="LOKAL"' + (lastOrder === 'LOKAL' ? ' selected' : '') + '> LOKAL </option>' +
            '<option value="IMPORT"' + (lastOrder === 'IMPORT' ? ' selected' : '') + '> IMPORT </option>' +
            '</select>' +
            '</td>' +
            '<td><input type="number" name="part_qty[]" placeholder="Jumlah" class="form-control" value="' + lastJumlah + '" required></td>' +
            '<td><input type="text" name="pic[]" placeholder="pic" class="form-control" value="' + lastPic + '" required></td>' +
            '<td><input type="text" name="applicator_no[]" placeholder="applicator no" class="form-control" value="' + lastApplicatorNo + '" required></td>' +
            '<td><input type="text" name="remarks[]" placeholder="remarks" class="form-control" value="' + lastRemarks + '" required></td>' +
            '<td>' +
            '<input type="text" name="image_part_display[]" class="form-control" readonly value="' + lastImagePartDisplay + '">' +
            '<input type="file" name="image_part[]" class="form-control" onchange="updateImagePartDisplay(this)">' +
            '</td>' +
            '<td><a href="#" class="btn btn-danger remove">-</a></td>' +
            '<td><input type="text" hidden name="wear_and_tear_status[]" placeholder="wt status" class="form-control" value="Open" required></td>' +
            '</tr>';
        $('.table-body1').append(tr);

        // Inisialisasi Select2 untuk elemen baru
        var newRow = $('.table-body1').find('tr:last');
        newRow.find('.car_model, select[name="machine_no[]"], select[name="part_id[]"], .carname').select2({
            placeholder: function() {
                return $(this).data('placeholder');
            },
            allowClear: true
        });

        // Tambahkan event listener untuk pencarian
        newRow.find('.select2-search__field').on('input', function() {
            $(this).attr('placeholder', 'Cari...');
        });

        // Tambahkan event listener untuk part_id pada baris baru
        newRow.find('select[name="part_id[]"]').on('change', function() {
            updateOrder(this);
        });
    }

    // Fungsi untuk memperbarui nilai input readonly ketika file dipilih
    function updateImagePartDisplay(fileInput) {
        var fileName = fileInput.files[0] ? fileInput.files[0].name : '';
        $(fileInput).closest('td').find('input[name="image_part_display[]"]').val(fileName);
    }



    // Inisialisasi Select2 untuk elemen yang sudah ada, kecuali carname
    $(document).ready(function() {
        $('.car_model, select[name="machine_no[]"], select[name="part_id[]"]').select2({
            placeholder: function() {
                return $(this).data('placeholder');
            },
            allowClear: true
        });

        // Tambahkan event listener untuk pencarian pada elemen yang sudah ada
        $('.select2-search__field').on('input', function() {
            $(this).attr('placeholder', 'Cari...');
        });

        // Event listener untuk perubahan pada semua select part_id[]
        $(document).on('change', 'select[name="part_id[]"]', function() {
            updateOrder(this);
        });
    });

    $('.table-body1').on('click', '.remove', function(event) {
        event.preventDefault();
        $(this).parent().parent().remove();
    });

    // Fungsi untuk mengisi field order berdasarkan part_id yang dipilih
    function updateOrder(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var orderSelect = selectElement.closest('tr').querySelector('select[name="order[]"]');

        if (selectedOption.value !== "") {
            var partAsal = selectedOption.getAttribute("data-part-asal");
            orderSelect.value = partAsal === "LOKAL" ? "LOKAL" : "IMPORT";
        } else {
            orderSelect.value = "";
        }
    }
</script>

<script>
    document.getElementById("carname").addEventListener("change", function() {
        var selectedCarlineCategory = this.value;
        var carlineDropdown = document.getElementById("car_model");
        carlineDropdown.innerHTML = '<option value="">- Pilih Car Model -</option>';
        @foreach($carlines as $carline)
        if ({
                {
                    $carline - > carline_category_id
                }
            } == selectedCarlineCategory) {
            var option = document.createElement("option");
            option.value = {
                {
                    $carline - > carline_id
                }
            };
            option.textContent = "{{ $carline->carline_name }}";
            carlineDropdown.appendChild(option);
        }
        @endforeach
    });
</script>

<script>
    document.getElementById("part_id").addEventListener("change", function() {
        var selectedOption = this.options[this.selectedIndex];
        var partNameInput = document.getElementById("part_name");
        var partNoInput = document.getElementById("part_no");
        var partOrder = document.getElementById("order");

        if (selectedOption.value !== "") {
            var partName = selectedOption.getAttribute("data-part-name");
            var partNumber = selectedOption.getAttribute("data-part-number");
            partNameInput.value = partName;
            partNoInput.value = partNumber;
            partOrder.value = selectedOption.getAttribute("data-part-asal");
        } else {
            partNameInput.value = "";
            partNoInput.value = "";
            partOrder.value = "";
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#part_id').change(function() {
            var selectedPartNumber = $(this).find(':selected').data('part-asal');

            $('#order').val(selectedPartNumber);
        });
    });
</script>
@endsection

<style>
    .form-control,
    .select2-container {
        width: 100% !important;
    }

    th,
    td {
        white-space: nowrap;
        min-width: 150px;
    }

    .table-responsive {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 500px;
    }
</style>