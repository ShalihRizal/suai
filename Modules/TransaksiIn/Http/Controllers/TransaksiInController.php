<?php

namespace Modules\TransaksiIn\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\Part\Repositories\PartRepository;
use Modules\PartCategory\Repositories\PartCategoryRepository;
use Modules\Rack\Repositories\RackRepository;
use Modules\SubRack\Repositories\SubRackRepository;
use Modules\TransaksiIn\Repositories\TransaksiInRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Validator;


class TransaksiInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_rackRepository = new RackRepository;
        $this->_subRackRepository = new SubRackRepository;
        $this->_partRepository = new PartRepository;
        $this->_partCategoryRepository = new PartCategoryRepository;
        $this->_transaksiinRepository = new TransaksiInRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "TransaksiIn";
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        $params = [
            'part_request.status' => 0
        ];

        $transaksiins = $this->_transaksiinRepository->getAll();
        $partcategories = $this->_partCategoryRepository->getAll();
        $parts = $this->_partRepository->getAll();
        $racks = $this->_rackRepository->getAll();
        $subracks = $this->_subRackRepository->getAll();
        // dd($subracks);

        // dd($transaksiins, $partcategories);

        return view('transaksiin::index', compact('transaksiins', 'parts', 'racks', 'partcategories', 'subracks'));
    }

    // public function filterTransactions(Request $request)
    // {
    //     $start_date = $request->input('start_date');
    //     $end_date = $request->input('end_date');

    //     // Use the start_date and end_date to filter your transactions
    //     $filteredTransactions = DB::whereBetween('created_at', [$start_date, $end_date])->get();

    //     return view('transaksiin::index', ['filteredTransactions' => $filteredTransactions]);
    // }



    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        try {
            // Authorize
            if (Gate::denies(__FUNCTION__, $this->module)) {
                return redirect('unauthorize');
            }

            if (!$request->hasFile('file')) {
                return response()->json(['message' => 'No file uploaded'], 400);
            }

            // Start a database transaction
            DB::beginTransaction();

            $file = $request->file('file');
            $filePath = $file->getRealPath();
            $csvData = array_map('str_getcsv', file($filePath));
            $header = array_shift($csvData);

            foreach ($csvData as $row) {
                $data = array_combine($header, $row);
                // dd($data);

                // Get the existing part data
                $existingPart = DB::table('part')
                    ->where('part_id', $data['part_id'])
                    ->first();

                if ($existingPart) {
                    // Update the qty_in in the part table
                    $newQtyIn = $existingPart->qty_in + $data['qty'];
                    DB::table('part')
                        ->where('part_id', $data['part_id'])
                        ->update(['qty_in' => $newQtyIn]);
                }

                $existingData = DB::table('transaksi_in')
                    ->where('transaksi_in_id', $data['transaksi_in_id'])
                    ->first();

                if ($existingData) {
                    // Update the record
                    DB::table('transaksi_in')
                        ->where('transaksi_in_id', $data['transaksi_in_id'])
                        ->update($data);
                } else {
                    // Insert a new record
                    DB::table('transaksi_in')->insert($data);
                }
            }

            // Commit the transaction if all operations succeeded
            DB::commit();

            // Log your action or any relevant information
            Log::info('File uploaded successfully');

            return redirect('transaksiin');
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollback();

            // Log the exception with more details for debugging
            Log::error('Gagal mengunggah file: ' . $e->getMessage() . ' at ' . $e->getFile() . ' line ' . $e->getLine());

            return response()->json(['message' => 'Gagal mengunggah file. ' . $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Gagal mengunggah file'], 400);
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

        if ($validator->fails()) {
            return redirect('transaksiin')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Normalize and insert the data
            $normalizedData = DataHelper::_normalizeParams($request->all(), true);
            $this->_transaksiinRepository->insert($normalizedData);

            // Update the qty_in in the part table
            $partId = $request->input('part_id');
            $qty = $request->input('qty');

            $existingPart = DB::table('part')
                ->where('part_id', $partId)
                ->first();

            if ($existingPart) {
                $newQtyIn = $existingPart->qty_in + $qty;
                DB::table('part')
                    ->where('part_id', $partId)
                    ->update(['qty_in' => $newQtyIn]);
            }

            // Log the creation action
            $this->_logHelper->store($this->module, $request->invoice_no, 'create');

            DB::commit();

            return redirect('transaksiin')->with('message', 'Transaksi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal menyimpan transaksi: ' . $e->getMessage() . ' at ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect('transaksiin')->with('error', 'Gagal menyimpan transaksi. ' . $e->getMessage());
        }
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

        return view('transaksiin::show');
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

        return view('transaksiin::edit');
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

        if ($validator->fails()) {
            return redirect('transaksiin')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_transaksiinRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->invoice_no, 'update');

        DB::commit();

        return redirect('transaksiin')->with('message', 'Transaksi berhasil diubah');
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
        $detail = $this->_transaksiinRepository->getById($id);

        
        if (!$detail) {
            return redirect('transaksiin');
        }
        
        DB::beginTransaction();
        
        $part_qty = (int)$detail->qty;
        $part_id = $detail->part_id;    
        // dd($part_id);
        $part = $this->_partRepository->getById($part_id);
        $part_qty_in = $part->qty_in - $part_qty;

        $param = [
            'qty_in' =>$part_qty_in
        ];
    
            $cek = $this->_partRepository->update($param, $part_id);
            // dd($cek);
        $this->_transaksiinRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->invoice_no, 'delete');

        DB::commit();

        return redirect('transaksiin')->with('message', 'Transaksi berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_transaksiinRepository->getById($id);

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
                'invoice_no' => 'required',
            ];
        } else {
            return [
                'invoice_no' => 'required',
            ];
        }
    }
    public function downloadPDF()
    {
        // Path lengkap file
        $filePath = storage_path('app/public/uploads/images/transaksi_in.csv');

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            // Jika file tidak ditemukan, redirect dengan pesan error
            return redirect('transaksiin')->with('message', 'Template file not found.');
        }

        // Menentukan nama file saat diunduh
        $fileName = 'TemplateTransaksiIn.csv';

        // Mengunduh file dengan nama yang sudah ditentukan dan tipe konten CSV
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'text/csv', // Menentukan MIME Type untuk file CSV
        ]);
    }

    public function downloadData()
    {
        try {
            // Ambil semua data transaksi_in
            $transaksiins = $this->_transaksiinRepository->getAll();
            
            // Buat nama file dengan timestamp
            $fileName = 'transaksi_in_' . date('Y-m-d_H-i-s') . '.csv';
            
            // Buat file CSV
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ];
            
            $callback = function() use ($transaksiins) {
                $file = fopen('php://output', 'w');
                
                // Header CSV
                fputcsv($file, [
                    'No',
                    'Id',
                    'Invoice No',
                    'PO Number',
                    'PO Date',
                    'Part No Urut',
                    'Part Name',
                    'Part Category',
                    'Molts No',
                    'Price',
                    'Part No',
                    'Qty',
                    'Loc PPTI',
                    'Created At'
                ]);
                
                // Data CSV
                foreach ($transaksiins as $index => $transaksi) {
                    fputcsv($file, [
                        $index + 1,
                        $transaksi->transaksi_in_id,
                        $transaksi->invoice_no,
                        $transaksi->po_no,
                        $transaksi->po_date,
                        $transaksi->part_no . $transaksi->no_urut,
                        $transaksi->part_name,
                        $transaksi->part_category_name,
                        $transaksi->molts_no,
                        $transaksi->price,
                        $transaksi->part_no,
                        $transaksi->qty,
                        $transaksi->loc_ppti,
                        $transaksi->transaksi_created_at
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Gagal mengunduh data: ' . $e->getMessage());
            return redirect('transaksiin')->with('error', 'Gagal mengunduh data. ' . $e->getMessage());
        }
    }
}
