<?php namespace App\Http\Models\Ortho;

use DB;

class ResultModel
{

    protected $table = 't_result';

    public function Rules()
    {
    	return array(
    		'result_date'                   => 'required',
            'result_start_time'             => 'required',
            'clinic_id'                     => 'required',
            'doctor_id'                     => 'required',
            'service_1'                     => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            'result_date.required'          => trans('validation.error_result_result_date_required'),
            'result_start_time.required'    => trans('validation.error_result_result_start_time_required'),
            'clinic_id.required'            => trans('validation.error_result_clinic_id_required'),
            'doctor_id.required'            => trans('validation.error_result_doctor_id_required'),
            'service_1.required'            => trans('validation.error_result_service_1_required'),
		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('result_date', 'asc')->get();
        return $results;
    }

    public function get_by_patientID($patient_id)
    {
        $results = DB::table($this->table)
                        ->leftJoin('m_clinic as t1', 't_result.clinic_id', '=', 't1.clinic_id')
                        ->select('t_result.*', 't1.clinic_name')
                        ->where('t_result.patient_id', $patient_id)
                        ->where('t_result.last_kind', '<>', DELETE)
                        ->orderBy('t_result.result_date', 'asc')
                        ->get();
        return $results;
    }

    public function get_list()
    {
        return DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('result_date', 'asc')->lists('result_date', 'patient_id');
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
        $results = DB::table($this->table)->where('result_id', $id)->first();
        return $results;
    }

    public function get_by_patient_id($patient_id)
    {
        $results = DB::table($this->table)->where('patient_id', $patient_id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('result_id', $id)->update($data);
        return $results;
    }

    public function update_by_patient_id($patient_id, $data)
    {
        $results = DB::table($this->table)->where('patient_id', $patient_id)->update($data);
        return $results;
    }

    public function update_by_where($where = array(), $data)
    {
        $db = DB::table($this->table)->where('last_kind', '<>', DELETE);

        // where result_date
        if ( isset($where['result_date']) && !empty($where['result_date']) ) {
            $db = $db->where('result_date', $where['result_date']);
        }

        // where patient_id
        if ( isset($where['patient_id']) && !empty($where['patient_id']) ) {
            $db = $db->where('patient_id', $where['patient_id']);
        }

        // where clinic_id
        if ( isset($where['clinic_id']) && !empty($where['clinic_id']) ) {
            $db = $db->where('clinic_id', $where['clinic_id']);
        }

        // where facility_id
        if ( isset($where['facility_id']) && !empty($where['facility_id']) ) {
            $db = $db->where('facility_id', $where['facility_id']);
        }

        $results = $db->update($data);

        return $results;
    }

    public function get_by_where($where = array())
    {
        $db = DB::table($this->table)->where('last_kind', '<>', DELETE);

        // where result_date
        if ( isset($where['result_date']) && !empty($where['result_date']) ) {
            $db = $db->where('result_date', $where['result_date']);
        }

        // where patient_id
        if ( isset($where['patient_id']) && !empty($where['patient_id']) ) {
            $db = $db->where('patient_id', $where['patient_id']);
        }

        // where clinic_id
        if ( isset($where['clinic_id']) && !empty($where['clinic_id']) ) {
            $db = $db->where('clinic_id', $where['clinic_id']);
        }

        // where facility_id
        if ( isset($where['facility_id']) && !empty($where['facility_id']) ) {
            $db = $db->where('facility_id', $where['facility_id']);
        }

        $results = $db->first();

        return $results;
    }
}