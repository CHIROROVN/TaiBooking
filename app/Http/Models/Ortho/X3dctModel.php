<?php namespace App\Http\Models\Ortho;

use DB;

class X3dctModel
{
    protected $table = 't_3dct';
    protected $primaryKey = 'ct_id';
    public $timestamps  = false;

    public function Rules()
    {
        return array(
            'ct_date'   => 'required',
            'u_id'      => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'ct_date.required'      => trans('validation.error_ct_date_required'),
            'u_id.required'         => trans('validation.error_ct_u_id_required'),
        );
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('ct_date', 'asc')->get();
        return $results;
    }

    public function get_by_patient_id($id_patient)
    {
        $db = DB::table($this->table)
                    ->leftJoin('t_patient', 't_3dct.p_id', '=', 't_patient.p_id')
                    ->select('t_3dct.*', 't_patient.p_id as p_patient_id', 't_patient.p_no', 't_patient.p_name', 't_patient.p_name_kana', 't_patient.p_sex', 't_patient.p_birthday')
                    ->where('t_3dct.p_id', $id_patient)
                    ->where('t_patient.last_kind', '<>', DELETE)
                    ->where('t_3dct.last_kind', '<>', DELETE)
                    ->orderBy('ct_date', 'asc')
                    ->get();

        return $db;
    }

    public function insert($data)
    {
        return DB::table($this->table)->insert($data);
    }

    public function insert_get_id($data)
    {
        $results = DB::table($this->table)->insertGetId($data);
        return $results;
    }

    public function get_by_id($id)
    {
        $results = DB::table($this->table)->where('ct_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
        return DB::table($this->table)->where('ct_id', $id)->update($data);
    }

}