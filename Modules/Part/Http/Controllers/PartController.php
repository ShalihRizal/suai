<?php

namespace Modules\Part\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Modules\PartCategory\Repositories\PartCategoryRepository;
use Modules\Part\Repositories\PartRepository;
use Modules\TransaksiIn\Repositories\TransaksiInRepository;
use Modules\Rack\Repositories\RackRepository;
use Modules\SubRack\Repositories\SubRackRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class PartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_partRepository = new PartRepository;
        $this->_partCategoryRepository = new PartCategoryRepository;
        $this->_transaksiinRepository = new TransaksiInRepository;
        $this->_subRackRepository = new SubRackRepository;
        $this->_rackRepository = new RackRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "Part";
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        $partCategoryFilter = $request->input('part_category'); // Get the selected category from the request

        $parts = $this->_partRepository->getAll();
        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        $subrack = $this->_subRackRepository->getAll();
        // Filter parts based on the selected category
        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }



        return view('part::index', compact('parts', 'partcategories', 'racks', 'partCategoryFilter','subrack'));
    }
    public function download(Request $request)
    {
        $category = $request->input('category');
        
        if ($category) {
            $parts = $this->_partRepository->getAllByParams(['part_category_id' => $category]);
        } else {
            $parts = $this->_partRepository->getAll();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID');
        $sheet->setCellValue('C1', 'Part No');
        $sheet->setCellValue('D1', 'Part Name'); 
        $sheet->setCellValue('E1', 'Lokasi PPTI');
        $sheet->setCellValue('F1', 'Lokasi HIB');
        $sheet->setCellValue('G1', 'Lokasi TAPC');
        $sheet->setCellValue('H1', 'Begin');
        $sheet->setCellValue('I1', 'Qty In');
        $sheet->setCellValue('J1', 'Qty Out');
        $sheet->setCellValue('K1', 'Qty STO');
        $sheet->setCellValue('L1', 'Qty End');
        $sheet->setCellValue('M1', 'Status Part');
        $sheet->setCellValue('N1', 'Status');
        $sheet->setCellValue('O1', 'Safety Stock');
        $sheet->setCellValue('P1', 'ROP');
        $sheet->setCellValue('Q1', 'Forecast');
        $sheet->setCellValue('R1', 'Max');

        $row = 2;
        foreach ($parts as $index => $part) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $part->part_id);
            $sheet->setCellValue('C' . $row, $part->part_no);
            $sheet->setCellValue('D' . $row, $part->part_name);
            $sheet->setCellValue('E' . $row, $part->loc_ppti);
            $sheet->setCellValue('F' . $row, $part->lokasi_hib);
            $sheet->setCellValue('G' . $row, $part->loc_tapc);
            $sheet->setCellValue('H' . $row, $part->qty_begin);
            $sheet->setCellValue('I' . $row, $part->qty_in);
            $sheet->setCellValue('J' . $row, $part->qty_out);
            $sheet->setCellValue('K' . $row, $part->adjust);
            $sheet->setCellValue('L' . $row, $part->qty_begin + $part->qty_in - $part->qty_out);
            $sheet->setCellValue('M' . $row, $part->status);
            $sheet->setCellValue('N' . $row, $part->kategori_inventory);
            $sheet->setCellValue('O' . $row, $part->ss);
            $sheet->setCellValue('P' . $row, $part->rop);
            $sheet->setCellValue('Q' . $row, $part->forecast);
            $sheet->setCellValue('R' . $row, $part->max);
            $row++;
        }

        // Auto size columns
        foreach(range('A','Q') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'parts_data_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function allindex(Request $request)
    {
        // Authorize
        // if (Gate::denies(__FUNCTION__, $this->module)) {
        //     return redirect('unauthorize');
        // }

        $partCategoryFilter = $request->input('part_category'); // Get the selected category from the request

        $parts = $this->_partRepository->getAll();
        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        $subrack = $this->_subRackRepository->getAll();
        // Filter parts based on the selected category
        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }



        return view('part::index', compact('parts', 'partcategories', 'racks', 'partCategoryFilter','subrack'));
    }

    public function afindex(Request $request)
    {
        // // Authorize
        // if (Gate::denies(__FUNCTION__, $this->module)) {
        //     return redirect('unauthorize');
        // }

        $params = [
            'part_category_id' => 3
        ];

        $parts = $this->_partRepository->getAllByParams($params);

        $partCategoryFilter = $request->input('part_category'); // Get the selected category from the request

        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        $subrack = $this->_subRackRepository->getAll();

        // Filter parts based on the selected category
        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }

        return view('part::af', compact('parts', 'partcategories', 'racks', 'partCategoryFilter', 'subrack'));
    }
    public function cfindex(Request $request)
    {
        // // Authorize
        // if (Gate::denies(__FUNCTION__, $this->module)) {
        //     return redirect('unauthorize');
        // }

        $params = [
            'part_category_id' => 4
        ];

        $parts = $this->_partRepository->getAllByParams($params);

        $partCategoryFilter = $request->input('part_category'); // Get the selected category from the request

        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        $subrack = $this->_subRackRepository->getAll();

        // Filter parts based on the selected category
        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }

        return view('part::cf', compact('parts', 'partcategories', 'racks', 'partCategoryFilter', 'subrack'));
    }
    public function cdindex(Request $request)
    {
        $params = [
            'part_category_id' => 1
        ];

        $parts = $this->_partRepository->getAllByParams($params);
        $partCategoryFilter = $request->input('part_category');
        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();
        $subrack = $this->_subRackRepository->getAll();
        // dd($subrack);

        // Mengambil qty berdasarkan part_id dari transaksi_in
        foreach ($parts as $part) {
            $transaksi = DB::table('transaksi_in')
                ->where('part_id', $part->part_id)
                ->select('qty')
                ->first();

            // Menambahkan qty ke objek part
            $part->qty = $transaksi->qty ?? 0; // Jika tidak ada transaksi, set qty ke 0
        }

        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }

        return view('part::cd', compact('parts', 'partcategories', 'racks', 'partCategoryFilter', 'subrack'));
    }

    public function spindex(Request $request)
    {
        $params = [
            'part_category_id' => 2
        ];

        $parts = $this->_partRepository->getAllByParams($params);
        $partCategoryFilter = $request->input('part_category');
        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        $subrack = $this->_subRackRepository->getAll();

        // Mengambil qty berdasarkan part_id dari transaksi_in
        foreach ($parts as $part) {
            $transaksi = DB::table('transaksi_in')
                ->where('part_id', $part->part_id)
                ->select('qty')
                ->first();

            // Menambahkan qty ke objek part
            $part->qty = $transaksi->qty ?? 0; // Jika tidak ada transaksi, set qty ke 0
        }

        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }

        return view('part::sp', compact('parts', 'partcategories', 'racks', 'partCategoryFilter', 'subrack'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        return view('part::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        $validator = Validator::make($request->all(), $this->_validationRules(''));
        // dd($this->_subRackRepository->getById($request->subrack), $request->subrack);
        $rak = $this->_rackRepository->getById($request->rack)->rack_name;;
        $subrack = $this->_subRackRepository->getById($request->subrack)->sub_rack_name;
        $locppti =  $rak . $subrack;
        // dd($locppti);

        if ($validator->fails()) {
            return redirect('part')
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'part_no' => $request->part_no,
            'no_urut' => $request->no_urut,
            'applicator_no' => $request->applicator_no,
            'applicator_type' => $request->applicator_type,
            'applicator_qty' => $request->applicator_qty,
            'kode_tooling_bc' => $request->kode_tooling_bc,
            'part_name' => $request->part_name,
            'asal' => $request->asal,
            'invoice' => $request->invoice,
            'po' => $request->po,
            'po_date' => $request->po_date,
            'rec_date' => $request->rec_date,
            'used_date' => $request->used_date,
            'rcv_date' => $request->rcv_date,
            'loc_ppti' => $locppti,
            'loc_tapc' => $request->loc_tapc,
            'lokasi_hib' => $request->lokasi_hib,
            'qty_begin' => $request->qty_begin,
            'molts_no' => $request->molts_no,
            'qty_in' => $request->qty_in,
            'qty_out' => $request->qty_out,
            'adjust' => $request->adjust,
            'qty_end' => $request->qty_end,
            'remarks' => $request->remarks,
            'last_sto' => $request->last_sto,
            'has_sto' => $request->has_sto,
            'part_category_id' => $request->part_category_id,
            'created_at' => $request->created_at,
            'created_by' => $request->created_by,
            'updated_at' => $request->updated_at,
            'updated_by' => $request->updated_by,
        ];
// dd($data);
        DB::beginTransaction();
        $cek = $this->_partRepository->insert(DataHelper::_normalizeParams($data, true));
        // dd($cek);
        // $check = $this->_partRepository->insert(DataHelper::_normalizeParams($data, true));
        $this->_logHelper->store($this->module, $request->part_no, 'create');
        DB::commit();
        // dd($check);


        // // DB::beginTransaction();
        // // $this->_partRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        // $check = $this->_partRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        // // $this->_logHelper->store($this->module, $request->part_no, 'create');
        // dd($check);
        // // DB::commit();

        return redirect('part')->with('message', 'Part berhasil ditambahkan');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        return view('part::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }
        $part = $this->_partRepository->getById($id);
        $racks = $this->_rackRepository->getAll();

        $subrack = $this->_subRackRepository->getAll();

        return view('part::edit', compact('part', 'racks', 'subrack'));
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        $validator = Validator::make($request->all(), $this->_validationRules($id));

        // $rak = $this->_rackRepository->getById($request->rack)->rack_name;;
        // $subrack = $this->_subRackRepository->getById($request->subrack)->sub_rack_name;
        // $locppti =  $rak . $subrack;
        if ($validator->fails()) {
            return redirect('part')
                ->withErrors($validator)
                ->withInput();
        }
        // Ambil data yang ada dari database

        $existingData = $this->_partRepository->getById($id);
        $dataUpdate = [
            'part_no' => $request->part_no ?? $existingData->part_no,
            'no_urut' => $request->no_urut ?? $existingData->no_urut,
            'applicator_no' => $request->applicator_no ?? $existingData->applicator_no,
            'applicator_type' => $request->applicator_type ?? $existingData->applicator_type,
            'applicator_qty' => $request->applicator_qty ?? $existingData->applicator_qty,
            'kode_tooling_bc' => $request->kode_tooling_bc ?? $existingData->kode_tooling_bc,
            'part_name' => $request->part_name ?? $existingData->part_name,
            'asal' => $request->asal ?? $existingData->asal,
            'invoice' => $request->invoice ?? $existingData->invoice,
            'po' => $request->po ?? $existingData->po,
            'po_date' => $request->po_date ?? $existingData->po_date,
            'rec_date' => $request->rec_date ?? $existingData->rec_date,
            'loc_ppti' => $request->loc_ppti ?? $existingData->loc_ppti,
            'loc_tapc' => $request->loc_tapc ?? $existingData->loc_tapc,
            'lokasi_hib' => $request->lokasi_hib ?? $existingData->lokasi_hib,
            'qty_begin' => $request->qty_begin ?? $existingData->qty_begin,
            'molts_no' => $request->molts_no ?? $existingData->molts_no,
            'qty_in' => $request->qty_in ?? $existingData->qty_in,
            'qty_out' => $request->qty_out ?? $existingData->qty_out,
            'kategori_inventory' => $request->kategori_inventory ?? $existingData->kategori_inventory,
            'adjust' => $request->adjust ?? $existingData->adjust,
            'qty_end' => $request->qty_end ?? $existingData->qty_end,
            'remarks' => $request->remarks ?? $existingData->remarks,
            'last_sto' => $request->last_sto ?? $existingData->last_sto,
            'has_sto' => $request->has_sto ?? $existingData->has_sto,
            'part_category_id' => $request->part_category_id ?? $existingData->part_category_id,
            'created_at' => $request->created_at ?? $existingData->created_at,
            'created_by' => $request->created_by ?? $existingData->created_by,
            'updated_at' => $request->updated_at ?? $existingData->updated_at,
            'updated_by' => $request->updated_by ?? $existingData->updated_by,
        ];
        // dd($dataUpdate);

        // Gabungkan data baru dengan data yang ada
        DB::beginTransaction();

        $cek = $this->_partRepository->update(DataHelper::_normalizeParams($dataUpdate, false, true), $id);
        // dd($cek);
        $this->_logHelper->store($this->module, $request->part_no, 'update');

        DB::commit();

        return redirect('part')->with('message', 'Part berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }
        // Check detail to db
        $detail = $this->_partRepository->getById($id);

        if (!$detail) {
            return redirect('part');
        }

        DB::beginTransaction();

        $this->_partRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->part_no, 'delete');

        DB::commit();

        return redirect('part')->with('message', 'Part berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_partRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;
    }

    private function _validationRules($id = '')
    {
        if ($id == '') {
            return [
                'part_no' => 'required',
            ];
        } else {
            return [
                'part_no' => 'required',
            ];
        }
    }
}
