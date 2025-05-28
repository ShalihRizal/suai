<?php

namespace Modules\Carline\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\CarlineCategory\Repositories\CarlineCategoryRepository;
use Modules\Carname\Repositories\CarnameRepository;
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
        $this->_carnameRepository = new CarnameRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "Carline";
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        

        $carlines = $this->_carlineRepository->getAll();
        $carlinecategories = $this->_carlineCategoryRepository->getAll();
        $carnames = $this->_carnameRepository->getAll();

        return view('carline::index', compact('carlines', 'carlinecategories','carnames'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('carline::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    public function bulkDelete(Request $request)
    {
        // Authorize
        if (Gate::denies('destroy', $this->module)) {
            return response()->json(['status' => 0, 'message' => 'Unauthorized action']);
        }

        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Invalid request']);
        }

        DB::beginTransaction();

        try {
            foreach ($request->input('ids') as $id) {
                $this->_carlineRepository->delete($id);
                $this->_logHelper->store($this->module, $id, 'delete');
            }

            DB::commit();

            return response()->json(['status' => 1, 'message' => 'Bulk deletion successful']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => 'Error occurred during bulk deletion']);
        }
    }
    public function store(Request $request)
    {
        // dd($request->all());
       
        // dd($request->all());
        $validator = Validator::make($request->all(), $this->_validationRules(''));

        if ($validator->fails()) {
            return redirect('carline')
                ->withErrors($validator)
                ->withInput();
        }
        // dd($request->all());
        // DB::beginTransaction();
        $cek = $this->_carlineRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        // $check = $this->_carlineRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $cek1 = $this->_logHelper->store($this->module, $request->carline_id, 'create');
        // dd($cek, $cek1);
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
       
        return view('carline::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
       
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
       
        // Check detail to db
        $detail = $this->_carlineRepository->getById($id);

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

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_carlineRepository->getById($id);

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
                'carline_carname_id' => 'required',
            ];
        } else {
            return [
                'carline_carname_id' => 'required',
            ];
        }
    }
}