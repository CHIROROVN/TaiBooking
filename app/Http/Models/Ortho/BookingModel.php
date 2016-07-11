<?php namespace App\Http\Models\Ortho;

use DB;

class BookingModel
{

    protected $table = 't_booking';

    public function Rules()
    {
    	return array(
    		// 'q1_1_sei'      => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
      //       'q1_1_mei'      => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
      //       'q1_2_sei'      => 'required',
      //       'q1_2_mei'      => 'required',
      //       'q1_6'          => 'required',
      //       'q1_9'          => 'required|email',
		);
    }

    public function Messages()
    {
    	return array(
            // 'q1_1_sei.required'     => trans('validation.error_q1_1_sei_required'),
            // 'q1_1_sei.regex'        => trans('validation.error_q1_1_sei_regex'),
            // 'q1_1_mei.required'     => trans('validation.error_q1_1_mei_required'),
            // 'q1_1_mei.regex'        => trans('validation.error_q1_1_mei_regex'),
            // 'q1_2_sei.required'     => trans('validation.error_q1_2_sei_required'),
            // 'q1_2_mei.required'     => trans('validation.error_q1_2_mei_required'),
            // 'q1_6.required'         => trans('validation.error_q1_6_required'),
            // 'q1_9.required'         => trans('validation.error_q1_9_required'),
            // 'q1_9.email'            => trans('validation.error_q1_9_email'),
		);
    }

    public function get_all($where = array())
    {
        $db = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name')
                        ->where('t_booking.last_kind', '<>', DELETE);
        
        // where clinic_id
        if ( isset($where['s_clinic_id']) && $where['s_clinic_id'] != 0 ) {
            $results = $db->where('t_booking.clinic_id', $where['s_clinic_id']);
        }
        // where u_id
        if ( isset($where['s_u_id']) && $where['s_u_id'] != 0 ) {
            $results = $db->where('t_booking.doctor_id', $where['s_u_id'])
                          ->orWhere('t_booking.hygienist_id', $where['s_u_id']);
        }

        $results = $db->orderBy('t_booking.booking_id', 'asc')->get();
        return $results;
    }

    public function get_by_today()
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.booking_date', date('Y-m-d'))
                        ->orderBy('t_booking.booking_id', 'asc')
                        ->get();
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
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->leftJoin('m_clinic as t2', 't_booking.clinic_id', '=', 't2.clinic_id')
                        ->leftJoin('t_facility as t3', 't_booking.facility_id', '=', 't3.facility_id')
                        ->leftJoin('m_equipment as t4', 't_booking.equipment_id', '=', 't4.equipment_id')
                        ->leftJoin('m_inspection as t5', 't_booking.inspection_id', '=', 't5.inspection_id')
                        ->leftJoin('m_insurance as t6', 't_booking.insurance_id', '=', 't6.insurance_id')
                        ->select('t_booking.*', 't1.p_no', 't1.p_name', 't2.clinic_name', 't3.facility_name', 't4.equipment_name', 't5.inspection_name', 't6.insurance_name')
                        ->where('booking_id', $id)
                        ->first();
        return $results;
    }

    public function update($id, $data)
    {
    	return DB::table($this->table)->where('booking_id', $id)->update($data);
    }

    public function get_list1_list(){
        return DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->leftJoin('m_clinic as m1', 't_booking.clinic_id', '=', 'm1.clinic_id')
                        ->leftJoin('m_service as ms1', 't_booking.service_1', '=', 'ms1.service_id')
                        ->leftJoin('m_service as ms2', 't_booking.service_2', '=', 'ms2.service_id')
                        ->select('t_booking.*', 't1.p_name', 't1.p_no', 't1.p_tel', 'm1.clinic_name', 'ms1.service_name', 'ms2.service_name')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.booking_status', '=', '1')
                        ->orderBy('t_booking.booking_id', 'asc')
                        ->get();
    }

    public function get_list2_list($where = array()){
        $db = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->join('t_result as t2', 't_booking.patient_id', '=', 't2.patient_id')
                        ->leftJoin('m_clinic as m1', 't_booking.clinic_id', '=', 'm1.clinic_id')
                        // ->leftJoin('m_service as ms1', 't_booking.service_1', '=', 'ms1.service_id')
                        // ->leftJoin('m_service as ms2', 't_booking.service_2', '=', 'ms2.service_id')
                        ->select('t_booking.*', 't1.p_name', 't1.p_no', 't1.p_tel', 'm1.clinic_name', 't2.result_date', 't2.result_memo')
                        ->where('t_booking.last_kind', '<>', DELETE);

        if ( !empty($where['booking_date_year']) && !empty($where['booking_date_month']) ) {
            $db = $db->whereYEAR('t_booking.booking_date', '=', $where['booking_date_year'])
                    ->whereMONTH('t_booking.booking_date', '=', $where['booking_date_month']);
        } elseif ( !empty($where['booking_date_year']) && empty($where['booking_date_month']) ) {
            $db = $db->whereYEAR('t_booking.booking_date', '=', $where['booking_date_year']);
        } elseif ( empty($where['booking_date_year']) && !empty($where['booking_date_month']) ) {
            $db = $db->whereMONTH('t_booking.booking_date', '=', $where['booking_date_month']);
        }
        
        $db = $db->orderBy('t2.result_date', 'desc')->get();
        return $db;
    }

    public function get_booking_list($where = null){
        $db =  DB::table($this->table)
                                ->leftJoin('t_facility as tf1', 't_booking.facility_id', '=', 'tf1.facility_id')
                                ->select('t_booking.booking_id', 't_booking.patient_id', 't_booking.booking_date', 't_booking.booking_start_time', 't_booking.booking_total_time', 't_booking.facility_id', 't_booking.facility_id', 't_booking.service_1', 't_booking.service_1_kind', 't_booking.service_2', 't_booking.service_2_kind','t_booking.doctor_id','t_booking.hygienist_id', 'tf1.facility_id', 'tf1.facility_name')
                                //->select('t_booking.*', 'tf1.*')
                                ->where('t_booking.last_kind', '<>', DELETE);

        if(isset($where['clinic_id'])){
            $result = $db->where('t_booking.clinic_id', '=', $where['clinic_id']);
        }

        if(isset($where['doctor_id'])){
            $doctor_id = $where['doctor_id'];
            $result = $db->where('t_booking.doctor_id', function($subQuery) use ($doctor_id){
                $subQuery->select('t_booking.doctor_id')->whereIn('t_booking.doctor_id', $doctor_id);
            });
        }

        if(isset($where['hygienist_id'])){
            $hygienist_id = $where['hygienist_id'];
            $result = $db->where('t_booking.hygienist_id', function($subQuery) use ($hygienist_id){
                $subQuery->select('t_booking.hygienist_id')->whereIn('t_booking.hygienist_id', $hygienist_id);
            });
        }

        if(isset($where['booking_date'])){
            $booking_date = $where['booking_date'];
            $result = $db->where('t_booking.booking_date', function($subQuery) use ($booking_date){
                $subQuery->select('t_booking.booking_date')->whereIn('t_booking.booking_date', $booking_date);
            });
        }

        if(isset($where['week_later'])){
            if($where['week_later'] == 'one_week'){
               $week_later = date('Y-m-d', strtotime(date("Y-m-d").' + 1 week'));
               $result = $db->whereDate('t_booking.booking_date', '<=', $week_later);
            }elseif($where['week_later'] == 'two_week'){
                $week_later = date('Y-m-d', strtotime(date("Y-m-d").' + 2 week'));
                $result = $db->whereDate('t_booking.booking_date', '<=', $week_later);
            }elseif($where['week_later'] == 'three_week'){
                $week_later = date('Y-m-d', strtotime(date("Y-m-d").' + 3 week'));
                $result = $db->whereDate('t_booking.booking_date', '<=', $week_later);
            }elseif($where['week_later'] == 'four_week'){
                $week_later = date('Y-m-d', strtotime(date("Y-m-d").' + 4 week'));
                $result = $db->whereDate('t_booking.booking_date', '<=', $week_later);
            }elseif($where['week_later'] == 'five_week'){
                $week_later = date('Y-m-d', strtotime(date("Y-m-d").' + 5 week'));
                $result = $db->whereDate('t_booking.booking_date', '<=', $week_later);
            }elseif($where['week_later'] == 'one_month'){
                $month_later = date('Y-m-d', strtotime(date("Y-m-d").' + 1 month'));
                $result = $db->whereDate('t_booking.booking_date', '<=', $month_later);
            }elseif($where['week_later'] == 'two_month'){
                $two_month_later = date('Y-m-d', strtotime(date("Y-m-d").' + 2 month'));
                $result = $db->whereDate('t_booking.booking_date', '<=', $two_month_later);
            }
        }

        if(isset($where['clinic_service_name'])){

            $sk = explode('_', $where['clinic_service_name']);
            $service          = $sk[0];
            $s_kind            = str_split($sk[1], 3);
            $service_kind     = $s_kind[1];

            if($service_kind == 1){
                $result = $db->where('t_booking.service_1', '=', $service)
                ->where('t_booking.service_1_kind', '=', $service_kind);
                $result = $db->orWhere('t_booking.service_2', '=', $service)
                ->where('t_booking.service_2_kind', '=', $service_kind);
            }

            if($service_kind == 2){
                $result = $db->where('t_booking.service_1', '=', $service)
                ->where('t_booking.service_1_kind', '=', $service_kind);
                $result = $db->orWhere('t_booking.service_2', '=', $service)
                ->where('t_booking.service_2_kind', '=', $service_kind);
            }
        }

        return $db->orderBy('t_booking.booking_id', 'asc')->simplePaginate();

    }
}