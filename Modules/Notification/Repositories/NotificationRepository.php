<?php

namespace Modules\Notification\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class NotificationRepository extends QueryBuilderImplementation
{
    public $fillable = ['part_req_id', 'part_id', 'part_req_number', 'carline', 'car_model', 'alasan', 'order', 'shift', 'machine_no', 'applicator_no', 'wear_and_tear_status', 'wear_and_tear_code', 'serial_no', 'side_no', 'stroke', 'pic', 'remarks', 'part_qty', 'status', 'approved_by', 'part_no', 'created_at', 'created_by', 'updated_at', 'updated_by'];

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
                ->join('part', 'part_request.part_id', '=', 'part.part_id')
                ->select("part_request.*", "part.*", "part.created_at as part_created_at", "part_request.created_at as part_request_created_at", "part_request.remarks as part_request_remarks")
                ->where($params)
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
                ->join('part', 'part_request.part_id', '=', 'part.part_id')
                ->join('carline', 'part_request.car_model', '=', 'carline.carline_id')
                // ->join('machine', 'part_request.machine_no', '=', 'machine.machine_id')
                ->select("part_request.*", "part.*", "carline.*", "part.created_at as part_created_at", "part_request.created_at as part_request_created_at", "part_request.remarks as part_request_remarks", "part_request.applicator_no as part_request_applicator_no", "part.applicator_no as part_applicator_no")
                ->where($this->pk, '=', $id)
                ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
