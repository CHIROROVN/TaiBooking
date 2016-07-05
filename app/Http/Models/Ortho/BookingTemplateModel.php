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
}