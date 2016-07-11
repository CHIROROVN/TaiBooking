<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

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
use App\Http\Models\Ortho\InterviewModel;
use App\Http\Models\Ortho\ResultModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;
use Carbon;

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
     * get view Dailily
     */
    public function bookingDaily()
    {
        $data                   = array();
        return view('backend.ortho.bookings.booking_daily', $data);
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
        //$data['clinic_services']    = $clsClinicService->getAll(1);
        //$data['treatment1s']        = $clsTreatment1->get_all();
        $data['start_date']         = Input::get('start_date');
        $clsService                 = new ServiceModel();
        $data['services']           = $clsService->get_list();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();

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
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
        $clsService                 = new ServiceModel();
        $data['services']           = $clsService->get_list();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        $clsFacility                = new FacilityModel();
        $data['facilities']         = $clsFacility->list_facility_all();
        $clsEquipment               = new EquipmentModel();
        $data['equipments']         = $clsEquipment->get_list();
        $clsInspection              = new InspectionModel();
        $data['inspections']        = $clsInspection->get_list();
        $clsInsurance               = new InsuranceModel();
        $data['insurances']         = $clsInsurance->get_list();
       // echo "<pre>";print_r($data);die;
        return view('backend.ortho.bookings.booking_edit', $data);
    }

    public function postEdit($id)
    {
        $clsBooking                 = new BookingModel();
        $s_1_kind = Input::get('service_1');
        $s1k = explode('#', $s_1_kind);
        $service_1          = $s1k[0];
        $s1_kind            = str_split($s1k[1], 3);
        $service_1_kind     = $s1_kind[1];

        $s_2_kind = Input::get('service_2');
        $s2k = explode('#', $s_2_kind);
        $service_2          = $s2k[0];
        $s2_kind            = str_split($s2k[1], 3);
        $service_2_kind     = $s2_kind[1];

        $dataInput = array(
                'facility_id'               => Input::get('facility_id'),
                'doctor_id'                 => Input::get('doctor_id'),
                'hygienist_id'              => Input::get('hygienist_id'),
                'equipment_id'              => Input::get('equipment_id'),
                'service_1'                 => $service_1,
                'service_1_kind'            => $service_1_kind,
                'service_2'                 => $service_2,
                'service_2_kind'            => $service_2_kind,
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

        $validator                  = Validator::make($dataInput, $clsBooking->Rules(), $clsBooking->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.bookings.booking.edit', [ $id ])->withErrors($validator)->withInput();
        }

        if ( $clsBooking->update($id, $dataInput) ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.bookings.booking.result.list');
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.booking_edit', $id);
        }

    }

    public function getRegist($id)
    {
        $data                       = array();
        $clsBooking                 = new BookingModel();
        $clsUser                    = new UserModel();
        $clsClinicService           = new ClinicServiceModel();
        $clsTreatment1              = new Treatment1Model();
        $data['booking']            = $clsBooking->get_by_id($id);
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
        $clsService                 = new ServiceModel();
        $data['services']           = $clsService->get_list();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        $clsFacility                = new FacilityModel();
        $data['facilities']         = $clsFacility->list_facility_all();
        $clsEquipment               = new EquipmentModel();
        $data['equipments']         = $clsEquipment->get_list();
        $clsInspection              = new InspectionModel();
        $data['inspections']        = $clsInspection->get_list();
        $clsInsurance               = new InsuranceModel();
        $data['insurances']         = $clsInsurance->get_list();
        $data['booking_id']         = $id;
        return view('backend.ortho.bookings.booking_regist', $data);
    }


    public function postRegist($id)
    {
        $clsBooking                 = new BookingModel();
        $s_1_kind = Input::get('service_1');
        $s1k = explode('#', $s_1_kind);
        $service_1          = $s1k[0];
        $s1_kind            = str_split($s1k[1], 3);
        $service_1_kind     = $s1_kind[1];

        $s_2_kind = Input::get('service_2');
        $s2k = explode('#', $s_2_kind);
        $service_2          = $s2k[0];
        $s2_kind            = str_split($s2k[1], 3);
        $service_2_kind     = $s2_kind[1];

        $dataInput = array(
                'facility_id'               => Input::get('facility_id'),
                'doctor_id'                 => Input::get('doctor_id'),
                'hygienist_id'              => Input::get('hygienist_id'),
                'equipment_id'              => Input::get('equipment_id'),
                'service_1'                 => $service_1,
                'service_1_kind'            => $service_1_kind,
                'service_2'                 => $service_2,
                'service_2_kind'            => $service_2_kind,
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
        if ( $clsBooking->update($id, $dataInput) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('ortho.bookings.booking.result.list');
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('ortho.bookings.booking.regist', ['?booking_id='.$booking_id.'&patient_id='.$patient_id]);
        }
    }

    public function get1stRegist($id)
    {
        $data                       = array();
        $clsBooking                 = new BookingModel();
        $clsUser                    = new UserModel();
        $clsClinicService           = new ClinicServiceModel();
        $clsTreatment1              = new Treatment1Model();
        $data['booking']            = $clsBooking->get_by_id($id);
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
        $clsService                 = new ServiceModel();
        $data['services']           = $clsService->get_list();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        $clsFacility                = new FacilityModel();
        $data['facilities']         = $clsFacility->list_facility_all();
        $clsEquipment               = new EquipmentModel();
        $data['equipments']         = $clsEquipment->get_list();
        $clsInspection              = new InspectionModel();
        $data['inspections']        = $clsInspection->get_list();
        $clsInsurance               = new InsuranceModel();
        $data['insurances']         = $clsInsurance->get_list();
        $data['booking_id']         = $id;
        return view('backend.ortho.bookings.booking_1st_regist', $data);
    }

    public function post1stRegist($id)
    { 
        $clsPatient             = new PatientModel();
        $p_max                  = $clsPatient->get_max_pid();
        $p_id                   = $p_max + 1;

        $patientInst = array(
            'p_name'            => Input::get('p_name'),
            'p_name_kana'       => Input::get('p_name_kana'),
            'p_sex'             => Input::get('p_sex'),
            'p_tel'             => Input::get('p_tel'),
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id,
            );

        $validator                  = Validator::make($patientInst, $clsPatient->Rules(), $clsPatient->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.bookings.booking.1st.regist', [ $id ])->withErrors($validator)->withInput();
        }
        $clsPatient->insert($patientInst);

        if(!empty(Input::get('insert_to_tbl_first'))){
            $clsInterview           = new InterviewModel();
            $interviewInst = array(
                    'patient_id'        => $p_id,
                    'last_date'         => date('y-m-d H:i:s'),
                    'last_kind'         => INSERT,
                    'last_ipadrs'       => CLIENT_IP_ADRS,
                    'last_user'         => Auth::user()->id
                );
            $clsInterview->insert($interviewInst);
        }

        $clsBooking                 = new BookingModel();
        $s_1_kind = Input::get('service_1');
        $s1k = explode('#', $s_1_kind);
        $service_1          = $s1k[0];
        $s1_kind            = str_split($s1k[1], 3);
        $service_1_kind     = $s1_kind[1];

        $s_2_kind = Input::get('service_2');
        $s2k = explode('#', $s_2_kind);
        $service_2          = $s2k[0];
        $s2_kind            = str_split($s2k[1], 3);
        $service_2_kind     = $s2_kind[1];

        $dataInput = array(
                'patient_id'                => $p_id,
                'facility_id'               => Input::get('facility_id'),
                'doctor_id'                 => Input::get('doctor_id'),
                'hygienist_id'              => Input::get('hygienist_id'),
                'equipment_id'              => Input::get('equipment_id'),
                'service_1'                 => $service_1,
                'service_1_kind'            => $service_1_kind,
                'service_2'                 => $service_2,
                'service_2_kind'            => $service_2_kind,
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

        if ( $clsBooking->update($id, $dataInput) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('ortho.bookings.booking.regist', [$id]);
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('ortho.bookings.booking.1st.regist', [$id]);
        }
    }


    public function getChangeDate($id)
    {
        $clsBooking                 = new BookingModel();
        $data['booking']            = $clsBooking->get_by_id($id);
        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_list_clinic();
        $clsUser                    = new UserModel();
        $data['doctors']            = $clsUser->get_by_belong_shift([1]);
        $data['hygienists']         = $clsUser->get_by_belong_shift([2,3]);
        $clsService                 = new ServiceModel();
        $data['services']           = $clsService->get_list();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();

        return view('backend.ortho.bookings.booking_change', $data);
    }


    public function postChangeDate($id)
    {
        $date                           = Input::get('booking_date');
        $dataInput['booking_id']        = $id;
        $dataInput['clinic_id']         = Input::get('clinic_id');
        $dataInput['doctor_id']         = Input::get('doctor_id');
        $dataInput['hygienist_id']      = Input::get('hygienist_id');
        switch (Input::get('week_later')) {
            case 'one_week':
                $dataInput['booking_recall_ym'] = date2YearMonth(booking_change_date($date, 'week_later'));
                $dataInput['booking_date_change'] = booking_change_date($date, 'one_week');
                break;
            case 'one_month':
                $dataInput['booking_recall_ym'] = date2YearMonth(booking_change_date($date, 'one_month'));
                $dataInput['booking_date_change'] = booking_change_date($date, 'one_month');
                break;
            case 'two_month':
                $dataInput['booking_recall_ym'] = date2YearMonth(booking_change_date($date, 'two_month'));
                $dataInput['booking_date_change'] = booking_change_date($date, 'two_month');
                break;
            case 'week_specified':
                $date_option = Input::get('week_later_option');
                $dataInput['booking_recall_ym'] = date2YearMonth(booking_change_date($date, $date_option));
                $dataInput['booking_date_change'] = booking_change_date($date, $date_option);
                break;
            case 'date_picker':
                $datepicker = Input::get('date_picker_option');
                $dataInput['booking_recall_ym'] = date2YearMonth(booking_change_date($date, $datepicker));
                $dataInput['booking_date_change'] = booking_change_date($date, $datepicker);
                break;
            default:
                $dataInput['booking_recall_ym'] = '';
                break;
        }

        if(!empty(Input::get('clinic_service_name'))){
            $sk = explode('_', Input::get('clinic_service_name'));
            $service                        = $sk[0];
            $s_kind                         = str_split($sk[1], 3);
            $service_kind                   = $s_kind[1];
            $dataInput['service_1']         = $service;
            $dataInput['service_1_kind']    = $service_kind;
        }

        $dataInput['last_date']         = date('y-m-d H:i:s');
        $dataInput['last_kind']         = UPDATE;
        $dataInput['last_ipadrs']       = CLIENT_IP_ADRS;
        $dataInput['last_user']         = Auth::user()->id;

        Session::put('booking_change', $dataInput);
        return redirect()->route('ortho.bookings.booking.change.confirm', [$id]);

    }


    public function getConfirm($id)
    {
        $clsBooking                 = new BookingModel();
        $data['booking']            = $clsBooking->get_by_id($id);
        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_list_clinic();
        $clsUser                    = new UserModel();
        $data['doctors']            = $clsUser->get_list();
        $data['hygienists']         = $clsUser->get_list();
        $clsService                 = new ServiceModel();
        $data['services']           = $clsService->get_list();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        $clsEquipment               = new EquipmentModel();
        $data['equipments']         = $clsEquipment->get_list();
        $clsInspection              = new InspectionModel();
        $data['inspections']        = $clsInspection->get_list();
        $clsInsurance               = new InsuranceModel();
        $data['insurances']         = $clsInsurance->get_list();

        $data['booking_change']     = Session::get('booking_change');
        return view('backend.ortho.bookings.booking_change_confirm', $data);
    }


    public function postConfirm($id)
    {
        if ( $next == 'booking_result_calendar' ) {
            return redirect()->route('ortho.bookings.booking.result.calendar');
        } else {
            return redirect()->route('ortho.bookings.booking.result.list');
        }
    }

    //Booking Search
    public function getSearch(){
        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_list_clinic();
        $clsUser                    = new UserModel();
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
        $clsService                 = new ServiceModel();
        $data['services']           = $clsService->get_list();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();

        return view('backend.ortho.bookings.booking_search', $data);
    }

     public function postSearch(){

        $condition = array();
        if(!empty(Input::get('clinic_id')))
            $condition['clinic_id']         = Input::get('clinic_id');
        if(!empty(Input::get('doctor_id')))
            $condition['doctor_id']         = Input::get('doctor_id');
        if(!empty(Input::get('hygienist_id')))
            $condition['hygienist_id']      = Input::get('hygienist_id');
        if(!empty(Input::get('booking_date')))
            $condition['booking_date'] = Input::get('booking_date');

        if(!empty(Input::get('week_later'))){
            if(Input::get('week_later') == 'week_specified'){
            $condition['week_later'] = Input::get('week_later_option');
            }elseif (Input::get('week_later') == 'date_picker') {
                $condition['week_later'] = formatDate(Input::get('date_picker_option'), '-');
            }else{
                $condition['week_later'] = Input::get('week_later');
            }
        }
        if(!empty(Input::get('clinic_service_name')))
            $condition['clinic_service_name']         = Input::get('clinic_service_name');
        return redirect()->route('ortho.bookings.booking.result.list', $condition);
     }


    public function bookingResultList()
    {
        $where = array();
        if(Input::get('clinic_id') != null)
            $where['clinic_id']        = Input::get('clinic_id');
        if(Input::get('doctor_id') != null)
            $where['doctor_id']        = Input::get('doctor_id');
        if(Input::get('hygienist_id') != null)
            $where['hygienist_id']        = Input::get('hygienist_id');
        if(Input::get('booking_date') != null)
            $where['booking_date']        = Input::get('booking_date');
        if(Input::get('week_later') != null)
            $where['week_later']        = Input::get('week_later');
        if(Input::get('clinic_service_name') != null)
            $where['clinic_service_name']        = Input::get('clinic_service_name');


        $clsBooking                 = new BookingModel();
        $data['bookings']           = $clsBooking->get_booking_list($where);
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

    /**
     * List2 list
     */
    public function list2_list(){
        // where
        $where = array();
        $where['booking_date_year']     = Input::get('booking_date_year');
        $where['booking_date_month']    = Input::get('booking_date_month');

        $clsBooking                     = new BookingModel();
        $clsService                     = new ServiceModel();
        $clsTreatment1                  = new Treatment1Model();
        $data['list2s']                 = $clsBooking->get_list2_list($where);
        $data['services']               = $clsService->get_list();
        $data['treatment1s']            = $clsTreatment1->get_list_treatment();
        $data['booking_date_year']      = $where['booking_date_year'];
        $data['booking_date_month']     = $where['booking_date_month'];
        
        // set year
        $curYear = date('Y');
        $tmpYears = array();
        $tmpYears[$curYear] = $curYear;
        for ( $i = 1; $i <= 5; $i++ ) {
            $tmpYears[$curYear + $i] = $curYear + $i;
        }
        $data['years'] = $tmpYears;

        return view('backend.ortho.bookings.list2_list', $data);
    }

    /**
     * List3 list
     */
    public function list3_list(){
        // where
        $where = array();
        $where['booking_recall_yy']     = Input::get('booking_recall_yy');
        $where['booking_recall_mm']     = Input::get('booking_recall_mm');

        $clsBooking                     = new BookingModel();
        $clsService                     = new ServiceModel();
        $clsTreatment1                  = new Treatment1Model();
        $data['list3s']                 = $clsBooking->get_list3_list($where);
        $data['services']               = $clsService->get_list();
        $data['treatment1s']            = $clsTreatment1->get_list_treatment();
        $data['booking_recall_yy']      = $where['booking_recall_yy'];
        $data['booking_recall_mm']      = $where['booking_recall_mm'];
        
        // set year
        $curYear = date('Y');
        $tmpYears = array();
        $tmpYears[$curYear] = $curYear;
        for ( $i = 1; $i <= 5; $i++ ) {
            $tmpYears[$curYear + $i] = $curYear + $i;
        }
        $data['years'] = $tmpYears;

        return view('backend.ortho.bookings.list3_list', $data);
    }

    /**
     * List4 list
     */
    public function list4_list(){
        $clsBooking                     = new BookingModel();
        $clsService                     = new ServiceModel();
        $clsTreatment1                  = new Treatment1Model();
        $data['list4s']                 = $clsBooking->get_list4_list(4);
        $data['services']               = $clsService->get_list();
        $data['treatment1s']            = $clsTreatment1->get_list_treatment();
        
        // set year
        $curYear = date('Y');
        $tmpYears = array();
        $tmpYears[$curYear] = $curYear;
        for ( $i = 1; $i <= 5; $i++ ) {
            $tmpYears[$curYear + $i] = $curYear + $i;
        }
        $data['years'] = $tmpYears;

        return view('backend.ortho.bookings.list4_list', $data);
    }

    /**
     * List5 list
     */
    public function list5_list(){
        $clsBooking                     = new BookingModel();
        $clsService                     = new ServiceModel();
        $clsTreatment1                  = new Treatment1Model();
        $data['list5s']                 = $clsBooking->get_list4_list(5);
        $data['services']               = $clsService->get_list();
        $data['treatment1s']            = $clsTreatment1->get_list_treatment();
        
        // set year
        $curYear = date('Y');
        $tmpYears = array();
        $tmpYears[$curYear] = $curYear;
        for ( $i = 1; $i <= 5; $i++ ) {
            $tmpYears[$curYear + $i] = $curYear + $i;
        }
        $data['years'] = $tmpYears;

        return view('backend.ortho.bookings.list5_list', $data);
    }
}
