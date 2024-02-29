<?php

namespace Modules\PartConsumptionList\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class PartConsumptionListDetailRepository extends QueryBuilderImplementation
{

    public $fillable = [
        'part_consumption_list_detail_id',
        'part_consumption_list_id',
        'part_id',
        'end_drawing',
        'no_accessories',
        'type',
        'tiang',
        'qty_per_jb',
        'qty_total',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function __construct()
    {
        $this->table = 'part_consumption_list_detail';
        $this->pk = 'part_consumption_list_detail_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('part', 'part_consumption_list_detail.part_id', '=', 'part.part_id')
                ->join('part_consumption_list', 'part_consumption_list_detail.part_consumption_list_id', '=', 'part_consumption_list.pcl_id')
                ->orderBy('part_consumption_list_detail_id')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllByParams(array $params)
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->leftJoin('part', 'part_consumption_list_detail.part_id', '=', 'part.part_id')
                ->where($params)
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


}
