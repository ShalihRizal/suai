<?php

namespace Modules\PartRequest\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class PartRequestRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_req_id','part_req_number','carline','car_model','alasan','order','shift','machine_no','applicator_no','wear_and_tear_code','serial_no','side_no','stroke','pic','remarks','anvil_qty','insulation_crimper_qty','wire_crimper_qty','created_at','created_by','updated_at','updated_by'];

    public function __construct()
    {
        $this->table = 'part_request';
        $this->pk = 'part_req_id';
    }


}
