<?php

namespace Modules\ListOfPartRequest\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class ListOfPartRequestRepository extends QueryBuilderImplementation
{

    public $fillable = [
        'part_req_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',

    ];

    public function __construct()
    {
        $this->table = 'partlist';
        $this->pk = 'partlist_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('part_request', 'part_request.part_req_id', '=', 'partlist.part_req_id')
                ->join('part', 'part_request.part_id', '=', 'part.part_id')
                ->leftjoin('carname', 'part_request.carline', '=', 'carname.carname_id')
                ->leftjoin('carline', 'part_request.car_model', '=', 'carline.carline_id')
                ->leftJoin('sys_users', 'part_request.approved_by', '=', 'sys_users.user_id')
                ->select(
                    "part_request.*",
                    "sys_users.*",
                    "part.*",
                    "carline.*",
                    "carname.*",  // Pastikan ini ada
                    "part.created_at as part_created_at",
                    "partlist.part_req_id as partlist_part_req_id",
                    "part_request.part_req_id as part_request_part_req_id",
                    "part_request.created_at as part_request_created_at",
                    "part_request.applicator_no as part_request_applicator_no",
                    "part_request.applicator_no as applicator_no2",
                    "part_request.remarks as remarks2",
                    "partlist.created_at as partlist_created_at",
                    "partlist.partlist_id as partlist_id",
                )
                ->orderBy('part_request.created_at', 'desc')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function getById($id)
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('part_request', 'part_request.part_req_id', '=', 'partlist.part_req_id')
                ->join('part', 'part_request.part_id', '=', 'part.part_id')
                ->join('carname', 'part_request.carline', '=', 'carname.carname_id')
                ->join('carline', 'part_request.car_model', '=', 'carline.carline_id')
                ->select(
                    "part_request.*",
                    "part.*",
                    "carline.*",
                    "carname.*",
                    "part.created_at as part_created_at",
                    "part_request.created_at as part_request_created_at",
                    "part_request.remarks as part_request_remarks",
                    "part_request.applicator_no as part_request_applicator_no",
                    "carname.carname_name as carname_part_request",
                )
                ->where($this->pk, '=', $id)
                ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function getByDateRange($startDate, $endDate)
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('part_request', 'part_request.part_req_id', '=', 'partlist.part_req_id')
                ->join('part', 'part_request.part_id', '=', 'part.part_id')
                ->join('carname', 'part_request.carline', '=', 'carname.carname_id')
                ->join('carline', 'part_request.car_model', '=', 'carline.carline_id')
                ->select(
                    "part_request.*",
                    "part.*",
                    "carline.*",
                    "carname.*",
                    "part_request.created_at as part_request_created_at"
                )
                ->whereBetween('part_request.created_at', [$startDate, $endDate])
                ->orderBy('part_request.created_at', 'desc')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Server-side DataTables handler.
     * Handles search, sort, and pagination at the DB level.
     */
    public function getServerSideData($request)
    {
        $draw     = intval($request->input('draw', 1));
        $start    = intval($request->input('start', 0));
        $length   = intval($request->input('length', 25));
        $search   = $request->input('search.value', '');
        $orderCol = intval($request->input('order.0.column', 3));
        $orderDir = $request->input('order.0.dir', 'desc');

        $columns = [
            0 => 'partlist.partlist_id',
            1 => 'part_request.part_req_number',
            2 => 'part_request.created_at',
            3 => 'part_request.created_at',
            4 => 'carname.carname_name',
            5 => 'carline.carline_name',
            6 => 'part_request.alasan',
            7 => 'part.kategori',
            8 => 'part_request.shift',
            9 => 'part_request.machine_no',
            10 => 'part_request.applicator_no',
            11 => 'part_request.applicator_no',
            12 => 'part_request.wear_and_tear_code',
            13 => 'part_request.serial_no',
            14 => 'part_request.side_no',
            15 => 'part_request.stroke',
            16 => 'part_request.pic',
            17 => 'part_request.remarks',
            18 => 'part_request.part_qty',
            19 => 'part_request.status',
            20 => 'sys_users.user_name',
            21 => 'part_request.part_no',
            22 => 'part_request.wear_and_tear_status',
            23 => 'partlist.partlist_id',
        ];

        $sortColumn = isset($columns[$orderCol]) ? $columns[$orderCol] : 'part_request.created_at';

        $baseQuery = DB::connection($this->db)
            ->table($this->table)
            ->join('part_request', 'part_request.part_req_id', '=', 'partlist.part_req_id')
            ->join('part', 'part_request.part_id', '=', 'part.part_id')
            ->leftJoin('carname', 'part_request.carline', '=', 'carname.carname_id')
            ->leftJoin('carline', 'part_request.car_model', '=', 'carline.carline_id')
            ->leftJoin('sys_users', 'part_request.approved_by', '=', 'sys_users.user_id')
            ->select(
                "part_request.*",
                "sys_users.user_name",
                "part.part_no",
                "part.part_name",
                "part.kategori",
                "carline.carline_name",
                "carname.carname_name",
                "part.created_at as part_created_at",
                "partlist.part_req_id as partlist_part_req_id",
                "part_request.part_req_id as part_request_part_req_id",
                "part_request.created_at as part_request_created_at",
                "part_request.applicator_no as part_request_applicator_no",
                "part_request.applicator_no as applicator_no2",
                "part_request.remarks as remarks2",
                "partlist.created_at as partlist_created_at",
                "partlist.partlist_id as partlist_id"
            );

        $recordsTotal = (clone $baseQuery)->count();

        if (!empty($search)) {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('part_request.part_req_number', 'LIKE', "%{$search}%")
                  ->orWhere('part_request.part_no', 'LIKE', "%{$search}%")
                  ->orWhere('part_request.machine_no', 'LIKE', "%{$search}%")
                  ->orWhere('part_request.applicator_no', 'LIKE', "%{$search}%")
                  ->orWhere('part_request.pic', 'LIKE', "%{$search}%")
                  ->orWhere('part_request.alasan', 'LIKE', "%{$search}%")
                  ->orWhere('part.kategori', 'LIKE', "%{$search}%")
                  ->orWhere('part_request.shift', 'LIKE', "%{$search}%")
                  ->orWhere('part_request.wear_and_tear_code', 'LIKE', "%{$search}%")
                  ->orWhere('part_request.wear_and_tear_status', 'LIKE', "%{$search}%")
                  ->orWhere('carname.carname_name', 'LIKE', "%{$search}%")
                  ->orWhere('carline.carline_name', 'LIKE', "%{$search}%")
                  ->orWhere('sys_users.user_name', 'LIKE', "%{$search}%");
            });
        }

        $recordsFiltered = (clone $baseQuery)->count();

        $data = $baseQuery
            ->orderBy($sortColumn, $orderDir)
            ->offset($start)
            ->limit($length)
            ->get();

        return [
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ];
    }
}
