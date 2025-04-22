<?php
namespace Modules\MonthlyReport\Http\Controllers;

use Modules\PartCategory\Repositories\PartCategoryRepository;
use Modules\Part\Repositories\PartRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use GuzzleHttp\Client;
use App\Exports\partexport;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
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

    public function getPriceInByWearAndTearCode($part_id, $kategori, $wear_and_tear_code, $dateBegin, $dateEnd)
    {
        if (!$this->isValidDate($dateBegin) || !$this->isValidDate($dateEnd)) {
            return 0;
        }

        $allParts = $this->_partRepository->getAll();

        // Define your conditions here
        $conditions = [
            'part_category_id' => $part_id,
            'kategori' => $kategori,
            'wear_and_tear_code' => $wear_and_tear_code
        ];

        $qtyParts = $allParts->filter(function ($part) use ($conditions, $dateBegin, $dateEnd) {
            foreach ($conditions as $key => $value) {
                if ($part->{$key} != $value) {
                    return false;
                }
            }
            
            // Filter by used_date within the specified range
            if ($part->used_date) {
                return (strtotime($part->used_date) >= strtotime($dateBegin) && 
                       strtotime($part->used_date) <= strtotime($dateEnd));
            }
            return false;
        });

        // Jika tidak ada data dalam range waktu yang dipilih, return 0
        if ($qtyParts->isEmpty()) {
            return 0;
        }

        // Menghitung total price berdasarkan qty_in
        $total = $qtyParts->sum(function($part) {
            return ($part->qty_in * ($part->price ?? 0));
        });
        
        return $total ?: 0;
    }

    public function getPriceOutByWearAndTearCode($part_id, $kategori, $wear_and_tear_code, $dateBegin, $dateEnd)
    {
        if (!$this->isValidDate($dateBegin) || !$this->isValidDate($dateEnd)) {
            return 0;
        }

        $allParts = $this->_partRepository->getAll();

        // Define your conditions here
        $conditions = [
            'part_category_id' => $part_id,
            'kategori' => $kategori,
            'wear_and_tear_code' => $wear_and_tear_code
        ];

        $qtyParts = $allParts->filter(function ($part) use ($conditions, $dateBegin, $dateEnd) {
            foreach ($conditions as $key => $value) {
                if ($part->{$key} != $value) {
                    return false;
                }
            }
            
            // Filter by used_date within the specified range
            if ($part->used_date) {
                return (strtotime($part->used_date) >= strtotime($dateBegin) && 
                       strtotime($part->used_date) <= strtotime($dateEnd));
            }
            return false;
        });

        // Jika tidak ada data dalam range waktu yang dipilih, return 0
        if ($qtyParts->isEmpty()) {
            return 0;
        }

        // Menghitung total price berdasarkan qty_out
        $total = $qtyParts->sum(function($part) {
            return ($part->qty_out * ($part->price ?? 0));
        });
        
        return $total ?: 0;
    }

    public function getPriceEndByWearAndTearCode($part_id, $kategori, $wear_and_tear_code, $dateBegin, $dateEnd)
    {
        if (!$this->isValidDate($dateBegin) || !$this->isValidDate($dateEnd)) {
            return 0;
        }

        $allParts = $this->_partRepository->getAll();

        // Define your conditions here
        $conditions = [
            'part_category_id' => $part_id,
            'kategori' => $kategori,
            'wear_and_tear_code' => $wear_and_tear_code
        ];

        $qtyParts = $allParts->filter(function ($part) use ($conditions, $dateBegin, $dateEnd) {
            foreach ($conditions as $key => $value) {
                if ($part->{$key} != $value) {
                    return false;
                }
            }
            
            // Filter by used_date within the specified range
            if ($part->used_date) {
                return (strtotime($part->used_date) >= strtotime($dateBegin) && 
                       strtotime($part->used_date) <= strtotime($dateEnd));
            }
            return false;
        });

        // Jika tidak ada data dalam range waktu yang dipilih, return 0
        if ($qtyParts->isEmpty()) {
            return 0;
        }

        // Menghitung total price berdasarkan qty_end
        $total = $qtyParts->sum(function($part) {
            return ($part->qty_end * ($part->price ?? 0));
        });
        
        return $total ?: 0;
    }

    public function exportExcel(Request $request )
    {

        // Inisialisasi Spreadsheet
        $spreadsheet = new Spreadsheet();

        //Repositories
        $parts = $this->_partRepository->getAll();
        $partcategories = $this->_partCategoryRepository->getAll();
        $partcategories = $this->_partCategoryRepository->getAll();
        $dateBegin = $request->input('date_begin');
        $dateEnd = $request->input('date_end');

        // Buat objek worksheet
        $sheet = $spreadsheet->getActiveSheet();

        //Merge
        $mergeCells = [
            'A12:A14',
            'A25:B25',
            'C12:E13',
            'A36:A37',
            'A38:A39',
            'A40:A41',
            'B12:B14',
            'B36:B37',
            'C36:E36',
            'F12:H13',
            'I12:K13',
            'L12:Q12',
            'L13:N13',
            'O13:Q13',
            'A27:B29',
            'C27:E28',
            'F27:Q28',
            'R27:AC28',
            'A34:B34',
            'A32:A33',
            'A32:A33',
            'A43:E43',
            'B45:C45',
            'D45:E45',
            'F45:G45',
            'H45:I45',
            'J45:K45',
            'L45:M45',
            'B46:C46',
            'D46:E46',
            'F46:G46',
            'H46:I46',
            'J46:K46',
            'L46:M46',
            'B47:C47',
            'D47:E47',
            'F47:G47',
            'H47:I47',
            'J47:K47',
            'L47:M47',
            // 'M45:N47',
            'Q57:U57',
            'A56:U56',
            'A66:A67',
            'B66:E66',
            'AD27:AF28',
            'AG27:AI28',
            'R12:T13',
            'U12:W13',
        ];


        foreach ($mergeCells as $mergeCell) {
            $sheet->mergeCells($mergeCell);
        }

        $range = 'C15:W25';
        $style = $sheet->getStyle($range);
        $font = $style->getFont();
        $font->setSize(8);


        //Dimensions
        $columns = ['A' => 40, 'B' => 30, 'F' => 30, 'G' => 15, 'H' => 15, 'I' => 15, 'J' => 15, 'K' => 15, 'L' => 15, 'M' => 15, 'N' => 15, 'O' => 15, 'P' => 15, 'Q' => 15, 'R' => 15, 'S' => 15, 'T' => 15, 'U' => 15, 'V' => 15, 'W' => 15, 'X' => 15, 'Y' => 15, 'Z' => 15, 'AA' => 15, 'AB' => 15, 'AC' => 15, 'AD' => 15, 'AE' => 15, 'AF' => 15, 'AG' => 15, 'AH' => 15, 'AI' => 15];

        foreach ($columns as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        for ($column = 'C'; $column <= 'W'; $column++) {
            $sheet->getColumnDimension($column)->setWidth(15);
        }


        // //values qty
        // $calculatedValue = $this->calculateQtyBegin('1','Import');
        // $sheet->setCellValue('C15', "5");
        // $calculatedValue = $this->calculateQtyBegin('1','Lokal');
        // $sheet->setCellValue('C16', $calculatedValue);


        //Style
        $sheet->getStyle('A1:AZ100')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:AZ100')->getAlignment()->setVertical('center');
        $sheet->getStyle('C15:W25')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A43')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A55')->getAlignment()->setHorizontal('left');
        $range = 'C15:W25';
        $style = $sheet->getStyle($range);
        $font = $style->getFont();
        $font->setSize(8);
        $range = 'A12:W14';
        $style = $sheet->getStyle($range);
        $font = $style->getFont();
        $font->setBold(true);
        $range = 'A25:W25';
        $style = $sheet->getStyle($range);
        $font = $style->getFont();
        $font->setBold(true);
        $range = 'A12:W25';
        $style = $sheet->getStyle($range);
        $style->getAlignment()->setWrapText(true);
        $style->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $range = 'A27:AI34';
        $style = $sheet->getStyle($range);
        $style->getAlignment()->setWrapText(true);
        $style->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $range = 'A36:S41';
        $style = $sheet->getStyle($range);
        $style->getAlignment()->setWrapText(true);
        $style->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $range = 'A45:M47';
        $style = $sheet->getStyle($range);
        $style->getAlignment()->setWrapText(true);
        $style->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Single Cells/Manual Labor
        for ($column = 'C'; $column <= 'W'; $column++) {
            $cell = $column . '25';
            $range = $column . '15:' . $column . '22';
            $sheet->setCellValue($cell, "=SUM($range)");
        }

        $cellValues = [
            'D14' => 'AMOUNT(USD)',
            'A25' => 'TOTAL',
            'E14' => 'AMOUNT(IDR)',
            'F12' => 'IN GIT '.strtoupper(date('F')).' '.date('Y'),
            'F14' => 'QTY',
            'G14' => 'AMOUNT(USD)',
            'H14' => 'AMOUNT(IDR)',
            'I12' => 'IN CIP '.strtoupper(date('F')).' '.date('Y'),
            'I14' => 'QTY',
            'J14' => 'AMOUNT(USD)',
            'K14' => 'AMOUNT(IDR)',
            'L14' => 'QTY',
            'M14' => 'AMOUNT(USD)',
            'N14' => 'AMOUNT(IDR)',
            'O14' => 'QTY',
            'P14' => 'AMOUNT(USD)',
            'Q14' => 'AMOUNT(IDR)',
            'R14' => 'QTY',
            'R12' => 'ADJ STO',
            'S14' => 'AMOUNT(USD)',
            'T14' => 'AMOUNT(IDR)',
            'U12' => 'INVENTORY STORAGE END '.strtoupper(date('F')).' '.date('Y'),
            'U14' => 'QTY',
            'V14' => 'AMOUNT(USD)',
            'W14' => 'AMOUNT(IDR)',
            'L12' => 'USAGE '.strtoupper(date('F')).' '.date('Y'),
            'L13' => 'CIP',
            'O13' => 'EXPENSE',
            'A36' => 'Kategori',
            'A38' => 'Crimping Dies',
            'A40' => 'Sparepart Machine',
            'B36' => 'IMPORT/LOKAL',
            'B38' => 'IMPORT',
            'B39' => 'LOKAL',
            'B40' => 'IMPORT',
            'B41' => 'LOKAL',
            'C36' => 'W & T Code Beg (USD)',
            'F36' => 'W & T Code In (USD)',
            'I36' => 'W & T Code Out (USD)',
            'L36' => 'W & T Code End (USD)',
            'O36' => 'W & T Code End (IDR)',
            'R36' => 'End',
            'C37' => '101',
            'D37' => '102',
            'E37' => '108',
            'F37' => '101',
            'G37' => '102',
            'H37' => '108',
            'I37' => '101',
            'J37' => '102',
            'K37' => '108',
            'L37' => '101',
            'M37' => '102',
            'N37' => '108',
            'O37' => '101',
            'P37' => '102',
            'Q37' => '108',
            'R37' => 'USD',
            'S37' => 'IDR',
            'A49' => 'Recalculation Aging Inventory Wear and Tear (DEADSTOCK > 2 YEAR)',
            'A43' => 'Recalculation Aging Inventory Wear and Tear',
            'A45' => 'Kategori',
            'A46' => 'TOTAL AGING INVENTORY AF & CF',
            'A47' => 'TOTAL',
            'AA28' => 'MOVE TO INVENTORY',
            'AA29' => 'QTY',
            'AB29' => 'AMOUNT(USD)',
            'AC29' => 'AMOUNT(IDR)',
            'AD27' => 'ADJ STO',
            'AD29' => 'QTY',
            'AE29' => 'AMOUNT(USD)',
            'AF29' => 'AMOUNT(IDR)',
            'AG27' => 'END CIP MESIN'.strtoupper(date('F')).' '.date('Y'),
            'AG29' => 'QTY',
            'AH29' => 'AMOUNT(USD)',
            'AI29' => 'AMOUNT(IDR',
            'A34' => 'TOTAL',
            'C34' => '=+SUM(C30:C33)',
            'D34' => '=+SUM(D30:D33)',
            'E34' => '=+SUM(E30:E33)',
            'F34' => '=+SUM(F30:F33)',
            'G34' => '=+SUM(G30:G33)',
            'H34' => '=+SUM(H30:H33)',
            'I34' => '=+SUM(I30:I33)',
            'J34' => '=+SUM(J30:J33)',
            'K34' => '=+SUM(K30:K33)',
            'L34' => '=+SUM(L30:L33)',
            'M34' => '=+SUM(M30:M33)',
            'N34' => '=+SUM(N30:N33)',
            'O34' => '=+SUM(O30:O33)',
            'P34' => '=+SUM(P30:P33)',
            'Q34' => '=+SUM(Q30:Q33)',
            'R34' => '=+SUM(R30:R33)',
            'S34' => '=+SUM(S30:S33)',
            'T34' => '=+SUM(T30:T33)',
            'U34' => '=+SUM(U30:U33)',
            'V34' => '=+SUM(V30:V33)',
            'W34' => '=+SUM(W30:W33)',
            'X34' => '=+SUM(X30:X33)',
            'Y34' => '=+SUM(Y30:Y33)',
            'Z34' => '=+SUM(Z30:Z33)',
            'AA34' => '=+SUM(AA30:AA33)',
            'AB34' => '=+SUM(AB30:AB33)',
            'AC34' => '=+SUM(AC30:AC33)',
            'AD34' => '=+SUM(AD30:AD33)',
            'AE34' => '=+SUM(AE30:AE33)',
            'AF34' => '=+SUM(AF30:AF33)',
            'AG34' => '=+SUM(AG30:AG33)',
            'AH34' => '=+SUM(AH30:AH33)',
            'AI34' => '=+SUM(AI30:AI33)',
            'A12' => 'INVENTORY',
            'A24' => 'TOTAL',
            'B12' => 'IMPORT/LOKAL',
            'C12' => 'BEGIN '.strtoupper(date('F')).' '.date('Y'),
            'C14' => 'QTY',
            'A27' => 'CIP TOTAL (CIP INLINE+CIP)',
            'B27' => 'IMPORT LOKAL',
            'C27' => 'BEGIN'.strtoupper(date('F')).' '.date('Y'),
            'C29' => 'QTY',
            'D29' => 'AMOUNT(USD)',
            'E29' => 'AMOUNT(IDR)',
            'F27' => 'IN'.strtoupper(date('F')).' '.date('Y'),
            'F28' => 'IN GIT',
            'F29' => 'QTY',
            'G29' => 'AMOUNT(USD)',
            'H29' => 'AMOUNT(IDR)',
            'I28' => 'IN FROM CIP',
            'I29' => 'QTY',
            'J29' => 'AMOUNT(USD)',
            'K29' => 'AMOUNT(IDR)',
            'L28' => 'IN FROM ASSET CLEARING',
            'L29' => 'QTY',
            'M29' => 'AMOUNT(USD)',
            'N29' => 'AMOUNT(IDR)',
            'O28' => 'IN FROM INVENTORY',
            'O29' => 'QTY',
            'P29' => 'AMOUNT(USD)',
            'Q29' => 'AMOUNT(IDR)',
            'R27' => 'TRANSAKSI OUT'.strtoupper(date('F')).' '.date('Y'),
            'R28' => 'EXPENSE',
            'R29' => 'QTY',
            'S29' => 'AMOUNT(USD)',
            'T29' => 'AMOUNT(IDR)',
            'U28' => 'ASSET',
            'U29' => 'QTY',
            'V29' => 'AMOUNT(USD)',
            'W29' => 'AMOUNT(IDR)',
            'X28' => 'CIP',
            'X29' => 'QTY',
            'Y29' => 'AMOUNT(USD)',
            'Z29' => 'AMOUNT(IDR)',
            'B45' => 'Last Month (USD)',
            'D45' => 'This Month (USD)',
            'F45' => 'Last Month (IDR)',
            'H45' => 'This Month (IDR)',
            'J45' => 'Difference (USD)',
            'L45' => 'Difference (IDR)',
            'C47' => '=+SUM(B46:C46)',
            'E47' => '=+SUM(D46:E46)',
            'G47' => '=+SUM(F46:G46)',
            'I47' => '=+SUM(H46:I46)',
            'K47' => '=+SUM(J46:K46)',
            'M47' => '=+SUM(L46:M46)',
            'A30' => 'CIP ASSEMBLY FICTURE',
            'A32' => 'CIP CHECKER FICTURE',
            'B30' => 'IMPORT',
            'B31' => 'LOKAL',
            'B32' => 'IMPORT',
            'B33' => 'LOKAL',
            'A56' => 'KATEGORI',
            'B56' => 'SUPPLIER (USD)',
            'L56' => 'SUPPLIER (IDR)',
            'B57' => 'LOKAL',
            'G57' => 'IMPORT',
            'L57' => 'LOKAL',
            'Q57' => 'IMPORT',
            'B58' => '101',
            'C58' => '102',
            'D58' => '105',
            'E58' => '106',
            'F58' => '108',
            'G58' => '101',
            'H58' => '102',
            'I58' => '105',
            'J58' => '106',
            'K58' => '108',
            'L58' => '101',
            'M58' => '102',
            'N58' => '105',
            'O58' => '106',
            'P58' => '108',
            'Q58' => '101',
            'R58' => '102',
            'S58' => '105',
            'T58' => '106',
            'U58' => '108',
            'A59' => 'ASSEMBLY FIXTURE (CIP)',
            'A60' => 'CHECKER FIXTURE (CIP)',
            'A61' => 'CRIMPING DIES',
            'A62' => 'SPAREPART MACHINE',
            'A66' => 'INVENTORY',
            'B66' => 'JUL-23',
            'D66' => 'AUG-23',
            'A68' => 'CLIMPING DIES',
            'A69' => 'SPAREPART MACHINE',
            'A70' => 'ASSEMBLY FIXTURE(INVENTORY)+CIP',
            'A71' => 'CHECKER FIXTURE(INVENTORY)+CIP',
            'B67' => 'QTY IN',
            'C67' => 'AMOUNT',
            'D67' => 'QTY IN',
            'E67' => 'AMOUNT',
            'A72' => 'TOTAL',
            'B72' => '=+SUM(B68:B71)',
            'C72' => '=+SUM(C68:C71)',
            'D72' => '=+SUM(D68:D71)',
            'E72' => '=+SUM(E68:E71)',
        ];



        foreach ($cellValues as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Crimping Dies - IMPORT dengan wear_and_tear_code 101
        $priceCrimpingImport101 = $this->getPriceByWearAndTearCode(1, 'IMPORT', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('C38', $priceCrimpingImport101);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 101
        $priceCrimpingLokal101 = $this->getPriceByWearAndTearCode(1, 'LOKAL', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('C39', $priceCrimpingLokal101);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 101
        $priceSparepartImport101 = $this->getPriceByWearAndTearCode(2, 'IMPORT', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('C40', $priceSparepartImport101);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 101
        $priceSparepartLokal101 = $this->getPriceByWearAndTearCode(2, 'LOKAL', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('C41', $priceSparepartLokal101);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 102
        $priceCrimpingImport102 = $this->getPriceByWearAndTearCode(1, 'IMPORT', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('D38', $priceCrimpingImport102);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 102
        $priceCrimpingLokal102 = $this->getPriceByWearAndTearCode(1, 'LOKAL', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('D39', $priceCrimpingLokal102);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 102
        $priceSparepartImport102 = $this->getPriceByWearAndTearCode(2, 'IMPORT', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('D40', $priceSparepartImport102);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 102
        $priceSparepartLokal102 = $this->getPriceByWearAndTearCode(2, 'LOKAL', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('D41', $priceSparepartLokal102);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 108
        $priceCrimpingImport108 = $this->getPriceByWearAndTearCode(1, 'IMPORT', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('E38', $priceCrimpingImport108);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 108
        $priceCrimpingLokal108 = $this->getPriceByWearAndTearCode(1, 'LOKAL', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('E39', $priceCrimpingLokal108);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 108
        $priceSparepartImport108 = $this->getPriceByWearAndTearCode(2, 'IMPORT', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('E40', $priceSparepartImport108);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 108
        $priceSparepartLokal108 = $this->getPriceByWearAndTearCode(2, 'LOKAL', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('E41', $priceSparepartLokal108);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 101 (qty_in)
        $priceInCrimpingImport101 = $this->getPriceInByWearAndTearCode(1, 'IMPORT', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('F38', $priceInCrimpingImport101);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 101 (qty_in)
        $priceInCrimpingLokal101 = $this->getPriceInByWearAndTearCode(1, 'LOKAL', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('F39', $priceInCrimpingLokal101);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 101 (qty_in)
        $priceInSparepartImport101 = $this->getPriceInByWearAndTearCode(2, 'IMPORT', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('F40', $priceInSparepartImport101);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 101 (qty_in)
        $priceInSparepartLokal101 = $this->getPriceInByWearAndTearCode(2, 'LOKAL', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('F41', $priceInSparepartLokal101);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 102 (qty_in)
        $priceInCrimpingImport102 = $this->getPriceInByWearAndTearCode(1, 'IMPORT', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('G38', $priceInCrimpingImport102);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 102 (qty_in)
        $priceInCrimpingLokal102 = $this->getPriceInByWearAndTearCode(1, 'LOKAL', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('G39', $priceInCrimpingLokal102);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 102 (qty_in)
        $priceInSparepartImport102 = $this->getPriceInByWearAndTearCode(2, 'IMPORT', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('G40', $priceInSparepartImport102);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 102 (qty_in)
        $priceInSparepartLokal102 = $this->getPriceInByWearAndTearCode(2, 'LOKAL', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('G41', $priceInSparepartLokal102);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 108 (qty_in)
        $priceInCrimpingImport108 = $this->getPriceInByWearAndTearCode(1, 'IMPORT', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('H38', $priceInCrimpingImport108);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 108 (qty_in)
        $priceInCrimpingLokal108 = $this->getPriceInByWearAndTearCode(1, 'LOKAL', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('H39', $priceInCrimpingLokal108);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 108 (qty_in)
        $priceInSparepartImport108 = $this->getPriceInByWearAndTearCode(2, 'IMPORT', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('H40', $priceInSparepartImport108);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 108 (qty_in)
        $priceInSparepartLokal108 = $this->getPriceInByWearAndTearCode(2, 'LOKAL', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('H41', $priceInSparepartLokal108);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 101 (qty_out)
        $priceOutCrimpingImport101 = $this->getPriceOutByWearAndTearCode(1, 'IMPORT', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('I38', $priceOutCrimpingImport101);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 101 (qty_out)
        $priceOutCrimpingLokal101 = $this->getPriceOutByWearAndTearCode(1, 'LOKAL', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('I39', $priceOutCrimpingLokal101);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 101 (qty_out)
        $priceOutSparepartImport101 = $this->getPriceOutByWearAndTearCode(2, 'IMPORT', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('I40', $priceOutSparepartImport101);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 101 (qty_out)
        $priceOutSparepartLokal101 = $this->getPriceOutByWearAndTearCode(2, 'LOKAL', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('I41', $priceOutSparepartLokal101);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 102 (qty_out)
        $priceOutCrimpingImport102 = $this->getPriceOutByWearAndTearCode(1, 'IMPORT', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('J38', $priceOutCrimpingImport102);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 102 (qty_out)
        $priceOutCrimpingLokal102 = $this->getPriceOutByWearAndTearCode(1, 'LOKAL', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('J39', $priceOutCrimpingLokal102);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 102 (qty_out)
        $priceOutSparepartImport102 = $this->getPriceOutByWearAndTearCode(2, 'IMPORT', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('J40', $priceOutSparepartImport102);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 102 (qty_out)
        $priceOutSparepartLokal102 = $this->getPriceOutByWearAndTearCode(2, 'LOKAL', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('J41', $priceOutSparepartLokal102);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 108 (qty_out)
        $priceOutCrimpingImport108 = $this->getPriceOutByWearAndTearCode(1, 'IMPORT', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('K38', $priceOutCrimpingImport108);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 108 (qty_out)
        $priceOutCrimpingLokal108 = $this->getPriceOutByWearAndTearCode(1, 'LOKAL', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('K39', $priceOutCrimpingLokal108);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 108 (qty_out)
        $priceOutSparepartImport108 = $this->getPriceOutByWearAndTearCode(2, 'IMPORT', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('K40', $priceOutSparepartImport108);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 108 (qty_out)
        $priceOutSparepartLokal108 = $this->getPriceOutByWearAndTearCode(2, 'LOKAL', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('K41', $priceOutSparepartLokal108);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 101 (qty_end)
        $priceEndCrimpingImport101 = $this->getPriceEndByWearAndTearCode(1, 'IMPORT', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('L38', $priceEndCrimpingImport101);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 101 (qty_end)
        $priceEndCrimpingLokal101 = $this->getPriceEndByWearAndTearCode(1, 'LOKAL', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('L39', $priceEndCrimpingLokal101);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 101 (qty_end)
        $priceEndSparepartImport101 = $this->getPriceEndByWearAndTearCode(2, 'IMPORT', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('L40', $priceEndSparepartImport101);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 101 (qty_end)
        $priceEndSparepartLokal101 = $this->getPriceEndByWearAndTearCode(2, 'LOKAL', '101', $dateBegin, $dateEnd);
        $sheet->setCellValue('L41', $priceEndSparepartLokal101);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 102 (qty_end)
        $priceEndCrimpingImport102 = $this->getPriceEndByWearAndTearCode(1, 'IMPORT', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('M38', $priceEndCrimpingImport102);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 102 (qty_end)
        $priceEndCrimpingLokal102 = $this->getPriceEndByWearAndTearCode(1, 'LOKAL', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('M39', $priceEndCrimpingLokal102);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 102 (qty_end)
        $priceEndSparepartImport102 = $this->getPriceEndByWearAndTearCode(2, 'IMPORT', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('M40', $priceEndSparepartImport102);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 102 (qty_end)
        $priceEndSparepartLokal102 = $this->getPriceEndByWearAndTearCode(2, 'LOKAL', '102', $dateBegin, $dateEnd);
        $sheet->setCellValue('M41', $priceEndSparepartLokal102);

        // Crimping Dies - IMPORT dengan wear_and_tear_code 108 (qty_end)
        $priceEndCrimpingImport108 = $this->getPriceEndByWearAndTearCode(1, 'IMPORT', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('N38', $priceEndCrimpingImport108);

        // Crimping Dies - LOKAL dengan wear_and_tear_code 108 (qty_end)
        $priceEndCrimpingLokal108 = $this->getPriceEndByWearAndTearCode(1, 'LOKAL', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('N39', $priceEndCrimpingLokal108);

        // Sparepart Machine - IMPORT dengan wear_and_tear_code 108 (qty_end)
        $priceEndSparepartImport108 = $this->getPriceEndByWearAndTearCode(2, 'IMPORT', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('N40', $priceEndSparepartImport108);

        // Sparepart Machine - LOKAL dengan wear_and_tear_code 108 (qty_end)
        $priceEndSparepartLokal108 = $this->getPriceEndByWearAndTearCode(2, 'LOKAL', '108', $dateBegin, $dateEnd);
        $sheet->setCellValue('N41', $priceEndSparepartLokal108);

        // Total untuk Crimping Dies - IMPORT (C38 hingga N38)
        $totalCrimpingImport = $priceCrimpingImport101 + $priceCrimpingImport102 + $priceCrimpingImport108 + 
                              $priceInCrimpingImport101 + $priceInCrimpingImport102 + $priceInCrimpingImport108 + 
                              $priceOutCrimpingImport101 + $priceOutCrimpingImport102 + $priceOutCrimpingImport108 + 
                              $priceEndCrimpingImport101 + $priceEndCrimpingImport102 + $priceEndCrimpingImport108;
        $sheet->setCellValue('R38', $totalCrimpingImport);

        // Total untuk Crimping Dies - LOKAL (C39 hingga N39)
        $totalCrimpingLokal = $priceCrimpingLokal101 + $priceCrimpingLokal102 + $priceCrimpingLokal108 + 
                             $priceInCrimpingLokal101 + $priceInCrimpingLokal102 + $priceInCrimpingLokal108 + 
                             $priceOutCrimpingLokal101 + $priceOutCrimpingLokal102 + $priceOutCrimpingLokal108 + 
                             $priceEndCrimpingLokal101 + $priceEndCrimpingLokal102 + $priceEndCrimpingLokal108;
        $sheet->setCellValue('R39', $totalCrimpingLokal);

        // Total untuk Sparepart Machine - IMPORT (C40 hingga N40)
        $totalSpmImport = $priceSparepartImport101 + $priceSparepartImport102 + $priceSparepartImport108 + 
                          $priceInSparepartImport101 + $priceInSparepartImport102 + $priceInSparepartImport108 + 
                          $priceOutSparepartImport101 + $priceOutSparepartImport102 + $priceOutSparepartImport108 + 
                          $priceEndSparepartImport101 + $priceEndSparepartImport102 + $priceEndSparepartImport108;
        $sheet->setCellValue('R40', $totalSpmImport);

        // Total untuk Sparepart Machine - LOKAL (C41 hingga N41)
        $totalSpmLokal = $priceSparepartLokal101 + $priceSparepartLokal102 + $priceSparepartLokal108 + 
                         $priceInSparepartLokal101 + $priceInSparepartLokal102 + $priceInSparepartLokal108 + 
                         $priceOutSparepartLokal101 + $priceOutSparepartLokal102 + $priceOutSparepartLokal108 + 
                         $priceEndSparepartLokal101 + $priceEndSparepartLokal102 + $priceEndSparepartLokal108;
        $sheet->setCellValue('R41', $totalSpmLokal);

        //Dynamics/Loops
        if (sizeof($partcategories) > 0) {
            $row = 15; // Initialize the row variable
            foreach ($partcategories as $partCategory) {
                $cellStart = 'A' . $row; // Build the starting cell reference with the current row
                $cellEnd = 'A' . ($row + 1); // Build the ending cell reference in the next row

                // Merge the two cells vertically (below)
                $sheet->mergeCells($cellStart . ':' . $cellEnd);

                // Set the value in the merged cell
                $sheet->setCellValue($cellStart, $partCategory->part_category_name);

                $row += 2; // Increment the row variable by 2 for the next iteration (to skip the merged cell)
            }
        }

        $aaa = 1; // Move the initialization outside the loop
        $bbb = 1; // Move the initialization outside the loop

        for ($i = 15; $i < 15 + (sizeof($partcategories) * 2); $i++) {
            $cellStart = 'B' . $i;
            $cellstartC = 'C' . $i;
            $cellStartD = 'D' . $i;
            $cellStartE = 'E' . $i;
            $cellstartF = 'F' . $i;
            $cellStartG = 'G' . $i;
            $cellStartH = 'H' . $i;
            $cellstartL = 'L' . $i;
            $cellStartM = 'M' . $i;
            $cellStartN = 'N' . $i;
            $cellstartR = 'R' . $i;
            $cellStartS = 'S' . $i;
            $cellStartT = 'T' . $i;
            $cellstartU = 'U' . $i;
            $cellStartV = 'V' . $i;
            $cellStartW = 'W' . $i;
            $cellStartO = 'O' . $i;
            $cellStartQ = 'Q' . $i;
            $cellStartP = 'P' . $i;

            if ($i % 2 == 0) {
                $sheet->setCellValue($cellStart, "LOKAL");
                // qty begin
                $calculatedValueQtyBegin = $this->getQty($aaa, 'LOKAL', 'qty_begin', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellstartC, $calculatedValueQtyBegin);
                $amountusdin = $this->getPrice($aaa, 'LOKAL', 'qty_begin', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellStartD, $amountusdin);
                $amountidrin = $this->convertAndDisplayAmount($amountusdin);
                $sheet->setCellValue($cellStartE, $amountidrin);
                // qty in
                $calculatedValueQtyIn = $this->getQty($aaa, 'LOKAL', 'qty_in', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellstartF, $calculatedValueQtyIn);
                $amountusdin = $this->getPrice($aaa, 'LOKAL', 'qty_in', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellStartG, $amountusdin);
                $amountidrin = $this->convertAndDisplayAmount($amountusdin);
                $sheet->setCellValue($cellStartH, $amountidrin);
                // qty out CIP
                $calculatedValueQtyOutCIP = $this->getQty($aaa, 'LOKAL', 'qty_out', $dateBegin, $dateEnd, 'CIP');
                $sheet->setCellValue($cellstartL, $calculatedValueQtyOutCIP);
                $amountusdinCIP = $this->getPrice($aaa, 'LOKAL', 'qty_out', $dateBegin, $dateEnd, 'CIP');
                $sheet->setCellValue($cellStartM, $amountusdinCIP);
                $amountidrinCIP = $this->convertAndDisplayAmount($amountusdinCIP);
                $sheet->setCellValue($cellStartN, $amountidrinCIP);
                // qty out Expense
                $calculatedValueQtyOutExp = $this->getQty($aaa, 'LOKAL', 'qty_out', $dateBegin, $dateEnd, 'Expense');
                $sheet->setCellValue($cellStartO, $calculatedValueQtyOutExp);
                $amountusdinExp = $this->getPrice($aaa, 'LOKAL', 'qty_out', $dateBegin, $dateEnd, 'Expense');
                $sheet->setCellValue($cellStartP, $amountusdinExp);
                $amountidrinExp = $this->convertAndDisplayAmount($amountusdinExp);
                $sheet->setCellValue($cellStartQ, $amountidrinExp);
                // adjust
                $calculatedValueAdjust = $this->getQty($aaa, 'LOKAL', 'adjust', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellstartR, $calculatedValueAdjust);
                $amountusdin = $this->getPrice($aaa, 'LOKAL', 'adjust', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellStartS, $amountusdin);
                $amountidrin = $this->convertAndDisplayAmount($amountusdin);
                $sheet->setCellValue($cellStartT, $amountidrin);
                //qty end
                $calculatedValueQtyEnd = $this->getQty($aaa, 'LOKAL', 'qty_end', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellstartU, $calculatedValueQtyEnd);
                $amountusdin = $this->getPrice($aaa, 'LOKAL', 'qty_end', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellStartV, $amountusdin);
                $amountidrin = $this->convertAndDisplayAmount($amountusdin);
                $sheet->setCellValue($cellStartW, $amountidrin);
                //qty
                $aaa++;
            } else {
                $sheet->setCellValue($cellStart, "IMPORT");
                // qty begin
                $calculatedValueQtyBegin = $this->getQty($bbb, 'IMPORT', 'qty_begin', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellstartC, $calculatedValueQtyBegin);
                $amountusdin = $this->getPrice($bbb, 'IMPORT', 'qty_begin', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellStartD, $amountusdin);
                $amountidrin = $this->convertAndDisplayAmount($amountusdin);
                $sheet->setCellValue($cellStartE, $amountidrin);
                // qty in
                $calculatedValueQtyIn = $this->getQty($bbb, 'IMPORT', 'qty_in', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellstartF, $calculatedValueQtyIn);
                $amountusdin = $this->getPrice($bbb, 'IMPORT', 'qty_in', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellStartG, $amountusdin);
                $amountidrin = $this->convertAndDisplayAmount($amountusdin);
                $sheet->setCellValue($cellStartH, $amountidrin);
                // qty out CIP
                $calculatedValueQtyOutCIP = $this->getQty($bbb, 'IMPORT', 'qty_out', $dateBegin, $dateEnd, 'CIP');
                $sheet->setCellValue($cellstartL, $calculatedValueQtyOutCIP);
                $amountusdinCIP = $this->getPrice($bbb, 'IMPORT', 'qty_out', $dateBegin, $dateEnd, 'CIP');
                $sheet->setCellValue($cellStartM, $amountusdinCIP);
                $amountidrinCIP = $this->convertAndDisplayAmount($amountusdinCIP);
                $sheet->setCellValue($cellStartN, $amountidrinCIP);
                // qty out Expense
                $calculatedValueQtyOutExp = $this->getQty($bbb, 'IMPORT', 'qty_out', $dateBegin, $dateEnd, 'Expense');
                $sheet->setCellValue($cellStartO, $calculatedValueQtyOutExp);
                $amountusdinExp = $this->getPrice($bbb, 'IMPORT', 'qty_out', $dateBegin, $dateEnd, 'Expense');
                $sheet->setCellValue($cellStartP, $amountusdinExp);
                $amountidrinExp = $this->convertAndDisplayAmount($amountusdinExp);
                $sheet->setCellValue($cellStartQ, $amountidrinExp);
                // adjust
                $calculatedValueAdjust = $this->getQty($bbb, 'IMPORT', 'adjust', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellstartR, $calculatedValueAdjust);
                $amountusdin = $this->getPrice($bbb, 'IMPORT', 'adjust', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellStartS, $amountusdin);
                $amountidrin = $this->convertAndDisplayAmount($amountusdin);
                $sheet->setCellValue($cellStartT, $amountidrin);
                // qty end
                $calculatedValueQtyEnd = $this->getQty($bbb, 'IMPORT', 'qty_end', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellstartU, $calculatedValueQtyEnd);
                $amountusdin = $this->getPrice($bbb, 'IMPORT', 'qty_end', $dateBegin, $dateEnd);
                $sheet->setCellValue($cellStartV, $amountusdin);
                $amountidrin = $this->convertAndDisplayAmount($amountusdin);
                $sheet->setCellValue($cellStartW, $amountidrin);
                // qty
                $bbb++;
            }
        }



        $currentMonth = date('F');
        // Buat file Excel
        $writer = new Xlsx($spreadsheet);
        $filename = "Monthly Report - $currentMonth.xlsx";

        // Simpan file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }




    public function getQty($part_id, $asal, $qty_type, $dateBegin, $dateEnd, $kategori_inventory = null)
    {
        if (!$this->isValidDate($dateBegin) || !$this->isValidDate($dateEnd)) {
            return 0;
        }

        $allParts = $this->_partRepository->getAll();

        // Define your conditions here
        $conditions = [
            'part_category_id' => $part_id,
            'kategori' => $asal,
        ];

        if ($kategori_inventory !== null) {
            $conditions['kategori_inventory'] = $kategori_inventory;
        }

        $qtyEndParts = $allParts->filter(function ($part) use ($conditions, $dateBegin, $dateEnd) {
            foreach ($conditions as $key => $value) {
                if ($part->{$key} != $value) {
                    return false;
                }
            }
            
            // Filter by used_date within the specified range
            if ($part->used_date) {
                return (strtotime($part->used_date) >= strtotime($dateBegin) && 
                       strtotime($part->used_date) <= strtotime($dateEnd));
            }
            return false;
        });

        // Jika tidak ada data dalam range waktu yang dipilih, return 0
        if ($qtyEndParts->isEmpty()) {
            return 0;
        }

        // Hitung total qty berdasarkan tipe
        switch($qty_type) {
            case 'qty_begin':
                return $qtyEndParts->sum('qty_begin') ?: 0;
            case 'qty_in':
                return $qtyEndParts->sum('qty_in') ?: 0;
            case 'qty_out':
                return $qtyEndParts->sum('qty_out') ?: 0;
            case 'adjust':
                return $qtyEndParts->sum('adjust') ?: 0;
            case 'qty_end':
                return $qtyEndParts->sum(function($part) {
                    return ($part->qty_begin + $part->qty_in - $part->qty_out + $part->adjust);
                    
                }) ?: 0;
            default:
                return 0;
        }
    }
    public function getQtyExpsense($part_id, $asal, $qty_type, $dateBegin, $dateEnd, $kategori_inventory = null)
    {
        if (!$this->isValidDate($dateBegin) || !$this->isValidDate($dateEnd)) {
            return 0;
        }

        $allParts = $this->_partRepository->getAll();

        // Define your conditions here
        $conditions = [
            'part_category_id' => $part_id,
            'kategori' => $asal,
        ];

        if ($kategori_inventory !== null) {
            $conditions['kategori_inventory'] = $kategori_inventory;
        }

        $qtyEndParts = $allParts->filter(function ($part) use ($conditions, $dateBegin, $dateEnd) {
            foreach ($conditions as $key => $value) {
                if ($part->{$key} != $value) {
                    return false;
                }
            }
            
            // Filter by used_date within the specified range
            if ($part->used_date) {
                return (strtotime($part->used_date) >= strtotime($dateBegin) && 
                       strtotime($part->used_date) <= strtotime($dateEnd));
            }
            return false;
        });

        // Jika tidak ada data dalam range waktu yang dipilih, return 0
        if ($qtyEndParts->isEmpty()) {
            return 0;
        }

        // Hitung total qty berdasarkan tipe
        switch($qty_type) {
            case 'qty_begin':
                return $qtyEndParts->sum('qty_begin') ?: 0;
            case 'qty_in':
                return $qtyEndParts->sum('qty_in') ?: 0;
            case 'qty_out':
                return $qtyEndParts->sum('qty_out') ?: 0;
            case 'adjust':
                return $qtyEndParts->sum('adjust') ?: 0;
            case 'qty_end':
                return $qtyEndParts->sum(function($part) {
                    return ($part->qty_begin + $part->qty_in - $part->qty_out + $part->adjust);
                    
                }) ?: 0;
            default:
                return 0;
        }
    }

    public function getPrice($part_id, $asal, $qty_type, $dateBegin, $dateEnd, $kategori_inventory = null)
    {
        if (!$this->isValidDate($dateBegin) || !$this->isValidDate($dateEnd)) {
            return 0;
        }

        $allParts = $this->_partRepository->getAll();

        // Define your conditions here
        $conditions = [
            'part_category_id' => $part_id,
            'kategori' => $asal,
        ];

        if ($kategori_inventory !== null) {
            $conditions['kategori_inventory'] = $kategori_inventory;
        }

        // Filter parts based on conditions and date range
        $qtyEndParts = $allParts->filter(function ($part) use ($conditions, $dateBegin, $dateEnd) {
            foreach ($conditions as $key => $value) {
                if ($part->{$key} != $value) {
                    return false;
                }
            }
            
            // Filter by used_date within the specified range
            if ($part->used_date) {
                return (strtotime($part->used_date) >= strtotime($dateBegin) && 
                       strtotime($part->used_date) <= strtotime($dateEnd));
            }
            return false;
        });

        // Jika tidak ada data dalam range waktu yang dipilih, return 0
        if ($qtyEndParts->isEmpty()) {
            return 0;
        }

        // Hitung total price berdasarkan qty_type
        switch($qty_type) {
            case 'qty_begin':
                $total = $qtyEndParts->sum(function($part) {
                    return ($part->qty_begin * ($part->price ?? 0));
                });
                return $total ?: 0;
            case 'qty_in':
                $total = $qtyEndParts->sum(function($part) {
                    return ($part->qty_in * ($part->price ?? 0));
                });
                return $total ?: 0;
            case 'qty_out':
                $total = $qtyEndParts->sum(function($part) {
                    return ($part->qty_out * ($part->price ?? 0));
                });
                return $total ?: 0;
            case 'adjust':
                $total = $qtyEndParts->sum(function($part) {
                    return ($part->adjust * ($part->price ?? 0));
                });
                return $total ?: 0;
            case 'qty_end':
                $total = $qtyEndParts->sum(function($part) {
                    $qty_end = ($part->qty_begin + $part->qty_in - $part->qty_out + $part->adjust);
                    
                    return ($qty_end * ($part->price ?? 0));
                });
                return $total ?: 0;
            default:
                return 0;
        }
    }

    private function isValidDate($date)
    {
        if (empty($date)) {
            return false;
        }
        return (bool) strtotime($date);
    }

    protected function calculatePriceSum($partCategoryId, $asal)
    {
        // Specify the columns and aggregation methods
        $aggregations = [
            'price' => 'sum',
        ];

        // Fetch the results for the specified columns and methods
        $results = $this->_partRepository->getByParams([
            'part_category_id' => $partCategoryId,
            'asal' => $asal,
        ], $aggregations);

        // Extract the value from the result
        $priceSum = isset($results->price) ? $results->price : 0;

        return $priceSum;
    }


    public function convertAndDisplayAmount($usdAmount)
    {
        $conversionRate = 0;

        $idrAmount = $usdAmount * $conversionRate;

        return $idrAmount;
    }

    public function getPriceByWearAndTearCode($part_id, $kategori, $wear_and_tear_code, $dateBegin, $dateEnd)
    {
        if (!$this->isValidDate($dateBegin) || !$this->isValidDate($dateEnd)) {
            return 0;
        }

        $allParts = $this->_partRepository->getAll();

        // Define your conditions here
        $conditions = [
            'part_category_id' => $part_id,
            'kategori' => $kategori,
            'wear_and_tear_code' => $wear_and_tear_code
        ];

        $qtyParts = $allParts->filter(function ($part) use ($conditions, $dateBegin, $dateEnd) {
            foreach ($conditions as $key => $value) {
                if ($part->{$key} != $value) {
                    return false;
                }
            }
            
            // Filter by used_date within the specified range
            if ($part->used_date) {
                return (strtotime($part->used_date) >= strtotime($dateBegin) && 
                       strtotime($part->used_date) <= strtotime($dateEnd));
            }
            return false;
        });

        // Jika tidak ada data dalam range waktu yang dipilih, return 0
        if ($qtyParts->isEmpty()) {
            return 0;
        }

        // Menghitung total price (qty_begin * price)
        $total = $qtyParts->sum(function($part) {
            return ($part->qty_begin * ($part->price ?? 0));
        });
        
        return $total ?: 0;
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
    }
}
