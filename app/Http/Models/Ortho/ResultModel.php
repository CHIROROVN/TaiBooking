<?php namespace App\Http\Models\Ortho;

use DB;

class ResultModel
{

    protected $table = 't_result';

    public function Rules()
    {
    	return array(
    		// 'area_name' => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            // 'area_name.required' => trans('validation.error_area_name_required'),
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

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('result_id', $id)->update($data);
        return $results;
    }
}