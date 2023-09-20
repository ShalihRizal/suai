<?php

namespace Modules\TransaksiOut\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class TransaksiOutRepository extends QueryBuilderImplementation
{

    public $fillable = ['transaksi_out_id', 'condition', 'end_stock', 'rop', 'date_transaksi', 'receiving', 'balance', 'no_urut', 'master_part_no', 'part_no', 'kind', 'molts_no', 'applicator_no', 'part_name', 'qty', 'machine', 'serial_number', 'pic', 'shift', 'stroke', 'carline_maker', 'remark','created_at','created_by','updated_at','updated_by'];

    public function __construct()
    {
        $this->table = 'transaksi_out';
        $this->pk = 'transaksi_out_id';
    }

}
