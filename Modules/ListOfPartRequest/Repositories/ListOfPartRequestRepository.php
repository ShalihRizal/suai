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
}
