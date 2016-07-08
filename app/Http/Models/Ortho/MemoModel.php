<?php namespace App\Http\Models\Ortho;

use DB;

class MemoModel
{

    protected $table = 't_memo';

    public function Rules()
    {
    	return array(

		);
    }

    public function Messages()
    {
    	return array(

		);
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('memo_date', 'asc')->get();
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
        $results = DB::table($this->table)->where('memo_id', $id)->where('last_kind', '<>', DELETE)->first();
        return $results;
    }

    public function get_by_memo_date($memo_date)
    {
        $results = DB::table($this->table)->where('memo_date', $memo_date)->where('last_kind', '<>', DELETE)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('memo_id', $id)->update($data);
        return $results;
    }
}