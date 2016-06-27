<?php namespace App\Http\Models\Ortho;

use DB;

class XrayModel
{
    protected $table = 't_xray';


    public function Rules()
    {
    	return array(
    		'p_id'                  => 'required',
            'xray_date'             => 'required',
            'xray_place'            => 'required',
		);
    }


    public function Messages()
    {
    	return array(
            'p_id.required'             => trans('validation.error_p_id_required'),
            'xray_date.required'        => trans('validation.error_xray_date_required'),
            'xray_place.required'       => trans('validation.error_xray_place_required'),
		);
    }


    public function get_all($pagination = false, $where = array())
    {
        $db = DB::table($this->table)
                    ->leftJoin('t_patient', 't_xray.p_id', '=', 't_patient.p_id')
                    ->select('t_xray.*', 't_patient.p_id as p_patient_id', 't_patient.p_no', 't_patient.p_name', 't_patient.p_name_kana', 't_patient.p_sex', 't_patient.p_birthday')
                    ->where('t_xray.last_kind', '<>', DELETE);

        // if(!empty($keyword))
        // {
        //     $db = $db->where('clinic_name', 'LIKE', '%' . $keyword . '%');
        // }

        $db = $db->orderBy('xray_date', 'asc');
        if ( $pagination ) {
            $results = $db->simplePaginate(PAGINATION); //simplePaginate, paginate
        } else {
            $results = $db->get();
        }
        
        return $results;
    }


    public function get_by_patient_id($id_patient)
    {
        $db = DB::table($this->table)
                    ->leftJoin('t_patient', 't_xray.p_id', '=', 't_patient.p_id')
                    ->leftJoin('m_clinic', 't_xray.xray_place', '=', 'm_clinic.clinic_id')
                    ->select('t_xray.*', 't_patient.p_id as p_patient_id', 't_patient.p_no', 't_patient.p_name', 't_patient.p_name_kana', 't_patient.p_sex', 't_patient.p_birthday', 'm_clinic.clinic_name')
                    ->where('t_xray.p_id', $id_patient)
                    ->where('t_xray.last_kind', '<>', DELETE)
                    ->get();

        return $db;
    }


    public function insert($data)
    {
        $results = DB::table($this->table)->insert($data);
        return $results;
    }


    public function insert_get_id($data)
    {
        $results = DB::table($this->table)->insertGetId($data);
        return $results;
    }


    public function get_by_id($id)
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient', 't_xray.p_id', '=', 't_patient.p_id')
                        ->select('t_xray.*', 't_patient.p_id as p_patient_id', 't_patient.p_no', 't_patient.p_name', 't_patient.p_name_kana', 't_patient.p_sex', 't_patient.p_birthday', 't_patient.p_dr')
                        ->where('xray_id', $id)
                        ->first();

        return $results;
    }


    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('xray_id', $id)->update($data);
        return $results;
    }
}