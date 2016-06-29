<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\InterviewModel;
use App\Http\Models\Ortho\PatientModel;
use App\Http\Models\Ortho\PatientModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;

class InterviewController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function index()
    {
        $clsInterview           = new InterviewModel();
        $data['interviews']     = $clsInterview->get_all();

        return view('backend.ortho.interviews.index', $data);
    }


    /**
     * get view set patient, interview
     */
    public function getSet()
    {
        return view('backend.ortho.interviews.set');
    }


    /**
     * insert database to table patient, interview
     */
    public function postSet()
    {
        $clsInterview           = new InterviewModel();
        $clsPatient             = new PatientModel();

        $dataInsert             = array(
            'p_name'            => Input::get('p_name'),
            'p_name_kana'       => Input::get('p_name_kana'),
            'p_sex'             => Input::get('p_sex'),
            'p_tel'             => Input::get('p_tel'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        
        $validator              = Validator::make($dataInsert, $clsPatient->Rules(), $clsPatient->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.interviews.set')->withErrors($validator)->withInput();
        }

        // insert to table "patient"
        $patient_id = $clsPatient->insert_get_id($dataInsert);
        // insert to table "interview"
        $dataInsert = array(
            'patient_id' => $patient_id
        );
        $insert_interview = $clsInterview->insert($dataInsert);

        if ( $patient_id && $insert_interview ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.interviews.index');
    }


    /**
     * get view regist
     */
    public function getRegist()
    {
        $data                   = array();
        $data['prefs']          = Config::get('constants.PREF');
        $data['patient_id']     = Input::get('patient_id');
        $data['clinic_id']      = Input::get('clinic_id');
        $data['booking_id']     = Input::get('booking_id');

        return view('backend.ortho.interviews.regist', $data);
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsInterview           = new InterviewModel();

        $dataInsert = array(
            'patient_id'        => Input::get('patient_id'),
            'first_date'        => '',
            'first_start_time'  => '',
            'first_total_time'  => '',
            'clinic_id'         => Input::get('clinic_id'),
            'booking_id'        => Input::get('patient_id'),

            'q1_1_sei'          => Input::get('q1_1_sei'),
            'q1_1_mei'          => Input::get('q1_1_mei'),
            'q1_2_sei'          => Input::get('q1_2_sei'),
            'q1_2_mei'          => Input::get('q1_2_mei'),
            'q1_3'              => Input::get('q1_3'),
            'q1_4'              => Input::get('q1_4'),
            'q1_5_zip_1'        => Input::get('q1_5_zip_1'),
            'q1_5_zip_2'        => Input::get('q1_5_zip_2'),
            'q1_5_pref'         => Input::get('q1_5_pref'),
            'q1_5_address_1'    => Input::get('q1_5_address_1'),
            'q1_5_address_2'    => Input::get('q1_5_address_2'),
            'q1_6'              => Input::get('q1_6'),
            'q1_7'              => Input::get('q1_7'),
            'q1_8'              => Input::get('q1_8'),
            'q1_9'              => Input::get('q1_9'),
            'q1_10'             => '', // after
            'q1_11'             => Input::get('q1_11'),
            'q1_12'             => Input::get('q1_12'),
            'q1_13'             => Input::get('q1_13'),
            'q1_14'             => Input::get('q1_14'),
            'q1_15'             => Input::get('q1_15'),

            'q2_kind'           => Input::get('q2_kind'),
            'q2_sq'             => Input::get('q2_sq'),

            'q3_kind'           => Input::get('q3_kind'),
            'q3_sq'             => Input::get('q3_sq'),

            'q4_kind'           => Input::get('q4_kind'),

            'q5_a_1'            => Input::get('q5_a_1'),
            'q5_a_2'            => Input::get('q5_a_2'),
            'q5_b_1'            => Input::get('q5_b_1'),
            'q5_b_2'            => Input::get('q5_b_2'),
            'q5_c_1'            => Input::get('q5_c_1'),
            'q5_c_2'            => Input::get('q5_c_2'),
            'q5_d_1'            => Input::get('q5_d_1'),
            'q5_d_2'            => Input::get('q5_d_2'),
            'q5_e_1'            => Input::get('q5_e_1'),
            'q5_e_2'            => Input::get('q5_e_2'),
            'q5_g_1'            => Input::get('q5_g_1'),
            'q5_g_2'            => Input::get('q5_g_2'),
            'q5_h_1'            => Input::get('q5_h_1'),
            'q5_h_2'            => Input::get('q5_h_2'),
            'q5_i_1'            => Input::get('q5_i_1'),
            'q5_i_2'            => Input::get('q5_i_2'),

            'q6_kind'           => Input::get('q6_kind'),
            // q6_sg after --->

            'q7_kind'           => Input::get('q7_kind'),
            'q7_sq_1'           => Input::get('q7_sq_1'),
            'q7_sq_2'           => Input::get('q7_sq_2'),
            'q7_sq_3'           => Input::get('q7_sq_3'),
            'q7_sq_4'           => Input::get('q7_sq_4'),
            'q7_sq'             => Input::get('q7_sq'),

            'q8_kind'           => Input::get('q8_kind'),
            'q8_kind_1_1'       => Input::get('q8_kind_1_1'), //checkbox for q8_sq
            'q8_sq'             => Input::get('q8_sq'),

            'q9_kind'           => Input::get('q9_kind'),

            'q10_kind'          => Input::get('q10_kind'),
            'q10_sq_1'          => Input::get('q10_sq_1'),
            'q10_sq_2'          => Input::get('q10_sq_2'),

            'q11_kind'          => Input::get('q11_kind'),
            'q11_sq'            => Input::get('q11_sq'),

            'q12_kind'          => Input::get('q12_kind'),

            'q13_kind'          => Input::get('q13_kind'),
            'q13_sq_1'          => Input::get('q13_sq_1'),
            'q13_sq_2'          => Input::get('q13_sq_2'),
            'q13_sq_3'          => Input::get('q13_sq_3'),

            'q14_kind'          => Input::get('q14_kind'),
            'q14_sq'            => Input::get('q14_sq'),

            'q15_kind'          => Input::get('q15_kind'),
            'q15_sq'            => Input::get('q15_sq'),

            'q16_kind'          => Input::get('q16_kind'),
            'q16_sq'            => Input::get('q16_sq'),

            'q17_kind'          => Input::get('q17_kind'),

            'q18_kind'          => Input::get('q18_kind'),

            'q19_kind'          => Input::get('q19_kind'),
            'q19_sq'            => Input::get('q19_sq'),

            'q20_kind'          => Input::get('q20_kind'),
            'q20_sq'            => Input::get('q20_sq'),

            'q21_kind'          => Input::get('q21_kind'),
            'q21_sq_1'          => Input::get('q21_sq_1'),
            'q21_sq_2'          => Input::get('q21_sq_2'),
            'q21_sq_3'          => Input::get('q21_sq_3'),

            'q22'               => Input::get('q22'),

            'q23_kind'          => Input::get('q23_kind'),
            'q23_sq'            => Input::get('q23_sq'),

            'q24_kind'          => Input::get('q24_kind'),
            'q24_sq_1'          => Input::get('q24_sq_1'),
            'q24_sq_2'          => Input::get('q24_sq_2'),
            'q24_sq_3'          => Input::get('q24_sq_3'),

            'q25_kind'          => Input::get('q25_kind'),
            'q25_sq_1'          => Input::get('q25_sq_1'),
            'q25_sq_2'          => Input::get('q25_sq_2'),
            'q25_sq_3'          => Input::get('q25_sq_3'),

            'q26_kind'          => Input::get('q26_kind'),
            'q26_sq'            => Input::get('q26_sq'),

            'q27_1'             => Input::get('q27_1'),
            'q27_2'             => Input::get('q27_2'),
            'q27_3'             => Input::get('q27_3'),
            'q27_4'             => Input::get('q27_4'),
            'q27_5'             => Input::get('q27_5'),
            'q27_6'             => Input::get('q27_6'),

            'q28'               => Input::get('q28'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        // get value q6
        for ( $i = 1; $i <= 46; $i++ ) {
            $dataInsert['q6_sq_' . $i] = Input::get('q6_sq_' . $i);
        }
        // get YYYY-mm-dd
        if ( !empty(Input::get('q1_10_year')) && !empty(Input::get('q1_10_month')) && !empty(Input::get('q1_10_day')) ) {
            $dataInsert['q1_10'] = Input::get('q1_10_year') . '-' . Input::get('q1_10_month') . '-' . Input::get('q1_10_day');
        }

        $validator      = Validator::make($dataInsert, $clsInterview->Rules(), $clsInterview->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.interviews.regist')->withErrors($validator)->withInput();
        }

        // set value befor insert
        // q6
        if ( $dataInsert['q6_kind'] != 1 ) {
            for ( $i = 1; $i <= 46; $i++ ) {
                $dataInsert['q6_sq_' . $i] = null;
            }
        }
        // q7
        if ( $dataInsert['q7_kind'] != 1 ) {
            $dataInsert['q7_sq_1']  = null;
            $dataInsert['q7_sq_2']  = null;
            $dataInsert['q7_sq_3']  = null;
            $dataInsert['q7_sq_4']  = null;
            $dataInsert['q7_sq']    = null;
        }
        if ( $dataInsert['q7_sq_4'] != 1 ) {
            $dataInsert['q7_sq']    = null;
        }
        // q8
        if ( $dataInsert['q8_kind'] != 1 ) {
            $dataInsert['q8_kind_1_1']    = null;
        }
        if ( $dataInsert['q8_kind_1_1'] != 1 ) {
            $dataInsert['q8_sq']    = null;
        }
        // q10
        if ( $dataInsert['q10_kind'] != 1 ) {
            $dataInsert['q10_sq_1']    = null;
            $dataInsert['q10_sq_2']    = null;
        }
        // q11
        if ( $dataInsert['q11_kind'] != 1 ) {
            $dataInsert['q11_sq']    = null;
        }
        // q13
        if ( $dataInsert['q13_kind'] != 1 ) {
            $dataInsert['q13_sq_1']    = null;
            $dataInsert['q13_sq_2']    = null;
            $dataInsert['q13_sq_3']    = null;
        }
        // q14
        if ( $dataInsert['q14_kind'] != 1 ) {
            $dataInsert['q14_sq']    = null;
        }
        // q15
        if ( $dataInsert['q15_kind'] != 1 ) {
            $dataInsert['q15_sq']    = null;
        }
        // q16
        if ( $dataInsert['q16_kind'] != 2 ) {
            $dataInsert['q16_sq']    = null;
        }
        // q19
        if ( $dataInsert['q19_kind'] != 1 ) {
            $dataInsert['q19_sq']    = null;
        }
        // q20
        if ( $dataInsert['q20_kind'] != 1 ) {
            $dataInsert['q20_sq']    = null;
        }
        // q21
        if ( $dataInsert['q21_kind'] != 1 ) {
            $dataInsert['q21_sq_1']    = null;
            $dataInsert['q21_sq_2']    = null;
        }
        if ( $dataInsert['q21_kind'] != 2 ) {
            $dataInsert['q21_sq_3']    = null;
        }
        // q23
        if ( $dataInsert['q23_kind'] != 1 ) {
            $dataInsert['q23_sq']    = null;
        }
        // q24
        if ( $dataInsert['q24_kind'] != 1 ) {
            $dataInsert['q24_sq_1']    = null;
            $dataInsert['q24_sq_2']    = null;
            $dataInsert['q24_sq_3']    = null;
        }
        // q25
        if ( $dataInsert['q25_kind'] != 1 ) {
            $dataInsert['q25_sq_1']    = null;
            $dataInsert['q25_sq_2']    = null;
            $dataInsert['q25_sq_3']    = null;
        }
        // q26
        if ( $dataInsert['q26_kind'] != 1 ) {
            $dataInsert['q26_sq']    = null;
        }

        if ( $clsInterview->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.interviews.index');
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        // $clsInterview                = new InterviewModel();
        // $clsClinic              = new ClinicModel();
        // $clsClinicArea          = new ClinicInterviewModel();
        // $data['area']           = $clsInterview->get_by_id($id);
        // $data['clinics']        = $clsClinic->get_all();
        // $area_clinics           = $clsClinicArea->get_by_area($id);
        // $tmp                    = array();
        // foreach($area_clinics as $area_clinic)
        // {
        //     $tmp[$area_clinic->clinic_id] = $area_clinic->clinic_id;
        // }
        // $data['area_clinics']   = $tmp;

        // return view('backend.ortho.interviews.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        // $clsInterview                = new InterviewModel();
        // $clsClinicArea          = new ClinicInterviewModel();
        // $inputs                 = Input::all();

        // $validator              = Validator::make($inputs, $clsInterview->Rules(), $clsInterview->Messages());

        // if ($validator->fails()) {
        //     return redirect()->route('ortho.interviews.edit', [$id])->withErrors($validator)->withInput();
        // }

        // // update table area
        // $dataUpdate = array(
        //     'area_name'         => Input::get('area_name'),

        //     'last_date'         => date('y-m-d H:i:s'),
        //     'last_kind'         => UPDATE,
        //     'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
        //     'last_user'         => Auth::user()->id
        // );
        // $clsInterview->update($id, $dataUpdate);

        // // before update table clinic_area
        // $clinics = Input::get('clinic');
        // if(!empty($clinics))
        // {
        //     $status_insert = false;
        //     foreach($clinics as $clinic)
        //     {
        //         if($clsClinicArea->exist_clinic($clinic))
        //         {
        //             // update
        //             $data = array(
        //                 'area_id'           => $id,
        //                 'clinic_id'         => $clinic,

        //                 'last_date'         => date('y-m-d H:i:s'),
        //                 'last_kind'         => UPDATE,
        //                 'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
        //                 'last_user'         => Auth::user()->id
        //             );
        //             if ( $clsClinicArea->update_by_clinic($clinic, $data) ) {
        //                 $status_insert = true;
        //             } else {
        //                 $status_insert = false;
        //             }
        //         }
        //         else
        //         {
        //             // add new
        //             $dataInsert = array(
        //                 'area_id'           => $id,
        //                 'clinic_id'         => $clinic,

        //                 'last_date'         => date('y-m-d H:i:s'),
        //                 'last_kind'         => INSERT,
        //                 'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
        //                 'last_user'         => Auth::user()->id
        //             );
        //             if ( $clsClinicArea->insert($dataInsert) ) {
        //                 $status_insert = true;
        //             } else {
        //                 $status_insert = false;
        //             }
        //         }
        //     } 
        // }
        // if ( $status_insert ) {
        //     Session::flash('success', trans('common.message_regist_success'));
        // } else {
        //     Session::flash('danger', trans('common.message_regist_danger'));
        // }

        // return redirect()->route('ortho.interviews.index');
    }

    /**
     * 
     */
    public function getDelete($id)
    {
        $clsInterview                   = new InterviewModel();

        // update
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );

        if ( $clsInterview->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_delete_success'));
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
        }

        return redirect()->route('ortho.interviews.index');
    }
}
