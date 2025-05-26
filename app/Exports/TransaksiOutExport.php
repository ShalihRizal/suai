<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\TransaksiOut\Repositories\TransaksiOutRepository;

class TransaksiOutExport implements FromCollection, WithHeadings, WithMapping
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
        $repository = new TransaksiOutRepository();
        $query = $repository->getAll();

        if ($this->startDate && $this->endDate) {
            $query = $query->whereBetween('transaksi_created_at', [$this->startDate, $this->endDate]);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Invoice No',
            'Part Number',
            'Part Name',
            'Quantity',
            'Created At'
        ];
    }

    public function map($transaksi): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $transaksi->invoice_no,
            $transaksi->part_no,
            $transaksi->part_name,
            $transaksi->qty,
            $transaksi->transaksi_created_at
        ];
    }
} 