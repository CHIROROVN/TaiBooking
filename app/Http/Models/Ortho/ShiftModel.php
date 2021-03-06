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
                    ->leftJoin('m_clinic as t2', 't_shift.clinic_id', '=', 't2.clinic_id')
                    ->select('t_shift.*', 't1.u_name', 't1.u_name_display', 't1.u_belong', 't2.clinic_name', 't2.clinic_display_name')
                    ->where('t_shift.last_kind', '<>', DELETE);
        // where
        if ( !empty($where['u_id']) ) {
            $db = $db->where('t_shift.u_id', $where['u_id']);
        }
        if ( !empty($where['clinic_id']) ) {
            $db = $db->where('t_shift.clinic_id', $where['clinic_id']);
        }
        if ( !empty($where['shift_date']) ) {
            $db = $db->where('t_shift.shift_date', $where['shift_date']);
        }

        $results = $db->get();
        return $results;
    }

    public function get_by_belong($belong_kind = array(), $date = '', $clinic_id = '')
    {
        $db = DB::table($this->table)
                    ->leftJoin('m_users as t2', 't_shift.u_id', '=', 't2.id')
                    ->leftJoin('m_belong as t1', 't2.u_belong', '=', 't1.belong_id')
                    ->select('t_shift.*', 'u_name')
                    ->where('t_shift.last_kind', '<>', DELETE)
                    ->whereIn('t1.belong_kind', $belong_kind);
        if ( !empty($date) ) {
            $db = $db->where('t_shift.shift_date', $date);
        }
        if ( !empty($clinic_id) ) {
            $db = $db->where('t_shift.clinic_id', $clinic_id);
        }

        $results = $db->get();
        return $results;
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

    public function checkExist($where = array())
    {
        $db = DB::table($this->table);
        // u_id
        if ( !empty($where['u_id']) ) {
            $db->where('u_id', $where['u_id']);
        }
        // shift_date
        if ( !empty($where['shift_date']) ) {
            $db->where('shift_date', $where['shift_date']);
        }
        // clinic_id
        if ( !empty($where['clinic_id']) ) {
            $db->where('clinic_id', $where['clinic_id']);
        }
        $db = $db->first();
        return $db;
    }

    public function get_user_shift($belong_kind = array())
    {
        $db = DB::table($this->table)
                    ->leftJoin('m_users as t2', 't_shift.u_id', '=', 't2.id')
                    ->leftJoin('m_belong as t1', 't2.u_belong', '=', 't1.belong_id')
                    ->select('id', 'u_name')
                    ->where('t_shift.last_kind', '<>', DELETE)
                    ->distinct('id')
                    ->whereIn('t1.belong_kind', $belong_kind);
       return $db->get();
    }

    public function get_user_shift2($clinic_id, $shift_date)
    {
        $db = DB::table($this->table)
                    ->leftJoin('m_users', 't_shift.u_id', '=', 'm_users.id')
                    ->select('shift_id', 'u_id', 'u_name', 'u_belong', 'u_name_display')
                    ->where('t_shift.clinic_id', $clinic_id)
                    ->where('t_shift.shift_date', $shift_date)
                    ->where('t_shift.last_kind', '<>', DELETE)
                    ->groupBy('u_id');
       return $db->get();
    }

    public function autoInsert($data)
    {
        $results = DB::table($this->table)->insert($data);
        return $results;
    }

}