<?php

namespace Modules\Machine\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class MachineRepository extends QueryBuilderImplementation
{

    public $fillable = ['machine_name', 'machine_no', 'carname_id'];

    public function __construct()
    {
        $this->table = 'machine';
        $this->pk = 'machine_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('carname', 'machine.carname_id', '=', 'carname.carname_id')
                ->orderBy('machine_id')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
