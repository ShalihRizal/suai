<?php

namespace Modules\Rack\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class RackRepository extends QueryBuilderImplementation
{

    public $fillable = ['rack_name'];

    public function __construct()
    {
        $this->table = 'rack';
        $this->pk = 'rack_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->orderBy('rack_id')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
