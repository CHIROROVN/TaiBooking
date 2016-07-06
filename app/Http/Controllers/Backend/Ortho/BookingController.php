<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
// use Hash;
use App\User;
use App\Http\Models\Ortho\BookingModel;
use App\Http\Models\Ortho\ShiftModel;
use App\Http\Models\Ortho\FacilityModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\ClinicServiceModel;
use App\Http\Models\Ortho\Treatment1Model;
use App\Http\Models\Ortho\PatientModel;
use App\Http\Models\Ortho\EquipmentModel;
use App\Http\Models\Ortho\InspectionModel;
use App\Http\Models\Ortho\InsuranceModel;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;

class BookingController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }


    /**
     * get view monthly
     */
    public function bookingMonthly()
    {
        $data                   = array();
        $data['s_clinic_id']    = Input::get('s_clinic_id', 0);
        $data['s_u_id']         = Input::get('s_u_id', 0);
        // $clsShift            = new ShiftModel();
        // $shifts              = $clsShift->get_all();
        $clsBooking             = new BookingModel();
        $clsUser                = new UserModel();
        $clsClinic              = new ClinicModel();
        $data['users']          = $clsUser->get_all();
        $data['clinics']        = $clsClinic->get_all();
        $bookings               = $clsBooking->get_all($data);

        $tmp_arr            = array();
        foreach ( $bookings as $booking ) {
            $tmp_arr[] = array(
                'title' => '<img src="' . asset('') . 'public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="' . asset('') . 'public/backend/ortho/common/image/docter.png">' . $booking->p_name,
                'start' => $booking->booking_date,
                'end' => $booking->booking_date + 1,
                'url' => route('ortho.bookings.booking.result.calendar', [ 'start_date' => $booking->booking_date ]),
            );
        }
        $data['bookings'] = json_encode($tmp_arr);

        return view('backend.ortho.bookings.booking_monthly', $data);
    }


    /**
     * get view bookingResultCalendar
     */
    public function bookingResultCalendar()
    {
        $start_date             = Input::get('start_date');
        $month_current          = date('m');
        if ( Input::get('month_cur') && Input::get('month_cur') >= 1 && Input::get('month_cur') <= 12 ) {
            $month_current = Input::get('month_cur');
        }

        $clsShift               = new ShiftModel();
        $clsBooking             = new BookingModel();
        $clsFacility            = new FacilityModel();
        $data                   = array();
        $data['doctors']        = $clsShift->get_by_belong([1], $start_date);
        $data['hygienists']     = $clsShift->get_by_belong([2,3], $start_date);
        $data['facilitys']      = $clsFacility->getAll();

        $data['date_current']   = date('Y-m-d');
        $data['start_date']     = $start_date;
        $data['month_current']  = $month_current;
        $data['times']          = Config::get('constants.TIME');

        $bookings               = $clsBooking->get_all();
        $arr_bookings           = array();
        foreach ( $data['times'] as $time ) {
            foreach ( $data['facilitys'] as $fac ) {
                foreach ( $bookings as $booking ) {
                    if ( $booking->facility_id == $fac->facility_id ) {
                        $arr_bookings[$fac->facility_id][$time] = $booking;
                    }
                }
            }
        }
        $data['arr_bookings'] = $arr_bookings;

        return view('backend.ortho.bookings.booking_result_calendar', $data);
    }


    /**
     * get view detail
     * $id: ID record
     */
    public function bookingDetail($id)
    {
        $data                       = array();
        $clsBooking                 = new BookingModel();
        $clsUser                    = new UserModel();
        $clsClinicService           = new ClinicServiceModel();
        $clsTreatment1              = new Treatment1Model();
        $data['booking']            = $clsBooking->get_by_id($id);
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hys']                = $clsUser->get_by_belong([2,3]);
        $data['clinic_services']    = $clsClinicService->get_all();
        $data['treatment1s']        = $clsTreatment1->get_all();
        $data['start_date']         = Input::get('start_date');

        return view('backend.ortho.bookings.booking_detail', $data);
    }

    public function getEdit($id)
    {
        $data                       = array();
        $clsBooking                 = new BookingModel();
        $clsUser                    = new UserModel();
        $clsClinicService           = new ClinicServiceModel();
        $clsTreatment1              = new Treatment1Model();
        $data['booking']            = $clsBooking->get_by_id($id);
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hys']                = $clsUser->get_by_belong([2,3]);
        $data['clinic_services']    = $clsClinicService->get_all();
        $data['treatment1s']        = $clsTreatment1->get_all();

        return view('backend.ortho.bookings.booking_edit', $data);
    }

    public function postEdit($id)
    {
        $clsBooking                 = new BookingModel();

        $dataInput = array(
            'booking_status'        => Input::get('booking_status'),
            'booking_recall_ym'     => Input::get('booking_recall_ym'),
            'booking_memo'          => Input::get('booking_memo'),

            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => INSERT,
            'last_ipadrs'           => $_SERVER['REMOTE_ADDR'],
            'last_user'             => Auth::user()->id
        );

        $validator                  = Validator::make($dataInput, $clsBooking->Rules(), $clsBooking->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.bookings.booking.edit', [ $id ])->withErrors($validator)->withInput();
        }

        if ( $clsBooking->update($id, $dataInput) ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }

        return redirect()->route('ortho.bookings.booking.detail', [ $id ]);
    }

    public function getRegist()
    {
        $booking_id             = Input::get('booking_id');
        $patient_id             = Input::get('patient_id');

        $clsBooking             = new BookingModel();
        $clsClinic              = new ClinicModel();
        $data['clinics']        = $clsClinic->get_list_clinic();
        $clsEquipment           = new EquipmentModel();
        $data['equipments']     = $clsEquipment->get_list();
        $clsFacility            = new FacilityModel();
        $data['facilities']     = $clsFacility->list_facility_all();
        $clsUser                = new UserModel();
        $data['users']          = $clsUser->get_list();
        $data['booking']        = $clsBooking->get_by_id($booking_id);

        $data['booking_id']     = $booking_id;
        $data['patient_id']     = Input::get('patient_id');

        $clsPatient             = new PatientModel();
        $data['patient']        = $clsPatient->get_patient_by_id($patient_id);
        $clsService             = new ServiceModel();
        $data['services']       = $clsService->get_list();
        $clsTreatment1          = new Treatment1Model();
        $data['treatment1s']    = $clsTreatment1->get_list_treatment();
        $clsInspection          = new InspectionModel();
        $data['inspections']    = $clsInspection->get_list();
        $clsInsurance           = new InsuranceModel();
        $data['insurances']    = $clsInsurance->get_list();
        return view('backend.ortho.bookings.booking_regist', $data);
    }


    public function postRegist()
    {
        $clsBooking                 = new BookingModel();
        $patient_id                 = Input::get('patient_id');
        $booking_id                 = Input::get('booking_id');

        // echo "<pre>"; print_r($data);die;
        $dataInput = array(
                'facility_id'               => Input::get('facility_id'),
                'doctor_id'                 => Input::get('doctor_id'),
                'hygienist_id'              => Input::get('hygienist_id'),
                'equipment_id'              => Input::get('equipment_id'),
                'service_1'                 => Input::get('service_1'),
                'service_2'                 => Input::get('service_2'),
                'inspection_id'             => Input::get('inspection_id'),
                'insurance_id'              => Input::get('insurance_id'),
                'emergency_flag'            => (Input::get('emergency_flag') == 'on') ? 1 : NULL,
                'booking_status'            => Input::get('booking_status'),
                'booking_recall_ym'         => Input::get('booking_recall_ym'),
                'booking_memo'              => Input::get('booking_memo'),
                'last_date'                 => date('y-m-d H:i:s'),
                'last_kind'                 => UPDATE,
                'last_ipadrs'               => CLIENT_IP_ADRS,
                'last_user'                 => Auth::user()->id
            );
        
        if ( $clsBooking->update($booking_id, $dataInput) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('ortho.bookings.booking.result.list');
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('ortho.bookings.booking.regist', ['?booking_id='.$booking_id.'&patient_id='.$patient_id]);
        }
    }

    public function get1stRegist()
    {
        return view('backend.ortho.bookings.booking_1st_regist');
    }

    public function post1stRegist()
    {

    }


    public function getChangeDate($id)
    {
        $data                       = array();
        $clsClinic                  = new ClinicModel();
        $clsUser                    = new UserModel();
        $clsClinic                  = new ClinicModel();
        $clsBooking                 = new BookingModel();
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hys']                = $clsUser->get_by_belong([2,3]);
        $data['clinics']            = $clsClinic->get_for_select();
        $data['booking']            = $clsBooking->get_by_id($id);

        return view('backend.ortho.bookings.booking_change_date', $data);
    }


    public function postChangeDate($id)
    {

    }


    public function getConfirm($id)
    {
        $data['next'] = Input::get('next');
        return view('backend.ortho.bookings.booking_change_confirm', $data);
    }


    public function postConfirm($id)
    {
        $next = Input::get('next');
        if ( $next == 'booking_result_calendar' ) {
            return redirect()->route('ortho.bookings.booking.result.calendar');
        } else {
            return redirect()->route('ortho.bookings.booking.result.list');
        }
    }

    public function bookingResultList()
    {
        $clsBooking                 = new BookingModel();
        $data['bookings']           = $clsBooking->get_booking_list();
        $clsFacility                = new FacilityModel();
        $data['facilities']         = $clsFacility->list_facility_all();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        $clsService                 = new ServiceModel();
        $data['services']           = $clsService->get_list();
        return view('backend.ortho.bookings.booking_result_list', $data);
    }

    /**
     * List1 list
     */
    public function list1_list(){
        $clsBooking             = new BookingModel();
        $data['list1']          = $clsBooking->get_list1_list();
        $clsService             = new ServiceModel();
        $data['sercices']       = $clsService->get_list();
        return view('backend.ortho.bookings.list1_list', $data);
    }
}
