<?php namespace App\Http\Models;

use DB;

class UserModel
{
    protected $table = 'm_user';
    protected $primaryKey = 'u_id';
    public $timestamps  = false;

    public function Rules()
    {
        return array(
            'u_name'                    => 'required',
            'u_login'                   => 'required|unique:m_user',
            'u_passwd'                  => 'required|min:6',
            'u_power'                   => 'required',
            'currpasswd'                => 'required',
            'newpasswd'                 => 'required|alpha_num|min:6',
            'confnewpasswd'             => 'same:newpasswd',
        );
    }

    public function addRules()
    {
        return array(
            'u_name'                    => 'required',
            'u_login'                   => 'required|unique:m_user',
            'u_passwd'                  => 'required|min:6',
            'u_power'                   => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'u_name.required'           => trans('validation.error_u_name_required'),
            'u_login.required'          => trans('validation.error_u_login_required'),
            'u_passwd.required'         => trans('validation.error_u_passwd_required'),
            'u_passwd.min'              => trans('validation.error_u_passwd_min'),
            'u_power.required'          => trans('validation.error_u_power_required'),
            'u_login.unique'            => trans('validation.error_u_login_unique'),
            'currpasswd.required'       => trans('validation.error_currpasswd_required'),
            'newpasswd.required'        => trans('validation.error_newpasswd_required'),
            'newpasswd.alpha_num'       => trans('validation.error_newpasswd_alpha_num'),
            'newpasswd.min'             => trans('validation.error_newpasswd_min'),
            'confnewpasswd.same'        => trans('validation.error_confnewpasswd_same'),
        );
    }

    public function get_all($pagination = true)
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('u_id', 'desc');
        if ($pagination) {
            $db = $results->simplePaginate(PAGINATION); //simplePaginate, paginate
        } else {
            $db = $results->get();
        }
        return $db;
    }

    public function get_list($pagination = true)
    {
        return DB::table($this->table)->where('last_kind', '<>', DELETE)->lists('u_name', 'u_id');
    }

    public function count() {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->count();
        return $results;
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
        return DB::table($this->table)->where('u_id', $id)->first();
    }

    public function update($id, $data)
    {
        return DB::table($this->table)->where('u_id', '=', $id)->update($data);
    }

    public function delete($id, $data)
    {
        return DB::table($this->table)->where('u_id', '=', $id)->update($data);
    }
}