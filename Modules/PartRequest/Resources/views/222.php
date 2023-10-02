@extends('layouts.app')

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
                        <h3 class="h3">Part Request</h3>
                    </div>
                    <div class="col-md-6">
                        <!-- Add content for the second column if needed -->
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="container">
                    <select id="tabDropdown" class="form-control">
                        <option value="tab0">Pilih Kategori</option>
                        <option value="tab1">Crimping Dies</option>
                        <option value="tab2">SparePart Machine</option>
                        <option value="tab3">Assembly Fixture</option>
                        <option value="tab4">Checker Fixture</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container mt-3">
    <div id="tab1" class="tab-content" style="display: none;">
        <!-- Content for tab1 -->
    </div>
    <div id="tab2" class="tab-content" style="display: none;">
        <!-- Content for tab2 -->
    </div>
    <div id="tab3" class="tab-content" style="display: none;">
        <!-- Content for tab3 -->
    </div>
    <div id="tab4" class="tab-content" style="display: none;">
        <!-- Content for tab4 -->
    </div>
</div>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Part Request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modalContent">Modal content goes here.</p>
                <!-- Conditional input fields for Crimping Dies -->
                <div id="crimpingDiesFields" style="display: none;">
                    <div class="form-group">
                        <label for="part_req_number">Part Request Number</label>
                        <input type="text" class="form-control" id="part_req_number" readonly>
                    </div>
                    <div class="form-group">
                        <label for="carline">Carline</label>
                        <input type="text" class="form-control" id="carline">
                    </div>
                    <div class="form-group">
                        <label for="car_model">Car Model</label>
                        <input type="text" class="form-control" id="car_model">
                    </div>
                    <div class="form-group">
                        <label for="alasan">Alasan</label>
                        <input type="text" class="form-control" id="alasan">
                    </div>
                    <div class="form-group">
                        <label for="order">Order</label>
                        <input type="text" class="form-control" id="order">
                    </div>
                    <div class="form-group">
                        <label for="shift">Shift</label>
                        <input type="text" class="form-control" id="shift">
                    </div>
                    <div class="form-group">
                        <label for="machine_no">Machine Number</label>
                        <input type="text" class="form-control" id="machine_no">
                    </div>
                    <div class="form-group">
                        <label for="applicator_no">Applicator Number</label>
                        <input type="text" class="form-control" id="applicator_no">
                    </div>
                    <div class="form-group">
                        <label for="wear_and_tear_code">Wear and Tear Code</label>
                        <input type="text" class="form-control" id="wear_and_tear_code">
                    </div>
                    <div class="form-group">
                        <label for="serial_no">Serial Number</label>
                        <input type="text" class="form-control" id="serial_no">
                    </div>
                    <div class="form-group">
                        <label for="side_no">Side Number</label>
                        <input type="text" class="form-control" id="side_no">
                    </div>
                    <div class="form-group">
                        <label for="stroke">Stroke</label>
                        <input type="text" class="form-control" id="stroke">
                    </div>
                    <div class="form-group">
                        <label for="pic">PIC</label>
                        <input type="text" class="form-control" id="pic">
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control" id="remarks">
                    </div>
                    <div class="form-group">
                        <label for="part_qty">Part Quantity</label>
                        <input type="text" class="form-control" id="part_qty">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" id="status">
                    </div>
                    <div class="form-group">
                        <label for="approved_by">Approved By</label>
                        <input type="text" class="form-control" id="approved_by">
                    </div>
                    <div class="form-group">
                        <label for="part_no">Part Number</label>
                        <input type="text" class="form-control" id="part_no">
                    </div>
                    <div class="form-group">
                        <label for="wear_and_tear_status">Wear and Tear Status</label>
                        <input type="text" class="form-control" id="wear_and_tear_status">
                    </div>
                    <div class="form-group">
                        <label for="anvil">Anvil</label>
                        <input type="text" class="form-control" id="anvil">
                    </div>
                    <div class="form-group">
                        <label for="insulation_crimper">Insulation Crimper</label>
                        <input type="text" class="form-control" id="insulation_crimper">
                    </div>
                    <div class="form-group">
                        <label for="wire_crimper">Wire Crimper</label>
                        <input type="text" class="form-control" id="wire_crimper">
                    </div>
                    <div class="form-group">
                        <label for="other">Other</label>
                        <input type="text" class="form-control" id="other">
                    </div>
                </div>
                <!-- Conditional input fields for SparePart Machine -->
                <div id="sparePartMachineFields" style="display: none;">
                    <div class="form-group">
                        <label for="carline">Carline</label>
                        <input type="text" class="form-control" id="carline">
                    </div>
                    <div class="form-group">
                        <label for="car_model">Car Model</label>
                        <input type="text" class="form-control" id="car_model">
                    </div>
                    <div class="form-group">
                        <label for="shift">Shift</label>
                        <input type="text" class="form-control" id="shift">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" id="kategori">
                    </div>
                    <div class="form-group">
                        <label for="mesin_no">Mesin Number</label>
                        <input type="text" class="form-control" id="mesin_no">
                    </div>
                    <div class="form-group">
                        <label for="stroke">Stroke</label>
                        <input type="text" class="form-control" id="stroke">
                    </div>
                    <div class="form-group">
                        <label for="order">Order</label>
                        <input type="text" class="form-control" id="order">
                    </div>
                    <div class="form-group">
                        <label for="part">Part</label>
                        <input type="text" class="form-control" id="part">
                    </div>
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="text" class="form-control" id="qty">
                    </div>
                    <div class="form-group">
                        <label for="alasan">Alasan Pergantian</label>
                        <input type="text" class="form-control" id="alasan">
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control" id="remarks">
                    </div>
                    <div class="form-group">
                        <label for="pic">PIC</label>
                        <input type="text" class="form-control" id="pic">
                    </div>
                </div>
                <!-- Conditional input fields for Assembly Fixture -->
                <div id="assemblyFixtureFields" style="display: none;">
                    <div class="form-group">
                        <label for="carline">Carline</label>
                        <input type="text" class="form-control" id="carline">
                    </div>
                    <div class="form-group">
                        <label for="car_model">Car Model</label>
                        <input type="text" class="form-control" id="car_model">
                    </div>
                    <div class="form-group">
                        <label for="shift">Shift</label>
                        <input type="text" class="form-control" id="shift">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" id="kategori">
                    </div>
                    <div class="form-group">
                        <label for="mesin_no">Mesin Number</label>
                        <input type="text" class="form-control" id="mesin_no">
                    </div>
                    <div class="form-group">
                        <label for="stroke">Stroke</label>
                        <input type="text" class="form-control" id="stroke">
                    </div>
                    <div class="form-group">
                        <label for="order">Order</label>
                        <input type="text" class="form-control" id="order">
                    </div>
                    <div class="form-group">
                        <label for="part">Part</label>
                        <input type="text" class="form-control" id="part">
                    </div>
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="text" class="form-control" id="qty">
                    </div>
                    <div class="form-group">
                        <label for="alasan">Alasan Pergantian</label>
                        <input type="text" class="form-control" id="alasan">
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control" id="remarks">
                    </div>
                    <div class="form-group">
                        <label for="pic">PIC</label>
                        <input type="text" class="form-control" id="pic">
                    </div>
                </div>
                <!-- Conditional input fields for Checker Fixture -->
                <div id="checkerFixtureFields" style="display: none;">
                    <div class="form-group">
                        <label for="carline">Carline</label>
                        <input type="text" class="form-control" id="carline">
                    </div>
                    <div class="form-group">
                        <label for="car_model">Car Model</label>
                        <input type="text" class="form-control" id="car_model">
                    </div>
                    <div class="form-group">
                        <label for="shift">Shift</label>
                        <input type="text" class="form-control" id="shift">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" id="kategori">
                    </div>
                    <div class="form-group">
                        <label for="mesin_no">Mesin Number</label>
                        <input type="text" class="form-control" id="mesin_no">
                    </div>
                    <div class="form-group">
                        <label for="stroke">Stroke</label>
                        <input type="text" class="form-control" id="stroke">
                    </div>
                    <div class="form-group">
                        <label for="order">Order</label>
                        <input type="text" class="form-control" id="order">
                    </div>
                    <div class="form-group">
                        <label for="part">Part</label>
                        <input type="text" class="form-control" id="part">
                    </div>
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="text" class="form-control" id="qty">
                    </div>
                    <div class="form-group">
                        <label for="alasan">Alasan Pergantian</label>
                        <input type="text" class="form-control" id="alasan">
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control" id="remarks">
                    </div>
                    <div class="form-group">
                        <label for="pic">PIC</label>
                        <input type="text" class="form-control" id="pic">
                    </div>
                </div>
                <!-- Additional labels and input fields -->
                <div class="form-group" hidden>
                    <label class="form-label">Part <span class="text-danger">*</span> </label>
                    <select class="form-control" name="part_id" id="part_id">
                        <option value="">- Pilih Part -</option>
                        @if(sizeof($parts) > 0)
                        @foreach($parts as $part)
                        <option value="{{ $part->part_id }}">{{ $part->part_no }} - {{ $part->part_name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitModal">Submit</button>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabDropdown = document.getElementById('tabDropdown');
        const modalContent = document.getElementById('modalContent');
        const crimpingDiesFields = document.getElementById('crimpingDiesFields');
        const sparePartMachineFields = document.getElementById('sparePartMachineFields');
        const assemblyFixtureFields = document.getElementById('assemblyFixtureFields');
        const checkerFixtureFields = document.getElementById('checkerFixtureFields');

        tabDropdown.addEventListener('change', function () {
            const selectedTab = tabDropdown.value;

            if (selectedTab === 'tab0') {
                // Reload the page when "Pilih Kategori" is selected
                location.reload();
            } else {
                // Hide/show the Crimping Dies or SparePart Machine input fields conditionally
                if (selectedTab === 'tab1') {
                    crimpingDiesFields.style.display = 'block';
                    sparePartMachineFields.style.display = 'none';
                    assemblyFixtureFields.style.display = 'none';
                    checkerFixtureFields.style.display = 'none';
                    modalContent.textContent = 'Crimping Dies';
                } else if (selectedTab === 'tab2') {
                    crimpingDiesFields.style.display = 'none';
                    sparePartMachineFields.style.display = 'block';
                    assemblyFixtureFields.style.display = 'none';
                    checkerFixtureFields.style.display = 'none';
                    modalContent.textContent = 'SparePart Machine';
                } else if (selectedTab === 'tab3') {
                    crimpingDiesFields.style.display = 'none';
                    sparePartMachineFields.style.display = 'none';
                    assemblyFixtureFields.style.display = 'block';
                    checkerFixtureFields.style.display = 'none';
                    modalContent.textContent = 'Assembly Fixture';
                } else if (selectedTab === 'tab4') {
                    crimpingDiesFields.style.display = 'none';
                    sparePartMachineFields.style.display = 'none';
                    assemblyFixtureFields.style.display = 'none';
                    checkerFixtureFields.style.display = 'block';
                    modalContent.textContent = 'Checker Fixture';
                } else {
                    crimpingDiesFields.style.display = 'none';
                    sparePartMachineFields.style.display = 'none';
                    assemblyFixtureFields.style.display = 'none';
                    checkerFixtureFields.style.display = 'none';

                    // Set the modal content based on the selected value
                    switch (selectedTab) {
                        default:
                            modalContent.textContent = 'Unknown selection.';
                    }
                }

                // Show the modal
                $('#myModal').modal('show');
            }
        });

        // Handle submit button click
        document.getElementById('submitModal').addEventListener('click', function () {
            // Retrieve values from the input fields as needed
            const carline = document.getElementById('carline').value;
            const carModel = document.getElementById('car_model').value;
            const shift = document.getElementById('shift').value;
            const kategori = document.getElementById('kategori').value;
            const mesinNo = document.getElementById('mesin_no').value;
            const stroke = document.getElementById('stroke').value;
            const order = document.getElementById('order').value;
            const part = document.getElementById('part').value;
            const qty = document.getElementById('qty').value;
            const alasan = document.getElementById('alasan').value;
            const remarks = document.getElementById('remarks').value;
            const pic = document.getElementById('pic').value;

            // You can perform actions with these values here
            // For example, send them to a server using AJAX

            // Close the modal
            $('#myModal').modal('hide');
        });
    });
</script>
@endsection


@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabDropdown = document.getElementById('tabDropdown');
        const modalContent = document.getElementById('modalContent');
        const crimpingDiesFields = document.getElementById('crimpingDiesFields');

        tabDropdown.addEventListener('change', function () {
            const selectedTab = tabDropdown.value;

            if (selectedTab === 'tab0') {
                // Reload the page when "Pilih Kategori" is selected
                location.reload();
            } else {
                // Hide/show the Crimping Dies input fields conditionally
                if (selectedTab === 'tab1') {
                    crimpingDiesFields.style.display = 'block';
                    modalContent.textContent = 'Crimping Dies';
                } else {
                    crimpingDiesFields.style.display = 'none';

                    // Set the modal content based on the selected value
                    switch (selectedTab) {
                        case 'tab2':
                            modalContent.textContent = 'SparePart Machine';
                            break;
                        case 'tab3':
                            modalContent.textContent = 'Assembly Fixture';
                            break;
                        case 'tab4':
                            modalContent.textContent = 'Checker Fixture';
                            break;
                        default:
                            modalContent.textContent = 'Unknown selection.';
                    }
                }

                // Show the modal
                $('#myModal').modal('show');
            }
        });

        // Handle submit button click
        document.getElementById('submitModal').addEventListener('click', function () {
            const partReqNumber = document.getElementById('part_req_number').value;
            const carline = document.getElementById('carline').value;
            const carModel = document.getElementById('car_model').value;
            const alasan = document.getElementById('alasan').value;
            const order = document.getElementById('order').value;
            const shift = document.getElementById('shift').value;
            const machineNo = document.getElementById('machine_no').value;
            const applicatorNo = document.getElementById('applicator_no').value;
            const wearAndTearCode = document.getElementById('wear_and_tear_code').value;
            const serialNo = document.getElementById('serial_no').value;
            const sideNo = document.getElementById('side_no').value;
            const stroke = document.getElementById('stroke').value;
            const pic = document.getElementById('pic').value;
            const remarks = document.getElementById('remarks').value;
            const partQty = document.getElementById('part_qty').value;
            const status = document.getElementById('status').value;
            const approvedBy = document.getElementById('approved_by').value;
            const partNo = document.getElementById('part_no').value;
            const wearAndTearStatus = document.getElementById('wear_and_tear_status').value;
            const anvil = document.getElementById('anvil').value;
            const insulationCrimper = document.getElementById('insulation_crimper').value;
            const wireCrimper = document.getElementById('wire_crimper').value;
            const other = document.getElementById('other').value;

            // You can perform actions with these values here
            // For example, send them to a server using AJAX

            // Close the modal
            $('#myModal').modal('hide');
        });
    });
</script>
@endsection
