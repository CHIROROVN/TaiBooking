<?php namespace App\Http\Models\Ortho;

use DB;

class BrotherModel
{

    protected $table = 't_brother';

    public function Rules()
    {
    	return array(
    		'p_relation_id'                       => 'required',
            'brother_relation'                    => 'required',
		);
    }


    public function Messages()
    {
    	return array(
            'p_relation_id.required'            => trans('validation.error_p_relation_id_required'),
            'brother_relation.required'         => trans('validation.error_brother_relation_required'),
		);
    }


    public function get_all($patient_id)
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient', 't_brother.p_relation_id', '=', 't_patient.p_id')
                        ->select('t_brother.*', 't_patient.p_id as patient_id', 't_patient.p_no', 't_patient.p_name', 't_patient.p_name_kana', 't_patient.p_sex', 't_patient.p_birthday')
                        ->where('t_brother.p_id', $patient_id)
                        ->where('t_patient.p_id', '<>', $patient_id)
                        ->where('t_patient.last_kind', '<>', DELETE)
                        ->where('t_brother.last_kind', '<>', DELETE);

        $db = $results->orderBy('p_id', 'asc')->get();
        
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
                        ->leftJoin('t_patient', 't_brother.p_relation_id', '=', 't_patient.p_id')
                        ->select('t_brother.*', 't_patient.p_id as patient_id', 't_patient.p_no', 't_patient.p_name', 't_patient.p_name_kana', 't_patient.p_sex', 't_patient.p_birthday')
                        ->where('t_patient.last_kind', '<>', DELETE)
                        ->where('t_brother.last_kind', '<>', DELETE)
                        ->where('brother_id', $id)->first();

        return $results;
    }


    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('brother_id', $id)->update($data);
        return $results;
    }
}