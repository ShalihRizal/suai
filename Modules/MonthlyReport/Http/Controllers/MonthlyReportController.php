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

        //Repositories
        $parts = $this->_partRepository->getAll();
        $partcategories = $this->_partCategoryRepository->getAll();
        $partcategories = $this->_partCategoryRepository->getAll();

        // Buat objek worksheet
        $sheet = $spreadsheet->getActiveSheet();

        //Merge
        $sheet->mergeCells('A12:A14');
        $sheet->mergeCells('A25:B25');
        $sheet->mergeCells('C12:E13');
        $sheet->mergeCells('A36:A37');
        $sheet->mergeCells('A38:A39');
        $sheet->mergeCells('A49:G49');
        $sheet->mergeCells('A40:A41');
        $sheet->mergeCells('B12:B14');
        $sheet->mergeCells('B45:C45');
        $sheet->mergeCells('D45:E45');
        $sheet->mergeCells('F45:G45');
        $sheet->mergeCells('H45:I45');
        $sheet->mergeCells('J45:K45');
        $sheet->mergeCells('L45:M45');
        $sheet->mergeCells('B36:B37');
        $sheet->mergeCells('C36:E36');
        $sheet->mergeCells('F36:H36');
        $sheet->mergeCells('I36:K36');
        $sheet->mergeCells('L36:N36');
        $sheet->mergeCells('O36:Q36');
        $sheet->mergeCells('R36:S36');
        $sheet->mergeCells('F12:H13');
        $sheet->mergeCells('I12:K13');
        $sheet->mergeCells('L12:Q12');
        $sheet->mergeCells('L13:N13');
        $sheet->mergeCells('O13:Q13');
        $sheet->mergeCells('R12:T13');
        $sheet->mergeCells('U12:W13');
        $sheet->mergeCells('A27:A29');
        $sheet->mergeCells('B27:B29');
        $sheet->mergeCells('C27:E28');
        $sheet->mergeCells('F27:Q27');
        $sheet->mergeCells('F28:H28');
        $sheet->mergeCells('I28:K28');
        $sheet->mergeCells('L28:N28');
        $sheet->mergeCells('O28:Q28');
        $sheet->mergeCells('R27:AC27');
        $sheet->mergeCells('R28:T28');
        $sheet->mergeCells('U28:W28');
        $sheet->mergeCells('X28:Z28');
        $sheet->mergeCells('AA28:AC28');
        $sheet->mergeCells('AD27:AF28');
        $sheet->mergeCells('AG27:AI28');
        $sheet->mergeCells('A34:B34');

        //Dimensions
        $sheet->getColumnDimension('A')->setWidth(30); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('B')->setWidth(30); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('F')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('G')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('H')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('I')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('J')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('K')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('L')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('M')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('N')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('O')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('P')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('Q')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('R')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('S')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('T')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('U')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('V')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('W')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('X')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('Y')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('Z')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('AA')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('AB')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('AC')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('AD')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('AE')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('AF')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('AG')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('AH')->setWidth(15); // Mengatur lebar kolom A menjadi 15
        $sheet->getColumnDimension('AI')->setWidth(15); // Mengatur lebar kolom A menjadi 15

        for ($column = 'C'; $column <= 'W'; $column++) {
            $sheet->getColumnDimension($column)->setWidth(15);
        }

        //Style
        $sheet->getStyle('A1:AZ100')->getAlignment()->setHorizontal('center'); // Mengatur teks rata tengah
        $sheet->getStyle('A1:AZ100')->getAlignment()->setVertical('center'); // Mengatur teks rata tengah
        $sheet->getStyle('C23:W23')->getAlignment()->setHorizontal('right'); // Mengatur teks rata tengah

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
            'F12' => 'IN GIT AUGUST',
            'F14' => 'QTY',
            'G14' => 'AMOUNT(USD)',
            'H14' => 'AMOUNT(IDR)',
            'I12' => 'IN CIP AUGUST',
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
            'U12' => 'INVENTORY STORAGE END AUGUST-23',
            'U14' => 'QTY',
            'V14' => 'AMOUNT(USD)',
            'W14' => 'AMOUNT(IDR)',
            'L12' => 'USAGE - AUGUST - 23',
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
            'AG27' => 'END CIP MESIN AUGUST-23',
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
            'A12' => 'Inventory',
            'A24' => 'TOTAL',
            'B12' => 'Import/Lokal',
            'C12' => 'Begin August-23',
            'C14' => 'QTY',
            'A27' => 'CIP TOTAL (CIP INLINE+CIP)',
            'B27' => 'IMPORT LOKAL',
            'C27' => 'BEGIN AUGUST-23',
            'C29' => 'QTY',
            'D29' => 'AMOUNT(USD)',
            'E29' => 'AMOUNT(IDR)',
            'F27' => 'IN AUGUST-23',
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
            'R27' => 'TRANSAKSI OUT AUGUST-23',
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
        ];

        foreach ($cellValues as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }




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

        for ($i = 15; $i < 15 + (sizeof($partcategories) * 2); $i++) {
            $cellStart = 'B' . $i;

            if ($i % 2 == 0) {
                $sheet->setCellValue($cellStart, "Lokal");
            } else {
                $sheet->setCellValue($cellStart, "Import");
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