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


    public function get_all($where = array())
    {
        $db = DB::table($this->table)
                    ->leftJoin('m_users as t1', 't_shift.u_id', '=', 't1.id')
                    ->select('t_shift.*', 't1.u_name')
                    ->where('t_shift.last_kind', '<>', DELETE);

        // where
        // if ( ) {

        // }

        $results = $db->get();
        return $results;
    }


    public function get_by_belong($belong_kind = array(), $date = '')
    {
        $db = DB::table($this->table)
                    ->leftJoin('m_users as t2', 't_shift.u_id', '=', 't2.id')
                    ->leftJoin('m_belong as t1', 't2.u_belong', '=', 't1.belong_id')
                    ->select('id', 'u_name')
                    ->where('t_shift.last_kind', '<>', DELETE)
                    ->whereIn('t1.belong_kind', $belong_kind);
        if ( !empty($date) ) {
            $db = $db->where('t_shift.shift_date', $date);
        }

        $results = $db->get();
        return $results;
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

    public function update_by_uid_shiftdate($u_id, $shift_date, $data)
    {
        return DB::table($this->table)
                    ->where('u_id', $u_id)
                    ->where('shift_date', $shift_date)
                    ->where('last_kind', '<>', DELETE)
                    ->update($data);
    }

    public function check_exist_by_uid_shiftdate($u_id, $shift_date)
    {
        $db = DB::table($this->table)
                    ->where('u_id', $u_id)
                    ->where('shift_date', $shift_date)
                    ->where('last_kind', '<>', DELETE)
                    ->first();

        if ( count($db) > 0 ) {
            // exist
            return true;
        }

        // not exist
        return false;
    }

}