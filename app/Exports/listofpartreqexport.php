<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\ListOfPartRequest\Repositories\ListOfPartRequestRepository;

class listofpartreqexport implements FromCollection, ShouldAutoSize
{
    protected $partRepository;

    // public function __construct(PartRepository $partRepository)
    // {
    //     $this->partRepository = $partRepository;
    // }

    public function __construct()
    {
        $this->partRepository = new ListOfPartRequestRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch data from the PartRepository
        $data = $this->partRepository->getAll();

        // Define the header row with all the specified field names
        $formattedData = [
            [
                'Part Req Number',
                'Part No',
                'Part Name',
                'Part Qty',
                'Carline',
                'Carname',
                'Alasan',
                'Order',
                'Shift',
                'Machine No',
                'Applicator No',
                'Wear And Tear Code',
                'Serial No',
                'Side No',
                'Stroke',
                'Pic',
                'Remarks',
                'Status',
                'Approved By',
                'Wear And Tear Status',
                'Tanggal Dibuat',

            ]
        ];

        // Loop through the data and add each row to the formatted data
        foreach ($data as $item) {
            $formattedData[] = [
                $item->part_req_number,
                $item->part_no,
                $item->part_name,
                $item->part_qty,
                $item->carline_name,
                $item->carname_name,
                $item->alasan,
                $item->order,
                $item->shift,
                $item->machine_no,
                $item->applicator_no,
                $item->wear_and_tear_code,
                $item->serial_no,
                $item->side_no,
                $item->stroke,
                $item->pic,
                $item->remarks,
                $item->status,
                $item->user_name,
                $item->wear_and_tear_status,
                $item->created_at,
            ];
        }

        return collect($formattedData);
    }

}
