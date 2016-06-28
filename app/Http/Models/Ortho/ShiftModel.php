<?php namespace App\Http\Models\Ortho;

use DB;

class ShiftModel
{
    protected $table = 't_shift';
    protected $primaryKey = 'shift_id';
    public $timestamps  = false;

    public function Rules()
    {
        return array(
            // 'shift_name'        => 'required',
            // 'shift_time'        => 'required',
        );
    }

    public function Messages()
    {
        return array(
            // 'shift_name.required' => trans('validation.error_shift_name_required'),
            // 'shift_time.required' => trans('validation.error_shift_time_required'),
        );
    }

    public function get_all()
    {
        return DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('shift_date', 'desc')->get();
    }

    public function insert($data)
    {
        $results = DB::table($this->table)->insert($data);
        return $results;
    }

    public function insert_get_id($data)
    {
        return DB::table($this->table)->insertGetId($data);
    }

    public function get_by_id($id)
    {
        return DB::table($this->table)->where('shift_id', $id)->first();
    }

    public function update($id, $data)
    {
        return DB::table($this->table)->where('shift_id', $id)->update($data);
    }

}