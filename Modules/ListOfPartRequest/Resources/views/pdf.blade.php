<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Of Part Request PDF</title>
</head>
<body>
    <h2>List Of Part Request</h2>
    <table border="1">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="5%">Date Transaksi</th>
                <th width="5%">Receiving</th>
                <th width="5%">Status Stok</th>
                <th width="5%">Molts No</th>
                <!-- <th width="5%">Applicator No</th> -->
                <th width="5%">Part Name</th>
                <th width="5%">Qty</th>
                <!-- <th width="5%">Machine</th>
                <th width="5%">Serial Number</th> -->
                <th width="5%">Shift</th>
                <th width="5%">Stroke</th>
                <th width="5%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($partrequests as $partrequest)
                <tr>
                <td>{{ $loop->iteration }}</td>
                                        <td>{{ substr($partrequest->updated_at, 0, 10) }}</td>
                                        <td>{{ $partrequest->part_req_number }}</td>
                                        <td>{{ $partrequest->status }}</td>
                                        <td>{{ $partrequest->molts_no }}</td>
                                        <!-- <td>{{ $partrequest->applicator_no }}</td> -->
                                        <td>{{ $partrequest->part_name }}</td>
                                        <td>{{ $partrequest->part_qty }}</td>
                                        <!-- <td>{{ $partrequest->machine_no }}</td>
                                        <td>{{ $partrequest->serial_no }}</td> -->
                                        <td>{{ $partrequest->shift }}</td>
                                        <td>{{ $partrequest->stroke }}</td>
                                        <td>
                                            @if ($partrequest->wear_and_tear_status == 'Open')
                                                <a data-id="{{ $partrequest->wear_and_tear_status }}"
                                                    data-toggle="tooltip" data-placement="top" title="Ubah">
                                                    <i width="16" height="16" class="open-text">Open</i>
                                                </a>
                                            @elseif($partrequest->wear_and_tear_status == 'On Progress')
                                                <a data-id="{{ $partrequest->wear_and_tear_status }}"
                                                    data-toggle="tooltip" data-placement="top" title="On Progress">
                                                    <i width="16" height="16" class="open-text2">On Progress</i>
                                                </a>
                                            @elseif($partrequest->wear_and_tear_status == 'Closed')
                                                <a data-id="{{ $partrequest->wear_and_tear_status }}"
                                                    data-toggle="tooltip" data-placement="top" title="Closed">
                                                    <i width="16" height="16" class="open-text3">Closed</i>
                                                </a>
                                            @endif
                                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
