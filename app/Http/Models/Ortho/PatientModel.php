<?php namespace App\Http\Models\Ortho;

use DB;

class PatientModel
{

    protected $table = 't_patient';


    public function Rules()
    {
    	return array(
            'p_name'                => 'required',
            'p_name_kana'           => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
            'p_sex'                 => 'required',
            'p_tel'                 => 'required',
            'p_email'               => 'email',
		);
    }


    public function Messages()
    {
    	return array(
            'p_name.required'                   => trans('validation.error_p_name_required'),
            'p_name_kana.required'              => trans('validation.error_p_name_kana_required'),
            'p_name_kana.regex'                 => trans('validation.error_p_name_kana_regex'),
            'p_sex.required'                    => trans('validation.error_p_sex_required'),
            'p_tel.required'                    => trans('validation.error_p_tel_required'),
            'p_email.email'                     => trans('validation.error_p_email_email'),
		);
    }


    public function get_all($where = array(), $paging = true)
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE);

        if ( !empty($where['keyword']) ) {
            $results = $results->where(function($subQuery) use ($where) {
                $subQuery->where('p_no', 'like', '%' . $where['keyword'] . '%');
                $subQuery->orWhere('p_name', 'like', '%' . $where['keyword'] . '%');
                $subQuery->orWhere('p_name_kana', 'like', '%' . $where['keyword'] . '%');
            });
        }

        if ( !empty($where['keyword_id']) ) {
            $results = $results->orWhere('p_id', $where['keyword_id']);
        }

        $results = $results->orderBy('p_no', 'asc');

        if ( $paging ) {
            $db = $results->simplePaginate(PAGINATION);
        } else {
            $db = $results->get();
        }

        return $db;
    }


    public function get_for_autocomplate($key = '', $id_not_me = 0)
    {
        $results = DB::table($this->table)
                        ->select('p_id', 'p_no', 'p_name', 'p_name_kana')
                        ->where('last_kind', '<>', DELETE)
                        ->where('p_id', '<>', $id_not_me);

        if ( !empty($key) ) {
            $results = $results->where('p_no', 'like', '%' . $key . '%')
                                ->orWhere('p_name', 'like', '%' . $key . '%')
                                ->orWhere('p_name_kana', 'like', '%' . $key . '%');
        }

        $db = $results->orderBy('p_no', 'asc')->get();

        return $db;
    }


    public function get_for_select()
    {
        return DB::table($this->table)->select('p_id', 'p_name')->where('last_kind', '<>', DELETE)->get();
    }


    public function insert($data)
    {
        return DB::table($this->table)->insert($data);
    }


    public function insert_get_id($data)
    {
        return DB::table($this->table)->insertGetId($data);
    }


    public function get_by_id($id)
    {
        return DB::table($this->table)
                        ->leftJoin('m_users', 't_patient.p_dr', '=', 'm_users.id')
                        ->leftJoin('m_clinic', 't_patient.p_hos', '=', 'm_clinic.clinic_id')
                        ->select('t_patient.*', 'm_users.u_name', 'm_clinic.clinic_name')
                        ->where('p_id', $id)
                        ->first();
    }


    public function update($id, $data)
    {
        return DB::table($this->table)->where('p_id', $id)->update($data);
    }

    public function get_patient_by_id($id)
    {
        return DB::table($this->table)
                        ->select('t_patient.p_id', 't_patient.p_no', 't_patient.p_name')
                        ->where('last_kind', '<>', DELETE)
                        ->where('p_id', '=', $id)
                        ->first();
    }
}