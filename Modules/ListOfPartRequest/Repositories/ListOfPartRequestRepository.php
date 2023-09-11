<?php

namespace Modules\ListOfPartRequest\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class ListOfPartRequestRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_req_id','part_req_number','carline','car_model','alasan','order','shift','machine_no','applicator_no','wear_and_tear_code','serial_no','side_no','stroke','pic','remarks','part_qty','status','wtstatus','approved_by','part_no','created_at','created_by','updated_at','updated_by'];

    public function __construct()
    {
        $this->table = 'part_request';
        $this->pk = 'part_req_id';
    }


}
