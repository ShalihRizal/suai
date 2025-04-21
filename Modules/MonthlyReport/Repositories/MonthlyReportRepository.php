<?php

namespace Modules\Part\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class PartRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_no', 'no_urut', 'applicator_no', 'applicator_type', 'applicator_qty', 'kode_tooling_bc', 'part_name', 'asal', 'invoice', 'po', 'po_date', 'rec_date', 'loc_ppti', 'loc_tapc', 'lokasi_hib', 'qty_begin', 'qty_in', 'qty_out', 'adjust', 'qty_end', 'remarks', 'last_sto', 'has_sto', 'part_category_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'price'];

    public function __construct()
    {
        $this->table = 'monthly_report';
        $this->pk = 'monthly_report_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('part_category', 'part.part_category_id', '=', 'part_category.part_category_id')
                ->orderBy('part_id');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function getByParams(array $params, array $aggregations)
    {
        try {
            $result = [];
            foreach ($aggregations as $column => $method) {
                $result[$column] = DB::connection($this->db)
                            ->table($this->table)
                            ->where($params)
                    ->$method($column);
            }

            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllByParams(array $params)
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('amount', 'part.id_amount', '=', 'amount.id_amount') // Adjust the join condition
                ->where($params)
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


}
