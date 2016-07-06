<?php namespace App\Http\Models\Ortho;

use DB;

class InsuranceModel
{

    protected $table = 'm_insurance';

    public function Rules()
    {
    	return array(
    		'insurance_name' => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            'insurance_name.required' => trans('validation.error_insurance_name_required'),
		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('insurance_sort_no', 'asc')->get();
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
        $results = DB::table($this->table)->where('insurance_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('insurance_id', $id)->update($data);
        return $results;
    }

    public function get_min()
    {
        $results = DB::table($this->table)->min('insurance_sort_no');
        return $results;
    }

    public function get_max()
    {
        $results = DB::table($this->table)->max('insurance_sort_no');
        return $results;
    }

    public function get_list()
    {
        return DB::table($this->table)
                            ->where('last_kind', '<>', DELETE)
                            ->orderBy('insurance_id', 'asc')
                            ->lists('insurance_name', 'insurance_id');
    }
}