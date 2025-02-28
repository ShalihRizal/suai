<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\StockOpname\Repositories\LogPartRequestRepository;

class Adjusting implements FromCollection, ShouldAutoSize
{

    protected $partRepository;

    public function __construct()
    {
        $this->partRepository = new LogPartRequestRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch data from the LogPartRequestRepository
        $data = $this->partRepository->getAll();

        // Remove duplicate entries based on a unique attribute, e.g., 'part_no'
        $data = $data->unique('part_no');

        // Initialize totals
        $totalParts = count($data);

        // Format the data as required for export
        $formattedData = [
            ['Total Part Yang Adjusting:', $totalParts],
            [''],
            ['Part Number', 'Qty Actual', 'Qty Sistem', 'Qty STO']
        ];

        $qty_end = 0;

        foreach ($data as $item) {
            if ($item->qty_end == 0) {
                $qty_end = "0";
            } else {
                $qty_end = $item->qty_end;
            }

            // Check if qty_actual is null or 0
            $qty_actual = ($item->qty_actual === null || $item->qty_actual == 0) ? "0" : $item->qty_actual;

            $formattedData[] = [$item->part_no, $item->description, $qty_end, $qty_actual]; // Adjust the columns as per your needs
        }

        return collect($formattedData);
    }
}
