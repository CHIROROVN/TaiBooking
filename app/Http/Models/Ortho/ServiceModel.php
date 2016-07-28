<?php namespace App\Http\Models\Ortho;

use DB;

class ServiceModel
{
    protected $table = 'm_service';
    protected $primaryKey = 'service_id';
    public $timestamps  = false;

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
        return DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('service_sort_no', 'asc')->get();
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

    public function get_list()
    {
        return DB::table($this->table)
                            //->rightJoin('t_clinic_service', 'm_service.service_id', '=', 't_clinic_service.service_id')
                            ->where('last_kind', '<>', DELETE)
                            ->orderBy('service_sort_no', 'asc')
                            ->lists('service_name', 'service_id');
    }

    public function get_clinic_service(){
      return DB::table($this->table)
                            ->rightJoin('t_clinic_service')
                            ->where('t_clinic_service.last_kind', '<>', DELETE)
                            ->where('last_kind', '<>', DELETE)
                            ->orderBy('service_sort_no', 'asc')
                            ->get();
    }

    public function service_available(){
        return DB::table($this->table)
                                    ->where('last_kind', '<>', DELETE)
                                    ->whereNotNull('last_kind')
                                    ->lists('service_id');
    }
}
