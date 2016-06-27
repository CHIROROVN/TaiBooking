<?php namespace App\Http\Models\Ortho;

use DB;

class CommunicationModel
{

    protected $table = 't_com';

    public function Rules()
    {
    	return array(
    		'com_title'                       => 'required',
            'com_contents'                    => 'required'
		);
    }

    public function Messages()
    {
    	return array(
            'com_title.required'                     => trans('validation.error_com_title_required'),
            'com_contents.required'                  => trans('validation.error_com_contents_required')
		);
    }

    public function get_all($patient_id)
    {
        $results = DB::table($this->table)
                        ->leftJoin('m_users', 't_com.u_id', '=', 'm_users.id')
                        ->select('t_com.*', 'm_users.u_name')
                        ->where('p_id', $patient_id)
                        ->where('t_com.last_kind', '<>', DELETE);

        $db = $results->orderBy('com_title', 'asc')->get();
        
        return $db;
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
        $results = DB::table($this->table)->where('com_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('com_id', $id)->update($data);
        return $results;
    }
}