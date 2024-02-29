<?php

namespace Modules\PartConsumptionList\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class PartConsumptionListRepository extends QueryBuilderImplementation
{

    public $fillable = [
        'pcl_id',
        'part_id',
        'pcl_category',
        'family',
        'pattern',
        'pic_prepared',
        'reason',
        'pic_req',
        'carline',
        'carname',
        'status',
        'fase',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function __construct()
    {
        $this->table = 'part_consumption_list';
        $this->pk = 'pcl_id';
    }

}
