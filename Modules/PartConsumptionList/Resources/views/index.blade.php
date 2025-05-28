@extends('layouts.app')
@section('title', 'Part Consumption List')

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
                            <h3 class="h3">Part Consumption List</h3>
                            {{ date('Y-m-d') }}
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="btn-group">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control" name="car_model" id="tabDropdown">
                                    <option value="">- Semua Kategori -</option>
                                    <option value="">Jig Board</option>
                                    <option value="">Checker Board</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap table-data">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="5%">Action</th>
                                    <th width="5%">Carline</th>
                                    <th width="5%">Carline Maker</th>
                                    <th width="5%">PCL</th>
                                    <th width="5%">Family</th>
                                    <th width="5%">Pattern</th>
                                    <th width="5%">PIC Prepared</th>
                                    <th width="5%">Status</th>
                                    <th width="5%">Fase</th>
                                    <th width="5%">Last Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($partconsumptionlists) == 0)
                                    <tr>
                                        <td colspan="3" align="center">Data kosong</td>
                                    </tr>
                                @else
                                    @foreach ($partconsumptionlists as $partconsumptionlist)
                                        <tr class="part-row" data-category="{{ $partconsumptionlist->pcl_category }}"
                                            data-pcl-category="{{ $partconsumptionlist->pcl_category }}">
                                            <td width="5%">{{ $loop->iteration }}</td>
                                            <td width="5%">
                                                @if ($partconsumptionlist->pcl_id > 0)
                                                    <a href="{{ url('partconsumptionlist/detail/' . $partconsumptionlist->pcl_id) }}"
                                                        class="btn btn-icon btn-warning text-white"
                                                        data-id="{{ $partconsumptionlist->pcl_id }}" data-toggle="tooltip"
                                                        data-placement="top" title="Ubah">
                                                        <i data-feather="edit" width="16" height="16"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td width="5%">{{ $partconsumptionlist->carline }}</td>
                                            <td width="5%">carline</td>
                                            <td width="5%">{{ $partconsumptionlist->pcl_category }}</td>
                                            <td width="5%">{{ $partconsumptionlist->family }}</td>
                                            <td width="5%">{{ $partconsumptionlist->pattern }}</td>
                                            <td width="5%">{{ $partconsumptionlist->pic_prepared }}</td>
                                            <td width="5%">{{ $partconsumptionlist->status }}</td>
                                            <td width="5%">{{ $partconsumptionlist->fase }}</td>
                                            <td width="5%">{{ $partconsumptionlist->updated_at }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-success btnAdd text-white mb-3" style="width: 175px">
                        <i data-feather="plus" class="me-2"></i>
                        Request New PCL
                    </a>
                    <div>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-success text-white mb-3" style="width: 175px"
                        id="printButton">
                        <i data-feather="printer" class="me-2"></i>
                        Print/Save
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade addModal" tabindex="-1" role="dialog" style="margin-top: 1%;" id="addModal">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ date('Y-m-d') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ url('partconsumptionlist/store') }}" method="POST" id="addForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">PIC Req <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="pic_req" id="pic_req">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Reason <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reason" id="reason">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Carline <span class="text-danger">*</span></label>
                                        <select class="form-control" name="carline" id="carline">
                                            <option value="">- Pilih Carline -</option>
                                            @if (sizeof($machines) > 0)
                                                @foreach ($machines as $machine)
                                                    <option value="{{ $machine->machine_id }}"
                                                        data-machine-name="{{ $machine->machine_name }}"
                                                        data-machine-number="{{ $machine->machine_no }}">
                                                        {{ $machine->machine_no }} - {{ $machine->machine_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Car Name <span class="text-danger">*</span></label>
                                        <select class="form-control" name="carname" id="carname">
                                            <option value="">- Pilih Car Name -</option>
                                            @if (sizeof($carnames) > 0)
                                                @foreach ($carnames as $carname)
                                                    <option value="{{ $carname->carname_id }}"
                                                        data-carname-name="{{ $carname->carname_name }}"
                                                        data-carname-number="{{ $carname->carname_id }}">
                                                        {{ $carname->carname_id }} - {{ $carname->carname_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">PCL Category <span class="text-danger">*</span></label>
                                        <select class="form-control" name="pcl_category" id="pcl_category">
                                            <option value="">- Pilih PCL Category -</option>
                                            <option value="Jig Board"> Jig Board</option>
                                            <option value="Checker Board"> Checker Board</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Family <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="family" id="family">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Pattern <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="pattern" id="pattern">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Assy No <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="assy_no" id="assy_no">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" hidden>Created At<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="created_at" id="created_at"
                                            hidden value="{{ date('Y-m-d:H-i-s') }}">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="text-white btn btn-danger" data-dismiss="modal">Clear</button>
                        <button type="submit" class="text-white btn btn-success">Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script type="text/javascript">
        $('.btnAdd').click(function() {
            $('#part_id').val('');
            $('#pcl_category').val('');
            $('#family').val('');
            $('#pattern').val('');
            $('#pic_prepared').val('');
            $('#status').val('0');
            $('#fase').val('');
            $('.addModal form').attr('action', "{{ url('partconsumptionlist/store') }}");
            $('.addModal .modal-title').text('{{ date('d-M-Y') }}');
            $('.addModal').modal('show');
        })




        // check error
        @if (count($errors))
            $('.addModal').modal('show');
        @endif

        $('.btnEdit').click(function() {

            var id = $(this).attr('data-id');
            var url = "{{ url('partconsumptionlist/getdata') }}";

            $('.addModal form').attr('action', "{{ url('partconsumptionlist/update') }}" + '/' + id);

            $.ajax({
                type: 'GET',
                url: url + '/' + id,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);

                    if (data.status == 1) {
                        $('#pic_req').val(data.result.pic_req);
                        $('#reason').val(data.result.reason);
                        $('#carline').val(data.result.carline);
                        $('#carname').val(data.result.carname);
                        $('#pcl_category').val(data.result.pcl_category);
                        $('#family').val(data.result.family);
                        $('#pattern').val(data.result.pattern);
                        $('#assy_no').val(data.result.assy_no);
                        $('.addModal .modal-title').text('Ubah Part Consumption List');
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
            var url = "{{ url('partconsumptionlist/getdata') }}";


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

        $('#addModal').on('hidden.bs.modal', function(e) {
            // You can save the form values in localStorage
            localStorage.setItem('car_model', $('#car_model').val());
            localStorage.setItem('carline', $('#carline').val());
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

        // Function to restore form values when modal is shown
        $('#addModal').on('shown.bs.modal', function(e) {
            // Retrieve the saved values from localStorage and set them in the form fields
            $('#car_model').val(localStorage.getItem('car_model'));
            $('#carline').val(localStorage.getItem('carline'));
            $('#shift').val(localStorage.getItem('shift'));
            $('#machine_id').val(localStorage.getItem('machine_id'));
            $('#stroke').val(localStorage.getItem('stroke'));
            $('#part_id').val(localStorage.getItem('part_id'));
            $('#machine_name').val(localStorage.getItem('machine_name'));
            $('#part_id').val(localStorage.getItem('part_id'));
            $('#part_no').val(localStorage.getItem('part_no'));
            $('#machine_no').val(localStorage.getItem('machine_no'));
            $('#pic').val(localStorage.getItem('pic'));
            $('#remarks').val(localStorage.getItem('remarks'));
        });

        // Clear the saved values when the form is submitted
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
                // Add the `help-block` class to the error element
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
    </script>

    <script>
        // JavaScript code to update the "Car Model" dropdown based on the selected "Carline"
        document.getElementById("car_model").addEventListener("change", function() {
            var selectedCarlineCategory = this.value;
            var carlineDropdown = document.getElementById("carline");

            // Reset the "Car Model" dropdown
            carlineDropdown.innerHTML = '<option value="">- Pilih Car Model -</option>';

            // Filter and add options based on the selected "Carline Category"
            @foreach ($carlines as $carline)
                if ({{ $carline->carline_carname_id }} == selectedCarlineCategory) {
                    var option = document.createElement("option");
                    option.value = {{ $carline->carline_id }};
                    option.textContent = "{{ $carline->carline_name }}";
                    carlineDropdown.appendChild(option);
                }
            @endforeach
        });
    </script>

    <script>
        // JavaScript code to populate Part Name and Part Number based on the selected Part
        document.getElementById("part_id").addEventListener("change", function() {
            var selectedOption = this.options[this.selectedIndex];
            var partNameInput = document.getElementById("part_name");
            var partNoInput = document.getElementById("part_no");

            // Check if a valid option is selected
            if (selectedOption.value !== "") {
                // Get the data attributes from the selected option
                var partName = selectedOption.getAttribute("data-part-name");
                var partNumber = selectedOption.getAttribute("data-part-number");

                // Set the values in the input fields
                partNameInput.value = partName;
                partNoInput.value = partNumber;
            } else {
                // Clear the input fields if no option is selected
                partNameInput.value = "";
                partNoInput.value = "";
            }
        });
    </script>

    <script>
        // Add event listener to the dropdown
        document.getElementById('machine_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var machineName = selectedOption.getAttribute('data-machine-name');
            var machineNumber = selectedOption.getAttribute('data-machine-number');

            // Set the values of the input fields
            document.getElementById('machine_name').value = machineName;
            document.getElementById('machine_no').value = machineNumber;
        });

        document.querySelector('.btnFilter').addEventListener('click', function() {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            const rows = document.querySelectorAll('.part-row');

            rows.forEach(function(row) {
                const createdAt = new Date(row.getAttribute('data-created-at'));

                if (
                    (!startDate || createdAt >= startDate) &&
                    (!endDate || createdAt <= endDate)
                ) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

    <script>
        document.getElementById("printButton").addEventListener("click", function() {
            // Get a reference to the table
            var table = document.getElementById("table-data");

            // Check if the table exists
            if (table) {
                // Open a new window for printing
                var newWindow = window.open("", "", "width=600,height=600");
                newWindow.document.write("<html><head><title>Print</title></head><body>");

                // Append the table content to the new window
                newWindow.document.write(table.outerHTML);

                newWindow.document.write("</body></html>");
                newWindow.print();
                newWindow.close();
            } else {
                alert("Table not found!");
            }
        });
    </script>


@endsection
