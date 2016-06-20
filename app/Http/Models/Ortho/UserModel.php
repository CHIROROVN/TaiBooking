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
            'password'          => 'required|min:6',
		);
    }

    public function Messages()
    {
    	return array(
            'u_name.required'           => '※必須',
            'u_name_yomi.required'      => '※必須',
            'u_name_yomi.regex'         => '※Hiragana',
            'u_name_display.required'   => '※必須',
            'u_login.required'          => '※必須',
            'password.required'         => '※必須',
		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('u_name_yomi', 'asc')->get();
        return $results;
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