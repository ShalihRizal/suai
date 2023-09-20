<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;

use Modules\PartCategory\Repositories\PartCategoryRepository;
use Modules\Part\Repositories\PartRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->_partCategoryRepository = new PartCategoryRepository;
        $this->_partRepository = new PartRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $partcategories = $this->_partCategoryRepository->getAll();
        $parts = $this->_partRepository->getAll();

        $labels = [];
        $data = [];

        foreach ($partcategories as $partcategory) {
            $data[$partcategory->part_category_id]['label'] = $partcategory->part_category_name;
            $sum = [];
            foreach ($parts as $part) {
                if (intval($part->part_category_id) == intval($partcategory->part_category_id)) {
                    $sum[] = intval($part->qty_end);
                }
            }
            $data[$partcategory->part_category_id]['qty'] = $this->array_multisum($sum);
        }


        dd($data);

        return view('dashboard::index', compact('partcategories', 'labels', 'data'));
    }

    function array_multisum(array $arr): float {
        $sum = array_sum($arr);
        foreach($arr as $child) {
            $sum += is_array($child) ? array_multisum($child) : 0;
        }
        return $sum;
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {


        return view('dashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {


        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {


        return view('dashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {


    }
}
