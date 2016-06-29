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
            // 'clinic_service_name'        => 'required',
            // 'clinic_service_kind'        => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'clinic_service_name.required' => trans('validation.error_clinic_service_name_required'),
            'clinic_service_kind.required' => trans('validation.error_clinic_service_kind_required'),
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

    // public function get_min()
    // {
    //     return DB::table($this->table)->min('clinic_service_id_sort_no');
    // }

    // public function get_max()
    // {
    //     return DB::table($this->table)->max('clinic_service_id_sort_no');
    // }
}