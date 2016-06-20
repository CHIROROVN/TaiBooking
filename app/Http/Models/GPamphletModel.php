<?php namespace App\Http\Models;

use DB;

class GPamphletModel
{
	protected $table = 'm_pamphlet_group';

    public function Rules()
    {
    	return array(
    		'gpamph_number'    	=> 'required',
            'pamph_id'          => 'required',
		);
    }

    public function Messages()
    {
        return array(
            'gpamph_number.required'   	=> trans('validation.error_gpamph_number_required'),
            'pamph_id.required'         => trans('validation.error_pamph_id_required'),
        );
    }

    public function get_all($pagination = true, $where = array())
    {
        $results = DB::table($this->table)->where('m_pamphlet_group.last_kind', '<>', DELETE);

        // where s_gpamph_number
        if ( !empty($where['s_gpamph_number']) ) {
            $results = $results->where('gpamph_number', 'like', '%' . $where['s_gpamph_number'] . '%');
        }

        // where s_pamph_id
        if ( !empty($where['s_pamph_id']) ) {
            $results = $results->where('pamph_id', $where['s_pamph_id']);
        }

        $results = $results->orderBy('gpamph_number', 'asc');
        $results = $results->groupby('gpamph_number');

        // count record pagination
        $total_count = $results->get();
        $total_count = count($total_count);


        if ($pagination) {
            $db = $results->simplePaginate(PAGINATION);//simplePaginate, paginate
        } else {
            $db = $results->get();
        }

        return array(
            'db'            => $db,
            'total_count'   => $total_count
        );
    }


    public function get_for_select()
    {
        $results = DB::table($this->table)->select('gpamph_id', 'gpamph_number')->where('last_kind', '<>', DELETE)->orderBy('m_pamphlet_group.gpamph_number', 'asc')->get();
        return $results;
    }

    public function get_all_distinct()
    {
        $results = DB::table($this->table)
                        ->leftJoin('m_pamphlet', 'm_pamphlet_group.pamph_id', '=', 'm_pamphlet.pamph_id')
                        ->select('m_pamphlet_group.*', 'm_pamphlet.pamph_id', 'm_pamphlet.pamph_number')
                        ->where('m_pamphlet_group.last_kind', '<>', DELETE)
                        ->orderBy('m_pamphlet_group.gpamph_number', 'asc')
                        ->get();
        return $results;
    }


    public function count() 
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->count();
        return $results;
    }


    public function count_distinct() 
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->groupby('gpamph_number')->get();
        return count($results);
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
        $results = DB::table($this->table)
                        ->leftJoin('m_pamphlet', 'm_pamphlet_group.pamph_id', '=', 'm_pamphlet.pamph_id')
                        ->select('m_pamphlet_group.*', 'm_pamphlet.pamph_id', 'm_pamphlet.pamph_number')
                        ->where('gpamph_id', $id)
                        ->first();
        return $results;
    }


    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('gpamph_id', $id)->update($data);
        return $results;
    }
}