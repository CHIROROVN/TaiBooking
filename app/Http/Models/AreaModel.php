<?php

namespace App\Http\Models;

use DB;

class AreaModel
{
	protected $table = 'm_area';

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


    public function get_for_select()
    {
        $results = DB::table($this->table)->select('area_id', 'area_name')->where('last_kind', '<>', DELETE)->orderBy('area_code', 'asc')->get();
        return $results;
    }
}