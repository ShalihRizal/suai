<?php

namespace Modules\StockOpname\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class LogPartRequestRepository extends QueryBuilderImplementation
{

    public $fillable = ['part_no', 'description', 'created_at', 'qty_end', 'qty_actual', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'log_part_request';
        $this->pk = 'id';
    }

    // Di LogPartReqRepository, tambahkan method ini untuk mengambil log berdasarkan part_no saja:
    public function getLogsByPartNumbers(array $partNumbers)
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->whereIn('part_no', $partNumbers)
                ->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
