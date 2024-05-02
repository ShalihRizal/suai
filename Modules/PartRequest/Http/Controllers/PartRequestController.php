<?php

namespace Modules\PartRequest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

use Modules\PartRequest\Repositories\PartRequestRepository;
use Modules\Carline\Repositories\CarlineRepository;
use Modules\Carname\Repositories\CarnameRepository;
use Modules\Machine\Repositories\MachineRepository;
use Modules\Users\Repositories\UsersRepository;
use Modules\CarlineCategory\Repositories\CarlineCategoryRepository;
use Modules\Part\Repositories\PartRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class PartRequestController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');

        $this->_partRepository = new PartRepository;
        $this->_PartRequestRepository = new PartRequestRepository;
        $this->_CarlineRepository = new CarlineRepository;
        $this->_carnameRepository = new CarnameRepository;
        $this->_userRepository = new UsersRepository;
        $this->_MachineRepository = new MachineRepository;
        $this->_CarlineCategoryRepository = new CarlineCategoryRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "PartRequest";
    }

    public function spindex()
    {
        $params = [
            'part_category_id' => 2
        ];
        $userparams = [
            'group_id' => 22
        ];



        $partrequests = $this->_PartRequestRepository->getAllByParams($params);
        $parts = $this->_partRepository->getAllByParams($params);
        $users = $this->_userRepository->getAllByParams($userparams);
        $carlines = $this->_CarlineRepository->getAll();
        $machines = $this->_MachineRepository->getAll();
        $carlinecategories = $this->_CarlineCategoryRepository->getAll();
        $carnames = $this->_carnameRepository->getAll();

        // dd($users);

        return view('partrequest::sp', compact('partrequests', 'parts', 'carlines', 'carlinecategories', 'machines','carnames'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function spcreate()
    {
        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::spcreate');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function spstore(Request $request)
    {
        $part = $this->_partRepository->getById($request->part_id);
        $last = $this->_PartRequestRepository->getLast();

        $file = $request->image_part;
        $fileName = DataHelper::getFileName($file);
        $filePath = DataHelper::getFilePath(false, true);
        $request->file('image_part')->storeAs($filePath, $fileName, 'public');

        $currentMonth = strtoupper(substr(date("F"), 0, 3));

        $currentYear = date('Y');

        if ($last != null) {
            $padded_part_req_id = str_pad($last->part_req_id, 4, '0', STR_PAD_LEFT);
            $part_req_number = "$padded_part_req_id/TO/SP/$currentMonth/$currentYear";
        } else {
            $part_req_number = "0000/TO/SP/$currentMonth/$currentYear";
        }


        $partreq = [
            'part_req_pic_filename' => $fileName,
            'part_req_pic_path' => $filePath,
            'part_id' => $request->part_id,
            'part_req_number' => $part_req_number,
            'carname' => $request->carname,
            'car_model' => $request->car_model,
            'alasan' => $request->alasan,
            'order' => $request->order,
            'shift' => $request->shift,
            'machine_no' => $request->machine_no,
            'applicator_no' => $request->applicator_no,
            'wear_and_tear_code' => $request->wear_and_tear_code,
            'wear_and_tear_status' => $request->wear_and_tear_status,
            'serial_no' => $request->serial_no,
            'side_no' => $request->side_no,
            'stroke' => $request->stroke,
            'pic' => $request->pic,
            'remarks' => $request->remarks,
            'part_qty' => $request->part_qty,
            'status' => $request->status,
            'approved_by' => $request->approved_by,
            'part_no' => $part->part_no,
        ];

        // dd($partreq);

        DB::beginTransaction();
       $cek =  $this->_PartRequestRepository->insert(DataHelper::_normalizeParams($partreq, true));
        $this->_logHelper->store($this->module, $request->part_req_number, 'create');
        DB::commit();

        $target = ['6281911511380, 6285215337568, 6287785121808, 6285965970004, 6287824003437, 6287824003436, 6285351891534'];

        $whatsappResponse = Http::get('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => 'Pemberitahuan! Ada Part Request masuk dengan nomor ' . $part_req_number . ', mohon untuk segera periksa. Terimakasih. Akses disini : https://inventory.suaisystem.com',
            'token' => 'fU7Xwicj-MrQ!hcHTNgp',
        ]);

        return redirect('partrequest/sp')->with('message', 'PartRequest berhasil ditambahkan');
    }


    public function SendWA() {
    $userparams = [
        'group_id' => 7
    ];

    $users = $this->_userRepository->getAllByParams($userparams);

    // Extract phone numbers from users
    $phoneNumbers = [];
    foreach ($users as $user) {
        // Assuming phone number is stored in the 'phone' property, modify it accordingly
        if (!empty($user->no_hp)) {
            $phoneNumbers[] = $user->no_hp;
        }
    }

    // Convert the array of phone numbers to a comma-separated string
    $target = implode(',', $phoneNumbers);

    $part_req_number = '...'; // Provide the actual part request number

    $whatsappResponse = Http::get('https://api.fonnte.com/send', [
        'target' => $target,
        'message' => 'Pemberitahuan! Ada Part Request masuk dengan nomor ' . $part_req_number . ', mohon untuk segera periksa. Terimakasih. Akses disini: https://inventory.suaisystem.com',
        'token' => 'fU7Xwicj-MrQ!hcHTNgp',
    ]);
    return redirect('partrequest/sp')->with('message', 'PartRequest berhasil ditambahkan');
}


    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function spshow($id)
    {
        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::spshow');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function spedit($id)
    {

        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::spedit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function spupdate(Request $request, $id)
    {


        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        $validator = Validator::make($request->all(), $this->_validationRules($id));

        if ($validator->fails()) {
            return redirect('partrequest/sp')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_PartRequestRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->part_req_number, 'update');

        DB::commit();

        return redirect('partrequest/sp')->with('message', 'PartRequest berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function spdestroy($id)
    {

        // if (Gate::denies(_FUNCTION_, $this->module)) {
        //     return redirect('unauthorize');
        // }

        $detail = $this->_PartRequestRepository->getById($id);

        if (!$detail) {
            return redirect('partrequest/sp');
        }

        DB::beginTransaction();

        $this->_PartRequestRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->part_req_number, 'delete');

        DB::commit();

        return redirect('partrequest/sp')->with('message', 'PartRequest berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function spgetdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_PartRequestRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }



        return $response;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function cdindex()
    {

        $params = [
            'part_category_id' => 1
        ];

        $partrequests = $this->_PartRequestRepository->getAllByParams($params);
        $parts = $this->_partRepository->getAllByParams($params);
        $carlines = $this->_CarlineRepository->getAll();
        $machines = $this->_MachineRepository->getAll();
        $carlinecategories = $this->_CarlineCategoryRepository->getAll();
        $carnames = $this->_carnameRepository->getAll();

        // dd($partrequests);

        return view('partrequest::cd', compact('partrequests', 'parts', 'carlines', 'carlinecategories', 'machines','carnames'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function cdcreate()
    {
        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::cdcreate');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function cdstore(Request $request)
    {
        $part = $this->_partRepository->getById($request->part_id);
        $last = $this->_PartRequestRepository->getLast();

        $file_images = [];
        $file_paths = [];

        if ($request->hasFile('image_part')) {
            foreach ($request->file('image_part') as $index => $file) {
                $fileName = DataHelper::getFileName($file);
                $filePath = DataHelper::getFilePath(false, true);
                $file->storeAs($filePath, $fileName, 'public');
                $file_images[$index] = $fileName;
                $file_paths[$index] = $filePath;
            }
        }
        // $file = $request->image_part;
        // $fileName = DataHelper::getFileName($file);
        // $filePath = DataHelper::getFilePath(false, true);
        // $request->file('image_part')->storeAs($filePath, $fileName, 'public');

        // if (Gate::denies(FUNCTION, $this->module)) {
        //     return redirect('unauthorize');
        // }
        // dd($file_images, $file_paths);

        $currentMonth = strtoupper(substr(date("F"), 0, 3));
        $currentYear = date('Y');

        if ($last != null) {
            $padded_part_req_id = str_pad($last->part_req_id, 4, '0', STR_PAD_LEFT);
            $part_req_number = "$padded_part_req_id/TO/CD/$currentMonth/$currentYear";
        } else {
            $part_req_number = "0000/TO/CD/$currentMonth/$currentYear";
        }
        // $part_req_pic_filenames = $request->input('part_req_pic_filename');
        // $part_req_pic_paths = $request->input('part_req_pic_path');
        $part_ids = $request->input('part_id');
        $carnames = $request->input('carname');
        $carmodels = $request->input('car_model');
        $shifts = $request->input('shift');
        $machine_nos = $request->input('machine_no');
        $alasans = $request->input('alasan');
        $orders = $request->input('order');
        // $machine_ids = $request->input('machine_id');
        // $machine_names = $request->input('machine_name');
        $strokes = $request->input('stroke');
        $pics = $request->input('pic');
        $remarkss = $request->input('remarks');
        $part_qtys = $request->input('part_qty');
        // $part_nos = $request->input('part_no');
        // $part_names = $request->input('part_name');
        $wear_and_tear_statuss = $request->input('wear_and_tear_status');


        $partRequests = [];
        // if (isset($part_req_numbers) && is_array($part_req_numbers)) {
        $index = 0;
        date_default_timezone_set('Asia/Jakarta');
        foreach ($part_ids as $part_id) {
            $partRequests[] = [
                'part_req_pic_filename' => $file_images[$index],
                'part_req_pic_path' => $file_paths[$index],
                'part_id' => $part_ids[$index],
                'carname' => $carnames[$index],
                'car_model' => $carmodels[$index],
                'shift' => $shifts[$index],
                'machine_no' => $machine_nos[$index],
                'alasan' => $alasans[$index],
                'order' => $orders[$index],
                // 'machine_id' => $machine_ids[$index],
                // 'machine_name' => $machine_names[$index],
                'stroke' => $strokes[$index],
                'pic' => $pics[$index],
                'remarks' => $remarkss[$index],
                'part_qty' => $part_qtys[$index],
                // 'part_no' => $part_nos[$index],
                'status' => 0,
                // 'part_name' => $part_names[$index],
                'wear_and_tear_status' => $wear_and_tear_statuss[$index],
                'part_req_number' => $part_req_number,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $index++;
        }
        // }
        // dd($partRequests);
        foreach ($partRequests as $partreq) {
            // DB::beginTransaction();
            $cek[] = $this->_PartRequestRepository->insert(DataHelper::_normalizeParams($partreq, true));
            // $check = $this->_PartRequestRepository->insert(DataHelper::_normalizeParams($partreq, true));
            // $this->_logHelper->store($this->module, $partRequests['part_id'], 'create');
            // DB::commit();
        }
        // dd($cek);
        // dd($check);
        $whatsappResponse = Http::get('https://api.fonnte.com/send', [
            'target' => '6288223492747',
            'message' => 'Pemberitahuan! Ada Part Request masuk dengan nomor ' . $part_req_number . ', mohon untuk segera periksa. Terimakasih. Akses disini : https://inventory.suaisystem.com',
            'token' => 'fU7Xwicj-MrQ!hcHTNgp',
        ]);


        return redirect('partrequest/cd')->with('message', 'PartRequest berhasil ditambahkan');
    }

    /**
     * Show the cdecified resource.
     * @param int $id
     * @return Response
     */
    public function cdshow($id)
    {
        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::cdshow');
    }

    /**
     * Show the form for editing the cdecified resource.
     * @param int $id
     * @return Response
     */
    public function cdedit($id)
    {

        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::cdedit');
    }

    /**
     * Update the cdecified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {


        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        $validator = Validator::make($request->all(), $this->_validationRules($id));

        if ($validator->fails()) {
            return redirect('partrequest/cd')
                ->withErrors($validator)
                ->withInput();
        }

        // DB::beginTransaction();

        // $this->_PartRequestRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $cek = $this->_PartRequestRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        // $this->_logHelper->store($this->module, $request->part_req_number, 'update');

dd($cek);
        DB::commit();

        return redirect('partrequest')->with('message', 'PartRequest berhasil diubah');
    }
    public function cdupdate(Request $request, $id)
    {


        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        $validator = Validator::make($request->all(), $this->_validationRules($id));

        if ($validator->fails()) {
            return redirect('partrequest/cd')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_PartRequestRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->part_req_number, 'update');

        DB::commit();

        return redirect('partrequest/cd')->with('message', 'PartRequest berhasil diubah');
    }

    /**
     * Remove the cdecified resource from storage.
     * @param int $id
     * @return Response
     */
    public function cddestroy($id)
    {

        // if (Gate::denies(_FUNCTION_, $this->module)) {
        //     return redirect('unauthorize');
        // }

        $detail = $this->_PartRequestRepository->getById($id);

        if (!$detail) {
            return redirect('partrequest/cd');
        }

        DB::beginTransaction();

        $cek = $this->_PartRequestRepository->delete($id);
        // dd($cek);
        $this->_logHelper->store($this->module, $detail->part_req_number, 'delete');

        DB::commit();

        return redirect('partrequest/cd')->with('message', 'PartRequest berhasil dihapus');
    }

    /**
     * Get data the cdecified resource in storage.
     * @param int $id
     * @return Response
     */
    public function cdgetdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_PartRequestRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function afindex()
    {

       $params = [
            'part_category_id' => 3
        ];

        $partrequests = $this->_PartRequestRepository->getAllByParams($params);
        $parts = $this->_partRepository->getAllByParams($params);
        $carlines = $this->_CarlineRepository->getAll();
        $machines = $this->_MachineRepository->getAll();
        $carlinecategories = $this->_CarlineCategoryRepository->getAll();
        $carnames = $this->_carnameRepository->getAll();

        return view('partrequest::af', compact('partrequests', 'parts', 'carlines', 'carlinecategories', 'machines','carnames'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function afcreate()
    {
        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::afcreate');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function afstore(Request $request)
    {
        $part = $this->_partRepository->getById($request->part_id);
        $last = $this->_PartRequestRepository->getLast();

        $fileName = null;
        $filePath = null;

        if ($request->hasFile('image_part')) {
            $file = $request->file('image_part');

            // Proses file
            $fileName = DataHelper::getFileName($file);
            $filePath = DataHelper::getFilePath(false, true);
            $file->storeAs($filePath, $fileName, 'public');

            // Tambahan proses terkait file jika diperlukan
        }

        $currentMonth = strtoupper(substr(date("F"), 0, 3));

        $currentYear = date('Y');

        if ($last != null) {
            $padded_part_req_id = str_pad($last->part_req_id, 4, '0', STR_PAD_LEFT);
            $part_req_number = "$padded_part_req_id/TO/AF/$currentMonth/$currentYear";
        } else {
            $part_req_number = "0000/TO/AF/$currentMonth/$currentYear";
        }


        $partreq = [
            'part_req_pic_filename' => $fileName,
            'part_req_pic_path' => $filePath,
            'part_id' => $request->part_id,
            'part_req_number' => $part_req_number,
            'carname' => $request->carname,
            'car_model' => $request->car_model,
            'alasan' => $request->alasan,
            'order' => $request->order,
            'shift' => $request->shift,
            'machine_no' => $request->machine_no,
            'applicator_no' => $request->applicator_no,
            'wear_and_tear_code' => $request->wear_and_tear_code,
            'wear_and_tear_status' => $request->wear_and_tear_status,
            'serial_no' => $request->serial_no,
            'side_no' => $request->side_no,
            'stroke' => $request->stroke,
            'pic' => $request->pic,
            'remarks' => $request->remarks,
            'part_qty' => $request->part_qty,
            'status' => $request->status,
            'approved_by' => $request->approved_by,
            'part_no' => $part->part_no,
        ];

        // dd($partreq);

        DB::beginTransaction();
        $this->_PartRequestRepository->insert(DataHelper::_normalizeParams($partreq, true));

        $this->_logHelper->store($this->module, $request->part_req_number, 'create');
        DB::commit();


        $whatsappResponse = Http::get('https://api.fonnte.com/send', [
            'target' => '6288223492747',
            'message' => 'Pemberitahuan! Ada Part Request masuk dengan nomor ' . $part_req_number . ', mohon untuk segera periksa. Terimakasih. Akses disini : https://inventory.suaisystem.com',
            'token' => 'fU7Xwicj-MrQ!hcHTNgp',
        ]);

        return redirect('partrequest/af')->with('message', 'PartRequest berhasil ditambahkan');
    }

    /**
     * Show the afecified resource.
     * @param int $id
     * @return Response
     */
    public function afshow($id)
    {
        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::afshow');
    }

    /**
     * Show the form for editing the afecified resource.
     * @param int $id
     * @return Response
     */
    public function afedit($id)
    {

        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::afedit');
    }

    /**
     * Update the afecified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function afupdate(Request $request, $id)
    {


        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        $validator = Validator::make($request->all(), $this->_validationRules($id));

        if ($validator->fails()) {
            return redirect('partrequest/af')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_PartRequestRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->part_req_number, 'update');

        DB::commit();

        return redirect('partrequest/af')->with('message', 'PartRequest berhasil diubah');
    }

    /**
     * Remove the afecified resource from storage.
     * @param int $id
     * @return Response
     */
    public function afdestroy($id)
    {

        // if (Gate::denies(_FUNCTION_, $this->module)) {
        //     return redirect('unauthorize');
        // }

        $detail = $this->_PartRequestRepository->getById($id);

        if (!$detail) {
            return redirect('partrequest/af');
        }

        DB::beginTransaction();

        $this->_PartRequestRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->part_req_number, 'delete');

        DB::commit();

        return redirect('partrequest/af')->with('message', 'PartRequest berhasil dihapus');
    }

    /**
     * Get data the afecified resource in storage.
     * @param int $id
     * @return Response
     */
    public function afgetdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_PartRequestRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function cfindex()
    {

        $params = [
            'part_category_id' => 4
        ];

        $partrequests = $this->_PartRequestRepository->getAllByParams($params);
        $parts = $this->_partRepository->getAllByParams($params);
        $carlines = $this->_CarlineRepository->getAll();
        $machines = $this->_MachineRepository->getAll();
        $carlinecategories = $this->_CarlineCategoryRepository->getAll();
        $carnames = $this->_carnameRepository->getAll();

        return view('partrequest::cf', compact('partrequests', 'parts', 'carlines', 'carlinecategories', 'machines','carnames'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function cfcreate()
    {
        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::cfcreate');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function cfstore(Request $request)
    {
        $part = $this->_partRepository->getById($request->part_id);
        $last = $this->_PartRequestRepository->getLast();

        $fileName = null;
        $filePath = null;

        if ($request->hasFile('image_part')) {
            $file = $request->file('image_part');

            // Proses file
            $fileName = DataHelper::getFileName($file);
            $filePath = DataHelper::getFilePath(false, true);
            $file->storeAs($filePath, $fileName, 'public');

            // Tambahan proses terkait file jika diperlukan
        }

        $currentMonth = strtoupper(substr(date("F"), 0, 3));

        $currentYear = date('Y');

        if ($last != null) {
            $padded_part_req_id = str_pad($last->part_req_id, 4, '0', STR_PAD_LEFT);
            $part_req_number = "$padded_part_req_id/TO/CF/$currentMonth/$currentYear";
        } else {
            $part_req_number = "0000/TO/CF/$currentMonth/$currentYear";
        }


        $partreq = [
            'part_req_pic_filename' => $fileName,
            'part_req_pic_path' => $filePath,
            'part_id' => $request->part_id,
            'part_req_number' => $part_req_number,
            'carname' => $request->carname,
            'car_model' => $request->car_model,
            'alasan' => $request->alasan,
            'order' => $request->order,
            'shift' => $request->shift,
            'machine_no' => $request->machine_no,
            'applicator_no' => $request->applicator_no,
            'wear_and_tear_code' => $request->wear_and_tear_code,
            'wear_and_tear_status' => $request->wear_and_tear_status,
            'serial_no' => $request->serial_no,
            'side_no' => $request->side_no,
            'stroke' => $request->stroke,
            'pic' => $request->pic,
            'remarks' => $request->remarks,
            'part_qty' => $request->part_qty,
            'status' => $request->status,
            'approved_by' => $request->approved_by,
            'part_no' => $part->part_no,
        ];

        // dd($partreq);

        DB::beginTransaction();
       $cek =  $this->_PartRequestRepository->insert(DataHelper::_normalizeParams($partreq, true));
        $this->_logHelper->store($this->module, $request->part_req_number, 'create');
        DB::commit();


        $whatsappResponse = Http::get('https://api.fonnte.com/send', [
            'target' => '6288223492747',
            'message' => 'Pemberitahuan! Ada Part Request masuk dengan nomor ' . $part_req_number . ', mohon untuk segera periksa. Terimakasih. Akses disini : https://inventory.suaisystem.com',
            'token' => 'fU7Xwicj-MrQ!hcHTNgp',
        ]);

        return redirect('partrequest/cf')->with('message', 'PartRequest berhasil ditambahkan');
    }

    /**
     * Show the cfecified resource.
     * @param int $id
     * @return Response
     */
    public function cfshow($id)
    {
        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::cfshow');
    }

    /**
     * Show the form for editing the cfecified resource.
     * @param int $id
     * @return Response
     */
    public function cfedit($id)
    {

        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        return view('partrequest::cfedit');
    }

    /**
     * Update the cfecified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function cfupdate(Request $request, $id)
    {


        // Authorize
        if (Gate::denies(_FUNCTION_, $this->module)) {
            return redirect('unauthorize');
        }

        $validator = Validator::make($request->all(), $this->_validationRules($id));

        if ($validator->fails()) {
            return redirect('partrequest/cf')
                ->withErrors($validator)
                ->withInput();
        }
        dd($request->all());

        DB::beginTransaction();

        $this->_PartRequestRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->part_req_number, 'update');

        DB::commit();

        return redirect('partrequest/cf')->with('message', 'PartRequest berhasil diubah');
    }

    /**
     * Remove the cfecified resource from storage.
     * @param int $id
     * @return Response
     */
    public function cfdestroy($id)
    {

        // if (Gate::denies(_FUNCTION_, $this->module)) {
        //     return redirect('unauthorize');
        // }

        $detail = $this->_PartRequestRepository->getById($id);

        if (!$detail) {
            return redirect('partrequest/cf');
        }

        DB::beginTransaction();

        $this->_PartRequestRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->part_req_number, 'delete');

        DB::commit();

        return redirect('partrequest/cf')->with('message', 'PartRequest berhasil dihapus');
    }

    /**
     * Get data the cfecified resource in storage.
     * @param int $id
     * @return Response
     */
    public function cfgetdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_PartRequestRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;
    }

    public function getdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_PartRequestRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;
    }
    public function gambar($id)
    {

        $partrequests = $this->_PartRequestRepository->getById($id);
        // $parts = $this->_partRepository->getAll();
        // $users = $this->_userRepository->getAll();
        // $carlines = $this->_CarlineRepository->getAll();
        // $machines = $this->_MachineRepository->getAll();
        // $carlinecategories = $this->_CarlineCategoryRepository->getAll();
        // $carnames = $this->_carnameRepository->getAll();

        // dd($users);

        return view('partrequest::gambar', compact('partrequests'));
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
