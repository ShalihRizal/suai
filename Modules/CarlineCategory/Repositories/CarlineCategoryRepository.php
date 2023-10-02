<?php

namespace Modules\CarlineCategory\Repositories;

use App\Implementations\QueryBuilderImplementation;
use DB;

class CarlineCategoryRepository extends QueryBuilderImplementation
{

    public $fillable = ['carline_category_name'];

    public function __construct()
    {
        $this->table = 'carline_category';
        $this->pk = 'carline_category_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->orderBy('carline_category_id')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
