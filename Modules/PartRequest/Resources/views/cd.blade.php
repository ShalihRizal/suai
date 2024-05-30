@extends('layouts.app')
@section('title', 'Part Request')

@section('content')
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
                            <h3 class="h3">Part Request - Crimping Dies</h3>
                            {{ date('Y-m-d') }}
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <a href="javascript:void(0)" class="btn btn-success btnAdd text-white mb-3">
                        <i data-feather="plus" width="16" height="16" class="me-2"></i>
                        Tambah Part Request
                    </a>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Start Date:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">End Date:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                    </div>

                    <a href="javascript:void(0)" class="btn btn-success btnFilter text-white mb-3">
                        <i data-feather="plus" width="16" height="16" class="me-2"></i>
                        Filter
                    </a>
                    <div class="table-responsive">
                        <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="80%">Part Request Number</th>
                                    <th width="80%">Date</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($partrequests) == 0)
                                    <tr>
                                        <td colspan="3" align="center">Data kosong</td>
                                    </tr>
                                @else
                                    @foreach ($partrequests as $partrequest)
                                        <tr class="part-row" data-category="{{ $partrequest->part_req_number }}"
                                            data-created-at="{{ $partrequest->created_at }}">
                                            <td width="5%">{{ $loop->iteration }}</td>
                                            <td width="80%">{{ $partrequest->part_req_number }}</td>
                                            <td width="80%">{{ $partrequest->created_at }}</td>
                                            <td width="15%">
                                                @if ($partrequest->part_req_id > 0)
                                                    {{-- <a href="javascript:void(0)"
                                                        class="btn btn-icon btnEdit btn-warning text-white"
                                                        data-id="{{ $partrequest->part_req_id }}" data-toggle="tooltip"
                                                        data-placement="top" title="Ubah">
                                                        <i data-feather="edit" width="16" height="16"></i>
                                                    </a> --}}
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-icon btn-danger text-white btnDelete"
                                                        data-url="{{ url('partrequest/cd/delete/' . $partrequest->part_req_id) }}"
                                                        data-toggle="tooltip" data-placement="top" title="Hapus">
                                                        <i data-feather="trash-2" width="16" height="16"></i>
                                                    </a>
                                                    <a href="gambar/{{ $partrequest->part_req_id }}"
                                                        class="btn btn-icon btn-info text-white"
                                                        data-id="{{ $partrequest->part_req_id }}" data-toggle="tooltip"
                                                        data-placement="top" title="Ubah">
                                                        <i data-feather="eye" width="16" height="16"></i>
                                                    </a>
                                                @endif
                                            </td>
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

    <!-- Modal Add -->
    <div class="modal fade addModal" tabindex="-1" role="dialog" style="margin-top: 1%;" id="addModal">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content" style="width: 100%;">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Part Request</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ url('partrequest/cd/store') }}" method="POST" id="addForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="table-data-modal" class="table table-stripped card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nama Car Model</th>
                                        <th>Nama Carline</th>
                                        <th>Shift Bagian</th>
                                        <th>Machine</th>
                                        <th>Nama Stroke</th>
                                        <th>ㅤㅤPartㅤㅤ</th>
                                        <th>ㅤㅤAlasanㅤㅤ</th>
                                        <th>ㅤㅤOrderㅤㅤ</th>
                                        <th>Part Quantity</th>
                                        <th>Person in Charge</th>
                                        <th>Remarks</th>
                                        <th></th>
                                        <th>Upload PNG File (Max 2MB)</th>
                                        <th><a href="#" class="btn btn-success addRow" id="addRow">+</a></th>
                                    </tr>
                                </thead>
                                <tbody class="table-body1">
                                    <tr>
                                        <td style="padding-right: 10px;">
                                            <select class="form-control carname" name="carname[]" id="carname">
                                                <option value="">- Pilih Carline -</option>
                                                @if (sizeof($carnames) > 0)
                                                    @foreach ($carnames as $carname)
                                                        <option value="{{ $carname->carname_id }}">
                                                            {{ $carname->carname_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>

                                        <td style="padding-right: 10px;">
                                            <select class="form-control car_model" name="car_model[]" id="car_model">
                                                <option value="">- Pilih Car Model -</option>
                                                @if (sizeof($carlines) > 0)
                                                    @foreach ($carlines as $carline)
                                                        <option value="{{ $carline->carline_id }}"
                                                            data-carline-category="{{ $carline->carline_category_id }}">
                                                            {{ $carline->carline_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>

                                        <td>
                                            <select class="form-control" name="shift[]" id="shift">
                                                <option value="">- Pilih Shift -</option>
                                                <option value="A">Shift A</option>
                                                <option value="B">Shift B</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="machine_no[]" id="machine_no[]">
                                                <option value=""disabled selected>- Pilih Machine -</option>
                                                @if (sizeof($machines) > 0)
                                                    @foreach ($machines as $machine)
                                                        <option value="{{ $machine->machine_id }}"
                                                            data-machine-name="{{ $machine->machine_name }}"
                                                            data-machine-number="{{ $machine->machine_no }}">
                                                            {{ $machine->machine_no }} - {{ $machine->machine_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td><input type="text" name="stroke[]" placeholder="stroke"
                                                class="form-control" value="{{ old('stroke') }}"></td>
                                        <td>
                                            <select class="form-control" name="part_id[]" id="part_id">
                                                <option value="">- Pilih Part -</option>
                                                @if (sizeof($parts) > 0)
                                                    @foreach ($parts as $part)
                                                        <option
                                                            value="{{ $part->part_id }}"data-part-name="{{ $part->part_name }}"
                                                            data-part-asal="{{ $part->asal }}"
                                                            data-part-number="{{ $part->part_no }}">{{ $part->part_no }}
                                                            -
                                                            {{ $part->part_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="alasan[]" id="alasan">
                                                <option value=""disabled selected>- Pilih Alasan -</option>
                                                <option value="New Project">- New Project -</option>
                                                <option value="Replacement">- Replacement -</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" readonly name="order[]" id="order">
                                                <option value=""disabled selected>- Pilih Order -</option>
                                                <option value="Lokal"> Lokal </option>
                                                <option value="Import"> Import </option>
                                            </select>
                                        </td>
                                        <td><input type="number" name="part_qty[]" placeholder="Jumlah"
                                                class="form-control" value="{{ old('part_qty') }}"></td>
                                        <td><input type="text" name="pic[]" placeholder="pic" class="form-control"
                                                value="{{ old('pic') }}"></td>
                                        <td><input type="text" name="remarks[]" placeholder="remarks"
                                                class="form-control" value="{{ old('remarks') }}"></td>
                                        <td><input type="text" hidden name="wear_and_tear_status[]"
                                                placeholder="wt status" class="form-control" value="Open"></td>
                                        <td><input required type="file" name="image_part[]" placeholder="wt status"
                                                class="form-control" value="{{ old('image_part') }}"></td>
                                        <td><a href="#" class="btn btn-danger remove">-</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="text-white btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade viewModal" tabindex="-1" role="dialog" style="margin-top: 1%;" id="viewModal">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Gambar</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ url('partrequest/cd/store') }}" method="POST" id="addForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="form-group">
                            <div id="view_image"></div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#part_id').select2({
                placeholder: "- Pilih Part -",
                allowClear: true
            });
            $('#part_id').on('select2:open', function(e) {
                $('.select2-search__field').attr('placeholder', 'Cari Part...');
            });
        });
    </script>
    <script type="text/javascript">
        $('.btnAdd').click(function() {
            $('#part_req_number').val('');
            $('#carname').val('');
            $('#car_model').val('');
            $('#alasan').val('');
            $('#order').val('');
            $('#shift').val('');
            $('#machine_no').val('');
            $('#applicator_no').val('');
            $('#part_req_pic_filenames').val('');
            $('#part_req_pic_paths').val('');
            $('#image_part').val('');
            $('#wear_and_tear_code').val('');
            $('#wear_and_tear_status').val('Open');
            $('#serial_no').val('');
            $('#part_id').val('');
            $('#status').val('0');
            $('#side_no').val('');
            $('#stroke').val('');
            $('#pic').val('');
            $('#part_qty').val('');
            $('#remarks').val('');
            $('#part_no').val('');
            $('#anvil').val('');
            $('#insulation_crimper').val('');
            $('#has_sto');
            $('#wire_crimper').val('');
            $('#other').val('');
            $('.addModal form').attr('action', "{{ url('partrequest/cd/store') }}");
            $('.addModal .modal-title').text('Tambah Part Request - Crimping Dies');
            $('.addModal').modal('show');
        })
        @if (count($errors))
            $('.addModal').modal('show');
        @endif

        $('.btnEdit').click(function() {

            var id = $(this).attr('data-id');
            var url = "{{ url('partrequest/getdata') }}";

            $('.detailModal form').attr('action', "{{ url('partrequest/cd/update') }}" + '/' + id);

            $.ajax({
                type: 'GET',
                url: url + '/' + id,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);

                    if (data.status == 1) {
                        $('#part_req_number').val(data.result.part_req_number);
                        $('#carname').val(data.result.carname);
                        $('#car_model').val(data.result.car_model);
                        $('#alasan').val(data.result.alasan);
                        $('#order').val(data.result.order);
                        $('#shift').val(data.result.shift);
                        $('#machine_no').val(data.result.machine_no);
                        $('#machine_name').val(data.result.machine_name);
                        $('#applicator_no').val(data.result.applicator_no);
                        $('#wear_and_tear_code').val(data.result.wear_and_tear_code);
                        $('#wear_and_tear_status').val(data.result.wear_and_tear_status);
                        $('#serial_no').val(data.result.serial_no);
                        $('#side_no').val(data.result.side_no);
                        $('#stroke').val(data.result.stroke);
                        $('#part_req_pic_filenames').val(data.result.part_req_pic_filenames);
                        $('#part_req_pic_paths').val(data.result.part_req_pic_paths);
                        $('#pic').val(data.result.pic);
                        $('#part_id').val(data.result.part_id);
                        $('#image_part').val(data.result.image_part);
                        $('#remarks').val(data.result.remarks);
                        $('#part_qty').val(data.result.part_qty);
                        $('#part_name').val(data.result.part_name);
                        $('#status').val(data.result.status);
                        $('#approved_by').val(data.result.approved_by);
                        $('#part_no').val(data.result.part_no);
                        $('.addModal .modal-title').text('Ubah Part Request');
                        $('.addModal').modal('show');
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Error : Gagal mengambil data');
                }
            });

        });

        $('.btnView').click(function() {

            var id = $(this).attr('data-id');
            var url = "{{ url('partrequest/cd/getdata') }}";


            $.ajax({
                type: 'GET',
                url: url + '/' + id,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);

                    if (data.status == 1) {
                        $('.viewModal .modal-title').text('Detail Gambar');
                        $('.viewModal').modal('show');

                        document.getElementById('view_image').innerHTML =
                            `<img src="/storage/${data.result.part_req_pic_path}${data.result.part_req_pic_filename}" alt="" width="200">`

                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Error : Gagal mengambil data');
                }
            });

        });

        $('.btnDelete').click(function() {
            $('.btnDelete').attr('disabled', true)
            var url = $(this).attr('data-url');
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus data?',
                text: "Kamu tidak akan bisa mengembalikan data ini setelah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya. Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function(data) {
                            if (result.isConfirmed) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data Berhasil Dihapus.',
                                    'success'
                                ).then(() => {
                                    location.reload()
                                })
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Swal.fire(
                                'Gagal!',
                                'Gagal menghapus data.',
                                'error'
                            );
                        }
                    });
                }
            })
        });

        $('#detailModal').on('hidden.bs.modal', function(e) {
            localStorage.setItem('car_model', $('#car_model').val());
            localStorage.setItem('carname', $('#carname').val());
            localStorage.setItem('part_id', $('#part_id').val());
            localStorage.setItem('part_no', $('#part_no').val());
            localStorage.setItem('shift', $('#shift').val());
            localStorage.setItem('machine_name', $('#machine_name').val());
            localStorage.setItem('machine_no', $('#machine_no').val());
            localStorage.setItem('machine_id', $('#machine_id').val());
            localStorage.setItem('stroke', $('#stroke').val());
            localStorage.setItem('pic', $('#pic').val());
            localStorage.setItem('remarks', $('#remarks').val());
        });

        $('#detailModal').on('shown.bs.modal', function(e) {
            $('#car_model').val(localStorage.getItem('car_model'));
            $('#carname').val(localStorage.getItem('carname'));
            $('#shift').val(localStorage.getItem('shift'));
            $('#machine_id').val(localStorage.getItem('machine_id'));
            $('#stroke').val(localStorage.getItem('stroke'));
            $('#part_id').val(localStorage.getItem('part_id'));
            $('#machine_name').val(localStorage.getItem('machine_name'));
            $('#part_no').val(localStorage.getItem('part_no'));
            $('#machine_no').val(localStorage.getItem('machine_no'));
            $('#pic').val(localStorage.getItem('pic'));
            $('#remarks').val(localStorage.getItem('remarks'));
        });

        $('#addForm').on('submit', function(e) {
            localStorage.clear();
        });


        $("#addForm").validate({
            rules: {
                module_name: "required",
            },
            messages: {
                module_name: "Modul tidak boleh kosong",
            },
            errorElement: "em",
            errorClass: "invalid-feedback",
            errorPlacement: function(error, element) {
                $(element).parents('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });

        var notyf = new Notyf({
            duration: 5000,
            position: {
                x: 'right',
                y: 'top'
            }
        });
        var msg = $('#msgId').html()
        if (msg !== undefined) {
            notyf.success(msg)
        }

        $(document).on('change', '.carname', function() {
            var selectedCarlineCategory = $(this).val();
            var carlineDropdown = $(this).closest('tr').find('.car_model');
            carlineDropdown.html('<option value="">- Pilih Car Model -</option>');

            @foreach ($carlines as $carline)
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
            var tr = '<tr>' +
                '<td style="padding-right: 10px;">' +
                '<select class="form-control carname" name="carname[]" id="carname">' +
                '<option value="">- Pilih Carline -</option>' +
                '@if (sizeof($carnames) > 0)' +
                '@foreach ($carnames as $carname)' +
                '<option value="{{ $carname->carname_id }}">{{ $carname->carname_name }}</option>' +
                '@endforeach' +
                '@endif' +
                '</select>' +
                '</td>' +
                '<td style="padding-right: 10px;">' +
                '<select class="form-control car_model" name="car_model[]" id="car_model">' +
                '<option value="">- Pilih Car Model -</option>' +
                '@if (sizeof($carlines) > 0)' +
                '@foreach ($carlines as $carline)' +
                '<option value="{{ $carline->carline_id }}" data-carline-category="{{ $carline->carline_category_id }}">{{ $carline->carline_name }}</option>' +
                '@endforeach' +
                '@endif' +
                '</select>' +
                '</td>' +
                '<td style="padding-right: 10px;">' +
                '<select class="form-control" name="shift[]" id="shift">' +
                '<option value="">- Pilih Shift -</option>' +
                '<option value="A">Shift A</option>' +
                '<option value="B">Shift B</option>' +
                '</select>' +
                '</td>' +
                '<td style="padding-right: 10px;">' +
                '<select class="form-control" name="machine_no[]" id="machine_no">' +
                '<option value="" disabled selected>- Pilih Machine -</option>' +
                '@if (sizeof($machines) > 0)' +
                '@foreach ($machines as $machine)' +
                '<option value="{{ $machine->machine_id }}" data-machine-name="{{ $machine->machine_name }}" data-machine-number="{{ $machine->machine_no }}">{{ $machine->machine_no }} - {{ $machine->machine_name }}</option>' +
                '@endforeach' +
                '@endif' +
                '</select>' +
                '</td>' +
                '<td style="padding-right: 10px;"><input type="text" name="stroke[]" placeholder="stroke" class="form-control" value="{{ old('stroke') }}"></td>' +
                '<td style="padding-right: 10px;">' +
                '<select class="form-control" name="part_id[]" id="part_id">' +
                '<option value="">- Pilih Part -</option>' +
                '@if (sizeof($parts) > 0)' +
                '@foreach ($parts as $part)' +
                '<option value="{{ $part->part_id }}" data-part-name="{{ $part->part_name }}" data-part-asal="{{ $part->asal }}" data-part-number="{{ $part->part_no }}">{{ $part->part_no }} - {{ $part->part_name }}</option>' +
                '@endforeach' +
                '@endif' +
                '</select>' +
                '</td>' +
                '<td style="padding-right: 10px;">' +
                '<select class="form-control" name="alasan[]" id="alasan">' +
                '<option value="" disabled selected>- Pilih Alasan -</option>' +
                '<option value="New Project">- New Project -</option>' +
                '<option value="Replacement">- Replacement -</option>' +
                '</select>' +
                '</td>' +
                '<td style="padding-right: 10px;">' +
                '<select class="form-control" readonly name="order[]" id="order">' +
                '<option value="" disabled selected>- Pilih Order -</option>' +
                '<option value="Lokal"> Lokal </option>' +
                '<option value="Import"> Import </option>' +
                '</select>' +
                '</td>' +
                '<td style="padding-right: 10px;"><input type="number" name="part_qty[]" placeholder="Jumlah" class="form-control"></td>' +
                '<td style="padding-right: 10px;"><input type="text" name="pic[]" placeholder="pic" class="form-control"></td>' +
                '<td style="padding-right: 10px;"><input type="text" name="remarks[]" placeholder="remarks" class="form-control"></td>' +
                '<td style="padding-right: 10px;"><input type="text" name="wear_and_tear_status[]" hidden placeholder="wt status" class="form-control" value="Open"></td>' +
                '<td style="padding-right: 10px;"><input required type="file" name="image_part[]" placeholder="wt status" class="form-control"></td>' +
                '<td><a href="#" class="btn btn-danger remove">-</a></td>' +
                '</tr>';
            $('.table-body1').append(tr);
        }

        $('.table-body1').on('click', '.remove', function(event) {
            event.preventDefault();
            $(this).parent().parent().remove();
        });
    </script>

    <script>
        document.getElementById("carname").addEventListener("change", function() {
            var selectedCarlineCategory = this.value;
            var carlineDropdown = document.getElementById("car_model");
            carlineDropdown.innerHTML = '<option value="">- Pilih Car Model -</option>';
            @foreach ($carlines as $carline)
                if ({{ $carline->carline_category_id }} == selectedCarlineCategory) {
                    var option = document.createElement("option");
                    option.value = {{ $carline->carline_id }};
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

            if (selectedOption.value !== "") {
                var partName = selectedOption.getAttribute("data-part-name");
                var partNumber = selectedOption.getAttribute("data-part-number");
                partNameInput.value = partName;
                partNoInput.value = partNumber;
            } else {
                partNameInput.value = "";
                partNoInput.value = "";
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#table-data').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });

            $('#start_date, #end_date').on('change', function() {
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                table.rows().every(function() {
                    var row = this.node();
                    var rowData = this.data();

                    var dateValue = rowData[2];

                    if (isDateInRange(dateValue, startDate, endDate)) {
                        $(row).show();
                    } else {
                        $(row).hide();
                    }
                });
            });

            function isDateInRange(dateStr, start, end) {
                var date = new Date(dateStr);
                var startDate = new Date(start);
                var endDate = new Date(end);

                return date >= startDate && date <= endDate;
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

    <script>
        $(document).ready(function() {
            var table = $('#table-data-modal').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false
            });
        });
    </script>

@endsection
