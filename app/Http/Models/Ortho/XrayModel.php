<?php namespace App\Http\Models\Ortho;
use DB;

class XrayModel
{
    protected $table = 't_xray';
    public function Rules()
    {
        return array(
            'xray_date'             => 'required',
            'xray_place'            => 'required',
            'u_id'                  => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'xray_date.required'        => trans('validation.error_xray_date_required'),
            'xray_place.required'       => trans('validation.error_xray_place_required'),
            'u_id.required'             => trans('validation.error_xray_u_id_required'),
        );
    }

    public function get_all($pagination = false, $where = array())
    {
        $db = DB::table('t_patient')
                    ->leftJoin('t_xray as t1', 't_patient.p_id', '=', 't1.p_id')
                    ->leftJoin('t_3dct as t2', 't_patient.p_id', '=', 't2.p_id')
                    ->select('t_patient.*', 't1.xray_id', 't1.xray_date', 't1.xray_place', 't2.ct_id', 't2.ct_date')
                    ->where('t_patient.last_kind', '<>', DELETE);
        // s_p_id
        if( !empty($where['s_p_id']) )
        {
            $db = $db->where('t_patient.p_id', $where['s_p_id']);
        }
        // s_p_name
        if( !empty($where['s_p_name']) && empty($where['s_p_id']) )
        {
            $db = $db->where(function($subquery) use ($where) {
                $subquery->where('t_patient.p_no', 'like', '%' . $where['s_p_name'] . '%');
                $subquery->orWhere('t_patient.p_name_f', 'like', '%' . $where['s_p_name'] . '%');
                $subquery->orWhere('t_patient.p_name_g', 'like', '%' . $where['s_p_name'] . '%');
            });
        }
        // s_p_birthday
        // Y-m-d <= s_t1.p_birthday <= Y-m-d
        if ( isset($where['s_p_birthday_year_from']) || isset($where['s_p_birthday_month_from']) || isset($where['s_p_birthday_day_from']) ) {
            if( ($where['s_p_birthday_year_from'] != 0 || $where['s_p_birthday_month_from'] != 0 || $where['s_p_birthday_day_from'] != 0) 
            && ($where['s_p_birthday_year_to'] != 0 || $where['s_p_birthday_month_to'] != 0 || $where['s_p_birthday_day_to'] != 0) )
            {
                if ( ($where['s_p_birthday_year_from'] != 0 && $where['s_p_birthday_month_from'] != 0 && $where['s_p_birthday_day_from'] != 0) && ($where['s_p_birthday_year_to'] != 0 && $where['s_p_birthday_month_to'] != 0 && $where['s_p_birthday_day_to'] != 0) ) {
                    $s_birthday_from    = $where['s_p_birthday_year_from'] . '-' . $where['s_p_birthday_month_from'] . '-' . $where['s_p_birthday_day_from'];
                    $s_birthday_to      = $where['s_p_birthday_year_to'] . '-' . $where['s_p_birthday_month_to'] . '-' . $where['s_p_birthday_day_to'];
                    $db = $db->where('t_patient.p_birthday', '>=', $s_birthday_from)
                             ->where('t_patient.p_birthday', '<=', $s_birthday_to);
                } elseif ( ($where['s_p_birthday_year_from'] != 0 && $where['s_p_birthday_month_from'] != 0) && ($where['s_p_birthday_year_to'] != 0 && $where['s_p_birthday_month_to'] != 0) ) {
                    $db = $db->where(function($subquery) use ($where) {
                        $subquery->whereYEAR('t_patient.p_birthday', '>=', $where['s_p_birthday_year_from']);
                        $subquery->whereMONTH('t_patient.p_birthday', '>=', $where['s_p_birthday_month_from']);
                    });
                    $db = $db->where(function($subquery) use ($where) {
                        $subquery->whereYEAR('t_patient.p_birthday', '<=', $where['s_p_birthday_year_to']);
                        $subquery->whereMONTH('t_patient.p_birthday', '<=', $where['s_p_birthday_month_to']);
                    });
                } elseif ( $where['s_p_birthday_year_from'] != 0 && $where['s_p_birthday_year_to'] != 0 ) {
                    $db = $db->whereYEAR('t_patient.p_birthday', '>=', $where['s_p_birthday_year_from'])->whereYEAR('t_patient.p_birthday', '<=', $where['s_p_birthday_year_to']);
                }
            }
            // Y-m-d <= s_t1.p_birthday
            elseif( ($where['s_p_birthday_year_from'] != 0 || $where['s_p_birthday_month_from'] != 0 || $where['s_p_birthday_day_from'] != 0) 
                && ($where['s_p_birthday_year_to'] == 0 && $where['s_p_birthday_month_to'] == 0 && $where['s_p_birthday_day_to'] == 0) )
            {
                if ( $where['s_p_birthday_year_from'] != 0 && $where['s_p_birthday_month_from'] != 0 && $where['s_p_birthday_day_from'] != 0 ) {
                    $s_birthday_from    = $where['s_p_birthday_year_from'] . '-' . $where['s_p_birthday_month_from'] . '-' . $where['s_p_birthday_day_from'];
                    $db = $db->where('t_patient.p_birthday', '>=', $s_birthday_from);
                } elseif ( $where['s_p_birthday_year_from'] != 0 && $where['s_p_birthday_month_from'] != 0 ) {
                    $db = $db->where(function($subquery) use ($where) {
                        $subquery->whereYEAR('t_patient.p_birthday', '>=', $where['s_p_birthday_year_from']);
                        $subquery->whereMONTH('t_patient.p_birthday', '>=', $where['s_p_birthday_month_from']);
                    });
                } elseif ( $where['s_p_birthday_year_from'] != 0 ) {
                    $db = $db->whereYEAR('t_patient.p_birthday', '>=', $where['s_p_birthday_year_from']);
                }
            }
            // s_t1.p_birthday <= Y-m-d
            elseif( ($where['s_p_birthday_year_from'] == 0 && $where['s_p_birthday_month_from'] == 0 && $where['s_p_birthday_day_from'] == 0) 
                && ($where['s_p_birthday_year_to'] != 0 || $where['s_p_birthday_month_to'] != 0 || $where['s_p_birthday_day_to'] != 0) )
            {
                if ( $where['s_p_birthday_year_to'] != 0 && $where['s_p_birthday_month_to'] != 0 && $where['s_p_birthday_day_to'] != 0 ) {
                    $s_birthday_to      = $where['s_p_birthday_year_to'] . '-' . $where['s_p_birthday_month_to'] . '-' . $where['s_p_birthday_day_to'];
                    $db = $db->where('t_patient.p_birthday', '<=', $s_birthday_to);
                } elseif ( $where['s_p_birthday_year_to'] != 0 && $where['s_p_birthday_month_to'] != 0 ) {
                    $db = $db->where(function($subquery) use ($where) {
                        $subquery->whereYEAR('t_patient.p_birthday', '<=', $where['s_p_birthday_year_to']);
                        $subquery->whereMONTH('t_patient.p_birthday', '<=', $where['s_p_birthday_month_to']);
                    });
                } elseif ( $where['s_p_birthday_year_to'] != 0 ) {
                    $db = $db->whereYEAR('t_patient.p_birthday', '<=', $where['s_p_birthday_year_to']);
                }
            }
        }
        // end s_p_birthday

        // s_p_sex_men
        if( !empty($where['s_p_sex_men']) || !empty($where['s_p_sex_women']) )
        {
            $db = $db->where(function($subquery) use ($where) {
                $subquery->where('t_patient.p_sex', $where['s_p_sex_men']);
                $subquery->orWhere('t_patient.p_sex', $where['s_p_sex_women']);
            });
        }

        // s_xray_date
        if ( isset($where['s_xray_date_year_from']) || isset($where['s_xray_date_month_from']) || isset($where['s_xray_date_day_from']) ) {
            // Y-m-d <= s_xray_date <= Y-m-d
            if( ($where['s_xray_date_year_from'] != 0 || $where['s_xray_date_month_from'] != 0 || $where['s_xray_date_day_from'] != 0) 
            && ($where['s_xray_date_year_to'] != 0 || $where['s_xray_date_month_to'] != 0 || $where['s_xray_date_day_to'] != 0) )
            {
                if ( ($where['s_xray_date_year_from'] != 0 && $where['s_xray_date_month_from'] != 0 && $where['s_xray_date_day_from'] != 0) && ($where['s_xray_date_year_to'] != 0 && $where['s_xray_date_month_to'] != 0 && $where['s_xray_date_day_to'] != 0) ) {
                    $s_birthday_from    = $where['s_xray_date_year_from'] . '-' . $where['s_xray_date_month_from'] . '-' . $where['s_xray_date_day_from'];
                    $s_birthday_to      = $where['s_xray_date_year_to'] . '-' . $where['s_xray_date_month_to'] . '-' . $where['s_xray_date_day_to'];
                    $where['s_birthday_from'] = $s_birthday_from;
                    $where['s_birthday_to'] = $s_birthday_to;
                    $db = $db->where(function ($subquery) use ($where) {
                        $subquery->where('t1.xray_date', '>=', $where['s_birthday_from'])->where('t1.xray_date', '<=', $where['s_birthday_to']);
                        $subquery->orWhere('t2.ct_date', '>=', $where['s_birthday_from'])->where('t2.ct_date', '<=', $where['s_birthday_to']);
                    });
                } elseif ( ($where['s_xray_date_year_from'] != 0 && $where['s_xray_date_month_from'] != 0) && ($where['s_xray_date_year_to'] != 0 && $where['s_xray_date_month_to'] != 0) ) {
                    $db = $db->where(function($subquerySum) use ($where) {
                        // xray
                        $subquerySum->where(function($subquery) use ($where) {
                            $subquery->whereYEAR('t1.xray_date', '>=', $where['s_xray_date_year_from']);
                            $subquery->whereMONTH('t1.xray_date', '>=', $where['s_xray_date_month_from']);
                        });
                        $subquerySum->where(function($subquery) use ($where) {
                            $subquery->whereYEAR('t1.xray_date', '<=', $where['s_xray_date_year_to']);
                            $subquery->whereMONTH('t1.xray_date', '<=', $where['s_xray_date_month_to']);
                        });
                        // 3dct
                        $subquerySum->orWhere(function($subquery) use ($where) {
                            $subquery->whereYEAR('t2.ct_date', '>=', $where['s_xray_date_year_from']);
                            $subquery->whereMONTH('t2.ct_date', '>=', $where['s_xray_date_month_from']);
                        });
                        $subquerySum->where(function($subquery) use ($where) {
                            $subquery->whereYEAR('t2.ct_date', '<=', $where['s_xray_date_year_to']);
                            $subquery->whereMONTH('t2.ct_date', '<=', $where['s_xray_date_month_to']);
                        });
                    });
                    
                } elseif ( $where['s_xray_date_year_from'] != 0 && $where['s_xray_date_year_to'] != 0 ) {
                    $db = $db->whereYEAR('t1.xray_date', '>=', $where['s_xray_date_year_from'])->whereYEAR('t1.xray_date', '<=', $where['s_xray_date_year_to']);
                }
            }
            // Y-m-d <= s_xray_date
            elseif( ($where['s_xray_date_year_from'] != 0 || $where['s_xray_date_month_from'] != 0 || $where['s_xray_date_day_from'] != 0) 
                && ($where['s_xray_date_year_to'] == 0 && $where['s_xray_date_month_to'] == 0 && $where['s_xray_date_day_to'] == 0) )
            {
                if ( $where['s_xray_date_year_from'] != 0 && $where['s_xray_date_month_from'] != 0 && $where['s_xray_date_day_from'] != 0 ) {
                    $s_birthday_from    = $where['s_xray_date_year_from'] . '-' . $where['s_xray_date_month_from'] . '-' . $where['s_xray_date_day_from'];
                    $db = $db->where('t1.xray_date', '>=', $s_birthday_from)->orWhere('t2.ct_date', '>=', $s_birthday_from);
                } elseif ( $where['s_xray_date_year_from'] != 0 && $where['s_xray_date_month_from'] != 0 ) {
                    $db = $db->where(function($subquery) use ($where) {
                        $subquery->whereYEAR('t1.xray_date', '>=', $where['s_xray_date_year_from']);
                        $subquery->whereMONTH('t1.xray_date', '>=', $where['s_xray_date_month_from']);
                    });
                    $db = $db->orWhere(function($subquery) use ($where) {
                        $subquery->whereYEAR('t2.ct_date', '>=', $where['s_xray_date_year_from']);
                        $subquery->whereMONTH('t2.ct_date', '>=', $where['s_xray_date_month_from']);
                    });
                } elseif ( $where['s_xray_date_year_from'] != 0 ) {
                    $db = $db->where(function($subquery) use ($where) {
                        $subquery->whereYEAR('t1.xray_date', '<=', $where['s_xray_date_year_from']);
                    });
                    $db = $db->orWhere(function($subquery) use ($where) {
                        $subquery->whereYEAR('t2.ct_date', '<=', $where['s_xray_date_year_from']);
                    });
                }
            }
            // s_xray_date <= Y-m-d
            elseif( ($where['s_xray_date_year_from'] == 0 && $where['s_xray_date_month_from'] == 0 && $where['s_xray_date_day_from'] == 0) 
                && ($where['s_xray_date_year_to'] != 0 || $where['s_xray_date_month_to'] != 0 || $where['s_xray_date_day_to'] != 0) )
            {
                if ( $where['s_xray_date_year_to'] != 0 && $where['s_xray_date_month_to'] != 0 && $where['s_xray_date_day_to'] != 0 ) {
                    $s_birthday_to      = $where['s_xray_date_year_to'] . '-' . $where['s_xray_date_month_to'] . '-' . $where['s_xray_date_day_to'];
                    $db = $db->where('t1.xray_date', '<=', $s_birthday_to)->orWhere('t2.ct_date', '<=', $s_birthday_to);
                } elseif ( $where['s_xray_date_year_to'] != 0 && $where['s_xray_date_month_to'] != 0 ) {
                    $db = $db->where(function($subquery) use ($where) {
                        $subquery->whereYEAR('t1.xray_date', '<=', $where['s_xray_date_year_to']);
                        $subquery->whereMONTH('t1.xray_date', '<=', $where['s_xray_date_month_to']);
                    });
                    $db = $db->orWhere(function($subquery) use ($where) {
                        $subquery->whereYEAR('t2.ct_date', '<=', $where['s_xray_date_year_to']);
                        $subquery->whereMONTH('t2.ct_date', '<=', $where['s_xray_date_month_to']);
                    });
                } elseif ( $where['s_xray_date_year_to'] != 0 ) {
                    $db = $db->where(function($subquery) use ($where) {
                        $subquery->whereYEAR('t1.xray_date', '<=', $where['s_xray_date_year_to']);
                    });
                    $db = $db->orWhere(function($subquery) use ($where) {
                        $subquery->whereYEAR('t2.ct_date', '<=', $where['s_xray_date_year_to']);
                    });
                }
            }
        }
        // end s_xray_date

        $db = $db->orderBy('t_patient.p_id', 'asc');
        if ( $pagination ) {
            $results = $db->simplePaginate(PAGINATION); //simplePaginate, paginate
        } else {
            $results = $db->get();
        }
        return $results;
    }

    public function get_by_patient_id($id_patient)
    {
        $db = DB::table($this->table)
                    ->leftJoin('t_patient', 't_xray.p_id', '=', 't_patient.p_id')
                    ->leftJoin('m_clinic', 't_xray.xray_place', '=', 'm_clinic.clinic_id')
                    ->select('t_xray.*', 't_patient.p_id as p_patient_id', 't_patient.p_no', 't_patient.p_name_f', 't_patient.p_name_g', 't_patient.p_name_f_kana', 't_patient.p_name_g_kana', 't_patient.p_sex', 't_patient.p_birthday', 'm_clinic.clinic_name')
                    ->where('t_xray.p_id', $id_patient)
                    ->where('t_xray.last_kind', '<>', DELETE)
                    ->get();
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
        $results = DB::table($this->table)
                        ->leftJoin('t_patient', 't_xray.p_id', '=', 't_patient.p_id')
                        ->select('t_xray.*', 't_patient.p_id as p_patient_id', 't_patient.p_no', 't_patient.p_name_f', 't_patient.p_name_g', 't_patient.p_name_f_kana', 't_patient.p_name_g_kana', 't_patient.p_sex', 't_patient.p_birthday', 't_patient.p_dr')
                        ->where('t_xray.last_kind', '<>', DELETE)
                        ->where('xray_id', $id)
                        ->first();
        return $results;
    }

    public function update($id, $data)
    {
        $results = DB::table($this->table)->where('xray_id', $id)->update($data);
        return $results;
    }
}