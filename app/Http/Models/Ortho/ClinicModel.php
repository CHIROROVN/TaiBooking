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
            'clinic_address2'           => 'required',
            'clinic_ownername'          => 'required',
            'clinic_tel'                => 'required|numeric',
            'clinic_email'              => 'required|email',
		);
    }

    public function Messages()
    {
    	return array(
            'clinic_name.required'          => '※必須',
            'clinic_name_yomi.required'     => '※必須',
            'clinic_name_yomi.regex'        => '※Hiragana',
            'clinic_display_name.required'  => '※必須',
            'clinic_zip3.required'          => '※必須',
            'clinic_zip4.required'          => '※必須',
            'clinic_address1.required'      => '※必須',
            'clinic_address2.required'      => '※必須',
            'clinic_ownername.required'     => '※必須',
            'clinic_tel.required'           => '※必須',
            'clinic_email.required'         => '※必須',
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
}