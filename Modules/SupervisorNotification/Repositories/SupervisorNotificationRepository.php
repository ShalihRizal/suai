<?php

namespace Modules\SupervisorNotification\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class SupervisorNotificationRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_req_id', 'part_id', 'kategori_inventory', 'part_req_number', 'carline', 'car_model', 'alasan', 'order', 'shift', 'machine_no', 'applicator_no', 'wear_and_tear_code', 'serial_no', 'side_no', 'stroke', 'pic', 'remarks', 'part_qty', 'status', 'approved_by', 'part_no', 'created_at', 'created_by', 'updated_at', 'updated_by'];

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
                ->join('sys_users', 'part_request.approved_by', '=', 'sys_users.user_id')
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
                ->where($this->pk, '=', $id)
                ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
