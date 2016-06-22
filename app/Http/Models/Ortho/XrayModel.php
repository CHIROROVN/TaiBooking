<?php namespace App\Http\Models\Ortho;

use DB;

class XrayModel
{
    protected $table = 't_xray';


    public function Rules()
    {
    	return array(
    		'p_id'                  => 'required',
            'xray_date'             => 'required',
            'xray_place'            => 'required',
		);
    }


    public function Messages()
    {
    	return array(
            'p_id.required'             => trans('validation.error_p_id_required'),
            'xray_date.required'        => trans('validation.error_xray_date_required'),
            'xray_place.required'       => trans('validation.error_xray_place_required'),
		);
    }


    public function get_all($pagination = false, $where = array())
    {
        $db = DB::table($this->table)->where('last_kind', '<>', DELETE);

        // if(!empty($keyword))
        // {
        //     $db = $db->where('clinic_name', 'LIKE', '%' . $keyword . '%');
        // }

        $db = $db->orderBy('xray_date', 'asc');
        if ( $pagination ) {
            $results = $db->simplePaginate(PAGINATION); //simplePaginate, paginate
        } else {
            $results = $db->get();
        }
        
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
        $results = DB::table($this->table)->where('xray_id', $id)->first();
        return $results;
    }


    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('xray_id', $id)->update($data);
        return $results;
    }
}