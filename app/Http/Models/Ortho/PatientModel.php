<?php namespace App\Http\Models\Ortho;

use DB;

class PatientModel
{

    protected $table = 't_patient';


    public function Rules()
    {
    	return array(
    		'p_no'                  => 'required',
            'p_dr'                  => 'required',
            'p_hos_memo'            => 'required',
            'p_hos'                 => 'required',
            'p_name'                => 'required',
            'p_name_kana'           => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
            'p_sex'                 => 'required',
            'p_birthday'            => 'required',
            'p_family_dr'           => 'required',
            'p_introduce'           => 'required',
            'p_start'               => 'required',
            'p_start2'              => 'required',
            'p_place'               => 'required',
            'p_xray'                => 'required',
            'p_clinic_memo'         => 'required',
            'p_personal_memo'       => 'required',
            'p_used'                => 'required',
            'p_payment'             => 'required',
            'p_amount'              => 'required',
            'p_zip'                 => 'required',
            'p_pref'                => 'required',
            'p_address1'            => 'required',
            'p_address_2'           => 'required',
            'p_tel'                 => 'required',
            'p_fax'                 => 'required',
            'p_mobile'              => 'required',
            'p_mobile_owner'        => 'required',
            'p_email'               => 'required|email',
            'p_company'             => 'required',
            'p_parent_name'         => 'required',
            'p_parent_company'      => 'required',
            'p_parent_tel'          => 'required',
            'p_parent_kind'         => 'required',
		);
    }


    public function Messages()
    {
    	return array(
            'p_no.required'                     => trans('validation.error_p_no_required'),
            'p_dr.required'                     => trans('validation.error_p_dr_required'),
            'p_hos_memo.required'               => trans('validation.error_p_hos_memo_required'),
            'p_hos.required'                    => trans('validation.error_p_hos_required'),
            'p_name.required'                   => trans('validation.error_p_name_required'),
            'p_name_kana.required'              => trans('validation.error_p_name_kana_required'),
            'p_name_kana.regex'                 => trans('validation.error_p_name_kana_regex'),
            'p_sex.required'                    => trans('validation.error_p_sex_required'),
            'p_birthday.required'               => trans('validation.error_p_birthday_required'),
            'p_family_dr.required'              => trans('validation.error_p_family_dr_required'),
            'p_introduce.required'              => trans('validation.error_p_introduce_required'),
            'p_start.required'                  => trans('validation.error_p_start_required'),
            'p_start2.required'                 => trans('validation.error_p_start2_required'),
            'p_place.required'                  => trans('validation.error_p_place_required'),
            'p_xray.required'                   => trans('validation.error_p_xray_required'),
            'p_clinic_memo.required'            => trans('validation.error_p_clinic_memo_required'),
            'p_personal_memo.required'          => trans('validation.error_p_personal_memo_required'),
            'p_used.required'                   => trans('validation.error_p_used_required'),
            'p_payment.required'                => trans('validation.error_p_payment_required'),
            'p_amount.required'                 => trans('validation.error_p_amount_required'),
            'p_zip.required'                    => trans('validation.error_p_zip_required'),
            'p_pref.required'                   => trans('validation.error_p_pref_required'),
            'p_address1.required'               => trans('validation.error_p_address1_required'),
            'p_address_2.required'              => trans('validation.error_p_address_2_required'),
            'p_tel.required'                    => trans('validation.error_p_tel_required'),
            'p_fax.required'                    => trans('validation.error_p_fax_required'),
            'p_mobile.required'                 => trans('validation.error_p_mobile_required'),
            'p_mobile_owner.required'           => trans('validation.error_p_mobile_owner_required'),
            'p_email.required'                  => trans('validation.error_p_email_required'),
            'p_email.email'                     => trans('validation.error_p_email_email'),
            'p_company.required'                => trans('validation.error_p_company_required'),
            'p_parent_name.required'            => trans('validation.error_p_parent_name_required'),
            'p_parent_company.required'         => trans('validation.error_p_parent_company_required'),
            'p_parent_tel.required'             => trans('validation.error_p_parent_tel_required'),
            'p_parent_kind.required'            => trans('validation.error_p_parent_kind_required'),
		);
    }


    public function get_all($where = array())
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE);

        if ( !empty($where['keyword']) ) {
            $db = $results->where(function($subQuery) use ($where) {
                $subQuery->where('p_no', 'like', '%' . $where['keyword'] . '%');
                $subQuery->orWhere('p_name', 'like', '%' . $where['keyword'] . '%');
                $subQuery->orWhere('p_name_kana', 'like', '%' . $where['keyword'] . '%');
            });
        }

        if ( !empty($where['keyword_id']) ) {
            $db = $results->orWhere('p_id', $where['keyword_id']);
        }

        $db = $results->orderBy('p_no', 'asc')->simplePaginate(PAGINATION);
        
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
        $db = DB::table($this->table)->select('p_id', 'p_name')->where('last_kind', '<>', DELETE)->get();
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
                        ->leftJoin('m_users', 't_patient.p_dr', '=', 'm_users.id')
                        ->leftJoin('m_clinic', 't_patient.p_hos', '=', 'm_clinic.clinic_id')
                        ->select('t_patient.*', 'm_users.u_name', 'm_clinic.clinic_name')
                        ->where('p_id', $id)
                        ->first();
        return $results;
    }


    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('p_id', $id)->update($data);
        return $results;
    }
}