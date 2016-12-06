<?php namespace App\Http\Models\Ortho;

use DB;
use Carbon;

class BookingTelWaitingModel
{

    protected $table = 't_booking_tel_waiting';

    public function Rules()
    {
        return array(
            'clinic_id'         => 'required',
            'p_id'              => 'required',
            'doctor_id'         => 'required',
            'service_1'         => 'required',
            'telephone'         => 'numeric',
        );
    }

    public function Messages()
    {
        return array(
            'clinic_id.required'        => trans('validation.error_clinic_id_required'),
            'p_id.required'             => trans('validation.error_p_id_required'),
            'doctor_id.required'        => trans('validation.error_doctor_id_required'),
            'service_1.required'        => trans('validation.error_service_1_required'),
            'telephone.numeric'         => trans('validation.error_telephone_numeric'),
        );
    }

    public function get_all($where = array())
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE);

        // p_id
        if ( !empty($where['p_id']) ) {
            $results = $results->where('patient_id', $where['p_id']);
        }

        // insert_date
        if ( !empty($where['insert_date']) ) {
            $results = $results->where('insert_date', $where['insert_date']);
        }

        $results = $results->orderBy('insert_date', 'asc');

        $db = $results->get();
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
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->where('id', $id)->first();
        return $results;
    }

    public function get_by_booking_id($booking_id)
    {
        $results = DB::table($this->table)
                            ->leftJoin('t_patient as t1', 't_booking_tel_waiting.patient_id', '=', 't1.p_id')
                            ->leftJoin('m_clinic as t2', 't_booking_tel_waiting.clinic_id', '=', 't2.clinic_id')
                            ->leftJoin('t_facility as t3', 't_booking_tel_waiting.facility_id', '=', 't3.facility_id')
                            ->leftJoin('m_equipment as t4', 't_booking_tel_waiting.equipment_id', '=', 't4.equipment_id')
                            ->leftJoin('m_inspection as t5', 't_booking_tel_waiting.inspection_id', '=', 't5.inspection_id')
                            ->leftJoin('m_insurance as t6', 't_booking_tel_waiting.insurance_id', '=', 't6.insurance_id')
                            ->select('t_booking_tel_waiting.*', 't1.p_no', 't1.p_name_f', 't1.p_name_g', 't2.clinic_name', 't3.facility_name', 't4.equipment_name', 't5.inspection_name', 't6.insurance_name')
                            ->where('t_booking_tel_waiting.last_kind', '<>', DELETE)
                            ->where('t_booking_tel_waiting.booking_id', $booking_id)
                            ->first();
        return $results;
    }

    public function get_by_patient_id($patient_id)
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->where('patient_id', $patient_id)->first();
        return $results;
    }

    public function update($id, $data)
    {
        $results = DB::table($this->table)->where('id', $id)->update($data);
        return $results;
    }

    public function get_where($where = array(), $lastBookingVer = true, $orderBy = 'booking_childgroup_id')
    {
        $db = DB::table($this->table)->where('t_booking_tel_waiting.last_kind', '<>', DELETE);

        if ( $lastBookingVer ) {
            // $db = $db->where('t_booking_tel_waiting.booking_rev', $this->getLastBookingRev());
        }

        // where booking_group_id
        if ( isset($where['booking_group_id']) && !empty($where['booking_group_id']) ) {
            $db = $db->where('t_booking_tel_waiting.booking_group_id', $where['booking_group_id']);
        }
        // where booking_childgroup_id
        if ( isset($where['booking_childgroup_id']) && !empty($where['booking_childgroup_id']) ) {
            $db = $db->where('t_booking_tel_waiting.booking_childgroup_id', $where['booking_childgroup_id']);
        }
        // where clinic_id
        if ( isset($where['clinic_id']) && !empty($where['clinic_id']) ) {
            $db = $db->where('t_booking_tel_waiting.clinic_id', $where['clinic_id']);
        }
        // where booking_date
        if ( isset($where['booking_date']) && !empty($where['booking_date']) ) {
            $db = $db->where('t_booking_tel_waiting.booking_date', $where['booking_date']);
        }
        // where facility_id
        if ( isset($where['facility_id']) && !empty($where['facility_id']) ) {
            $db = $db->where('t_booking_tel_waiting.facility_id', $where['facility_id']);
        }

        $db = $db->orderBy($orderBy, 'asc')->get();

        return $db;
    }

    public function get_booking_list1($where = null){

        $db =  DB::table($this->table)
                        ->leftJoin('t_facility as tf1', 't_booking_tel_waiting.facility_id', '=', 'tf1.facility_id')
                        ->select('t_booking_tel_waiting.booking_id', 't_booking_tel_waiting.patient_id', 't_booking_tel_waiting.booking_date', 't_booking_tel_waiting.booking_start_time', 't_booking_tel_waiting.booking_total_time', 't_booking_tel_waiting.facility_id', 't_booking_tel_waiting.facility_id', 't_booking_tel_waiting.service_1', 't_booking_tel_waiting.service_1_kind', 't_booking_tel_waiting.service_2', 't_booking_tel_waiting.service_2_kind','t_booking_tel_waiting.doctor_id','t_booking_tel_waiting.hygienist_id', 'tf1.facility_name', 't_booking_tel_waiting.clinic_id', 't_booking_tel_waiting.booking_group_id')
                        ->whereNull('t_booking_tel_waiting.patient_id')
                        ->where('t_booking_tel_waiting.last_kind', '<>', DELETE);

        if(isset($where['clinic_id'])){
            $result = $db->where('t_booking_tel_waiting.clinic_id', '=', $where['clinic_id']);
        }

        if(isset($where['clinic_service_name'])){
            $sk = explode('_', $where['clinic_service_name']);
            $service           = $sk[0];
            $s_kind            = str_split($sk[1], 2);
            $service_kind      = $s_kind[1];

            if($service_kind == 1){
                $result = $db->where('t_booking_tel_waiting.service_1', $service);
                $result = $db->where('t_booking_tel_waiting.service_1_kind', $service_kind);
                // $result = $db->orWhere('t_booking_tel_waiting.service_2', '=', $service)
                // ->where('t_booking_tel_waiting.service_2_kind', '=', $service_kind);
            }

            if($service_kind == 2){
                $split = explode('#', $service);
                $treatment_id   = $split[0];
                $treatment_time = $split[1];

                $result = $db->where('t_booking_tel_waiting.service_1', '=', $treatment_id);
                $result = $db->orWhere('t_booking_tel_waiting.service_1', '=', '-1');
                $result = $db->where('t_booking_tel_waiting.service_1_kind', '=', $service_kind);
                // $result = $db->orWhere('t_booking_tel_waiting.service_2', '=', '-1')
                // ->where('t_booking_tel_waiting.service_2_kind', '=', $service_kind);
            }
        }else{
            if ( isset($where['service_1_kind']) ) {
                $result = $db->where('t_booking_tel_waiting.service_1_kind', $where['service_1_kind']);
            }
        }

        if(isset($where['service_1_kind']))
            $result = $db->where('t_booking_tel_waiting.service_1_kind', $where['service_1_kind']);

        // if(isset($where['doctor_id'])){
        //     $doctor_id = $where['doctor_id'];
        //     $result = $db->whereIn('t_booking_tel_waiting.doctor_id', $doctor_id);
        // }

        // if(isset($where['hygienist_id'])){
        //     $hygienist_id = $where['hygienist_id'];
        //     $result = $db->whereIn('t_booking_tel_waiting.hygienist_id', $hygienist_id);
        // }

        if(isset($where['booking_date'])){
            $result = $db->whereIn(DB::raw("DAYOFWEEK(booking_date)"), $where['booking_date']);
        }

        if(isset($where['week_later'])){
            if($where['week_later'] == 'one_week'){
                $result = $db->whereBetween('t_booking_tel_waiting.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'two_week'){
                $result = $db->whereBetween('t_booking_tel_waiting.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'three_week'){
                $result = $db->whereBetween('t_booking_tel_waiting.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'four_week'){
                $result = $db->whereBetween('t_booking_tel_waiting.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'five_week'){
                $result = $db->whereBetween('t_booking_tel_waiting.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'one_month'){
                $result = $db->whereBetween('t_booking_tel_waiting.booking_date', weeklater($where['week_later']));
            }elseif($where['week_later'] == 'two_month'){
                $result = $db->whereBetween('t_booking_tel_waiting.booking_date', weeklater($where['week_later']));
            }else{
                $result = $db->whereDate('t_booking_tel_waiting.booking_date', '=', $where['week_later']);
            }
        }else{
            $dateNow = formatDate(Carbon::now()->toDateTimeString(), '-');
            $result = $db->whereDate('booking_date', '>=', $dateNow);
        }

        if(isset($where['booking_start_time'])){
            $result = $db->where('booking_start_time', '=', $where['booking_start_time']);
        }

        return $db->groupBy('t_booking_tel_waiting.booking_date','t_booking_tel_waiting.booking_start_time','t_booking_tel_waiting.facility_id')
                        ->orderBy('t_booking_tel_waiting.booking_date', 'asc')
                        ->orderBy('t_booking_tel_waiting.booking_start_time', 'asc')
                        ->orderBy('tf1.facility_id', 'asc')
                        ->get();

        // if(isset($where['clinic_service_name']) && $service_kind == 2){
        //     return $db->groupBy('t_booking_tel_waiting.booking_date','t_booking_tel_waiting.booking_start_time','t_booking_tel_waiting.facility_id')
        //                 ->orderBy('t_booking_tel_waiting.booking_date', 'asc')
        //                 ->orderBy('tf1.facility_id', 'asc')
        //                 ->orderBy('t_booking_tel_waiting.booking_start_time', 'asc')
        //                 ->get();
        // }else{
        //     return $db->groupBy('t_booking_tel_waiting.booking_date','t_booking_tel_waiting.booking_start_time','t_booking_tel_waiting.facility_id')
        //                 ->orderBy('t_booking_tel_waiting.booking_date', 'asc')
        //                 ->orderBy('t_booking_tel_waiting.booking_start_time', 'asc')
        //                 ->orderBy('tf1.facility_name', 'asc')
        //                 ->get();
        // }
    }

    public function checkExistID2($id){
        if (DB::table('t_booking_tel_waiting')
                    ->where('last_kind', '<>', DELETE)
                    // ->where('t_booking_tel_waiting.booking_rev', $this->getLastBookingRev())
                    ->where('booking_id', '=', $id)
                    ->exists()) {
            return true;
        }else{
            return false;
        }
    }

    public function get_by_child_group_list1($booking_childgroup_id=null, $patient_id=null, $facility_id=null, $booking_group_id=null, $booking_status=null)
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking_tel_waiting.patient_id', '=', 't1.p_id')
                        ->select('t_booking_tel_waiting.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking_tel_waiting.last_kind', '<>', DELETE)
                        ->where('t_booking_tel_waiting.booking_childgroup_id', $booking_childgroup_id)
                        ->where('t_booking_tel_waiting.booking_status', $booking_status)
                        ->orderBy('t_booking_tel_waiting.booking_id', 'asc')
                        ->get();
        if(!empty($patient_id)){
            $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking_tel_waiting.patient_id', '=', 't1.p_id')
                        ->select('t_booking_tel_waiting.*', 't1.p_name_f', 't1.p_name_g')
                        ->where('t_booking_tel_waiting.last_kind', '<>', DELETE)
                        ->where('t_booking_tel_waiting.patient_id', $patient_id)
                        ->where('t_booking_tel_waiting.booking_group_id', $booking_group_id)
                        ->where('t_booking_tel_waiting.facility_id', $facility_id)
                        ->where('t_booking_tel_waiting.booking_childgroup_id', $booking_childgroup_id)
                        ->where('t_booking_tel_waiting.booking_status', $booking_status)
                        ->orderBy('t_booking_tel_waiting.booking_id', 'asc')
                        ->get();
        }

        return $results;
    }

    public function getTelChildGroup($clinic_id=null, $tel_booking_start_time=null, $patient_id=null, $tel_booking_group_id=null, $tel_booking_childgroup_id=null, $facility_id=null, $service_1_kind=null, $tel_booking_end_time=null)
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE);

        // clinic_id
        if ( !empty($clinic_id) ) {
            $results = $results->where('clinic_id', $clinic_id);
        }

        // booking_start_time
        if ( !empty($tel_booking_start_time) ) {
            $results = $results->where('booking_start_time', '>=', $tel_booking_start_time);
        }

        // patient_id
        if ( !empty($patient_id) ) {
            $results = $results->where('patient_id', $patient_id);
        }

        // booking_childgroup_id
        if ( !empty($tel_booking_childgroup_id) ) {
            $results = $results->where('booking_childgroup_id', $tel_booking_childgroup_id);
        }

        // booking_group_id
        if ( !empty($tel_booking_group_id) ) {
            $results = $results->where('booking_group_id', $tel_booking_group_id);
        }

        // facility_id
        if ( !empty($facility_id) ) {
            $results = $results->where('facility_id', $facility_id);
        }

        // service_1_kind
        if ( !empty($service_1_kind) ) {
            $results = $results->where('service_1_kind', $service_1_kind);
        }

        // booking_end_time
        if ( !empty($tel_booking_end_time) ) {
            $results = $results->where('booking_start_time', '<', $tel_booking_end_time);
        }

        $results = $results->orderBy('booking_date', 'asc')->orderBy('booking_start_time', 'asc')->orderBy('id', 'asc');

        $db = $results->get();
        return $db;
    }
}