<?php

namespace Modules\CIP\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class CIPRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_req_id', 'part_id', 'part_req_number', 'carname', 'car_model', 'alasan', 'order', 'shift', 'machine_no', 'applicator_no', 'wear_and_tear_status', 'wear_and_tear_code', 'serial_no', 'side_no', 'stroke', 'pic', 'remarks', 'part_qty', 'status', 'approved_by', 'part_no', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'part_request';
        $this->pk = 'part_req_id';
    }

    public function getAllByParams(array $params)
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->leftJoin('part', 'part_request.part_id', '=', 'part.part_id')
                // Perbaiki referensi kolom di sini
                ->leftJoin('carname', 'part_request.carline', '=', 'carname.carname_id')
                ->leftJoin('carline_category', 'part_request.car_model', '=', 'carline_category.carline_carname_id')
                ->select("part_request.*", "part.*", "carname.*", "carline_category.*", "part.created_at as part_created_at", "part_request.created_at as part_request_created_at")
                ->where($params)
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
