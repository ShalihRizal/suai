<?php

namespace Modules\SupervisorNotification\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\SupervisorNotification\Repositories\SupervisorNotificationRepository;
use Modules\PartRequest\Repositories\PartRequestRepository;
use Modules\Users\Repositories\UsersRepository;
use Modules\Part\Repositories\PartRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;
use Carbon\Carbon;

class SupervisorNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_partRepository = new PartRepository;
        $this->_supervisornotificationRepository = new SupervisorNotificationRepository;
        $this->_partRequestRepository = new PartRequestRepository;
        $this->_userRepository = new UsersRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "SupervisorNotification";
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
            'part_request.status' => 1
        ];

        // getAllByParams already JOINs part table — no need for a separate getAll() call
        $supervisornotifications = $this->_supervisornotificationRepository->getAllByParams($params);
        $users = $this->_userRepository->getAll();

        // Store count in session for badge display
        session(['supervisornotifications_count' => count($supervisornotifications)]);

        return view('supervisornotification::index', compact('supervisornotifications', 'users'));
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

        return view('supervisornotification::create');
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
            return redirect('supervisornotification')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        $this->_supervisornotificationRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->supervisornotification_id, 'create');
        DB::commit();

        return redirect('supervisornotification')->with('message', 'supervisornotification berhasil ditambahkan');
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

        return view('supervisornotification::show');
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

        return view('supervisornotification::edit');
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

        $detail = $this->_supervisornotificationRepository->getById($id);
        $part   = $this->_partRepository->getById($detail->part_id);

        if ($part) {
            $nowDate = Carbon::now();
            $stock   = intval($part->qty_out) + intval($detail->part_qty);

            if (intval($detail->status) == 0) {
                $updatePart = [
                    'qty_out'           => $stock,
                    'used_date'         => $nowDate,
                    'kategori_inventory'=> $request->kategori_inventory,
                ];
                $updateStatus2 = [
                    'wear_and_tear_status' => 'Closed',
                    'status'               => 2,
                ];
            } else {
                $updatePart = [
                    'used_date'         => $nowDate,
                    'qty_end'           => $stock,
                    'kategori_inventory'=> $request->kategori_inventory,
                ];
                $updateStatus2 = [
                    'wear_and_tear_status' => 'Closed',
                    'status'               => 2,
                ];
            }

            DB::beginTransaction();
            try {
                $this->_partRepository->update(DataHelper::_normalizeParams($updatePart, false, true), $detail->part_id);
                $this->_supervisornotificationRepository->update(DataHelper::_normalizeParams([], false, true), $id);
                $this->_partRequestRepository->update(DataHelper::_normalizeParams($updateStatus2, false, true), $id);
                $this->_logHelper->store($this->module, $request->supervisornotification_id, 'update');
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect('supervisornotification')->withErrors(['error' => $e->getMessage()]);
            }
        }

        return redirect('supervisornotification')->with('message', 'supervisornotification berhasil diubah');
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
        $detail = $this->_supervisornotificationRepository->getById($id);

        if (!$detail) {
            return redirect('supervisornotification');
        }

        DB::beginTransaction();

        $this->_supervisornotificationRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->supervisornotification_id, 'delete');

        DB::commit();

        return redirect('supervisornotification')->with('message', 'supervisornotification berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_supervisornotificationRepository->getById($id);
        $test = $this->_partRequestRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
            $response['result'] = $test;
        }
        if ($test) {
            $response['status'] = 1;
            $response['result'] = $test;
        }

        // // dd($test);

        return $response;
    }

    private function _validationRules($id = '')
    {
        if ($id == '') {
            return [
                'supervisornotification_id' => 'required',
            ];
        } else {
            return [
                'supervisornotification_id' => 'required',
            ];
        }
    }
}
