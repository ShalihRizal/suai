<?php

namespace Modules\PartCategory\Repositories;

use App\Implementations\QueryBuilderImplementation;
use DB;

class PartCategoryRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_category_name'];

    public function __construct()
    {
        $this->table = 'part_category';
        $this->pk = 'part_category_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->orderBy('part_category_id')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
