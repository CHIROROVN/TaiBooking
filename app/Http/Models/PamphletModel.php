<?php namespace App\Http\Models;

use DB;

class PamphletModel
{
	protected $table = 'm_pamphlet';

    public function Rules()
    {
    	return array(
    		'pamph_number'    	=> 'required',
            'pamph_name'        => 'required',
            'pamph_kind'        => 'required|numeric',
            'pamph_class'       => 'required',
            'pamph_send'        => 'required',
            'pamph_area'        => 'required',
            'pamph_sex'         => 'required',
		);
    }

    public function Messages()
    {
    	return array(
            'pamph_number.required'   	    => trans('validation.error_pamph_number_required'),
            'pamph_name.required'           => trans('validation.error_pamph_name_required'),
            'pamph_kind.required'           => trans('validation.error_pamph_kind_required'),
            'pamph_class.required'          => trans('validation.error_pamph_class_required'),
            'pamph_send.required'           => trans('validation.error_pamph_send_required'),
            'pamph_area.required'           => trans('validation.error_pamph_area_required'),
            'pamph_sex.required'            => trans('validation.error_pamph_sex_required'),
		);
    }

    public function get_all($pagination = true, $where = array())
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE);

        // where s_pamph_number
        if ( !empty($where['s_pamph_number']) ) {
            $results = $results->where('pamph_number', 'like', '%' . $where['s_pamph_number'] . '%');
        }

        // where s_pamph_name
        if ( !empty($where['s_pamph_name']) ) {
            $results = $results->where('pamph_name', 'like', '%' . $where['s_pamph_name'] . '%');
        }

        // where pamph_kind
        if ( isset($where['s_pamph_kind_school']) || isset($where['s_pamph_kind_reserve']) || isset($where['s_pamph_kind_bundle']) ) {
            $s_pamph_kind_school = null;
            if ( isset($where['s_pamph_kind_school']) ) {
            $s_pamph_kind_school = $where['s_pamph_kind_school'];
            }
            $s_pamph_kind_reserve = null;
            if ( isset($where['s_pamph_kind_reserve']) ) {
            $s_pamph_kind_reserve = $where['s_pamph_kind_reserve'];
            }
            $s_pamph_kind_bundle = null;
            if ( isset($where['s_pamph_kind_bundle']) ) {
            $s_pamph_kind_bundle = $where['s_pamph_kind_bundle'];
            }
            $arr = [$s_pamph_kind_school, $s_pamph_kind_reserve, $s_pamph_kind_bundle];
            if ( !empty($s_pamph_kind_school) && !empty($s_pamph_kind_reserve) && !empty($s_pamph_kind_bundle) ) {
                $results = $results->whereIn('pamph_kind', $arr);
            }
        }

        // where s_pamph_class
        if ( isset($where['s_pamph_class_unused']) || isset($where['s_pamph_class_used']) ) {
            $s_pamph_class_unused = null;
            if ( isset($where['s_pamph_class_unused']) ) {
                $s_pamph_class_unused = $where['s_pamph_class_unused'];
            }
            $s_pamph_class_used = null;
            if ( isset($where['s_pamph_class_used']) ) {
                $s_pamph_class_used = $where['s_pamph_class_used'];
            }
            $arr = [$s_pamph_class_unused, $s_pamph_class_used];
            
            if ( !empty($s_pamph_class_unused) && !empty($s_pamph_class_used) ) {
                $results = $results->whereIn('pamph_class', $arr);
            }
        }

        // where s_pamph_cus_id
        if ( !empty($where['s_pamph_cus_id']) ) {
            $results = $results->where('pamph_cus_id', $where['s_pamph_cus_id']);
        }

        // where s_pamph_send
        if ( isset($where['s_pamph_send_none']) || isset($where['s_pamph_send_yes']) ) {
            $s_pamph_send_none = null;
            if ( isset($where['s_pamph_send_none']) ) {
                $s_pamph_send_none = $where['s_pamph_send_none'];
            }
            $s_pamph_send_yes = null;
            if ( isset($where['s_pamph_send_yes']) ) {
                $s_pamph_send_yes = $where['s_pamph_send_yes'];
            }
            $arr = [$s_pamph_send_none, $s_pamph_send_yes];
            
            if ( !empty($s_pamph_send_none) && !empty($s_pamph_send_yes) ) {
                $results = $results->whereIn('pamph_send', $arr);
            }
        }

        // where s_pamph_bunya_id
        if ( !empty($where['s_pamph_bunya_id']) ) {
            $results = $results->where('pamph_bunya_id', $where['s_pamph_bunya_id']);
        }

        // where s_pamph_pref and area
        if ( isset($where['s_pamph_pref']) ) {
            $results = $results->where(function($subquery) use ($where){
                // pref
                $s_pamph_pref = $where['s_pamph_pref'];
                if ( !empty($s_pamph_pref) ) {
                    $arr = array();
                    if ( !in_array('0', $s_pamph_pref) ) {
                        foreach ( $s_pamph_pref as $item ) {
                            if ( $item == '0' ) {
                                break;
                            }
                            $arr[] = $item;
                        }
                        $subquery->whereIn('pamph_pref', $arr);
                    }
                    // area
                    $s_pamph_area = $where['s_pamph_area'];
                    $arr = array();
                    if ( !in_array('0', $s_pamph_area) ) {
                        foreach ( $s_pamph_area as $item ) {
                            if ( $item == '0' ) {
                                break;
                            }
                            $arr[] = $item;
                        }
                        $subquery->orWhereIn('pamph_area', $arr);
                    }
                }
            });
        }

        // where s_pamph_sex_unspecified
        if ( isset($where['s_pamph_sex_unspecified']) || isset($where['s_pamph_sex_men']) || isset($where['s_pamph_sex_women']) ) {
            $s_pamph_sex_unspecified = null;
            if ( isset($where['s_pamph_sex_unspecified']) ) {
                $s_pamph_sex_unspecified = $where['s_pamph_sex_unspecified'];
            }
            $s_pamph_sex_men = null;
            if ( isset($where['s_pamph_sex_men']) ) {
                $s_pamph_sex_men = $where['s_pamph_sex_men'];
            }
            $s_pamph_sex_women = null;
            if ( isset($where['s_pamph_sex_women']) ) {
                $s_pamph_sex_women = $where['s_pamph_sex_women'];
            }
            $arr = [$s_pamph_sex_unspecified, $s_pamph_sex_men, $s_pamph_sex_women];
            
            if ( !empty($s_pamph_sex_unspecified) && !empty($s_pamph_sex_men) && !empty($s_pamph_sex_women) ) {
                $results = $results->whereIn('pamph_sex', $arr);
            }
        }

        $results = $results->orderBy('pamph_number', 'asc');
        $results = $results->groupby('pamph_number');

        // count record pagination
        $total_count = $results->get();
        $total_count = count($total_count);

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

    public function get_all_distinct()
    {
        $results = DB::table($this->table)
                        ->leftJoin('m_customer', 'm_pamphlet.pamph_cus_id', '=', 'm_customer.cus_id')
                        ->select('m_pamphlet.*', 'm_customer.cus_id', 'm_customer.cus_name')
                        ->where('m_pamphlet.last_kind', '<>', DELETE)
                        ->orderBy('pamph_number', 'asc')
                        ->get();
        return $results;
    }


    public function get_by_pamph_number($pamph_number)
    {
        $results = DB::table($this->table)
                            ->leftJoin('m_customer', 'm_pamphlet.pamph_cus_id', '=', 'm_customer.cus_id')
                            ->select('m_pamphlet.*', 'm_customer.cus_id', 'm_customer.cus_name')
                            ->where('m_pamphlet.last_kind', '<>', DELETE)
                            ->where('m_pamphlet.pamph_number', $pamph_number)
                            ->orderBy('pamph_number', 'asc')
                            ->get();
        return $results;
    }


    public function get_for_select()
    {
        $results = DB::table($this->table)->select('pamph_id', 'pamph_number', 'pamph_name')->where('last_kind', '<>', DELETE)->orderBy('pamph_number', 'asc')->get();
        return $results;
    }


    public function get_for_autocomplate($key = '')
    {
        $results = DB::table($this->table)
                        ->select('pamph_id', 'pamph_number', 'pamph_name')
                        ->where('last_kind', '<>', DELETE);
        if ( !empty($key) ) {
            $results = $results->where('pamph_number', 'like', '%' . $key . '%')
                                ->orWhere('pamph_name', 'like', '%' . $key . '%');
        }
        $db = $results->groupBy('pamph_number')->orderBy('pamph_number', 'asc')->get();

        return $db;
    }


    public function count() 
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->count();
        return $results;
    }


    public function count_distinct() 
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->groupby('pamph_number')->get();
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
                        ->leftJoin('m_customer', 'm_pamphlet.pamph_cus_id', '=', 'm_customer.cus_id')
                        ->select('m_pamphlet.*', 'm_customer.cus_id', 'm_customer.cus_code', 'm_customer.cus_name')
                        ->where('pamph_id', $id)
                        ->first();
        return $results;
    }


    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('pamph_id', $id)->update($data);
        return $results;
    }


    public function update_by_pamph_number($pamph_number, $data)
    {
        $results = DB::table($this->table)->where('pamph_number', $pamph_number)->update($data);
        return $results;
    }
}