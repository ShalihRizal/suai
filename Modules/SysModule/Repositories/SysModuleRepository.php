<?php

namespace Modules\SysModule\Repositories;

use App\Implementations\QueryBuilderImplementation;

class SysModuleRepository extends QueryBuilderImplementation
{
    public $fillable = ['module_name', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'sys_modules';
        $this->pk = 'module_id';
    }
}
