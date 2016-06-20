<?php namespace App\Http\Models;

use DB;

class PersonalModel
{
	protected $table = 't_personal';

    public function Rules()
    {
    	return array(
    		// 'baitai_code'    	=> 'required',
      //       'per_fname'       => 'required',
      //       'baitai_kind'       => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            // 'baitai_code.required'   	=> trans('validation.error_baitai_code_required'),
            // 'per_fname.required'      => trans('validation.error_per_fname_required'),
            // 'baitai_kind.required'      => trans('validation.error_baitai_kind_required'),
            // 'baitai_year.required'      => trans('validation.error_baitai_year_required'),
		);
    }

    public function get_all($pagination = true, $where = array())
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE);

        // // where baitai_code
        // if ( !empty($where['s_baitai_code']) ) {
        //     $results = $results->where('baitai_code', 'like', '%' . $where['s_baitai_code'] . '%');
        // }

        // // where per_fname
        // if ( !empty($where['s_per_fname']) ) {
        //     $results = $results->where('per_fname', 'like', '%' . $where['s_per_fname'] . '%');
        // }

        // // where baitai_kind
        // // (old) or (new) or (old or new)
        // if ( !empty($where['s_baitai_kind_old']) && !empty($where['s_baitai_kind_new']) ) {
        //     $results = $results->whereIn('baitai_kind', [1, 2]);
        // } elseif ( !empty($where['s_baitai_kind_old']) && empty($where['s_baitai_kind_new']) ) {
        //     $results = $results->where('baitai_kind', '=', $where['s_baitai_kind_old']);
        // } elseif ( empty($where['s_baitai_kind_old']) && !empty($where['s_baitai_kind_new']) ) {
        //     $results = $results->where('baitai_kind', '=', $where['s_baitai_kind_new']);
        // }

        // // where baitai_year
        // // begin & end
        // if ( !empty($where['s_baitai_year_begin']) && !empty($where['s_baitai_year_end']) ) {
        //     $results = $results->where('baitai_year', '>=', $where['s_baitai_year_begin'])
        //                         ->where('baitai_year', '<=', $where['s_baitai_year_end']);
        // } elseif ( !empty($where['s_baitai_year_begin']) && empty($where['s_baitai_year_end']) ) {
        //     $results = $results->where('baitai_year', '>=', $where['s_baitai_year_begin']);
        // } elseif ( empty($where['s_baitai_year_begin']) && !empty($where['s_baitai_year_end']) ) {
        //     $results = $results->where('baitai_year', '<=', $where['s_baitai_year_end']);
        // }

        // $results = $results->orderBy('baitai_code', 'asc');

        // count record pagination
        $total_count = $results->count();

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
        $results = DB::table($this->table)->select('per_id', 'per_fname')->where('last_kind', '<>', DELETE)->orderBy('baitai_code', 'asc')->get();
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
        $results = DB::table($this->table)->where('per_id', $id)->first();
        return $results;
    }


    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('per_id', $id)->update($data);
        return $results;
    }
}