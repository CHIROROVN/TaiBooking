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
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g', 't1.p_no', 't1.p_name_f_kana', 't1.p_name_g_kana', 'm_clinic.clinic_name')
                        ->where('t_booking.last_kind', '<>', DELETE);
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev());

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
                        ->leftJoin('m_equipment as t4', 't_booking.equipment_id', '=', 't4.equipment_id')
                        ->leftJoin('m_inspection as t5', 't_booking.inspection_id', '=', 't5.inspection_id')
                        ->leftJoin('m_insurance as t6', 't_booking.insurance_id', '=', 't6.insurance_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g', 't1.p_no', 't1.p_name_f_kana', 't1.p_name_g_kana', 'm_clinic.clinic_name', 't4.equipment_name', 't5.inspection_name', 't6.insurance_name')
                        ->whereNotNull('t_booking.patient_id')
                        ->where('t_booking.last_kind', '<>', DELETE);
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev());

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

        // where s_p_id
        if ( isset($where['s_p_id']) && !empty($where['s_p_id']) ) {
            $db = $db->where('t_booking.patient_id', $where['s_p_id']);
        }

        //$results = $db->orderBy('t_booking.booking_date', 'asc')->simplePaginate(PAGINATION);
        $results = $db->orderBy('t_booking.booking_date', 'asc')->get();

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
                            // ->where('t_booking.booking_rev', $this->getLastBookingRev());

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
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g', 't1.p_no', 't1.p_name_f_kana', 't1.p_name_g_kana', 'm_clinic.clinic_name')
                        ->where('t_booking.last_kind', '<>', DELETE);
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev());

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

    public function get_where($where = array(), $lastBookingVer = true, $orderBy = 'booking_childgroup_id')
    {
        $db = DB::table($this->table)->where('t_booking.last_kind', '<>', DELETE);

        // where booking_group_id
        if ( isset($where['booking_group_id']) ) {
        $db = $db->where('t_booking.booking_group_id', $where['booking_group_id']);
        }
        
        // where booking_childgroup_id
        if ( isset($where['booking_childgroup_id']) ) {
            $db = $db->where('t_booking.booking_childgroup_id', $where['booking_childgroup_id']);
        }
        
        // where clinic_id
        if ( isset($where['clinic_id']) && !empty($where['clinic_id']) ) {
            $db = $db->where('t_booking.clinic_id', $where['clinic_id']);
        }
        // where booking_date
        if ( isset($where['booking_date']) && !empty($where['booking_date']) ) {
            $db = $db->where('t_booking.booking_date', $where['booking_date']);
        }
        // where facility_id
        if ( isset($where['facility_id']) && !empty($where['facility_id']) ) {
            $db = $db->where('t_booking.facility_id', $where['facility_id']);
        }

        // where booking_free1
        if ( isset($where['booking_free1']) && !empty($where['booking_free1']) ) {
            $db = $db->where('t_booking.booking_free1', $where['booking_free1']);
        }

        // where booking_start_time
        if ( isset($where['booking_start_time']) && !empty($where['booking_start_time']) ) {
            $db = $db->where('t_booking.booking_start_time', $where['booking_start_time']);
        }

        $db = $db->orderBy($orderBy, 'asc')->get();

        return $db;
    }

    public function get_where_single($where = array())
    {
        $db = DB::table($this->table)->where('t_booking.last_kind', '<>', DELETE);
                                        // ->where('t_booking.booking_rev', $this->getLastBookingRev());

        // where clinic_id
        if ( isset($where['clinic_id']) && !empty($where['clinic_id']) ) {
            $db = $db->where('t_booking.clinic_id', $where['clinic_id']);
        }
        // where booking_date
        if ( isset($where['booking_date']) && !empty($where['booking_date']) ) {
            $db = $db->where('t_booking.booking_date', $where['booking_date']);
        }
        // where booking_start_time
        if ( isset($where['booking_start_time']) && !empty($where['booking_start_time']) ) {
            $db = $db->where('t_booking.booking_start_time', $where['booking_start_time']);
        }
        // where facility_id
        if ( isset($where['facility_id']) && !empty($where['facility_id']) ) {
            $db = $db->where('t_booking.facility_id', $where['facility_id']);
        }

        $db = $db->orderBy('t_booking.booking_childgroup_id', 'asc')->first();

        return $db;
    }

    public function get_by_today()
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.booking_date', date('Y-m-d'))
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                        ->groupBy('t_booking.patient_id')
                        ->orderBy('t_booking.booking_id', 'asc')
                        ->get();
        return $results;
    }

    public function get_by_group($booking_group_id = array())
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                        ->whereIn('t_booking.booking_group_id', $booking_group_id)
                        ->orderBy('t_booking.booking_start_time', 'asc')
                        ->get();
        return $results;
    }

    public function get_by_child_group($booking_childgroup_id=null, $patient_id=null, $facility_id=null, $booking_group_id=null, $booking_status=null)
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                        ->where('t_booking.booking_childgroup_id', $booking_childgroup_id)
                        ->orderBy('t_booking.booking_id', 'asc')
                        ->get();
        if(!empty($patient_id)){
            $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.patient_id', $patient_id)
                        ->where('t_booking.booking_group_id', $booking_group_id)
                        ->where('t_booking.facility_id', $facility_id)
                        ->where('t_booking.booking_childgroup_id', $booking_childgroup_id)
                        ->orderBy('t_booking.booking_id', 'asc')
                        ->get();
        }

        return $results;
    }

    public function get_by_child_group2($old_patient_id=null, $old_booking_group_id=null, $old_booking_childgroup_id=null, $old_facility_id=null, $old_start_time)
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking.last_kind', '<>', DELETE);

        if(!empty($old_booking_group_id)){
            $results = $results->where('t_booking.booking_group_id', $old_booking_group_id);
        }

        if(!empty($old_booking_childgroup_id)){
            $results = $results->where('t_booking.booking_childgroup_id', $old_booking_childgroup_id);
        }

        if(!empty($old_facility_id)){
            $results = $results->where('t_booking.facility_id', $old_facility_id);
        }

        if(!empty($old_patient_id)){
            $results = $results->where('t_booking.patient_id', $old_patient_id);
        }

        if(!empty($old_start_time)){
            $results = $results->where('t_booking.booking_start_time', '>=' , $old_start_time);
        }
                        
        return $results->orderBy('t_booking.booking_id', 'asc')->get();
    }


    public function get_by_child_group_list2($clinic_id=null, $bk_booking_date=null, $booking_start_time, $bk_child_group=null, $patient_id=null, $facility_id=null, $booking_group_id=null, $booking_status=null, $booking_end_time=null)
    {

        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.clinic_id', $clinic_id);

        if(!empty($bk_booking_date)){
            $results = $results->where('t_booking.booking_date', '=', $bk_booking_date);
        }

        if(!empty($booking_start_time)){
            $results = $results->where('t_booking.booking_start_time', '>=', $booking_start_time);
        }

        if(!empty($patient_id)){
            $results = $results->where('t_booking.patient_id', '=', $patient_id);
        }

        if(!empty($booking_group_id)){
            $results = $results->where('t_booking.booking_group_id', '=', $booking_group_id);
        }

        if(!empty($bk_child_group)){
            $results = $results->where('t_booking.booking_childgroup_id', '=' ,$bk_child_group);
        }

        if(!empty($facility_id)){
            $results = $results->where('t_booking.facility_id', '=', $facility_id);
        }

        if(!empty($booking_status)){
            $results = $results->where('t_booking.booking_status', '=', $booking_status);
        }

        if(!empty($booking_end_time)){
            $results = $results->where('t_booking.booking_start_time', '<', $booking_end_time);
        }

        return $results->orderBy('t_booking.booking_id', 'asc')->get();

    }
 
    public function get_new_booking_child_group($new_booking_date=null, $new_start_time=null, $new_facility_id=null, $new_booking_group=null, $new_booking_childgroup_id=null, $new_service_1=null, $new_service_1_kind=null, $limit=null)
    {
            $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking.last_kind', '<>', DELETE);

            if(!empty($new_booking_date)){
                $results = $results->where('t_booking.booking_date','=' , $new_booking_date);
            }
           
            if(!empty($new_booking_group)){
                $results = $results->where('t_booking.booking_group_id','=' , $new_booking_group);
            }

            if(!empty($new_booking_childgroup_id)){
                $results = $results->where('t_booking.booking_childgroup_id','=' , $new_booking_childgroup_id);
            }

            if(!empty($new_start_time)){
                $results = $results->where('t_booking.booking_start_time', '>=', $new_start_time);
            }

            if(!empty($new_facility_id)){
                $results = $results->where('t_booking.facility_id', $new_facility_id);
            }

            if(!empty($new_service_1)){
                $results = $results->where('t_booking.service_1', $new_service_1);
            }

            if(!empty($new_service_1_kind)){
                $results = $results->where('t_booking.service_1_kind', $new_service_1_kind);
            }

            $results = $results->orderBy('t_booking.booking_date', 'asc')
                        ->orderBy('t_booking.booking_start_time', 'asc')
                        ->limit($limit)
                        ->get();
        return $results;
    }

    public function get_new_booking_child_group2($new_booking_date=null, $booking_start_time=null, $service_1_kind=null, $new_facility_id=null, $new_booking_group_id=null, $new_booking_childgroup_id=null, $hhmmBookingEndTime=null)
    {
        $results = DB::table($this->table)
                        ->select('t_booking.*')
                        ->where('t_booking.last_kind', '<>', DELETE);

        if(!empty($service_1_kind)){
            if($service_1_kind == 1){
                $results = $results->where('t_booking.service_1_kind', '=', $service_1_kind);
            }else{
                $results = $results->where('t_booking.service_1', '=', -1);
                $results = $results->where('t_booking.service_1_kind', '=', $service_1_kind);
            }          
        }

        if(!empty($new_booking_group_id)){
            $results = $results->where('t_booking.booking_group_id', '=', $new_booking_group_id);
        }

        if(!empty($new_booking_childgroup_id)){
            $results = $results->where('t_booking.booking_childgroup_id', '=', $new_booking_childgroup_id);
        }

        if(!empty($new_facility_id)){
            $results = $results->where('t_booking.facility_id', '=', $new_facility_id);
        }

        if(!empty($booking_start_time)){
            $results = $results->where('t_booking.booking_start_time', '>=', $booking_start_time);
        }

        if(!empty($new_booking_date)){
            $results = $results->where('t_booking.booking_date', '=', $new_booking_date);
        }

        if(!empty($hhmmBookingEndTime)){
            $results = $results->where('t_booking.booking_start_time', '<', $hhmmBookingEndTime);
        }

        $results = $results->orderBy('t_booking.booking_date', 'asc')
                        ->orderBy('t_booking.booking_start_time', 'asc')
                        ->get();
        return $results;
    }


    public function get_recall_booking_child_group($new_booking_group_id=null, $new_booking_childgroup_id=null)
    {
            $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.booking_group_id','=' , $new_booking_group_id)
                        ->where('t_booking.booking_childgroup_id','=' , $new_booking_childgroup_id)
                        ->orderBy('t_booking.booking_date', 'asc')
                        ->orderBy('t_booking.booking_start_time', 'asc')
                        ->get();
        return $results;
    }

    public function get_by_childGroup($booking_group_id = array())
    {
        $results = DB::table($this->table)
                        ->where('t_booking.last_kind', '<>', DELETE)
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                        ->whereIn('t_booking.booking_group_id', $booking_group_id)
                        ->orderBy('t_booking.booking_start_time', 'asc')
                        ->get();
        return $results;
    }

    public function get_by_clinic($clinic_id, $date = null)
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
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
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                        ->where('booking_date', $booking_date)
                        ->where('clinic_id', $clinic_id)
                        ->where('facility_id', $facility_id)
                        // ->where('service_1', -1)
                        ->where('service_1_kind', 2)
                        ->where('booking_start_time', '>=', $begingStartTime)
                        ->where('booking_start_time', '<', $bookingEndTime)
                        ->orderBy('booking_start_time', 'asc')
                        ->get();
        return $results;
    }

    public function get_blue()
    {
        $results = DB::table($this->table)
                        ->select('booking_id', 'booking_group_id')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
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
                        ->select('t_booking.*', 't1.p_no', 't1.p_name_f', 't1.p_name_g', 't2.clinic_name', 't3.facility_name', 't4.equipment_name', 't5.inspection_name', 't6.insurance_name')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                        ->where('booking_id', $id)
                        ->first();
        return $results;
    }

    public function checkExist($where = array())
    {
        $db = DB::table($this->table)->where('t_booking.last_kind', '<>', DELETE);
                                        // ->where('t_booking.booking_rev', $this->getLastBookingRev());

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
        return DB::table($this->table)->where('t_booking.last_kind', '<>', DELETE)->where('booking_id', $id)->update($data);
    }

    public function update_by_bookingDate($booking_date, $linic_id, $data)
    {
        return DB::table($this->table)->where('booking_date', $booking_date)->where('clinic_id', $linic_id)->where('t_booking.last_kind', '<>', DELETE)
                                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                                        ->update($data);
    }

    // public function get_list1_list(){
    //  return DB::table($this->table)
    //                  ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
    //                  ->leftJoin('m_clinic as m1', 't_booking.clinic_id', '=', 'm1.clinic_id')
    //                  ->leftJoin('t_result as t2', 't_booking.patient_id', '=', 't2.patient_id')
    //                  // ->leftJoin('m_service as ms1', 't_booking.service_1', '=', 'ms1.service_id')
    //                  // ->leftJoin('m_service as ms2', 't_booking.service_2', '=', 'ms2.service_id')
    //                  ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g', 't1.p_no', 't1.p_tel', 'm1.clinic_name', 't2.result_date', 't2.result_memo')
    //                  ->where('t_booking.last_kind', '<>', DELETE)
    //                  // ->where('t_booking.booking_rev', $this->getLastBookingRev())
    //                  ->where('t_booking.booking_status', '=', 1)
    //                  ->orderBy('t_booking.booking_date', 'desc')
    //                  ->groupBy('t_booking.booking_childgroup_id')
    //                  ->get();
    // }

    public function get_list2_list($where = array()){
        $db = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->leftJoin('t_result as t2', 't_booking.patient_id', '=', 't2.patient_id')
                        ->leftJoin('m_clinic as m1', 't_booking.clinic_id', '=', 'm1.clinic_id')
                        // ->leftJoin('m_service as ms1', 't_booking.service_1', '=', 'ms1.service_id')
                        // ->leftJoin('m_service as ms2', 't_booking.service_2', '=', 'ms2.service_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g', 't1.p_no', 't1.p_tel', 'm1.clinic_name', 't2.result_date', 't2.result_memo')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                        ->where('t_booking.booking_status', '=', 2);

        if ( !empty($where['booking_date_year']) && !empty($where['booking_date_month']) ) {
            $db = $db->whereYEAR('t_booking.booking_date', '=', $where['booking_date_year'])
                    ->whereMONTH('t_booking.booking_date', '=', $where['booking_date_month']);
        } elseif ( !empty($where['booking_date_year']) && empty($where['booking_date_month']) ) {
            $db = $db->whereYEAR('t_booking.booking_date', '=', $where['booking_date_year']);
        } elseif ( empty($where['booking_date_year']) && !empty($where['booking_date_month']) ) {
            $db = $db->whereMONTH('t_booking.booking_date', '=', $where['booking_date_month']);
        }

        $db = $db->groupBy('t_booking.booking_childgroup_id')->orderBy('t2.result_date', 'desc')->get();
        return $db;
    }

    public function get_list2_list_by_patient_id($patient_id){
        return DB::table($this->table)
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.patient_id', $patient_id)
                        ->where('t_booking.booking_status', '=', 2)
                        ->first();
    }

    // public function get_list3_list($where = array()){
    //  $db = DB::table($this->table)
    //                  ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
    //                  ->leftJoin('t_result as t2', 't_booking.patient_id', '=', 't2.patient_id')
    //                  ->leftJoin('m_clinic as m1', 't_booking.clinic_id', '=', 'm1.clinic_id')
    //                  // ->leftJoin('m_service as ms1', 't_booking.service_1', '=', 'ms1.service_id')
    //                  // ->leftJoin('m_service as ms2', 't_booking.service_2', '=', 'ms2.service_id')
    //                  ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g', 't1.p_no', 't1.p_tel', 'm1.clinic_name', 't2.result_date', 't2.result_memo')
    //                  ->where('t_booking.last_kind', '<>', DELETE)
    //                  // ->where('t_booking.booking_rev', $this->getLastBookingRev());
    //                  ->where('t_booking.booking_status', 3);


    //  if ( !empty($where['booking_recall_yy']) && !empty($where['booking_recall_mm']) ) {
    //      $db = $db->where('t_booking.booking_recall_ym', 'like', $where['booking_recall_yy'] . '%')
    //              ->where('t_booking.booking_recall_ym', 'like', '%' . $where['booking_recall_mm']);
    //  } elseif ( !empty($where['booking_recall_yy']) && empty($where['booking_recall_mm']) ) {
    //      $db = $db->where('t_booking.booking_recall_ym', 'like', $where['booking_recall_yy'] . '%');
    //  } elseif ( empty($where['booking_recall_yy']) && !empty($where['booking_recall_mm']) ) {
    //      $db = $db->where('t_booking.booking_recall_ym', 'like', '%' . $where['booking_recall_mm']);
    //  }

    //  $db = $db->groupBy('t_booking.booking_childgroup_id')->orderBy('t2.result_date', 'desc')->get();
    //  return $db;
    // }

    public function get_list4_list($booking_status = 4){
        $db = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->leftJoin('t_result as t2', 't_booking.patient_id', '=', 't2.patient_id')
                        ->leftJoin('m_clinic as m1', 't_booking.clinic_id', '=', 'm1.clinic_id')
                        // ->leftJoin('m_service as ms1', 't_booking.service_1', '=', 'ms1.service_id')
                        // ->leftJoin('m_service as ms2', 't_booking.service_2', '=', 'ms2.service_id')
                        ->select('t_booking.*', 't1.p_name_f', 't1.p_name_g', 't1.p_no', 't1.p_tel', 'm1.clinic_name', 't2.result_date', 't2.result_memo')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                        ->where('t_booking.booking_status', $booking_status);
        
        $db = $db->groupBy('t_booking.booking_childgroup_id')->orderBy('t2.result_date', 'desc')->get();
        return $db;
    }

    public function get_list4_list_by_patient_id($patient_id){
        return DB::table($this->table)
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.patient_id', $patient_id)
                        ->where('t_booking.booking_status', '=', 4)
                        ->first();
    }

    public function get_list5_list_by_patient_id($patient_id){
        return DB::table($this->table)
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->where('t_booking.patient_id', $patient_id)
                        ->where('t_booking.booking_status', '=', 5)
                        ->first();
    }

    //search booking list
    public function get_booking_list($where = null){
        $db =  DB::table($this->table)
                        ->leftJoin('t_facility as tf1', 't_booking.facility_id', '=', 'tf1.facility_id')
                        ->select('t_booking.booking_id', 't_booking.patient_id', 't_booking.booking_date', 't_booking.booking_start_time', 't_booking.booking_total_time', 't_booking.facility_id', 't_booking.facility_id', 't_booking.service_1', 't_booking.service_1_kind', 't_booking.service_2', 't_booking.service_2_kind','t_booking.doctor_id','t_booking.hygienist_id', 'tf1.facility_id', 'tf1.facility_name', 't_booking.clinic_id', 't_booking.booking_group_id')
                        ->whereNull('t_booking.patient_id')
                        ->where('t_booking.last_kind', '<>', DELETE);
                        // ->where('t_booking.booking_rev', $this->getLastBookingRev());

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

        if(isset($where['booking_start_time'])){
            $result = $db->where('booking_start_time', '=', $where['booking_start_time']);
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

        return $db->groupBy('t_booking.booking_date','t_booking.booking_start_time','t_booking.facility_id')
                        ->orderBy('t_booking.booking_date', 'asc')
                        ->orderBy('t_booking.booking_start_time', 'asc')
                        ->orderBy('tf1.facility_name', 'asc')
                        ->simplePaginate(PAGINATION);
    }

    public function get_booking_list2($where = null){

        $db =  DB::table($this->table)
                        ->leftJoin('t_facility as tf1', 't_booking.facility_id', '=', 'tf1.facility_id')
                        ->select('t_booking.booking_id', 't_booking.patient_id', 't_booking.booking_date', 't_booking.booking_start_time', 't_booking.booking_total_time', 't_booking.facility_id', 't_booking.facility_id', 't_booking.service_1', 't_booking.service_1_kind', 't_booking.service_2', 't_booking.service_2_kind','t_booking.doctor_id','t_booking.hygienist_id', 'tf1.facility_name', 't_booking.clinic_id', 't_booking.booking_group_id')
                        ->whereNull('t_booking.patient_id')
                        ->where('t_booking.last_kind', '<>', DELETE);

        if(isset($where['clinic_id'])){
            $result = $db->where('t_booking.clinic_id', '=', $where['clinic_id']);
        }     

        if(isset($where['doctor_id'])){
            $doctor_id = $where['doctor_id'];
            $result = $db->where('t_booking.doctor_id', $doctor_id);
        }

        if(isset($where['hygienist_id'])){
            $hygienist_id = $where['hygienist_id'];
            $result = $db->where('t_booking.hygienist_id', $hygienist_id);
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
            $result = $db->whereDate('t_booking.booking_date', '>=', $dateNow);
        }

        if(isset($where['clinic_service_name']) && !empty($where['clinic_service_name'])){
            $sk = explode('_', $where['clinic_service_name']);
            $service           = $sk[0];
            $s_kind            = str_split($sk[1], 2);
            $service_kind      = $s_kind[1];

            if($service_kind == 1){
                $result = $db->where('t_booking.service_1', '=', $service);
                $result = $db->where('t_booking.service_1_kind', '=', $service_kind);
            }

            if($service_kind == 2){
                $split = explode('#', $service);
                $treatment_id   = $split[0];
               // $treatment_time = $split[1];

                $result = $db->where('t_booking.service_1_kind', '=', $service_kind);
                $result = $db->whereIn('t_booking.service_1', [$treatment_id, '-1']);
            }
        }else{
            if ( isset($where['service_1_kind']) ) {
                $result = $db->where('t_booking.service_1_kind', $where['service_1_kind']);
            }
        }

        if(isset($where['booking_start_time'])){
            $result = $db->where('booking_start_time', '=', $where['booking_start_time']);
        }

        return $db->groupBy('t_booking.booking_date','t_booking.booking_start_time','t_booking.facility_id')
                        ->orderBy('t_booking.booking_date', 'asc')
                        ->orderBy('t_booking.booking_start_time', 'asc')
                        ->orderBy('tf1.facility_id', 'asc')
                        ->get();
    }

    /**
     * get booking by patient id
    */
    public function getBookByPatientID($p_id=null){
        $dateNow = formatDate(Carbon::now()->toDateTimeString(), '-');
        return DB::table($this->table)
                            ->leftJoin('m_clinic as cl', 't_booking.clinic_id', '=', 'cl.clinic_id')
                            ->leftJoin('t_patient as pt', 't_booking.patient_id', '=', 'pt.p_id')
                            ->leftJoin('t_facility as fl', 't_booking.facility_id', '=', 'fl.facility_id')
                            ->leftJoin('m_insurance as insu', 't_booking.insurance_id', '=', 'insu.insurance_id')
                            ->leftJoin('m_inspection as insp', 't_booking.inspection_id', '=', 'insp.inspection_id')
                            ->leftJoin('m_equipment as equi', 't_booking.equipment_id', '=', 'equi.equipment_id')
                            ->select('t_booking.*', 'cl.clinic_name', 'pt.p_no', 'pt.p_name_f', 'pt.p_name_g','fl.facility_name','insu.insurance_name', 'insp.inspection_name','equi.equipment_name')
                            ->where('t_booking.last_kind', '<>', DELETE)
                            // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                            ->where('t_booking.patient_id', '=', $p_id)
                            ->where('t_booking.booking_date', '>=', $dateNow)
                            ->groupBy('t_booking.booking_childgroup_id')
                            ->orderBy('t_booking.booking_date', 'asc')
                            //->limit(2)
                            ->get();
    }

    // for helper
    public static function checkExistID($id){
        if (DB::table('t_booking')
                    ->where('last_kind', '<>', DELETE)
                    // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                    ->where('booking_id', '=', $id)
                    ->exists()) {
            return true;
        }else{
            return false;
        }
    }

    public function checkExistID2($id){
        if (DB::table('t_booking')
                    ->where('last_kind', '<>', DELETE)
                    // ->where('t_booking.booking_rev', $this->getLastBookingRev())
                    ->where('booking_id', '=', $id)
                    ->exists()) {
            return true;
        }else{
            return false;
        }
    }

    // get last version
    public function getLastBookingRev()
    {
        $version = DB::table($this->table)->where('t_booking.last_kind', '<>', DELETE)->max('booking_rev');

        if ( empty($version) ) {
            $version = 0;
        }

        return $version;
    }
}