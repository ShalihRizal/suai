<?php

namespace Modules\Machine\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\Carline\Repositories\CarlineRepository;
use Modules\Machine\Repositories\MachineRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class MachineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_machineRepository = new MachineRepository;
        $this->_carlineRepository = new CarlineRepository;
        $this->_logHelper           = new LogHelper;
        $this->module               = "Machine";
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

        $machines = $this->_machineRepository->getAll();
        $carlines = $this->_carlineRepository->getAll();

        return view('machine::index', compact('machines', 'carlines'));
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

        return view('machine::create');
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
        $validator = Validator::make($request->all(), $this->_validationRules(''));

        if ($validator->fails()) {
            return redirect('machine')
            ->withErrors($validator)
            ->withInput();
        }

        DB::beginTransaction();
        $this->_machineRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        // $check = $this->_machineRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->machine_id, 'create');
        DB::commit();
        // dd($check);

        return redirect('machine')->with('message', 'Machine berhasil ditambahkan');
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

        return view('machine::show');
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

        return view('machine::edit');
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
            return redirect('machine')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_machineRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->machine_id, 'update');

        DB::commit();

        return redirect('machine')->with('message', 'Machine berhasil diubah');
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
        $detail  = $this->_machineRepository->getById($id);

        if (!$detail) {
            return redirect('machine');
        }

        DB::beginTransaction();

        $this->_machineRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->machine_id, 'delete');

        DB::commit();

        return redirect('machine')->with('message', 'Machine berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_machineRepository->getById($id);

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
                'machine_name' => 'required',
            ];
        } else {
            return [
                'machine_name' => 'required',
            ];
        }
    }
}
