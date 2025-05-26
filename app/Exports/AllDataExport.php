<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\TransaksiIn\Repositories\TransaksiInRepository;
use Modules\TransaksiOut\Repositories\TransaksiOutRepository;
use Modules\ListOfPartRequest\Repositories\ListOfPartRequestRepository;

class AllDataExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        $transaksiInRepo = new TransaksiInRepository();
        $transaksiOutRepo = new TransaksiOutRepository();
        $listOfPartReqRepo = new ListOfPartRequestRepository();

        $transaksiIn = $transaksiInRepo->getAll();
        $transaksiOut = $transaksiOutRepo->getAll();
        $listOfPartReq = $listOfPartReqRepo->getAll();

        return collect([
            'transaksi_in' => $transaksiIn,
            'transaksi_out' => $transaksiOut,
            'list_of_part_request' => $listOfPartReq
        ]);
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis Data',
            'Invoice No',
            'Part Number',
            'Part Name',
            'Quantity',
            'Created At',
            'Status'
        ];
    }

    public function map($data): array
    {
        static $index = 0;
        $index++;

        $result = [];
        foreach ($data as $type => $items) {
            foreach ($items as $item) {
                $result[] = [
                    $index++,
                    ucfirst(str_replace('_', ' ', $type)),
                    $item->invoice_no ?? $item->part_req_number ?? '-',
                    $item->part_no ?? '-',
                    $item->part_name ?? '-',
                    $item->qty ?? $item->part_qty ?? '-',
                    $item->transaksi_created_at ?? $item->part_request_created_at ?? '-',
                    $item->status ?? $item->wear_and_tear_status ?? '-'
                ];
            }
        }

        return $result;
    }
} 