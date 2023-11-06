<?php

namespace Modules\PartConsumptionList\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\PartConsumptionList\Repositories\PartConsumptionListRepository;
use Modules\Carline\Repositories\CarlineRepository;
use Modules\Machine\Repositories\MachineRepository;
use Modules\CarlineCategory\Repositories\CarlineCategoryRepository;
use Modules\Part\Repositories\PartRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class PartConsumptionListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_partRepository = new PartRepository;
        $this->_PartConsumptionListRepository = new PartConsumptionListRepository;
        $this->_CarlineRepository = new CarlineRepository;
        $this->_MachineRepository = new MachineRepository;
        $this->_CarlineCategoryRepository = new CarlineCategoryRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "PartConsumptionList";
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

        $partconsumptionlists = $this->_PartConsumptionListRepository->getAll();
        $parts = $this->_partRepository->getAll();
        $carlines = $this->_CarlineRepository->getAll();
        $machines = $this->_MachineRepository->getAll();
        $carlinecategories = $this->_CarlineCategoryRepository->getAll();

        return view('partconsumptionlist::index', compact('partconsumptionlists', 'parts', 'carlines', 'carlinecategories', 'machines'));
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

        return view('partconsumptionlist::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        DB::beginTransaction();
        $this->_PartConsumptionListRepository->insert(DataHelper::_normalizeParams($request->all()));
        // $check = $this->_PartConsumptionListRepository->insert(DataHelper::_normalizeParams($partreq, true));
        $this->_logHelper->store($this->module, $request->pcl_id, 'create');
        DB::commit();
        // dd($check);

        return redirect('partconsumptionlist')->with('message', 'PartConsumptionList berhasil ditambahkan');
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

        return view('partconsumptionlist::show');
    }

    public function sendWA()
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        $token = 'w#xDUKWBboS97ME_gR8p';
        $target = '62895620310202';

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $target,
                    'message' => 'apal, ngetes weh',

                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token"
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        return view('partconsumptionlist::show');
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

        return view('partconsumptionlist::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        $validator = Validator::make($request->all(), $this->_validationRules($id));

        if ($validator->fails()) {
            return redirect('partconsumptionlist')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_PartConsumptionListRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->part_req_number, 'update');

        DB::commit();

        return redirect('partconsumptionlist')->with('message', 'PartConsumptionList berhasil diubah');
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
        $detail = $this->_PartConsumptionListRepository->getById($id);

        if (!$detail) {
            return redirect('partconsumptionlist');
        }

        DB::beginTransaction();

        $this->_PartConsumptionListRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->part_req_number, 'delete');

        DB::commit();

        return redirect('partconsumptionlist')->with('message', 'PartConsumptionList berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_PartConsumptionListRepository->getById($id);

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
                'part_id' => 'required',
            ];
        } else {
            return [
                'part_id' => 'required',
            ];
        }
    }
}
