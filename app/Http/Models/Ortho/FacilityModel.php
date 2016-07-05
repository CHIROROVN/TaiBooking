<?php namespace App\Http\Models\Ortho;

use DB;

class FacilityModel
{
    protected $table = 't_facility';
    protected $primaryKey = 'facility_id';
    public $timestamps  = false;

    public function Rules()
    {
        return array(
            'facility_name'        => 'required',
            'facility_kind'        => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'facility_name.required' => trans('validation.error_facility_name_required'),
            'facility_kind.required' => trans('validation.error_facility_kind_required'),
        );
    }

    public function getAll()
    {
        return DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('facility_sort_no', 'asc')->get();
    }

    public function get_all($clinic_id)
    {
        return DB::table($this->table)->where('last_kind', '<>', DELETE)->where('clinic_id', '=', $clinic_id)->orderBy('facility_sort_no', 'asc')->get();
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
        $results = DB::table($this->table)->where('facility_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
        $results = DB::table($this->table)->where('facility_id', $id)->update($data);
        return $results;
    }

    public function get_min()
    {
        $results = DB::table($this->table)->min('facility_sort_no');
        return $results;
    }

    public function get_max()
    {
        $results = DB::table($this->table)->max('facility_sort_no');
        return $results;
    }

    public function get_list($clinic_id, $facility_kind = null)
    {
        if(!empty($facility_kind)){
            return DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->where('clinic_id', '=', $clinic_id)
                                ->where('facility_kind', '=', $facility_kind)
                                ->orderBy('facility_sort_no', 'asc')
                                ->lists('facility_name', 'facility_id');
        }else{
            return DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->where('clinic_id', '=', $clinic_id)
                                ->orderBy('facility_sort_no', 'asc')
                                ->lists('facility_name', 'facility_id');
        }
    }

    public function list_facility_all(){
        return DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->orderBy('facility_id', 'asc')
                                ->lists('facility_name', 'facility_id');
    }
}