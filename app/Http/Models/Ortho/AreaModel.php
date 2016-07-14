<?php namespace App\Http\Models\Ortho;

use DB;

class AreaModel
{

    protected $table = 'm_area';

    public function Rules()
    {
    	return array(
    		'area_name' => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            'area_name.required' => trans('validation.error_area_name_required'),
		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('area_sort_no', 'asc')->get();
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
        $results = DB::table($this->table)->where('area_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('area_id', $id)->update($data);
        return $results;
    }

    public function get_min()
    {
        $results = DB::table($this->table)->min('area_sort_no');
        return $results;
    }

    public function get_max()
    {
        $results = DB::table($this->table)->max('area_sort_no');
        return $results;
    }

    public function get_list()
    {
        return DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('area_sort_no', 'asc')->lists('area_name', 'area_id');
    }
}