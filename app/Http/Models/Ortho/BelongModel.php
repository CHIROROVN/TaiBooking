<?php namespace App\Http\Models\Ortho;

use DB;

class BelongModel
{

    protected $table = 'm_belong';

    public function Rules()
    {
    	return array(
    		'belong_name' => 'required',
            'belong_kind' => 'required',
		);
    }

    public function Messages()
    {
    	return array(
    		'belong_name.required'  => trans('validation.error_belong_name_required'),
            'belong_kind.required'  => trans('validation.error_belong_kind_required'),
		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('belong_sort_no', 'asc')->get();
        return $results;
    }

    public function get_for_select($where = array())
    {
        $db = DB::table($this->table)->select('belong_id', 'belong_name', 'belong_kind')->where('last_kind', '<>', DELETE);

        // belong_kind
        if ( !empty($where['s_belong_kind']) ) {
            $db = $db->where('belong_kind', $where['s_belong_kind']);
        }

        $db = $db->orderBy('belong_sort_no', 'asc')->get();
        return $db;
    }

    public function insert($data)
    {
        $results = DB::table($this->table)->insert($data);
        return $results;
    }

    public function get_by_id($id)
    {
        $results = DB::table($this->table)->where('belong_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('belong_id', $id)->update($data);
        return $results;
    }

    public function get_min()
    {
        $results = DB::table($this->table)->min('belong_sort_no');
        return $results;
    }

    public function get_max()
    {
        $results = DB::table($this->table)->max('belong_sort_no');
        return $results;
    }
}