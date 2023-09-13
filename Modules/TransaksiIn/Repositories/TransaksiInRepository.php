<?php

namespace Modules\TransaksiIn\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class TransaksiInRepository extends QueryBuilderImplementation
{

    public $fillable = ['transaksi_in_id', 'invoice_no', 'ata_suai', 'po_no', 'po_date', 'no_urut', 'part_name', 'molts_no', 'part_no', 'qty', 'loc_hib', 'loc_ppti', 'qty_end','created_at','created_by','updated_at','updated_by'];

    public function __construct()
    {
        $this->table = 'transaksi_in';
        $this->pk = 'transaksi_in_id';
    }

}
