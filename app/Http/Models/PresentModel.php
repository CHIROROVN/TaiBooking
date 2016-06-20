<?php

namespace App\Http\Models;

use DB;

class PresentModel
{
	protected $table = 'm_presentlist';

    public function Rules()
    {
    	return array(
    		'present_code'    	=> 'required',
            'present_name'      => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            'present_code.required'   	=> trans('validation.error_present_code_required'),
            'present_name.required'     => trans('validation.error_present_name_required'),
		);
    }

    public function get_all($pagination = true)
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('present_code', 'asc');

        if ($pagination) {
            $db = $results->paginate(PAGINATION);
        } else {
            $db = $results->get();
        }
        
        return $db;
    }


    public function get_for_select()
    {
        $results = DB::table($this->table)->select('presentlist_id', 'present_name')->where('last_kind', '<>', DELETE)->orderBy('present_code', 'asc')->get();
        return $results;
    }

    public function count() {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->count();
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
        $results = DB::table($this->table)->where('presentlist_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('presentlist_id', $id)->update($data);
        return $results;
    }
}