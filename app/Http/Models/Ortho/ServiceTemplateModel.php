<?php namespace App\Http\Models\Ortho;

use DB;

class ServiceTemplateModel
{
    protected $table = 't_clinic_service';
    protected $primaryKey = 'clinic_service_id';
    public $timestamps  = false;

    public function Rules()
    {
        return array(
            'service_facility_1'        => 'required',
            'service_facility_2'        => 'required',
            'service_facility_3'        => 'required',
            'service_facility_4'        => 'required',
            'service_facility_5'        => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'service_facility_1.required' => trans('validation.error_service_facility_1_required'),
            'service_facility_2.required' => trans('validation.error_service_facility_2_required'),
            'service_facility_3.required' => trans('validation.error_service_facility_3_required'),
            'service_facility_4.required' => trans('validation.error_service_facility_4_required'),
            'service_facility_5.required' => trans('validation.error_service_facility_5_required'),
        );
    }

    public function get_all($clinic_id, $service_id)
    {
        return DB::table($this->table)
                            ->where('last_kind', '<>', DELETE)
                            ->where('clinic_id', '=', $clinic_id)
                            ->where('service_id', '=', $service_id)
                            ->orderBy('clinic_service_id_sort_no', 'asc')
                            ->get();
    }

    public function insert($data)
    {
        return DB::table($this->table)->insert($data);
    }

    public function insert_get_id($data)
    {
        return DB::table($this->table)->insertGetId($data);
    }

    public function get_by_id($id)
    {
        return DB::table($this->table)->where('clinic_service_id', $id)->first();
    }

    public function update($id, $data)
    {
        return DB::table($this->table)->where('clinic_service_id', $id)->update($data);
    }

}