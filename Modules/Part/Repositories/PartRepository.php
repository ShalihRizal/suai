<?php

namespace Modules\Part\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class PartRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_no','no_urut','applicator_no','applicator_type','applicator_qty','kode_tooling_bc','part_name','asal','invoice','po','po_date','rec_date','loc_ppti','loc_tapc','lokasi_hib','qty_begin','qty_in','qty_out','adjust','qty_end','remarks','created_at','created_by','updated_at','updated_by'];

    public function __construct()
    {
        $this->table = 'part';
        $this->pk = 'part_id';
    }

}
