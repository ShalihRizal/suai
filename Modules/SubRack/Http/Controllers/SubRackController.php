<?php

namespace Modules\SubRack\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\Rack\Repositories\RackRepository;
use Modules\Carline\Repositories\CarlineRepository;
use Modules\SubRack\Repositories\SubRackRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class SubRackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_subrackRepository = new SubRackRepository;
        $this->_carlineRepository = new CarlineRepository;
        $this->_rackRepository = new RackRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "SubRack";
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

        $subracks = $this->_subrackRepository->getAll();
        $carlines = $this->_carlineRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        // dd($subracks);

        return view('subrack::index', compact('subracks', 'racks', 'carlines'));
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

        return view('subrack::create');
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
            return redirect('subrack')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        $this->_subrackRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        // $check = $this->_subrackRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->sub_rack_id, 'create');
        DB::commit();
        // dd($check);

        return redirect('subrack')->with('message', 'SubRack berhasil ditambahkan');
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

        return view('subrack::show');
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

        return view('subrack::edit');
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
            return redirect('subrack')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_subrackRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->subrack_id, 'update');

        DB::commit();

        return redirect('subrack')->with('message', 'SubRack berhasil diubah');
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
        $detail = $this->_subrackRepository->getById($id);

        if (!$detail) {
            return redirect('subrack');
        }

        DB::beginTransaction();

        $this->_subrackRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->sub_rack_id, 'delete');

        DB::commit();

        return redirect('subrack')->with('message', 'SubRack berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_subrackRepository->getById($id);

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
                'sub_rack_name' => 'required',
            ];
        } else {
            return [
                'sub_rack_name' => 'required',
            ];
        }
    }
}
