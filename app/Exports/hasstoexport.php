<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Part\Repositories\PartRepository;

class HasstoExport implements FromCollection, ShouldAutoSize
{
    protected $partRepository;
    protected $categoryId;

    public function __construct($categoryId)
    {
        $this->partRepository = new PartRepository();
        $this->categoryId = $categoryId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $params = [
            'has_sto' => 'yes',
            'part_category_id' => $this->categoryId
        ];

        // Fetch data from the PartRepository
        $data = $this->partRepository->getAllByParams($params);

        // Group data by part_no and calculate the total qty_end for each part_no
        $groupedData = collect($data)->groupBy('part_no')->map(function ($items, $partNo) {
            return [
                'part_name' => $items->first()->part_name, // Assume part_name is the same for the same part_no
                'qty_end' => $items->sum('qty_end'), // Sum all qty_end for the same part_no
                'adjust' => $items->first()->adjust ?? 0, // Use the first adjust value or default to 0
            ];
        });

        // Calculate Qty Sistem for each part_no and prepare formatted data for export
        $formattedData = [
            ['Part Name', 'Part No', 'Qty End', 'Qty STO'] // Header row
        ];

        foreach ($groupedData as $partNo => $item) {
            $qtySistem = $this->calculateQtySistem($partNo);
            $formattedData[] = [
                $item['part_name'],
                $partNo,
                $qtySistem,
                $item['adjust']
            ];
        }

        return collect($formattedData);
    }

    /**
     * Calculate the total Qty Sistem for a given part_no
     *
     * @param string $partNo
     * @return int
     */
    private function calculateQtySistem($partNo)
    {
        $params = [
            'part_no' => $partNo
        ];

        // Fetch details for the given part_no
        $details = $this->partRepository->getAllByParams($params);

        // Calculate total qty_sistem
        return collect($details)->reduce(function ($total, $detail) {
            return $total + $detail->qty_begin + $detail->qty_in - $detail->qty_out;
        }, 0);
    }
}
