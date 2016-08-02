<?php namespace App\Http\Models\Ortho;

use DB;

class ClinicAreaModel
{

    protected $table = 't_clinic_area';

    public function Rules()
    {
    	return array(

		);
    }

    public function Messages()
    {
    	return array(

		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('ca_id', 'asc')->get();
        return $results;
    }

    public function get_by_area($area_id)
    {
        $results = DB::table($this->table)
                        ->where('last_kind', '<>', DELETE)
                        ->where('area_id', '=', $area_id)
                        ->orderBy('ca_id', 'asc')
                        ->get();
        return $results;
    }

    public function update_by_area($area_id, $data)
    {
        $results = DB::table($this->table)
                        ->where('last_kind', '<>', DELETE)
                        ->where('area_id', '=', $area_id)
                        ->update($data);
        return $results;
    }

    public function get_by_clinic($clinic_id)
    {
        $results = DB::table($this->table)
                        ->where('last_kind', '<>', DELETE)
                        ->where('clinic_id', '=', $clinic_id)
                        ->orderBy('ca_id', 'asc')
                        ->get();
        return $results;
    }

    public function update_by_clinic($clinic_id, $data)
    {
        $results = DB::table($this->table)
                        ->where('last_kind', '<>', DELETE)
                        ->where('clinic_id', '=', $clinic_id)
                        ->update($data);
        return $results;
    }

    public function exist_clinic($clinic_id)
    {
        $results = DB::table($this->table)
                        ->where('last_kind', '<>', DELETE)
                        ->where('clinic_id', '=', $clinic_id)
                        ->get();
        if(count($results) > 0)
        {
            return true;
        }
        return false;
    }

    public function exist_area_clinic($area_id, $clinic_id)
    {
        $results = DB::table($this->table)
                        ->where('last_kind', '<>', DELETE)
                        ->where('area_id', '=', $area_id)
                        ->where('clinic_id', '=', $clinic_id)
                        ->get();
        if(count($results) > 0)
        {
            return true;
        }
        return false;
    }

    public function insert($data)
    {
        $results = DB::table($this->table)->insert($data);
        return $results;
    }


    //get list clinic
    public function list_clinic_by_area($area_id = null){
        if(!empty($area_id)){
            return DB::table($this->table)
                                ->leftJoin('m_area', 't_clinic_area.area_id', '=', 'm_area.area_id')
                                ->leftJoin('m_clinic', 't_clinic_area.clinic_id', '=', 'm_clinic.clinic_id')
                                ->where('t_clinic_area.area_id', '=', $area_id)
                                ->where('t_clinic_area.last_kind', '<>', DELETE)
                                ->select('t_clinic_area.clinic_id','m_clinic.clinic_name')
                                ->get();
        }else{
            return null;
        }
    }

    public function get_clinic_area($clinic=null)
    {
        $results = DB::table($this->table)
                        ->select('ca_id', 'area_id', 'clinic_id')
                        ->where('last_kind', '<>', DELETE)
                        ->where('clinic_id', '=', $clinic)
                        ->first();
        return $results;
    }
}