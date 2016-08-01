<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Models\Ortho\BookingModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\Treatment1Model;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\ClinicServiceModel;
use App\Http\Models\Ortho\ResultModel;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class BookedController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function getHistory()
    {
        // where
        $data                       = array();
        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_for_select();

        $data['s_clinic_id']        = Input::get('s_clinic_id');
        $data['s_booking_date']     = Input::get('s_booking_date');
        if ( empty($data['s_clinic_id']) ) {
            foreach ( $data['clinics'] as $item ) {
                if ( $item->clinic_name == 'たい矯正歯科' ) {
                    $data['s_clinic_id'] = $item->clinic_id;
                }
            }
        }
        if ( empty($data['s_booking_date']) ) {
            $data['s_booking_date'] = date('Y-m-d');
        }

        $clsBooking                 = new BookingModel();
        $clsService                 = new ServiceModel();
        $clsTreatment1              = new Treatment1Model();
        $clsResult                  = new ResultModel();
        $data['bookeds']            = $clsBooking->getBookedHistory($data);
        $data['services']           = $clsService->get_list();
        $data['results']            = $clsResult->get_list();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        $data['dates']              = getSomeDayFromDay(date('Y-m-d'), 10);
        $data['currentDay']         = date('Y-m-d');
        return view('backend.ortho.bookeds.history', $data);
    }

    /**
     * 
     */
    public function getRegistHistory($booking_id)
    {
        $clsBooking                 = new BookingModel();
        $clsClinic                  = new ClinicModel();
        $clsUser                    = new UserModel();
        $clsTreatment1              = new Treatment1Model();
        $clsClinicService           = new ClinicServiceModel();
        $data['clinics']            = $clsClinic->get_for_select();
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        $data['services']           = $clsClinicService->get_service();
        $data['dates']              = getSomeDayFromDay(date('Y-m-d'), 10);
        $data['currentDay']         = date('Y-m-d');
        $data['booking']            = $clsBooking->get_by_id($booking_id);
        return view('backend.ortho.bookeds.history_regist', $data);
    }

    /**
     * 
     */
    public function postRegistHistory($booking_id)
    {
        $clsResult                  = new ResultModel();
        $clsBooking                 = new BookingModel();
        $inputs                     = Input::all();
        $booking                    = $clsBooking->get_by_id($booking_id);
        // set result_start_time
        $inputs['result_start_time'] = 'abc';
        if ( empty(Input::get('result_start_time_hh')) 
                && empty(Input::get('result_start_time_mm')) 
                && empty(Input::get('result_total_time_hh')) 
                && empty(Input::get('result_total_time_mm')) 
            ) {
            $inputs['result_start_time'] = null;
        }

        $validator                  = Validator::make($inputs, $clsResult->Rules(), $clsResult->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.bookeds.history.regist', [$booking_id])->withErrors($validator)->withInput();
        }

        // update table
        $dataUpdate = array(
            'patient_id'            => $booking->patient_id,
            'facility_id'           => $booking->facility_id,
            'equipment_id'          => $booking->equipment_id,
            'result_date'           => Input::get('result_date'),
            'result_start_time'     => Input::get('result_start_time_hh').Input::get('result_start_time_mm'),
            'result_total_time'     => '',
            'clinic_id'             => Input::get('clinic_id'),
            'doctor_id'             => Input::get('doctor_id'),
            'hygienist_id'          => Input::get('hygienist_id'),
            'service_1'             => '',
            'service_1_kind'        => '',
            'service_2'             => '',
            'service_2_kind'        => '',
            'result_memo'           => Input::get('result_memo'),
            'result_next'           => Input::get('result_next'),
            'next_service_1'        => '',
            'next_service_1_kind'   => '',
            'next_service_2'        => '',
            'next_service_2_kind'   => '',
            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => INSERT,
            'last_ipadrs'           => CLIENT_IP_ADRS,
            'last_user'             => Auth::user()->id
        );
        
        // set result_start_time
        if ( empty(Input::get('result_start_time_hh')) && empty(Input::get('result_start_time_mm')) ) {
            $dataUpdate['result_start_time'] = null;
        }
        
        // set result_total_time
        $totalSecond = totalSecond(Input::get('result_total_time_hh'), Input::get('result_total_time_mm'), '0', Input::get('result_start_time_hh'), Input::get('result_start_time_mm'), '0');
        $totalTime = $totalSecond / 60;
        $dataUpdate['result_total_time'] = $totalTime;
        // set service 1
        $service_1                          = Input::get('service_1');
        if ( !empty($service_1) ) {
            $tmp1                               = explode('|', $service_1);
            $dataUpdate['service_1_kind']       = $tmp1[0];
            $dataUpdate['service_1']            = $tmp1[1];
        }
        // set service 2
        $service_2                          = Input::get('service_2');
        if ( !empty($service_2) ) {
            $tmp2                               = explode('|', $service_2);
            $dataUpdate['service_2_kind']       = $tmp1[0];
            $dataUpdate['service_2']            = $tmp1[1];
        }

        // set next service 1
        $next_service_1                     = Input::get('next_service_1');
        if ( !empty($next_service_1) ) {
            $tmpNext1                           = explode('|', $next_service_1);
            $dataUpdate['next_service_1_kind']  = $tmpNext1[0];
            $dataUpdate['next_service_1']       = $tmpNext1[1];
        }
        // set next service 2
        $next_service_2                     = Input::get('next_service_2');
        if ( !empty($next_service_2) ) {
            $tmpNext2                           = explode('|', $next_service_2);
            $dataUpdate['next_service_2_kind']  = $tmpNext2[0];
            $dataUpdate['next_service_2']       = $tmpNext2[1];
        }
        if ( $clsResult->insert($dataUpdate) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.bookeds.history');
    }

    /**
     * 
     */
    public function getEditHistory($booking_id)
    {
        $clsBooking                 = new BookingModel();
        $clsClinic                  = new ClinicModel();
        $clsUser                    = new UserModel();
        $clsTreatment1              = new Treatment1Model();
        $clsClinicService           = new ClinicServiceModel();
        $clsResult                  = new ResultModel();
        $data                       = array();
        $data['booked']             = $clsBooking->get_by_id($booking_id);
        $data['clinics']            = $clsClinic->get_for_select();
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        $data['services']           = $clsClinicService->get_service();
        $data['result']             = $clsResult->get_by_patient_id($data['booked']->patient_id);
        $data['dates']              = getSomeDayFromDay(date('Y-m-d'), 10);
        $data['currentDay']         = date('Y-m-d');
        return view('backend.ortho.bookeds.history_edit', $data);
    }

    /**
     * 
     */
    public function postEditHistory($booking_id)
    {
        $clsResult                  = new ResultModel();
        $clsBooking                 = new BookingModel();
        $booking                    = $clsBooking->get_by_id($booking_id);
        $inputs                     = Input::all();
        // set result_start_time
        $inputs['result_start_time'] = 'abc';
        if ( empty(Input::get('result_start_time_hh')) 
                && empty(Input::get('result_start_time_mm')) 
                && empty(Input::get('result_total_time_hh')) 
                && empty(Input::get('result_total_time_mm')) 
            ) {
            $inputs['result_start_time'] = null;
        }

        $validator                  = Validator::make($inputs, $clsResult->Rules(), $clsResult->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.bookeds.history.edit', [$booking_id])->withErrors($validator)->withInput();
        }

        // update table
        $dataUpdate = array(
            'patient_id'            => $booking->patient_id,
            'facility_id'           => $booking->facility_id,
            'equipment_id'          => $booking->equipment_id,
            'result_date'           => Input::get('result_date'),
            'result_start_time'     => Input::get('result_start_time_hh').Input::get('result_start_time_mm'),
            'result_total_time'     => '',
            'clinic_id'             => Input::get('clinic_id'),
            'doctor_id'             => Input::get('doctor_id'),
            'hygienist_id'          => Input::get('hygienist_id'),
            'service_1'             => '',
            'service_1_kind'        => '',
            'service_2'             => '',
            'service_2_kind'        => '',
            'result_memo'           => Input::get('result_memo'),
            'result_next'           => Input::get('result_next'),
            'next_service_1'        => '',
            'next_service_1_kind'   => '',
            'next_service_2'        => '',
            'next_service_2_kind'   => '',
            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => UPDATE,
            'last_ipadrs'           => $_SERVER['REMOTE_ADDR'],
            'last_user'             => Auth::user()->id
        );
        
        // set result_start_time
        if ( empty(Input::get('result_start_time_hh')) && empty(Input::get('result_start_time_mm')) ) {
            $dataUpdate['result_start_time'] = null;
        }

        // set result_total_time
        $totalSecond = totalSecond(Input::get('result_total_time_hh'), Input::get('result_total_time_mm'), '0', Input::get('result_start_time_hh'), Input::get('result_start_time_mm'), '0');
        $totalTime = $totalSecond / 60;
        $dataUpdate['result_total_time'] = $totalTime;

        // set service 1
        $service_1                              = Input::get('service_1');
        if ( !empty($service_1) ) {
            $tmp1                               = explode('|', $service_1);
            $dataUpdate['service_1_kind']       = $tmp1[0];
            $dataUpdate['service_1']            = $tmp1[1];
        }

        // set service 2
        $service_2                              = Input::get('service_2');
        if ( !empty($service_2) ) {
            $tmp2                               = explode('|', $service_2);
            $dataUpdate['service_2_kind']       = $tmp1[0];
            $dataUpdate['service_2']            = $tmp1[1];
        }

        // set next service 1
        $next_service_1                         = Input::get('next_service_1');
        if ( !empty($next_service_1) ) {
            $tmpNext1                           = explode('|', $next_service_1);
            $dataUpdate['next_service_1_kind']  = $tmpNext1[0];
            $dataUpdate['next_service_1']       = $tmpNext1[1];
        }

        // set next service 2
        $next_service_2                         = Input::get('next_service_2');
        if ( !empty($next_service_2) ) {
            $tmpNext2                           = explode('|', $next_service_2);
            $dataUpdate['next_service_2_kind']  = $tmpNext2[0];
            $dataUpdate['next_service_2']       = $tmpNext2[1];
        }

        if ( $clsResult->update_by_patient_id($booking->patient_id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }
        return redirect()->route('ortho.bookeds.history');
    }
}
