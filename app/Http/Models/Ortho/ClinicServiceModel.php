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
                    ->where('last_kind', '<>', DELETE)
                    ->where('clinic_id', '=', $clinic_id)
                    ->orderBy('clinic_id', 'asc')
                    ->get();
    }

    public function get_all()
    {
        return DB::table($this->table)
                    ->leftJoin('m_service as t1', 't_clinic_service.service_id', '=', 't1.service_id')
                    ->select('t_clinic_service.*', 't1.service_name')
                    ->where('t_clinic_service.last_kind', '<>', DELETE)
                    ->orderBy('t_clinic_service.clinic_service_id', 'asc')
                    ->get();
    }
}