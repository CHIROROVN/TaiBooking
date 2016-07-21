<?php namespace App\Http\Models\Ortho;

use DB;

class ClinicModel
{

    protected $table = 'm_clinic';

    public function Rules()
    {
    	return array(
    		'clinic_name'               => 'required',
            'clinic_name_yomi'          => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
            'clinic_display_name'       => 'required',
            'clinic_zip3'               => 'required',
            'clinic_zip4'               => 'required',
            'clinic_address1'           => 'required',
            'clinic_ownername'          => 'required',
            'clinic_tel'                => 'required|numeric',
            'clinic_email'              => 'required|email',
		);
    }

    public function Messages()
    {
    	return array(
            'clinic_name.required'          => trans('validation.error_area_name_required'),
            'clinic_name_yomi.required'     => trans('validation.error_clinic_name_yomi_required'),
            'clinic_name_yomi.regex'        => trans('validation.error_clinic_name_yomi_regex'),
            'clinic_display_name.required'  => trans('validation.error_clinic_display_name_required'),
            'clinic_zip3.required'          => trans('validation.error_clinic_zip3_required'),
            'clinic_zip4.required'          => trans('validation.error_clinic_zip4_required'),
            'clinic_address1.required'      => trans('validation.error_clinic_address1_required'),
            'clinic_ownername.required'     => trans('validation.error_clinic_ownername_required'),
            'clinic_tel.required'           => trans('validation.error_clinic_tel_required'),
            'clinic_email.required'         => trans('validation.error_clinic_email_required'),
		);
    }

    public function get_all($pagination = false, $keyword = NULL)
    {
        $db = DB::table($this->table)->where('last_kind', '<>', DELETE);

        if(!empty($keyword))
        {
            $db = $db->where('clinic_name', 'LIKE', '%' . $keyword . '%');
        }

        $db = $db->orderBy('clinic_name_yomi', 'asc');
        if($pagination)
        {
            $results = $db->simplePaginate(PAGINATION); //simplePaginate, paginate
        }
        else
        {
            $results = $db->get();
        }
        
        return $results;
    }


    public function get_for_select()
    {
        $db = DB::table($this->table)->select('clinic_id', 'clinic_name')->where('last_kind', '<>', DELETE)->get();
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
        $results = DB::table($this->table)->where('clinic_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('clinic_id', $id)->update($data);
        return $results;
    }

    //get list clinic
    public function get_list_clinic(){
        return DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->orderBy('clinic_name', 'ASC')
                                ->lists('clinic_name', 'clinic_id');
    }
}