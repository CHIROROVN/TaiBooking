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

    public function getAll($clinic_id = null, $service_available = null)
    { 
        if($service_available != null){
           $db = DB::table($this->table)
                        ->rightJoin('m_service as t1', 't_clinic_service.service_id', '=', 't1.service_id')
                        ->select('t1.service_name', 't_clinic_service.*')
                        ->whereIn('t_clinic_service.service_id', $service_available )
                        ->where('t_clinic_service.last_kind', '<>', DELETE);

        if ( !empty($clinic_id) ) {
            $db = $db->where('t_clinic_service.clinic_id', $clinic_id);
            }

            $db = $db->orderBy('t1.service_name', 'asc')->get();

            return $db; 
        }else{
            $db = DB::table($this->table)
                        ->rightJoin('m_service as t1', 't_clinic_service.service_id', '=', 't1.service_id')
                        ->select('t1.service_name', 't_clinic_service.*')
                        ->where('t_clinic_service.last_kind', '<>', DELETE);
            if ( !empty($clinic_id) ) {
                $db = $db->where('t_clinic_service.clinic_id', $clinic_id);
            }

            $db = $db->orderBy('t1.service_name', 'asc')->get();
            return $db;
        }

    }

    public function get_service()
    {
        return DB::table($this->table)
                    ->leftJoin('m_service as t1', 't_clinic_service.service_id', '=', 't1.service_id')
                    ->select('t_clinic_service.service_id', 't1.service_name')
                    ->where('t1.last_kind', '<>', DELETE)
                    ->where('t_clinic_service.last_kind', '<>', DELETE)
                    ->groupBy('t_clinic_service.service_id')
                    ->get();
    }

    public function get_list_service()
    {
        return DB::table($this->table)
                    ->leftJoin('m_service as t1', 't_clinic_service.service_id', '=', 't1.service_id')
                    //->select('t_clinic_service.service_id', 't1.service_name')
                    ->where('t1.last_kind', '<>', DELETE)
                    ->where('t_clinic_service.last_kind', '<>', DELETE)
                    ->groupBy('t_clinic_service.service_id')
                    ->lists('t1.service_name');
    }

    public function service_using(){
        return DB::table($this->table)
                                    ->where('last_kind', '<>', DELETE)
                                    ->whereNotNull('last_kind')
                                    ->lists('service_id');
    }
}