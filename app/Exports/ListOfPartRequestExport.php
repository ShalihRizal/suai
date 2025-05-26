<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\ListOfPartRequest\Repositories\ListOfPartRequestRepository;

class ListOfPartRequestExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $repository = new ListOfPartRequestRepository();
        $query = $repository->getAll();

        if ($this->startDate && $this->endDate) {
            $query = $query->whereBetween('part_request_created_at', [$this->startDate, $this->endDate]);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Part Req Number',
            'Waktu',
            'Carname',
            'Car Model',
            'Alasan',
            'Order',
            'Shift',
            'Machine No',
            'Applicator No',
            'Applicator No Input',
            'Wear And Tear Code',
            'Serial No',
            'Side No',
            'Stroke',
            'Pic',
            'Remarks',
            'Part Qty',
            'Status',
            'Approved By',
            'Part No',
            'Wear And Tear Status'
        ];
    }

    public function map($partrequest): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $partrequest->part_req_number,
            $partrequest->part_request_created_at,
            $partrequest->carname_name,
            $partrequest->carline_name,
            $partrequest->alasan,
            $partrequest->kategori,
            $partrequest->shift,
            $partrequest->machine_no,
            $partrequest->applicator_no,
            $partrequest->applicator_no2,
            $partrequest->wear_and_tear_code,
            $partrequest->serial_no,
            $partrequest->side_no,
            $partrequest->stroke,
            $partrequest->pic,
            $partrequest->remarks2,
            $partrequest->part_qty,
            $partrequest->status,
            $partrequest->user_name ? $partrequest->user_name : 'Belum Di Approve',
            $partrequest->part_no,
            $partrequest->wear_and_tear_status
        ];
    }
} 