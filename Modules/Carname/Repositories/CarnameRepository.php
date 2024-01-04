<?php

namespace Modules\Carname\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class CarnameRepository extends QueryBuilderImplementation
{

    public $fillable = ['carname_name'];

    public function __construct()
    {
        $this->table = 'carname';
        $this->pk = 'carname_id';
    }


}
