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
    public function getAllByParams(array $params)
    {
        $query = DB::connection($this->db)
            ->table($this->table)
            ->select('part_name', 'part_no', 'qty_end')
            ->where('has_sto', $params['has_sto']);

        if (isset($params['part_category_id'])) {
            $query->where('part_category_id', $params['part_category_id']);
        }
        foreach ($params as $key => $value) {
            // Handle operator khusus jika ada
            if (is_array($value)) {
                $query->where($key, $value[0], $value[1]);
            }
            // Handle pencarian partial untuk part_no
            else if ($key === 'part_no') {
                $escapedValue = str_replace('/', '\/', $value);
                $query->where($key, 'LIKE', '%' . $escapedValue . '%');
            }
            // Handle kondisi biasa
            else {
                $query->where($key, $value);
            }
        }
        return $query->get();
    }
}
