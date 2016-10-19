<?php namespace App\Http\Models\Ortho;

use DB;

class RecallModel
{

    protected $table = 't_booking_recall';
    protected $primaryKey = 'id';
    public $timestamps  = false;
    
    public function Rules()
    {
        return array(
            'patient'           => 'required',
            'p_tel'             => 'numeric',
            'booking_recall_ym' => 'required'
        );
    }

    public function Messages()
    {
        return array(
            'patient.required'  => trans('validation.error_recall_patient_required'),
            'p_tel.numeric'     => trans('validation.error_recall_p_tel_numeric'),
            'booking_recall_ym.required'  => trans('validation.error_recall_booking_recall_ym_required'),
        );
    }

    public function insert($data)
    {
        $results = DB::table($this->table)->insert($data);
        return $results;
    }

    public function update($id, $data)
    {
        $results = DB::table($this->table)->where('id', $id)->update($data);
        return $results;
    }

    public function get_by_id($id)
    {
        return DB::table($this->table)
            ->leftJoin('t_patient as t1', 't_booking_recall.patient_id', '=', 't1.p_id')
            ->select('t_booking_recall.*', 't1.p_no', 't1.p_name_f','t1.p_name_g','t1.p_name_f_kana','t1.p_name_g_kana')
            ->where('id', $id)->first();
    }

    public function get_recall_list($where=array()){

        $db = DB::table($this->table)
                        ->leftJoin('t_patient as t1', 't_booking_recall.patient_id', '=', 't1.p_id')
                        ->leftJoin('t_result as t2', 't_booking_recall.patient_id', '=', 't2.patient_id')
                        ->leftJoin('m_clinic as m1', 't_booking_recall.clinic_id', '=', 'm1.clinic_id')
                        ->select('t_booking_recall.*', 't1.p_name_f', 't1.p_name_g', 't1.p_no', 'm1.clinic_name', 't2.result_date', 't2.result_memo')
                        ->where('t_booking_recall.last_kind', '<>', DELETE);
        // where patient_id
        if ( isset($where['patient_id']) && !empty($where['patient_id']) ) {
            $db = $db->where('t_booking_recall.patient_id', $where['patient_id']);
        }
        // where last_date
        if ( isset($where['last_date']) && !empty($where['last_date']) ) {
            $db = $db->where('t_booking_recall.last_date', $where['last_date']);
        }
        $db = $db->orderBy('booking_recall_ym', 'desc')->get();
        return $db;
    }

}