<?php namespace App\Http\Models\Ortho;

use DB;

class BookingTelWaitingModel
{

    protected $table = 't_booking_tel_waiting';

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
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('id', 'asc')->simplePaginate(PAGINATION);
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
        $results = DB::table($this->table)->where('id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('id', $id)->update($data);
        return $results;
    }
}