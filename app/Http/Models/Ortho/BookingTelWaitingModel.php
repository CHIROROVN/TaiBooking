<?php namespace App\Http\Models\Ortho;

use DB;

class BookingTelWaitingModel
{

    protected $table = 't_booking_tel_waiting';

    public function Rules()
    {
    	return array(
    		'clinic_id'         => 'required',
            'p_id'              => 'required',
            'telephone'         => 'numeric',
		);
    }

    public function Messages()
    {
    	return array(
            'clinic_id.required'        => trans('validation.error_clinic_id_required'),
            'p_id.required'             => trans('validation.error_p_id_required'),
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
        $results = DB::table($this->table)->where('id', $id)->first();
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
}