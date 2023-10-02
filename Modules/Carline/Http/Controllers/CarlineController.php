<?php

namespace Modules\Carline\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\CarlineCategory\Repositories\CarlineCategoryRepository;
use Modules\Carline\Repositories\CarlineRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class CarlineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_carlineRepository = new CarlineRepository;
        $this->_carlineCategoryRepository = new CarlineCategoryRepository;
        $this->_logHelper           = new LogHelper;
        $this->module               = "Carline";
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

        $carlines = $this->_carlineRepository->getAll();
        $carlinecategories = $this->_carlineCategoryRepository->getAll();

        return view('carline::index', compact('carlines', 'carlinecategories'));
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

        return view('carline::create');
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
            return redirect('carline')
            ->withErrors($validator)
            ->withInput();
        }

        DB::beginTransaction();
        $this->_carlineRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        // $check = $this->_carlineRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->carline_id, 'create');
        DB::commit();
        // dd($check);

        return redirect('carline')->with('message', 'Carline berhasil ditambahkan');
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

        return view('carline::show');
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

        return view('carline::edit');
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
            return redirect('carline')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_carlineRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->carline_id, 'update');

        DB::commit();

        return redirect('carline')->with('message', 'Carline berhasil diubah');
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
        $detail  = $this->_carlineRepository->getById($id);

        if (!$detail) {
            return redirect('carline');
        }

        DB::beginTransaction();

        $this->_carlineRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->carline_id, 'delete');

        DB::commit();

        return redirect('carline')->with('message', 'Carline berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_carlineRepository->getById($id);

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
                'carline_category_id' => 'required',
            ];
        } else {
            return [
                'carline_category_id' => 'required',
            ];
        }
    }
}
