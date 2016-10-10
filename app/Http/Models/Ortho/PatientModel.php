<?php namespace App\Http\Models\Ortho;

use DB;

class PatientModel
{

    protected $table = 't_patient';


    public function Rules()
    {
    	return array(
            'p_no'                  => 'unique:t_patient',
            'p_name_f'              => 'required',
            'p_name_g'              => 'required',
            'p_name_f_kana'         => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
            'p_name_g_kana'         => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
            'p_sex'                 => 'required',
            'p_tel'                 => 'required',
            'p_email'               => 'email',
		);
    }


    public function Messages()
    {
    	return array(
            'p_no.unique'                       => trans('validation.error_p_no_unique'),
            'p_name_f.required'                 => trans('validation.error_p_name_f_required'),
            'p_name_g.required'                 => trans('validation.error_p_name_g_required'),
            'p_name_f_kana.required'            => trans('validation.error_p_name_f_kana_required'),
            'p_name_g_kana.required'            => trans('validation.error_p_name_g_kana_required'),
            'p_name_f_kana.regex'               => trans('validation.error_p_name_f_kana_regex'),
            'p_name_g_kana.regex'               => trans('validation.error_p_name_g_kana_regex'),
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
                $subQuery->orWhere('p_name_f', 'like', '%' . $where['keyword'] . '%');
                $subQuery->orWhere('p_name_g', 'like', '%' . $where['keyword'] . '%');
                $subQuery->orWhere('p_name_f_kana', 'like', '%' . $where['keyword'] . '%');
                $subQuery->orWhere('p_name_g_kana', 'like', '%' . $where['keyword'] . '%');
            });
        }

        // keyword_id
        if ( !empty($where['keyword_id']) ) {
            $results = $results->orWhere('p_id', $where['keyword_id']);
        }

        // p_no
        if ( !empty($where['p_no']) ) {
            $results = $results->where('p_no', 'like', '%' . $where['p_no'] . '%');
        }

        // p_name_f
        if ( !empty($where['p_name_f']) ) {
            $results = $results->where('p_name_f', 'like', $where['p_name_f'] . '%');
        }

        // p_name_g
        if ( !empty($where['p_name_g']) ) {
            $results = $results->where('p_name_g', 'like', '%' . $where['p_name_g'] . '%');
        }

        // p_name_f_kana
        if ( !empty($where['p_name_f_kana']) ) {
            $results = $results->where('p_name_f_kana', 'like', $where['p_name_f_kana'] . '%');
        }

        // p_name_g_kana
        if ( !empty($where['p_name_g_kana']) ) {
            $results = $results->where('p_name_g_kana', 'like', '%' . $where['p_name_g_kana'] . '%');
        }

        // p_tel
        if ( !empty($where['p_tel']) ) {
            $results = $results->where('p_tel', 'like', '%' . $where['p_tel'] . '%');
        }

        // p_hos
        if ( !empty($where['p_hos']) ) {
            $results = $results->where('p_hos', $where['p_hos']);
        }

        // p_hos_memo
        if ( !empty($where['p_hos_memo']) ) {
            $results = $results->where('p_hos_memo', 'like', '%' . $where['p_hos_memo'] . '%');
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
                        ->select('p_id', 'p_no', 'p_name_f', 'p_name_g', 'p_name_f_kana', 'p_name_g_kana')
                        ->where('last_kind', '<>', DELETE)
                        ->where('p_id', '<>', $id_not_me);

        if ( !empty($key) ) {
            $results = $results->where('p_no', 'like', '%' . $key . '%')
                                ->orWhere('p_name_f', 'like', '%' . $key . '%')
                                ->orWhere('p_name_g', 'like', '%' . $key . '%')
                                ->orWhere('p_name_f_kana', 'like', '%' . $key . '%')
                                ->orWhere('p_name_g_kana', 'like', '%' . $key . '%');
        }

        $db = $results->orderBy('p_no', 'asc')->get();

        return $db;
    }

    public function get_for_select()
    {
        return DB::table($this->table)->select('p_id', 'p_no', 'p_name_f', 'p_name_g', 'p_name_f_kana', 'p_name_g_kana')->where('last_kind', '<>', DELETE)->get();
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
                        ->where('t_patient.last_kind', '<>', DELETE)
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
                        ->select('t_patient.p_id', 't_patient.p_no', 't_patient.p_name_f', 't_patient.p_name_g', 't_patient.p_name_f_kana', 't_patient.p_name_g_kana')
                        ->where('last_kind', '<>', DELETE)
                        ->where('p_id', '=', $id)
                        ->first();
    }

    public function get_max_pid()
    {
        return DB::table($this->table)->max('p_id');
    }

    public static function checkExistID($id){
        if (DB::table('t_patient')
                    ->where('last_kind', '<>', DELETE)
                    ->where('p_id', '=', $id)
                    ->exists()) {
            return $id;
        }else{
            return false;
        }
    }

    public function get_p_sex_by_id($id)
    {
        $patient = DB::table($this->table)
                        ->select('t_patient.p_sex')
                        ->where('last_kind', '<>', DELETE)
                        ->where('p_id', '=', $id)
                        ->first();
        if(!empty($patient)){
            $psex = $patient->p_sex;
            return $psex;
        }else{
            return null;
        }
    }
}