<?php namespace App\Http\Models;

use DB;

class EnterpriseModel
{
    protected $table = 'm_enterprise';

    public function Rules()
    {
        return array(
            'ent_name'         => 'required',
            'ent_login'        => 'required|unique:m_enterprise',
            'ent_passwd'       => 'required',
            'cus_name_lb2'     => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'ent_name.required'         => trans('validation.error_ent_name_required'),
            'ent_login.required'        => trans('validation.error_ent_login_id_required'),
            'ent_login.unique'          => trans('validation.error_ent_login_id_exist'),
            'ent_passwd.required'       => trans('validation.error_ent_passwd_required'),
            'cus_name_lb2.required'     => trans('validation.error_ent_cus_required'),
        );
    }

    public function get_all($where = null)
    {
        $query = DB::table($this->table)
                ->where('last_kind', '<>', DELETE)
                ->orderBy('ent_id', 'desc');

        if(!empty($where['entName']))
            $query->where('ent_name', 'LIKE', '%' .$where['entName']. '%');

        $results = $query->simplePaginate(PAGINATION);
        return $results;
    }

    public function count() {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->count();
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
        $results = DB::table($this->table)->where('ent_id', $id)->first();
        return $results;
    }

    public function get_list_ent()
    {
        return DB::table($this->table)->where('last_kind', '<>', DELETE)->lists('ent_name', 'ent_id');
    }

    public function find_max_id()
    {
        return DB::table($this->table)->where('last_kind', '<>', DELETE)->max('ent_id');
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('ent_id', $id)->update($data);
        return $results;
    }
}