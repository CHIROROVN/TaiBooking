<?php namespace App\Http\Models\Ortho;

use DB;

class BelongModel
{

    protected $table = 'm_belong';

    public function Rules()
    {
    	return array(
    		'belong_name' => 'required',
		);
    }

    public function Messages()
    {
    	return array(
    		'belong_name.required'  => '※必須',
            // 'belong_name.min'       => 'Min belong_name'
		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('belong_sort_no', 'asc')->get();
        return $results;
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