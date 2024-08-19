<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Part\Repositories\PartRepository;

class NostoExport implements FromCollection, ShouldAutoSize
{
    protected $partRepository;

    public function __construct()
    {
        $this->partRepository = new PartRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $params = [
            'has_sto' => 'no'
        ];

        // Fetch data from the PartRepository
        $data = $this->partRepository->getAllByParams($params);

        // Initialize totals
        $totalParts = count($data);
        $totalQty = array_sum(array_map(function ($item) {
            return $item->qty_end;
        }, $data->toArray()));

        // Format the data as required for export
        $formattedData = [
            ['Total Part Yang belum STO:', $totalParts],
            ['Total Qty yang belum STO:', $totalQty],
            [''],
            ['PartName', 'Part No', 'Qty']
        ];

        foreach ($data as $item) {
            $formattedData[] = [$item->part_name, $item->part_no, $item->qty_end]; // Adjust the columns as per your needs
        }

        return collect($formattedData);
    }
}
