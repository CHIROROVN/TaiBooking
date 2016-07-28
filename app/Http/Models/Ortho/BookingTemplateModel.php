<?php namespace App\Http\Models\Ortho;

use DB;

class BookingTemplateModel
{
    protected $table = 'm_booking_template';
    protected $primaryKey = 'mbt_id';
    public $timestamps  = false;

    public function Rules()
    {
        return array(
            'mbt_name'        => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'mbt_name.required' => trans('validation.error_mbt_name_required'),
        );
    }

    public function get_all($clinic_id = null)
    {
        return DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->where('clinic_id', '=', $clinic_id)
                                ->orderBy('mbt_sort_no', 'asc')
                                ->get();
    }

    public function get_list(){
        return DB::table($this->table)->where('last_kind', '<>', DELETE)->lists('mbt_name', 'mbt_id');
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
        return DB::table($this->table)->where('mbt_id', $id)->first();
    }

    public function update($id, $data)
    {
        return DB::table($this->table)->where('mbt_id', $id)->update($data);
    }

    public function get_min()
    {
        return DB::table($this->table)->min('mbt_sort_no');
    }

    public function get_max()
    {
        return DB::table($this->table)->max('mbt_sort_no');
    }

    /**
     * get booking template
    */
    public function getBookTemp(){
        return DB::table($this->table)
                                ->leftJoin('t_template', 'm_booking_template.mbt_id', '=', 't_template.mbt_id')
                                ->leftJoin('t_facility', 't_template.facility_id', '=', 't_facility.facility_id')
                                ->where('m_booking_template.last_kind', '<>', DELETE)
                                ->select('m_booking_template.*', 't_template.template_time', 't_facility.facility_name')
                                ->orderBy('m_booking_template.mbt_sort_no', 'asc')
                                ->simplePaginate(PAGINATION);
    }
}