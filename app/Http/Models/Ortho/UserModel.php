<?php namespace App\Http\Models\Ortho;

use DB;

class UserModel
{

    protected $table = 'm_users';

    public function Rules()
    {
    	return array(
    		'u_name'            => 'required',
            'u_name_yomi'       => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
            'u_name_display'    => 'required',
            'u_login'           => 'required|unique:m_users,u_login,NULL,id,last_kind,<>' . DELETE,
            'password'          => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            'u_name.required'           => trans('validation.error_u_name_required'),
            'u_name_yomi.required'      => trans('validation.error_u_name_yomi_required'),
            'u_name_yomi.regex'         => trans('validation.error_u_name_yomi_regex'),
            'u_name_display.required'   => trans('validation.error_u_name_display_required'),
            'u_login.required'          => trans('validation.error_u_login_required'),
            'u_login.unique'            => trans('validation.error_u_login_unique'),
            'password.required'         => trans('validation.error_password_required'),
		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('u_name_yomi', 'asc')->get();
        return $results;
    }


    public function get_for_select()
    {
        $db = DB::table($this->table)->select('id', 'u_name')->where('last_kind', '<>', DELETE)->get();
        return $db;
    }


    public function get_by_belong($belong_kind)
    {
        $db = DB::table($this->table)
                    ->leftJoin('m_belong', 'm_users.u_belong', '=', 'm_belong.belong_id')
                    ->select('id', 'u_name')
                    ->where('m_belong.belong_kind', '=', $belong_kind)
                    ->where('m_users.last_kind', '<>', DELETE)
                    ->get();
        return $db;
    }

    public function insert($data)
    {
        $results = DB::table($this->table)->insert($data);
        return $results;
    }

    public function get_by_id($id)
    {
        $results = DB::table($this->table)->where('id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('id', $id)->update($data);
        return $results;
    }
}