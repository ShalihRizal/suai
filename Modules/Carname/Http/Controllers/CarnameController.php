<?php

namespace Modules\Carname\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Carname\Repositories\CarnameRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class CarnameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_carnameRepository = new CarnameRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "Carname";
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

        $carnames = $this->_carnameRepository->getAll();

        // dd($carnames);

        return view('carname::index', compact('carnames'));
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

        return view('carname::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }
        // dd($request->all());
        // $validator = Validator::make($request->all(), $this->_validationRules(''));

        // if ($validator->fails()) {
        //     return redirect('carname')
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        DB::beginTransaction();
        $this->_carnameRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        // $check = $this->_carnameRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->carname_id, 'create');
        DB::commit();
        // dd($check);

        return redirect('carname')->with('message', 'Carname berhasil ditambahkan');
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

        return view('carname::show');
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

        return view('carname::edit');
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
            return redirect('carname')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_carnameRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->carname_id, 'update');

        DB::commit();

        return redirect('carname')->with('message', 'Carname berhasil diubah');
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
        $detail = $this->_carnameRepository->getById($id);

        if (!$detail) {
            return redirect('carname');
        }

        DB::beginTransaction();

        $this->_carnameRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->carname_id, 'delete');

        DB::commit();

        return redirect('carname')->with('message', 'Carname berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_carnameRepository->getById($id);

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
                'carname_id' => 'required',
            ];
        } else {
            return [
                'carname_id' => 'required',
            ];
        }
    }
}
