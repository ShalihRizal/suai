<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Modules\PartCategory\Repositories\PartCategoryRepository;
use Modules\Part\Repositories\PartRepository;
use Modules\SysLog\Repositories\SysLogRepository;
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
        $this->_logRepository = new SysLogRepository;
        $this->_logHelper = new LogHelper;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $partcategories = $this->_partCategoryRepository->getAll();
        $allParts = $this->_partRepository->getAll();
        $logs = $this->_logRepository->getAll();



        $thisMonthStart = Carbon::now()->startOfMonth();
        $thisMonthEnd = Carbon::now()->endOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        // dd($lastMonthStart);

        // Filter parts by created_by for this month
        $thisMonthParts = $allParts->whereBetween('created_at', [$thisMonthStart, $thisMonthEnd]);

        // Filter parts by created_by for last month
        $lastMonthParts = $allParts->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd]);
        //    dd($lastMonthParts);


        $data = [];

        foreach ($partcategories as $partcategory) {
            $data[$partcategory->part_category_id]['label'] = $partcategory->part_category_name;

            // Filter parts by part_category_id
            $thisMonthPartsByCategory = $thisMonthParts->where('part_category_id', $partcategory->part_category_id);
            $lastMonthPartsByCategory = $lastMonthParts->where('part_category_id', $partcategory->part_category_id);

            $thisMonthSum = [];
            $thisMonthAmountSum = [];
            $lastMonthSum = [];
            $lastMonthAmountSum = [];
            $data[$partcategory->part_category_id]['label'] = $partcategory->part_category_name;
            $sum = [];

            foreach ($allParts as $part) {
                if (intval($part->part_category_id) == intval($partcategory->part_category_id)) {
                    $sum[] = intval($part->qty_end);
                }
            }
            $data[$partcategory->part_category_id]['qty'] = $this->array_multisum($sum);

            foreach ($thisMonthPartsByCategory as $part) {
                $thisMonthSum[] = intval($part->qty_end);
                $thisMonthAmountSum[] = intval($part->qty_end) * floatval($part->price);
            }

            foreach ($lastMonthPartsByCategory as $part) {
                $lastMonthSum[] = intval($part->qty_end); // Accumulate qty_end for last month
                $lastMonthAmountSum[] = intval($part->qty_end) * floatval($part->price); // Calculate amount for last month
            }

            $data[$partcategory->part_category_id]['this_month_qty'] = $this->array_multisum($thisMonthSum);
            $data[$partcategory->part_category_id]['this_month_amount'] = $this->array_multisum($thisMonthAmountSum);
            $data[$partcategory->part_category_id]['last_month_qty'] = $this->array_multisum($lastMonthSum);
            $data[$partcategory->part_category_id]['last_month_amount'] = $this->array_multisum($lastMonthAmountSum);
        }

        $labels = [];
        $qty = [];
        $thsqty = [];
        $lstqty = [];
        $thsamounts = [];
        $lstamounts = [];

        foreach ($data as $partCategoryId => $partCategoryData) {
            $label = $partCategoryData['label'];
            $quantity = $partCategoryData['qty'];
            $thisquantity = $partCategoryData['this_month_qty'];
            $lastquantity = $partCategoryData['last_month_qty'];
            $thisamount = $partCategoryData['this_month_amount'];
            $lastamount = $partCategoryData['last_month_amount'];

            $labels[$partCategoryId] = $label;
            $qty[$partCategoryId] = $quantity;
            $thsqty[$partCategoryId] = $thisquantity;
            $lstqty[$partCategoryId] = $lastquantity;
            $thsamounts[$partCategoryId] = $thisamount;
            $lstamounts[$partCategoryId] = $lastamount;
        }

        return view('dashboard::index', compact('partcategories', 'labels', 'thsqty', 'qty', 'lstqty', 'logs', 'allParts', 'thsamounts', 'lstamounts'));

    }

    function array_multisum(array $arr): float
    {
        $sum = array_sum($arr);
        foreach ($arr as $child) {
            $sum += is_array($child) ? array_multisum($child) : 0;
        }
        return $sum;
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function tv()
    {
        $partcategories = $this->_partCategoryRepository->getAll();
        $parts = $this->_partRepository->getAll();
        return view('dashboard::tv', compact('partcategories', 'parts'));
       
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
