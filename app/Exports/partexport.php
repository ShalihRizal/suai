<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Part\Repositories\PartRepository;

class partexport implements FromCollection, ShouldAutoSize
{
    protected $partRepository;

    // public function __construct(PartRepository $partRepository)
    // {
    //     $this->partRepository = $partRepository;
    // }

    public function __construct()
    {
        $this->partRepository = new PartRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch data from the PartRepository
        $data = $this->partRepository->getAll();

        // Format the data as required for export
        $formattedData = [['Name', 'Part Number']];


        foreach ($data as $item) {
            $formattedData[] = ["=2+2", $item->part_no]; // Adjust the columns as per your needs
        }

        return collect($formattedData);
    }
}
