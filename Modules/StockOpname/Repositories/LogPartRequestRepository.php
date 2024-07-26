<?php

namespace Modules\StockOpname\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class LogPartRequestRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_no', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'log_part_request';
        $this->pk = 'id';
    }

}
