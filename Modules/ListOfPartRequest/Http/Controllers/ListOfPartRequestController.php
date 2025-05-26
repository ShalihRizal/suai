<?php

namespace Modules\ListOfPartRequest\Http\Controllers;

use App\Exports\listofpartreqexport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\ListOfPartRequest\Repositories\ListOfPartRequestRepository;
use Modules\PartRequest\Repositories\PartRequestRepository;
use Modules\Carname\Repositories\CarnameRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Validator;
use App\Exports\ListOfPartRequestExport;

class ListOfPartRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_ListOfPartRequestRepository = new ListOfPartRequestRepository;
        $this->_PartRequestRepository = new PartRequestRepository;
        $this->_CarnameRepository = new CarnameRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "PartRequest";
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

        // $params = [
        //     'part_request.status' => 2
        // ];

        // $listofpartrequests = $this->_ListOfPartRequestRepository->getAll();
        $partrequests = $this->_ListOfPartRequestRepository->getAll();
        // dd($partrequests);
        return view('listofpartrequest::index', compact('partrequests'));
    }
    public function downloadPDF()
    {
        // Path lengkap file
        $filePath = storage_path('app/public/uploads/images/transaksi_out.csv');

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            // Jika file tidak ditemukan, redirect dengan pesan error
            return redirect('listofpartrequest')->with('message', 'Template file not found.');
        }

        // Menentukan nama file saat diunduh
        $fileName = 'TemplateListOfPartReq.csv';

        // Mengunduh file dengan nama yang sudah ditentukan dan tipe konten CSV
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'text/csv', // Menentukan MIME Type untuk file CSV
        ]);
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

        return view('listofpartrequest::create');
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
            return redirect('listofpartrequest')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        $this->_ListOfPartRequestRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->part_req_number, 'create');
        DB::commit();

        return redirect('listofpartrequest')->with('message', 'PartRequest berhasil ditambahkan');
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

        return view('listofpartrequest::show');
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

        return view('listofpartrequest::edit');
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
            return redirect('listofpartrequest')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_ListOfPartRequestRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->part_req_number, 'update');

        DB::commit();

        return redirect('listofpartrequest')->with('message', 'PartRequest berhasil diubah');
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
        $detail = $this->_ListOfPartRequestRepository->getById($id);

        if (!$detail) {
            return redirect('listofpartrequest');
        }

        DB::beginTransaction();

        $this->_ListOfPartRequestRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->part_req_number, 'delete');

        DB::commit();

        return redirect('listofpartrequest')->with('message', 'PartRequest berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {
        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_ListOfPartRequestRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;
    }

    public function listofpartreqexport(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Pastikan format tanggal valid
        if (!$startDate || !$endDate) {
            return redirect()->back()->with('message', 'Please select a valid date range.');
        }

        // Kirim parameter tanggal ke export class
        return Excel::download(new listofpartreqexport($startDate, $endDate), 'listofpartreq.xlsx');
    }

    public function downloadData(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Validasi tanggal jika diisi
            if ($startDate && $endDate && $startDate > $endDate) {
                return redirect()->back()->with('error', 'Tanggal mulai harus lebih kecil dari tanggal akhir');
            }

            // Generate nama file dengan timestamp
            $fileName = 'list_of_part_request_' . date('Y-m-d_H-i-s') . '.xlsx';

            // Download file Excel
            return Excel::download(new ListOfPartRequestExport($startDate, $endDate), $fileName);
        } catch (\Exception $e) {
            \Log::error('Gagal mengunduh data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunduh data. ' . $e->getMessage());
        }
    }

    private function _validationRules($id = '')
    {
        if ($id == '') {
            return [
                'part_req_number' => 'required',
            ];
        } else {
            return [
                'part_req_number' => 'required',
            ];
        }
    }
    
}
