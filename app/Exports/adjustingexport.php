<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\StockOpname\Repositories\LogPartRequestRepository;

class AdjustingExport implements FromCollection, ShouldAutoSize
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

        // Initialize totals
        $totalParts = count($data);

        // Format the data as required for export
        $formattedData = [
            ['Total Part Yang Adjusting:', $totalParts],
            [''],
            ['Part Number', 'Adjusting']
        ];

        foreach ($data as $item) {
            $formattedData[] = [$item->part_no, $item->description]; // Adjust the columns as per your needs
        }

        return collect($formattedData);
    }
}
