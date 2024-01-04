<?php

namespace Modules\TransaksiIn\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\Part\Repositories\PartRepository;
use Modules\PartCategory\Repositories\PartCategoryRepository;
use Modules\Rack\Repositories\RackRepository;
use Modules\TransaksiIn\Repositories\TransaksiInRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class TransaksiInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_rackRepository = new RackRepository;
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

        // dd($transaksiins, $partcategories);

        return view('transaksiin::index', compact('transaksiins', 'parts', 'racks', 'partcategories'));
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
     * @return Response
     */
    public function create()
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        return view('transaksiin::create');
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
        // dd($request->all());

        DB::beginTransaction();
        $this->_transaksiinRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->invoice_no, 'create');
        DB::commit();
        // dd($request->all(), $check);

        return redirect('transaksiin')->with('message', 'Transaksi berhasil ditambahkan');
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
}
