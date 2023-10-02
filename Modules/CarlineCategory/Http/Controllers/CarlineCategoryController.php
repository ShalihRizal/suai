<?php

namespace Modules\CarlineCategory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\CarlineCategory\Repositories\CarlineCategoryRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;
use Validator;

class CarlineCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_carlinecategoryRepository = new CarlineCategoryRepository;
        $this->module               = "CarlineCategory";
        $this->_logHelper           = new LogHelper;
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

        $carlinecategories = $this->_carlinecategoryRepository->getAll();

        return view('carlinecategory::index', compact('carlinecategories'));
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

        return view('carlinecategory::create');
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

        $validator = Validator::make($request->all(), $this->_validationRules(''));

        if ($validator->fails()) {
            return redirect('carlinecategory')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();

        $this->_carlinecategoryRepository->insert(DataHelper::_normalizeParams($request->all()));
        $check = $this->_logHelper->store($this->module, $request->carline_category_name, 'create');
        DB::commit();
        // dd($check);

        return redirect('carlinecategory')->with('message', 'Carline Category berhasil ditambahkan');
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

        return view('carlinecategory::show');
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

        return view('carlinecategory::edit');
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
            return redirect('carlinecategory')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        $this->_carlinecategoryRepository->update(DataHelper::_normalizeParams($request->all()), $id);
        $this->_logHelper->store($this->module, $request->carline_category_name, 'update');
        DB::commit();

        return redirect('carlinecategory')->with('message', 'Carline Category berhasil diubah');
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


        $response   = array('status' => 0, 'result' => array());

        // Check detail to db
        $detail  = $this->_carlinecategoryRepository->getById($id);

        if (!$detail) {
            // return redirect('carlinecategory');
            $response['status'] = 0;
            $response['message'] = 'Data tidak ditemukan!';
        } elseif ($detail->carline_category_id == 1) {
            // return redirect('carlinecategory');
            $response['status'] = 0;
            $response['message'] = 'Data tidak dapat dihapus!';
        } else {
            DB::beginTransaction();
            $this->_carlinecategoryRepository->delete($id);
            $this->_logHelper->store($this->module, $detail->carline_category_name, 'delete');
            DB::commit();

            $response['status'] = 1;
            $response['message'] = 'Data berhasil dihapus!';
        }

        return $response;
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_carlinecategoryRepository->getById($id);

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
                'carline_category_name' => 'required|',
            ];
        } else {
            return [
                'carline_category_name' => 'required',
            ];
        }
    }
}
