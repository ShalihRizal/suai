<?php

namespace Modules\TransaksiOut\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\Part\Repositories\PartRepository;
use Modules\TransaksiOut\Repositories\TransaksiOutRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class TransaksiOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_partRepository = new PartRepository;
        $this->_transaksioutRepository = new TransaksiOutRepository;
        $this->_logHelper           = new LogHelper;
        $this->module               = "TransaksiOut";
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

        $transaksiouts = $this->_transaksioutRepository->getAll();
        $parts = $this->_partRepository->getAll();

        return view('transaksiout::index', compact('transaksiouts', 'parts'));
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

        return view('transaksiout::create');
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
            return redirect('transaksiout')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        $this->_transaksioutRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->invoice_no, 'create');
        DB::commit();

        return redirect('transaksiout')->with('message', 'Transaksi berhasil ditambahkan');
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

        return view('transaksiout::show');
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

        return view('transaksiout::edit');
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
            return redirect('transaksiout')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_transaksioutRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->invoice_no, 'update');

        DB::commit();

        return redirect('transaksiout')->with('message', 'Transaksi berhasil diubah');
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
        $detail  = $this->_transaksioutRepository->getById($id);

        if (!$detail) {
            return redirect('transaksiout');
        }

        DB::beginTransaction();

        $this->_transaksioutRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->invoice_no, 'delete');

        DB::commit();

        return redirect('transaksiout')->with('message', 'Transaksi berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_transaksioutRepository->getById($id);

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
                'condition' => 'required|unique:transaksi_out_id',
            ];
        } else {
            return [
                'condition' => 'required|unique:transaksi_out_id,condition,' . $id . ',transaksi_in_id',
            ];
        }
    }
}
