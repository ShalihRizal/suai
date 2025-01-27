<?php

namespace Modules\Part\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\PartCategory\Repositories\PartCategoryRepository;
use Modules\Part\Repositories\PartRepository;
use Modules\TransaksiIn\Repositories\TransaksiInRepository;
use Modules\Rack\Repositories\RackRepository;
use Modules\SubRack\Repositories\SubRackRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class PartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_partRepository = new PartRepository;
        $this->_partCategoryRepository = new PartCategoryRepository;
        $this->_transaksiinRepository = new TransaksiInRepository;
        $this->_subRackRepository = new SubRackRepository;
        $this->_rackRepository = new RackRepository;
        $this->_logHelper = new LogHelper;
        $this->module = "Part";
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        $partCategoryFilter = $request->input('part_category'); // Get the selected category from the request

        $parts = $this->_partRepository->getAll();
        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        // Filter parts based on the selected category
        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }



        return view('part::index', compact('parts', 'partcategories', 'racks', 'partCategoryFilter'));
    }
    public function allindex(Request $request)
    {
        // Authorize
        // if (Gate::denies(__FUNCTION__, $this->module)) {
        //     return redirect('unauthorize');
        // }

        $partCategoryFilter = $request->input('part_category'); // Get the selected category from the request

        $parts = $this->_partRepository->getAll();
        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        // Filter parts based on the selected category
        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }



        return view('part::index', compact('parts', 'partcategories', 'racks', 'partCategoryFilter'));
    }

    public function afindex(Request $request)
    {
        // // Authorize
        // if (Gate::denies(__FUNCTION__, $this->module)) {
        //     return redirect('unauthorize');
        // }

        $params = [
            'part_category_id' => 3
        ];

        $parts = $this->_partRepository->getAllByParams($params);

        $partCategoryFilter = $request->input('part_category'); // Get the selected category from the request

        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        $subrack = $this->_subRackRepository->getAll();

        // Filter parts based on the selected category
        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }

        return view('part::af', compact('parts', 'partcategories', 'racks', 'partCategoryFilter', 'subrack'));
    }
    public function cfindex(Request $request)
    {
        // // Authorize
        // if (Gate::denies(__FUNCTION__, $this->module)) {
        //     return redirect('unauthorize');
        // }

        $params = [
            'part_category_id' => 4
        ];

        $parts = $this->_partRepository->getAllByParams($params);

        $partCategoryFilter = $request->input('part_category'); // Get the selected category from the request

        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        $subrack = $this->_subRackRepository->getAll();

        // Filter parts based on the selected category
        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }

        return view('part::cf', compact('parts', 'partcategories', 'racks', 'partCategoryFilter', 'subrack'));
    }
    public function cdindex(Request $request)
    {
        $params = [
            'part_category_id' => 1
        ];

        $parts = $this->_partRepository->getAllByParams($params);
        $partCategoryFilter = $request->input('part_category');
        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();
        $subrack = $this->_subRackRepository->getAll();
        // dd($subrack);

        // Mengambil qty berdasarkan part_id dari transaksi_in
        foreach ($parts as $part) {
            $transaksi = DB::table('transaksi_in')
                ->where('part_id', $part->part_id)
                ->select('qty')
                ->first();

            // Menambahkan qty ke objek part
            $part->qty = $transaksi->qty ?? 0; // Jika tidak ada transaksi, set qty ke 0
        }

        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }

        return view('part::cd', compact('parts', 'partcategories', 'racks', 'partCategoryFilter', 'subrack'));
    }

    public function spindex(Request $request)
    {
        $params = [
            'part_category_id' => 2
        ];

        $parts = $this->_partRepository->getAllByParams($params);
        $partCategoryFilter = $request->input('part_category');
        $partcategories = $this->_partCategoryRepository->getAll();
        $racks = $this->_rackRepository->getAll();

        $subrack = $this->_subRackRepository->getAll();

        // Mengambil qty berdasarkan part_id dari transaksi_in
        foreach ($parts as $part) {
            $transaksi = DB::table('transaksi_in')
                ->where('part_id', $part->part_id)
                ->select('qty')
                ->first();

            // Menambahkan qty ke objek part
            $part->qty = $transaksi->qty ?? 0; // Jika tidak ada transaksi, set qty ke 0
        }

        if (!empty($partCategoryFilter)) {
            $parts = $parts->where('part_category_id', $partCategoryFilter);
        }

        return view('part::sp', compact('parts', 'partcategories', 'racks', 'partCategoryFilter', 'subrack'));
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

        return view('part::create');
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
        // dd($this->_subRackRepository->getById($request->subrack), $request->subrack);
        $rak = $this->_rackRepository->getById($request->rack)->rack_name;;
        $subrack = $this->_subRackRepository->getById($request->subrack)->sub_rack_name;
        $locppti =  $rak . $subrack;
        // dd($locppti);

        if ($validator->fails()) {
            return redirect('part')
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'part_no' => $request->part_no,
            'no_urut' => $request->no_urut,
            'applicator_no' => $request->applicator_no,
            'applicator_type' => $request->applicator_type,
            'applicator_qty' => $request->applicator_qty,
            'kode_tooling_bc' => $request->kode_tooling_bc,
            'part_name' => $request->part_name,
            'asal' => $request->asal,
            'invoice' => $request->invoice,
            'po' => $request->po,
            'po_date' => $request->po_date,
            'rec_date' => $request->rec_date,
            'loc_ppti' => $locppti,
            'loc_tapc' => $request->loc_tapc,
            'lokasi_hib' => $request->lokasi_hib,
            'qty_begin' => $request->qty_begin,
            'molts_no' => $request->molts_no,
            'qty_in' => $request->qty_in,
            'qty_out' => $request->qty_out,
            'adjust' => $request->adjust,
            'qty_end' => $request->qty_end,
            'remarks' => $request->remarks,
            'last_sto' => $request->last_sto,
            'has_sto' => $request->has_sto,
            'part_category_id' => $request->part_category_id,
            'created_at' => $request->created_at,
            'created_by' => $request->created_by,
            'updated_at' => $request->updated_at,
            'updated_by' => $request->updated_by,
        ];

        DB::beginTransaction();
        $cek = $this->_partRepository->insert(DataHelper::_normalizeParams($data, true));
        // dd($cek);
        // $check = $this->_partRepository->insert(DataHelper::_normalizeParams($data, true));
        $this->_logHelper->store($this->module, $request->part_no, 'create');
        DB::commit();
        // dd($check);


        // // DB::beginTransaction();
        // // $this->_partRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        // $check = $this->_partRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        // // $this->_logHelper->store($this->module, $request->part_no, 'create');
        // dd($check);
        // // DB::commit();

        return redirect('part')->with('message', 'Part berhasil ditambahkan');
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

        return view('part::show');
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

        return view('part::edit');
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
            return redirect('part')
                ->withErrors($validator)
                ->withInput();
        }
        $dataUpdate = [
            'part_no' => $request->part_no,
            'no_urut' => $request->no_urut,
            'applicator_no' => $request->applicator_no,
            'applicator_type' => $request->applicator_type,
            'applicator_qty' => $request->applicator_qty,
            'kode_tooling_bc' => $request->kode_tooling_bc,
            'part_name' => $request->part_name,
            'asal' => $request->asal,
            'invoice' => $request->invoice,
            'po' => $request->po,
            'po_date' => $request->po_date,
            'rec_date' => $request->rec_date,
            'loc_ppti' => $request->loc_ppti,
            'loc_tapc' => $request->loc_tapc,
            'lokasi_hib' => $request->lokasi_hib,
            'qty_begin' => $request->qty_begin,
            'molts_no' => $request->molts_no,
            'qty_in' => $request->qty_in,
            'qty_out' => $request->qty_out,
            'kategori_inventory' => $request->kategori_inventory,
            'adjust' => $request->adjust,
            'qty_end' => $request->qty_end,
            'remarks' => $request->remarks,
            'last_sto' => $request->last_sto,
            'has_sto' => $request->has_sto,
            'part_category_id' => $request->part_category_id,
            'created_at' => $request->created_at,
            'created_by' => $request->created_by,
            'updated_at' => $request->updated_at,
            'updated_by' => $request->updated_by,
        ];
        // dd($request);

        DB::beginTransaction();

        $this->_partRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->part_no, 'update');

        DB::commit();

        return redirect('part')->with('message', 'Part berhasil diubah');
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
        $detail = $this->_partRepository->getById($id);

        if (!$detail) {
            return redirect('part');
        }

        DB::beginTransaction();

        $this->_partRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->part_no, 'delete');

        DB::commit();

        return redirect('part')->with('message', 'Part berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response = array('status' => 0, 'result' => array());
        $getDetail = $this->_partRepository->getById($id);

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
                'part_no' => 'required',
            ];
        } else {
            return [
                'part_no' => 'required',
            ];
        }
    }
}
