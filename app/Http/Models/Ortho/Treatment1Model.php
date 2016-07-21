<?php namespace App\Http\Models\Ortho;

use DB;

class Treatment1Model
{
    protected $table = 'm_treatment';
    protected $primaryKey = 'treatment_id';
    public $timestamps  = false;

    public function Rules()
    {
        return array(
            'treatment_name'        => 'required',
            'treatment_time'        => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'treatment_name.required' => trans('validation.error_treatment_name_required'),
            'treatment_time.required' => trans('validation.error_treatment_time_required'),
        );
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('treatment_sort_no', 'asc')->get();
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
        $results = DB::table($this->table)->where('treatment_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
        $results = DB::table($this->table)->where('treatment_id', $id)->update($data);
        return $results;
    }

    public function get_min()
    {
        $results = DB::table($this->table)->min('treatment_sort_no');
        return $results;
    }

    public function get_max()
    {
        $results = DB::table($this->table)->max('treatment_sort_no');
        return $results;
    }

    public function get_treatment_search(){
        return DB::table($this->table)
                                    ->where('last_kind', '<>', DELETE)
                                    ->select('treatment_id','treatment_name', 'treatment_time')
                                    ->orderBy('treatment_id', 'asc')
                                    ->get();
    }
    
    public function get_list_treatment(){
        return DB::table($this->table)
                                    ->where('last_kind', '<>', DELETE)
                                    ->orderBy('treatment_id', 'asc')
                                    ->lists('treatment_name','treatment_id');
    }
}