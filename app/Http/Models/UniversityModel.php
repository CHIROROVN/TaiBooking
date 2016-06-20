<?php namespace App\Http\Models;

use DB;

class UniversityModel
{
	protected $table = 'm_university';

    public function Rules()
    {
    	return array(
    		'univ_code'    	                    => 'required|unique:m_university,univ_code',
            'univ_name'                         => 'required',
            'univ_name_kana'                    => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
            'univ_pref_id'                      => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            'univ_code.required'   	            => trans('validation.error_univ_code_required'),
            'univ_code.unique'                  => trans('validation.error_univ_code_unique'),
            'univ_name.required'                => trans('validation.error_univ_name_required'),
            'univ_name_kana.required'           => trans('validation.error_univ_name_kana_required'),
            'univ_name_kana.regex'              => trans('validation.error_univ_name_kana_regex'),
            'univ_pref_id.required'             => trans('validation.error_univ_pref_id_required'),
		);
    }

    public function get_all($pagination = true, $where = array())
    {
        $results = DB::table($this->table)
                        ->leftJoin('m_pref', 'm_university.univ_pref_id', '=', 'm_pref.pref_id')
                        ->select('m_university.*', 'm_pref.pref_id', 'm_pref.pref_code', 'm_pref.pref_name')
                        ->where('m_university.last_kind', '<>', DELETE);

        // where s_univ_code
        if ( !empty($where['s_univ_code']) ) {
            $results = $results->where('univ_code', 'like', '%' . $where['s_univ_code'] . '%');
        }

        // // where s_univ_name
        if ( !empty($where['s_univ_name']) ) {
            $results = $results->where('univ_name', 'like', '%' . $where['s_univ_name'] . '%');
        }

        // where s_univ_pref_id
        if ( isset($where['s_univ_pref_id']) ) {
            $results = $results->where(function($subquery) use ($where){
                $s_univ_pref_id = $where['s_univ_pref_id'];
                if ( !empty($s_univ_pref_id) ) {
                    $arr = array();
                    if ( !in_array('0', $s_univ_pref_id) ) {
                        foreach ( $s_univ_pref_id as $item ) {
                            if ( $item == '0' ) {
                                break;
                            }
                            $arr[] = $item;
                        }
                        $subquery->whereIn('univ_pref_id', $arr);
                    }
                }
            });
        }

        $results = $results->orderBy('univ_code', 'asc');

        // count record pagination
        $total_count = $results->count();

        if ($pagination) {
            $db = $results->simplePaginate(PAGINATION); //simplePaginate, paginate
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
        $results = DB::table($this->table)->select('univ_id', 'univ_code', 'univ_name')->where('last_kind', '<>', DELETE)->orderBy('univ_code', 'asc')->get();
        return $results;
    }


    public function count() 
    {
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
        $results = DB::table($this->table)->where('univ_id', $id)->where('last_kind', '<>', DELETE)->first();
        return $results;
    }


    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('univ_id', $id)->update($data);
        return $results;
    }
}