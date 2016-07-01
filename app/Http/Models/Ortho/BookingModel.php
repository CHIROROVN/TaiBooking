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

    public function get_all()
    {
        $results = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking.patient_id', '=', 't1.p_id')
                        ->select('t_booking.*', 't1.p_name')
                        ->where('t_booking.last_kind', '<>', DELETE)
                        ->orderBy('t_booking.booking_id', 'asc')
                        ->get();
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
        $results = DB::table($this->table)->where('booking_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
    	$results = DB::table($this->table)->where('booking_id', $id)->update($data);
        return $results;
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
}