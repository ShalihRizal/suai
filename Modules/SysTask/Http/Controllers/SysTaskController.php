<?php

namespace Modules\SysTask\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\SysTask\Repositories\SysTaskRepository;
use Modules\SysModule\Repositories\SysModuleRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;

class SysTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_systaskRepository   = new SysTaskRepository;
        $this->_sysmoduleRepository = new SysModuleRepository;
        $this->_logHelper           = new LogHelper;
        $this->module               = "SysTask";
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

        $tasks      = $this->_systaskRepository->getAll();
        $modules    = $this->_sysmoduleRepository->getAll();

        return view('systask::index', compact('tasks', 'modules'));
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

        return view('systask::create');
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
        DB::beginTransaction();

        $this->_systaskRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->task_name, 'create');

        DB::commit();

        return redirect('systask')->with('message', 'Task berhasil ditambahkan');
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

        return view('systask::show');
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

        return view('systask::edit');
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

        DB::beginTransaction();

        $this->_systaskRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->task_name, 'update');

        DB::commit();

        return redirect('systask')->with('message', 'Task berhasil diubah');
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
        $detail  = $this->_systaskRepository->getById($id);

        if (!$detail) {
            return redirect('systask');
        }

        DB::beginTransaction();

        $this->_systaskRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->task_name, 'delete');

        DB::commit();

        return redirect('systask')->with('message', 'Task berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_systaskRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;
    }
}
