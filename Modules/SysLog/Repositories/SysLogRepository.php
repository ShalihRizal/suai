<?php

namespace Modules\SysLog\Repositories;

use App\Implementations\QueryBuilderImplementation;
use DB;

class SysLogRepository extends QueryBuilderImplementation
{

    public $fillable = ['log_activity_id', 'log_description', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'sys_log_activities';
        $this->pk = 'log_activity_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->orderBy('log_activity_id', 'desc')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
