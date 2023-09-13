<?php

namespace Modules\PartConsumptionList\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class PartConsumptionListRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_consumption_list_id','created_at','created_by','updated_at','updated_by'];

    public function __construct()
    {
        $this->table = 'part_consumption_list';
        $this->pk = 'part_consumption_list_id';
    }


}
