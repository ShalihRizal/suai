<?php

namespace Modules\NonInventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\NonInventory\Repositories\NonInventoryRepository;
use Modules\PartCategory\Repositories\PartCategoryRepository;
use Modules\Part\Repositories\PartRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class NonInventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_noninventoryRepository = new NonInventoryRepository;
        $this->_partRepository = new PartRepository;
        $this->_partCategoryRepository = new PartCategoryRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "NonInventory";
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

        // $parts = $this->_noninventoryRepository->getAll();
        $partcategories = $this->_partCategoryRepository->getAll();

        $cdparam = [
            'type' => 'NonInventory'
        ];
        $parts = $this->_noninventoryRepository->getAllByParams($cdparam);


        return view('noninventory::index', compact('parts'));
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

        return view('noninventory::create');
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
            return redirect('noninventory')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        $this->_noninventoryRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        // $check = $this->_noninventoryRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->part_id, 'create');
        DB::commit();
        // dd($check, $request);

        return redirect('noninventory')->with('message', 'NonInventory berhasil ditambahkan');
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

        return view('noninventory::show');
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

        return view('noninventory::edit');
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
            return redirect('noninventory')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_noninventoryRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->part_id, 'update');

        DB::commit();

        return redirect('noninventory')->with('message', 'NonInventory berhasil diubah');
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
        $detail = $this->_noninventoryRepository->getById($id);

        if (!$detail) {
            return redirect('noninventory');
        }

        DB::beginTransaction();

        $this->_noninventoryRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->part_id, 'delete');

        DB::commit();

        return redirect('noninventory')->with('message', 'NonInventory berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_noninventoryRepository->getById($id);

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
                'part_name' => 'required',
            ];
        } else {
            return [
                'part_name' => 'required',
            ];
        }
    }
}
