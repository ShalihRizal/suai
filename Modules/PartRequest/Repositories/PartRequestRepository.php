<?php

namespace Modules\PartRequest\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class PartRequestRepository extends QueryBuilderImplementation
{

    public $fillable = [
        'part_req_id',
        'part_id',
        'part_req_number',
        'carname',
        'car_model',
        'alasan',
        'order',
        'part_req_pic_filename',
        'part_req_pic_path',
        'shift',
        'machine_no',
        'applicator_no',
        'wear_and_tear_code',
        'serial_no',
        'side_no',
        'stroke',
        'pic',
        'remarks',
        'part_qty',
        'status',
        'approved_by',
        'part_no',
        'wear_and_tear_status',
        'anvil',
        'insulation_crimper',
        'wire_crimper',
        'other',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function __construct()
    {
        $this->table = 'part_request';
        $this->pk = 'part_req_id';
    }

    //overide
    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('part', 'part_request.part_id', '=', 'part.part_id')
                ->join('carname', 'part_request.carline', '=', 'carname.carname_id')
                ->join('carline', 'part_request.car_model', '=', 'carline.carline_id')
                ->join('machine', 'part_request.machine_no', '=', 'machine.machine_id')
                ->select("part_request.*", "part.*", "carname.*", "carline.*", "machine.*", "part.created_at as part_created_at", "part_request.created_at as part_request_created_at", "part_request.remarks as part_request_remarks")
                ->orderBy('part_req_id')
                ->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getById($id)
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('part', 'part_request.part_id', '=', 'part.part_id')
                // ->join('carline', 'part_request.car_model', '=', 'carline.carline_id')
                // ->join('machine', 'part_request.machine_no', '=', 'machine.machine_id')
                ->select("part_request.*", "part.*", "part.created_at as part_created_at", "part_request.created_at as part_request_created_at", "part_request.remarks as part_request_remarks")
                ->where($this->pk, '=', $id)
                ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function getAllByParams(array $params, $startDate = null, $endDate = null)
    {
        try {
            $query = DB::connection($this->db)
                ->table($this->table)
                ->join('part', 'part_request.part_id', '=', 'part.part_id')
                ->join('carname', 'part_request.carline', '=', 'carname.carname_id')
                ->select("part_request.*", "part.part_no")
                ->where($params);

            // Tambahkan filter tanggal jika tersedia
            if ($startDate && $endDate) {
                $query->whereBetween('part_request.created_at', [$startDate, $endDate]);
            }

            return $query->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function insertBatch(array $data)
    {
        return DB::table('part_request')->insert($data); // Or use your model if Eloquent
    }

    public function insertGetIDs(array $dataArray)
    {
        $ids = [];

        foreach ($dataArray as $data) {
            $id = DB::table('part_request')->insertGetId($data);
            $ids[] = $id;
        }

        return $ids;
    }



}
