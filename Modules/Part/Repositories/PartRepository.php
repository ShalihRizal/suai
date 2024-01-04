<?php

namespace Modules\Part\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class PartRepository extends QueryBuilderImplementation
{

    public $fillable = [
        'part_no',
        'no_urut',
        'applicator_no',
        'applicator_type',
        'applicator_qty',
        'kode_tooling_bc',
        'part_name',
        'asal',
        'invoice',
        'po',
        'po_date',
        'rec_date',
        'loc_ppti',
        'loc_tapc',
        'lokasi_hib',
        'lokasi_replacement',
        'qty_begin',
        'qty_in',
        'qty_out',
        'adjust',
        'kategori_inventory',
        'qty_end',
        'qty_end_inventory',
        'qty_end_replacement',
        'qty_kedatangan_barang',
        'qty_in_order',
        'status',
        'safety_stock',
        'rop',
        'qty_order_forecast',
        'remarks',
        'last_sto',
        'molts_no',
        'has_sto',
        'part_category_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function __construct()
    {
        $this->table = 'part';
        $this->pk = 'part_id';
    }

    // Override
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('part_category', 'part.part_category_id', '=', 'part_category.part_category_id')
                ->orderBy('part_id')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
