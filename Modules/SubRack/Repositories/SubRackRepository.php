<?php

namespace Modules\SubRack\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class SubRackRepository extends QueryBuilderImplementation
{

    public $fillable = ['sub_rack_name','rack_id'];

    public function __construct()
    {
        $this->table = 'sub_rack';
        $this->pk = 'sub_rack_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('rack', 'sub_rack.rack_id', '=', 'rack.rack_id')
                ->orderBy('sub_rack_id')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
