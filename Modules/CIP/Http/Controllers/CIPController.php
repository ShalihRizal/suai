<?php

namespace Modules\CIP\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\CIP\Repositories\CIPRepository;
use Modules\Users\Repositories\UsersRepository;
use Modules\Part\Repositories\PartRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class CIPController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_partRepository = new PartRepository;
        $this->_cipRepository = new CIPRepository;
        $this->_userRepository = new UsersRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "CIP";
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
            'kategori_inventory' => 'CIP'
        ];

        $cips = $this->_cipRepository->getAllByParams($params);

        // dd($cips);

        return view('cip::index', compact('cips'));
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

        return view('cip::create');
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
            return redirect('cip')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        $this->_cipRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->cip_id, 'create');
        DB::commit();



        return redirect('cip')->with('message', 'cip berhasil ditambahkan');
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

        return view('cip::show');
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

        return view('cip::edit');
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

        return redirect('cip')->with('message', 'cip berhasil diubah');
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
        $detail = $this->_cipRepository->getById($id);

        if (!$detail) {
            return redirect('cip');
        }

        DB::beginTransaction();

        $this->_cipRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->cip_id, 'delete');

        DB::commit();

        return redirect('cip')->with('message', 'cip berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_cipRepository->getById($id);

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
                'cip_id' => 'required',
            ];
        } else {
            return [
                'cip_id' => 'required',
            ];
        }
    }
}
