<?php

namespace Modules\StockOpname\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\Part\Repositories\PartRepository;
use Modules\StockOpname\Repositories\StockOpnameRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class StockOpnameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_partRepository = new PartRepository;
        $this->_stockopnameRepository = new StockOpnameRepository;
        $this->_logHelper           = new LogHelper;
        $this->module               = "StockOpname";
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
            'has_sto' => 'no'
        ];

        $parts = $this->_partRepository->getAllByParams($params);
        $stockopnames = $this->_stockopnameRepository->getAll();


        return view('stockopname::index', compact('stockopnames', 'parts'));
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

        return view('stockopname::create');
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
            return redirect('stockopname')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        $this->_stockopnameRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->stockopname_no, 'create');
        DB::commit();

        return redirect('stockopname')->with('message', 'StockOpname berhasil ditambahkan');
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

        return view('stockopname::show');
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

        return view('stockopname::edit');
    }

    public function scan()
    {
        // Authorize
        // if (Gate::denies(__FUNCTION__, $this->module)) {
        //     return redirect('unauthorize');
        // }

        return view('stockopname::scan');
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
            return redirect('stockopname')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_stockopnameRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->stockopname_no, 'update');

        DB::commit();

        return redirect('stockopname')->with('message', 'StockOpname berhasil diubah');
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
        $detail  = $this->_stockopnameRepository->getById($id);

        if (!$detail) {
            return redirect('stockopname');
        }

        DB::beginTransaction();

        $this->_stockopnameRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->stockopname_no, 'delete');

        DB::commit();

        return redirect('stockopname')->with('message', 'StockOpname berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_stockopnameRepository->getById($id);

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
