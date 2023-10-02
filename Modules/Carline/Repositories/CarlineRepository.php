<?php

namespace Modules\Carline\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class CarlineRepository extends QueryBuilderImplementation
{

    public $fillable = ['carline_name', 'carline_category_id'];

    public function __construct()
    {
        $this->table = 'carline';
        $this->pk = 'carline_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('carline_category', 'carline.carline_category_id', '=', 'carline_category.carline_category_id')
                ->orderBy('carline_id')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
