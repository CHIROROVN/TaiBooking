<?php

namespace App\Http\Models;

use DB;

class PrefModel
{
	protected $table = 'm_pref';

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
        $results = DB::table($this->table)->select('pref_id', 'pref_name')->where('last_kind', '<>', DELETE)->orderBy('pref_code', 'asc')->get();
        return $results;
    }
}