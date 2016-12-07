<?php namespace App\Http\Models\Ortho;
use DB;

class DdrModel
{
    protected $table = 't_ddr';

    public function Rules()
    {
        return array(
            'ddr_start_date' => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'ddr_start_date.required' => trans('validation.error_ddr_start_date_required'),
        );
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('ddr_start_date', 'asc')->orderBy('ddr_start_time', 'asc')->get();
        return $results;
    }

    public function get_by_start_date($start_date = null)
    {
        $results = DB::table($this->table)->where('ddr_start_date', $start_date)->where('last_kind', '<>', DELETE)->orderBy('ddr_start_date', 'asc')->orderBy('ddr_start_time', 'asc')->get();
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
        $results = DB::table($this->table)->where('ddr_id', $id)->where('last_kind', '<>', DELETE)->first();
        return $results;
    }

    public function get_by_memo_date($memo_date)
    {
        $results = DB::table($this->table)->where('memo_date', $memo_date)->where('last_kind', '<>', DELETE)->first();
        return $results;
    }

    public function update($id, $data)
    {
        $results = DB::table($this->table)->where('ddr_id', $id)->update($data);
        return $results;
    }
}