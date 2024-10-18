<?php

namespace Modules\TransaksiIn\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class TransaksiInRepository extends QueryBuilderImplementation
{

    public $fillable = ['transaksi_in_id', 'invoice_no', 'ata_suai', 'part_id', 'po_no', 'po_date', 'no_urut', 'part_name', 'molts_no', 'part_no', 'qty', 'price', 'loc_hib', 'loc_ppti', 'qty_end', 'transaksi_in.created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'transaksi_in';
        $this->pk = 'transaksi_in_id';
    }

    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->select(
                    "transaksi_in.created_at as transaksi_created_at",
                    "part.created_at as part_created_at",
                    "transaksi_in.qty as qty2",
                    "transaksi_in.po_date as po_date2",
                    "transaksi_in.*",
                    "part.*",
                    "part_category.*" // Add the columns from the part_category table that you need
                )
                ->join('part', 'transaksi_in.part_id', '=', 'part.part_id')
                ->join('part_category', 'part.part_category_id', '=', 'part_category.part_category_id') // Add this line to join part_category
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
