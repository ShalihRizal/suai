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
                            <h3 class="h3">Part Consumption List || Detail</h3>
                            {{ date('Y-m-d') }}
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap table-data">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="5%">End Drawing</th>
                                    <th width="5%">No.Accessories</th>
                                    <th width="5%">Part Name</th>
                                    <th width="5%">Part No</th>
                                    <th width="5%">Type</th>
                                    <th width="5%">Tiang</th>
                                    <th width="5%">Qty Per J/B</th>
                                    <th width="5%">Qty Total</th>
                                    <th width="5%">Molts No</th>
                                    <th width="5%">Status</th>
                                    <th width="5%">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($partconsumptionlistsdetails) == 0)
                                    <tr>
                                        <td colspan="3" align="center">Data kosong</td>
                                    </tr>
                                @else
                                    @foreach ($partconsumptionlistsdetails as $partconsumptionlistsdetail)
                                        <tr class="part-row">
                                            <td width="5%">{{ $loop->iteration }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->end_drawing }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->no_accessories }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->part_name }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->part_no }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->type }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->tiang }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->qty_per_jb }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->qty_total }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->molts_no }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->status }}</td>
                                            <td width="5%">{{ $partconsumptionlistsdetail->remarks }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>


                    <div class="col-md-2">
                        <form action="{{ url('partconsumptionlist/upload/' . $partconsumptionlists->pcl_id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Upload <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="csv" id="csv">
                            </div>
                            <button type="submit" class="btn btn-success mb-3" style="width: 175px">
                                <i data-feather="upload" class="me-2"></i>
                                Upload & Import
                            </button>
                            <button id="printButton" class="btn btn-success mb-3" style="width: 175px">
                                <i data-feather="save" class="me-2"></i>
                                Print
                            </button>
                            {{-- <button id="downloadButton" class="btn btn-success mb-3" onclick="downloadFile()"
                            style="width: 175px">
                            <i data-feather="download" class="me-2"></i>
                            Download
                        </button> --}}

                            {{-- <button class="btn btn-info btnTemplate text-white mb-3" style="height: 100%;"
                        data-toggle="modal" data-target="#TemplateModal" onclick="downloadFile()">
                        <i data-feather="download" width="20" height="13" class="me-2"></i>
                        Download
                    </button> --}}
                            <div class="btn-group" style="width: 40px">
                                <a href="javascript:void(0)" class="btn btn-info btnTemplate text-white mb-3"
                                    style="height: 100%;" data-toggle="modal" data-target="#TemplateModal"
                                    onclick="downloadFile()">
                                    <i data-feather="download" width="20" height="13" class="me-2"></i>
                                    Download
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
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

    <script>
        function downloadFile() {
            // URL file yang ingin didownload
            var fileUrl = 'https://drive.google.com/uc?export=download&id=1mV2MIBwvJ5gON70cg6q0DpufCPLfwnve';

            // Nama file yang ingin ditampilkan saat diunduh
            var fileName = 'Header Part Consumption List';

            // Membuat elemen <a> untuk mendownload file
            var link = document.createElement('a');
            link.href = fileUrl;
            link.download = fileName;

            // Menambahkan elemen <a> ke dalam dokumen
            document.body.appendChild(link);

            // Simulasi klik pada elemen <a> untuk memulai proses unduhan
            link.click();

            // Menghapus elemen <a> setelah proses unduhan selesai
            document.body.removeChild(link);
        }
    </script>

@endsection
