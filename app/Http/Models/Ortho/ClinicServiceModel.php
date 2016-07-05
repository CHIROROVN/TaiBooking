<?php namespace App\Http\Models\Ortho;

use DB;
use App\Http\Models\Ortho\ServiceModel;

class ClinicServiceModel
{
    protected $table = 't_clinic_service';
    protected $primaryKey = 'clinic_service_id';
    public $timestamps  = false;


    public function get_clinic_service($clinic_id)
    {
        return DB::table($this->table)
                    ->rightJoin('m_service as t1', 't_clinic_service.service_id', '=', 't1.service_id')
                    ->where('t_clinic_service.last_kind', '<>', DELETE)
                    ->where('t_clinic_service.clinic_id', '=', $clinic_id)
                    ->orderBy('t1.service_sort_no', 'asc')
                    ->get();
    }

    public function get_all_by_sid($service_id=null)
    {
        return DB::table($this->table)
                    ->leftJoin('m_service as t1', 't_clinic_service.service_id', '=', 't1.service_id')
                    ->select('t_clinic_service.*', 't1.service_name')
                    ->where('t_clinic_service.last_kind', '<>', DELETE)
                    ->where('t_clinic_service.service_id', '=', $service_id)
                    ->orderBy('t_clinic_service.clinic_service_id', 'asc')
                    ->get();
    }


    public function get_by_id($id)
    {
        $results = DB::table($this->table)->where('clinic_service_id', $id)->first();
        return $results;
    }


    public function getAll()
    {
        $db = DB::table('m_service')
                    ->leftJoin('t_clinic_service as t1', 'm_service.service_id', '=', 't1.service_id')
                    ->select('m_service.*', 't1.clinic_service_id', 't1.service_facility_1', 't1.service_time_1', 't1.service_facility_2', 't1.service_time_2', 't1.service_facility_3', 't1.service_time_3', 't1.service_facility_4', 't1.service_time_4', 't1.service_facility_5', 't1.service_time_5')
                    ->where('m_service.last_kind', '<>', DELETE)
                    ->orderBy('m_service.service_name', 'asc')
                    ->get();

        return $db;
    }
}