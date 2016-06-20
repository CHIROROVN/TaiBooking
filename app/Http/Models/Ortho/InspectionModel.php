<?php namespace App\Http\Models\Ortho;

use DB;

class InspectionModel
{

    protected $table = 'm_inspection';

    public function Rules()
    {
    	return array(
    		'inspection_name' => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            'inspection_name.required' => trans('validation.error_inspection_name_required'),
		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('inspection_sort_no', 'asc')->get();
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
        $results = DB::table($this->table)->where('inspection_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('inspection_id', $id)->update($data);
        return $results;
    }

    public function get_min()
    {
        $results = DB::table($this->table)->min('inspection_sort_no');
        return $results;
    }

    public function get_max()
    {
        $results = DB::table($this->table)->max('inspection_sort_no');
        return $results;
    }
}