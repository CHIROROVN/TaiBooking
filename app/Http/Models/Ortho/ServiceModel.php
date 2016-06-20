<?php namespace App\Http\Models\Ortho;

use DB;

class ServiceModel
{
    protected $table = 'm_service';

    public function Rules()
    {
        return array(
            'service_name' => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'service_name.required' => trans('validation.error_service_name_required'),
        );
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('service_sort_no', 'asc')->get();
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
        $results = DB::table($this->table)->where('service_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
        $results = DB::table($this->table)->where('service_id', $id)->update($data);
        return $results;
    }

    public function get_min()
    {
        $results = DB::table($this->table)->min('service_sort_no');
        return $results;
    }

    public function get_max()
    {
        $results = DB::table($this->table)->max('service_sort_no');
        return $results;
    }
}