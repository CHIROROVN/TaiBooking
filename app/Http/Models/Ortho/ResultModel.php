<?php namespace App\Http\Models\Ortho;

use DB;

class ResultModel
{

    protected $table = 't_result';

    public function Rules()
    {
    	return array(
    		// 'area_name' => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            // 'area_name.required' => trans('validation.error_area_name_required'),
		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('result_date', 'asc')->get();
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
        $results = DB::table($this->table)->where('result_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('result_id', $id)->update($data);
        return $results;
    }
}