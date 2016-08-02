<?php namespace App\Http\Models\Ortho;

use DB;
use Carbon;
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

    public function get_all($where = array(), $paging = false)
    {
        $db = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->leftJoin('m_clinic', 't_booking.clinic_id', '=', 'm_clinic.clinic_id')
                        ->select('t_booking.*', 't1.p_name', 't1.p_no', 't1.p_name_kana', 'm_clinic.clinic_name')
                        ->where('t_booking.last_kind', '<>', DELETE);

        // where u_id
        if ( isset($where['u_id']) && !empty($where['u_id']) ) {
            $db = $db->where('t_booking.doctor_id', $where['u_id']);
        }
        // where booking_date
        if ( isset($where['booking_date']) && !empty($where['booking_date']) ) {
            $db = $db->where('t_booking.booking_date', $where['booking_date']);
        }

        // where clinic_id
        if ( isset($where['clinic_id']) && !empty($where['clinic_id']) ) {
            $db = $db->where('t_booking.clinic_id', $where['clinic_id']);
        }

        $db = $db->orderBy('t_booking.booking_date', 'asc');

        if ( $paging ) {
            $results = $db->simplePaginate(PAGINATION);
        } else {
            $results = $db->get();
        }

        return $results;
    }

    public function getBookedHistory($where = array())
    {
        $db = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->leftJoin('m_clinic', 't_booking.clinic_id', '=', 'm_clinic.clinic_id')
                        ->select('t_booking.*', 't1.p_name', 't1.p_no', 't1.p_name_kana', 'm_clinic.clinic_name')
                        ->whereNotNull('t_booking.patient_id')
                        ->where('t_booking.last_kind', '<>', DELETE);

        // where u_id
        if ( isset($where['u_id']) && !empty($where['u_id']) ) {
            $db = $db->where('t_booking.doctor_id', $where['u_id']);
        }
        // where booking_date
        if ( isset($where['s_booking_date']) && !empty($where['s_booking_date']) ) {
            $db = $db->where('t_booking.booking_date', $where['s_booking_date']);
        }

        // where clinic_id
        if ( isset($where['s_clinic_id']) && !empty($where['s_clinic_id']) ) {
            $db = $db->where('t_booking.clinic_id', $where['s_clinic_id']);
        }

        $results = $db->groupBy('t_booking.booking_group_id')->orderBy('t_booking.booking_date', 'asc')->simplePaginate(PAGINATION);

        return $results;
    }

    public function countTotal($date, $startTime, $endTime, $patient_id = false, $doctor_id = null)
    {
        $results = DB::table($this->table)
                            ->leftJoin('m_clinic', 't_booking.clinic_id', '=', 'm_clinic.clinic_id')
                            ->select('t_booking.booking_id', 'm_clinic.clinic_name')
                            ->where('m_clinic.clinic_name', '=', 'たい矯正歯科')
                            ->where('booking_date', $date)
                            ->where('booking_start_time', '>=', $startTime)
                            ->where('booking_start_time', '<', $endTime)
                            ->where('t_booking.last_kind', '<>', DELETE);

        if ( $patient_id ) {
            $results = $results->whereNotNull('patient_id');
        }

        if ( !empty($doctor_id) ) {
            $results = $results->where('doctor_id', $doctor_id);
        }
        
        $db = $results->count();
        return $db;
    }

    public function get_all_groupby($where = array(), $paging = false)
    {
        $db = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->leftJoin('m_clinic', 't_booking.clinic_id', '=', 'm_clinic.clinic_id')
                        ->select('t_booking.*', 't1.p_name', 't1.p_no', 't1.p_name_kana', 'm_clinic.clinic_name')
                        ->where('t_booking.last_kind', '<>', DELETE);

        // where u_id
        if ( isset($where['u_id']) && !empty($where['u_id']) ) {
            $db = $db->where('t_booking.doctor_id', $where['u_id']);
        }
        // where booking_date
        if ( isset($where['booking_date']) && !empty($where['booking_date']) ) {
            $db = $db->where('t_booking.booking_date', $where['booking_date']);
        }

        // where clinic_id
        if ( isset($where['s_clinic_id']) && !empty($where['s_clinic_id']) ) {
            $db = $db->where('t_booking.clinic_id', $where['s_clinic_id']);
        }

        $db = $db->groupBy('t_booking.booking_group_id')->orderBy('t_booking.booking_date', 'asc');

        if ( $paging ) {
            $results = $db->simplePaginate(PAGINATION);
        } else {
            $results = $db->get();
        }

        return $results;
    }

    public function get_where($where = array())
    {
        $db = DB::table($this->table)->where('t_booking.last_kind', '<>', DELETE);

        // where booking_group_id
        if ( isset($where['booking_group_id']) && !empty($where['booking_group_id']) ) {
            $db = $db->where('t_booking.booking_group_id', $where['booking_group_id']);
        }
        // where booking_childgroup_id
        if ( isset($where['booking_childgroup_id']) && !empty($where['booking_childgroup_id']) ) {
            $db = $db->where('t_booking.booking_childgroup_id', $where['booking_childgroup_id']);
        }
        // where clinic_id
        if ( isset($where['clinic_id']) && !empty($where['clinic_id']) ) {
            $db = $db->where('t_booking.clinic_id', $where['clinic_id']);
        }

        $db = $db->orderBy('t_booking.booking_childgroup_id', 'asc')->get();

        return $db;
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

    public function get_by_group($booking_group_id = array())
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->whereIn('t_booking.booking_group_id', $booking_group_id)
                        ->orderBy('t_booking.booking_id', 'asc')
                        ->get();
        return $results;
    }

    public function get_by_childGroup($booking_group_id = array())
    {
        $results = DB::table($this->table)
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->whereIn('t_booking.booking_group_id', $booking_group_id)
                        ->orderBy('t_booking.booking_start_time', 'asc')
                        ->get();
        return $results;
    }

    public function get_by_clinic($clinic_id, $date = null)
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.clinic_id', $clinic_id);

        if ( !empty($date) ) {
            $results = $results->where('t_booking.booking_date', $date);
        }

        $results = $results->orderBy('t_booking.booking_id', 'asc')->get();
        return $results;
    }

    public function get_for_update_treatment1($booking_date, $clinic_id, $facility_id, $begingStartTime, $bookingEndTime)
    {
        $results = DB::table($this->table)
                        ->where('last_kind', '<>', DELETE)
                        ->where('booking_date', $booking_date)
                        ->where('clinic_id', $clinic_id)
                        ->where('facility_id', $facility_id)
                        ->where('service_1', -1)
                        ->where('service_1_kind', 2)
                        ->where('booking_start_time', '>=', $begingStartTime)
                        ->where('booking_start_time', '<=', $bookingEndTime)
                        ->orderBy('booking_start_time', 'asc')
                        ->get();
        return $results;
    }

    public function get_blue()
    {
        $results = DB::table($this->table)
                        ->select('booking_id', 'booking_group_id')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.service_1', -1)
                        ->where('t_booking.service_1_kind', 2)
                        ->first();
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

    public function checkExist($where = array())
    {
        $db = DB::table($this->table);

        // booking_start_time
        if ( !empty($where['booking_start_time']) ) {
            $db->where('booking_start_time', $where['booking_start_time']);
        }
        // booking_group_id
        if ( !empty($where['booking_group_id']) ) {
            $db->where('booking_group_id', $where['booking_group_id']);
        }
        // booking_date
        if ( !empty($where['booking_date']) ) {
            $db->where('booking_date', $where['booking_date']);
        }
        // clinic_id
        if ( !empty($where['clinic_id']) ) {
            $db->where('clinic_id', $where['clinic_id']);
        }
        // facility_id
        if ( !empty($where['facility_id']) ) {
            $db->where('facility_id', $where['facility_id']);
        }

        $db = $db->first();
        return $db;
    }

    public function update($id, $data)
    {
    	return DB::table($this->table)->where('booking_id', $id)->update($data);
    }

    public function update_by_bookingDate($booking_date, $data)
    {
        return DB::table($this->table)->where('booking_date', $booking_date)->where('t_booking.last_kind', '<>', DELETE)->update($data);
    }

    public function get_list1_list(){
        return DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->leftJoin('m_clinic as m1', 't_booking.clinic_id', '=', 'm1.clinic_id')
                        ->leftJoin('m_service as ms1', 't_booking.service_1', '=', 'ms1.service_id')
                        ->leftJoin('m_service as ms2', 't_booking.service_2', '=', 'ms2.service_id')
                        ->select('t_booking.*', 't1.p_name', 't1.p_no', 't1.p_tel', 'm1.clinic_name', 'ms1.service_name', 'ms2.service_name')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.booking_status', '=', 1)
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

    public function get_list3_list($where = array()){
        $db = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->join('t_result as t2', 't_booking.patient_id', '=', 't2.patient_id')
                        ->leftJoin('m_clinic as m1', 't_booking.clinic_id', '=', 'm1.clinic_id')
                        // ->leftJoin('m_service as ms1', 't_booking.service_1', '=', 'ms1.service_id')
                        // ->leftJoin('m_service as ms2', 't_booking.service_2', '=', 'ms2.service_id')
                        ->select('t_booking.*', 't1.p_name', 't1.p_no', 't1.p_tel', 'm1.clinic_name', 't2.result_date', 't2.result_memo')
                        ->where('t_booking.last_kind', '<>', DELETE);

        if ( !empty($where['booking_recall_yy']) && !empty($where['booking_recall_mm']) ) {
            $db = $db->whereYEAR('t_booking.booking_recall_ym', '=', $where['booking_recall_yy'])
                    ->whereMONTH('t_booking.booking_recall_ym', '=', $where['booking_recall_mm']);
        } elseif ( !empty($where['booking_recall_yy']) && empty($where['booking_recall_mm']) ) {
            $db = $db->whereYEAR('t_booking.booking_recall_ym', '=', $where['booking_recall_yy']);
        } elseif ( empty($where['booking_recall_yy']) && !empty($where['booking_recall_mm']) ) {
            $db = $db->whereMONTH('t_booking.booking_recall_ym', '=', $where['booking_recall_mm']);
        }
        
        $db = $db->orderBy('t2.result_date', 'desc')->get();
        return $db;
    }

    public function get_list4_list($booking_status = 4){
        $db = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->join('t_result as t2', 't_booking.patient_id', '=', 't2.patient_id')
                        ->leftJoin('m_clinic as m1', 't_booking.clinic_id', '=', 'm1.clinic_id')
                        // ->leftJoin('m_service as ms1', 't_booking.service_1', '=', 'ms1.service_id')
                        // ->leftJoin('m_service as ms2', 't_booking.service_2', '=', 'ms2.service_id')
                        ->select('t_booking.*', 't1.p_name', 't1.p_no', 't1.p_tel', 'm1.clinic_name', 't2.result_date', 't2.result_memo')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.booking_status', $booking_status);
        
        $db = $db->orderBy('t2.result_date', 'desc')->get();
        return $db;
    }

    //search booking list
    public function get_booking_list($where = null){
        $db =  DB::table($this->table)
                        ->leftJoin('t_facility as tf1', 't_booking.facility_id', '=', 'tf1.facility_id')
                        ->select('t_booking.booking_id', 't_booking.patient_id', 't_booking.booking_date', 't_booking.booking_start_time', 't_booking.booking_total_time', 't_booking.facility_id', 't_booking.facility_id', 't_booking.service_1', 't_booking.service_1_kind', 't_booking.service_2', 't_booking.service_2_kind','t_booking.doctor_id','t_booking.hygienist_id', 'tf1.facility_id', 'tf1.facility_name', 't_booking.clinic_id', 't_booking.booking_group_id')
                        ->where('t_booking.last_kind', '<>', DELETE);

        if(isset($where['clinic_id'])){
            $result = $db->where('t_booking.clinic_id', '=', $where['clinic_id']);
        }

        if(isset($where['doctor_id'])){
            $doctor_id = $where['doctor_id'];
            $result = $db->whereIn('t_booking.doctor_id', $doctor_id);
        }

        if(isset($where['hygienist_id'])){
            $hygienist_id = $where['hygienist_id'];
            $result = $db->whereIn('t_booking.hygienist_id', $hygienist_id);
        }

        if(isset($where['booking_date'])){
            $result = $db->whereIn(DB::raw("DAYOFWEEK(booking_date)"), $where['booking_date']);
        }

        if(isset($where['week_later'])){
            if($where['week_later'] == 'one_week'){
                $result = $db->whereBetween('t_booking.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'two_week'){
                $result = $db->whereBetween('t_booking.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'three_week'){
                $result = $db->whereBetween('t_booking.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'four_week'){
                $result = $db->whereBetween('t_booking.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'five_week'){
                $result = $db->whereBetween('t_booking.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'one_month'){
                $result = $db->whereBetween('t_booking.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'two_month'){
                $result = $db->whereBetween('t_booking.booking_date', weeklater($where['week_later']));
            }else{
                $result = $db->whereDate('t_booking.booking_date', '=', $where['week_later']);
            }
        }else{
            $dateNow = formatDate(Carbon::now()->toDateTimeString(), '-');
            $result = $db->whereDate('booking_date', '>=', $dateNow);
        }

        if(isset($where['clinic_service_name'])){
            $sk = explode('_', $where['clinic_service_name']);
            $service          = $sk[0];
            $s_kind            = str_split($sk[1], 2);
            $service_kind     = $s_kind[1];

            if($service_kind == 1){
                $result = $db->where('t_booking.service_1', '=', $service)
                ->where('t_booking.service_1_kind', '=', $service_kind);
                $result = $db->orWhere('t_booking.service_2', '=', $service)
                ->where('t_booking.service_2_kind', '=', $service_kind);
            }

            if($service_kind == 2){
                $split = explode('#', $service);
                $treatment_id = $split[0];
                $treatment_time = $split[1];

                $result = $db->where('t_booking.service_1', '=', '-1')
                ->where('t_booking.service_1_kind', '=', $service_kind);
                $result = $db->orWhere('t_booking.service_2', '=', '-1')
                ->where('t_booking.service_2_kind', '=', $service_kind);
            }
        }

        if(isset($where['clinic_service_name']) && $service_kind == 2){
            return $db->orderBy('t_booking.booking_id', 'asc')->simplePaginate(PAGINATION);
        }else{
            return $db->groupBy('booking_group_id')->orderBy('t_booking.booking_id', 'asc')->simplePaginate(PAGINATION);
        }
    }

    /**
     * get booking by patient id
    */
    public function getBookByPatientID($p_id=null){
        return DB::table($this->table)
                                ->leftJoin('m_clinic as cl', 't_booking.clinic_id', '=', 'cl.clinic_id')
                                ->leftJoin('t_patient as pt', 't_booking.patient_id', '=', 'pt.p_id')
                                ->leftJoin('t_facility as fl', 't_booking.facility_id', '=', 'fl.facility_id')
                                ->leftJoin('m_insurance as insu', 't_booking.insurance_id', '=', 'insu.insurance_id')
                                ->leftJoin('m_inspection as insp', 't_booking.inspection_id', '=', 'insp.inspection_id')
                                ->leftJoin('m_equipment as equi', 't_booking.equipment_id', '=', 'equi.equipment_id')
                                ->select('t_booking.*', 'cl.clinic_name', 'pt.p_no', 'pt.p_name','fl.facility_name','insu.insurance_name', 'insp.inspection_name','equi.equipment_name')
                                ->where('t_booking.last_kind', '<>', DELETE)
                                ->where('t_booking.patient_id', '=', $p_id)
                                ->where('t_booking.booking_date', '>=', 'NOW()')
                                ->orderBy('t_booking.booking_date', 'asc')
                                ->limit(2)
                                ->get();
    }

    public static function checkExistID($id){
        if (DB::table('t_booking')
                    ->where('last_kind', '<>', DELETE)
                    ->where('booking_id', '=', $id)
                    ->exists()) {
            return true;
        }else{
            return false;
        }
    }
}