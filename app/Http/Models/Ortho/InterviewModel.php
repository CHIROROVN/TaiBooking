<?php namespace App\Http\Models\Ortho;

use DB;

class InterviewModel
{

    protected $table = 't_1st';

    public function Rules()
    {
    	return array(
    		'q1_1_sei'      => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
            'q1_1_mei'      => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
            'q1_2_sei'      => 'required',
            'q1_2_mei'      => 'required',
            'q1_6'          => 'required',
            'q1_9'          => 'required|email',
		);
    }

    public function Messages()
    {
    	return array(
            'q1_1_sei.required'     => trans('validation.error_q1_1_sei_required'),
            'q1_1_sei.regex'        => trans('validation.error_q1_1_sei_regex'),
            'q1_1_mei.required'     => trans('validation.error_q1_1_mei_required'),
            'q1_1_mei.regex'        => trans('validation.error_q1_1_mei_regex'),
            'q1_2_sei.required'     => trans('validation.error_q1_2_sei_required'),
            'q1_2_mei.required'     => trans('validation.error_q1_2_mei_required'),
            'q1_6.required'         => trans('validation.error_q1_6_required'),
            'q1_9.required'         => trans('validation.error_q1_9_required'),
            'q1_9.email'            => trans('validation.error_q1_9_email'),
		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_1st.patient_id', '=', 't1.p_id')
                        ->select('t_1st.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_1st.last_kind', '<>', DELETE)
                        ->orderBy('t_1st.first_id', 'asc')
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
        $results = DB::table($this->table)->where('first_id', $id)->first();
        return $results;
    }

    public function get_by_patient_id($patient_id)
    {
        $results = DB::table($this->table)->where('patient_id', $patient_id)->where('t_1st.last_kind', '<>', DELETE)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('first_id', $id)->update($data);
        return $results;
    }

    public function get_list()
    {
        $db = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('first_id', 'asc')->get();

        $tmp = array();
        foreach ( $db as $item ) {
            $tmp[$item->patient_id] = $item;
        }

        return $tmp;
    }
}