<?php

namespace Modules\MonthlyReport\Http\Controllers;

use Modules\PartCategory\Repositories\PartCategoryRepository;
use Modules\Part\Repositories\PartRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use App\Exports\partexport;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

use App\Helpers\LogHelper;

class MonthlyReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->_partCategoryRepository = new PartCategoryRepository;
        $this->_partRepository = new PartRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "MonthlyReport";
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {


        $partcategories = $this->_partCategoryRepository->getAll();
        $parts = $this->_partRepository->getAll();
        return view('monthlyreport::index', compact('partcategories', 'parts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('monthlyreport::create');
    }

    public function exportExcel()
{
    
    // Inisialisasi Spreadsheet
    $spreadsheet = new Spreadsheet();

    $parts = $this->_partRepository->getAll();
    $partcategories = $this->_partCategoryRepository->getAll();
    $partcategories = $this->_partCategoryRepository->getAll();

    // Buat objek worksheet
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->mergeCells('A12:A14');
    $sheet->mergeCells('B12:B14');
    $sheet->mergeCells('C12:E13');
    $sheet->getColumnDimension('A')->setWidth(30); // Mengatur lebar kolom A menjadi 15
    $sheet->getColumnDimension('B')->setWidth(30); // Mengatur lebar kolom A menjadi 15
    $sheet->getColumnDimension('C')->setWidth(15); // Mengatur lebar kolom A menjadi 15
    $sheet->getColumnDimension('D')->setWidth(15); // Mengatur lebar kolom A menjadi 15
    $sheet->getColumnDimension('E')->setWidth(15); // Mengatur lebar kolom A menjadi 15
    $sheet->getStyle('A1:AZ100')->getAlignment()->setHorizontal('center'); // Mengatur teks rata tengah
    $sheet->getStyle('A1:AZ100')->getAlignment()->setVertical('center'); // Mengatur teks rata tengah

    // Set data ke sel-sel
    if (sizeof($partcategories) > 0) {
        $row = 15; // Initialize the row variable
        foreach ($partcategories as $partCategory) {
            $cell = 'A' . $row; // Build the cell reference with the current row
            $sheet->setCellValue($cell, $partCategory->part_category_name);
            $row++; // Increment the row variable for the next iteration
        }
    }

    $sheet->setCellValue('A12', 'Inventory');
    $sheet->setCellValue('B12', 'Import/Lokal');
    $sheet->setCellValue('C12', 'Begin August-23');
    $sheet->setCellValue('C14', 'QTY');
    $sheet->setCellValue('D14', 'AMOUNT(USD)');
    $sheet->setCellValue('E14', 'AMOUNT(IDR)');
    $sheet->setCellValue('F14', 'IN GIT AUGUST');


    // Buat file Excel
    $writer = new Xlsx($spreadsheet);
    $filename = 'merged_cells_example.xlsx';

    // Simpan file Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
}

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('monthlyreport::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('monthlyreport::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
