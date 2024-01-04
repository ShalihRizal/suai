<?php

namespace Modules\StockOpname\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class StockOpnameRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_no', 'no_urut', 'last_sto', 'has_sto', 'applicator_no', 'applicator_type', 'applicator_qty', 'kode_tooling_bc', 'part_name', 'asal', 'invoice', 'po', 'po_date', 'rec_date', 'loc_ppti', 'loc_tapc', 'lokasi_hib', 'qty_begin', 'qty_in', 'qty_out', 'adjust', 'qty_end', 'remarks', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'part';
        $this->pk = 'part_id';
    }

    public function updateAll(array $data)
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->update($this->fillableMatch($data));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateHasStoToNo()
    {
        try {
            \DB::table('part')->update(['has_sto' => 'no']);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}
