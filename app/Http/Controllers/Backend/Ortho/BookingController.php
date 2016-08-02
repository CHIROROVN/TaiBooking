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
use App\Http\Models\Ortho\AreaModel;
use App\Http\Models\Ortho\ClinicAreaModel;
use App\Http\Models\Ortho\TemplateModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;
use Carbon;
use Response;

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
        $data['area_id']        = Input::get('area_id');
        $data['clinic_id']      = Input::get('clinic_id');
        $data['u_id']           = Input::get('u_id');
        $clsBooking             = new BookingModel();
        $clsShift               = new ShiftModel();
        $clsAreaModel           = new AreaModel();
        $clsUser                = new UserModel();
         $tmp_arr                = array();
        // $bookings               = $clsBooking->get_all($data);
        $data['areas']          = $clsAreaModel->get_list();
        $data['doctors']          = $clsUser->get_by_belong([1]);

        $shifts                 = $clsShift->get_all($data);
        foreach ( $shifts as $shift ) {
            // $booking_id     = $shift->booking_id;
            $clinic_id              = $shift->clinic_id;
            $clinic_display_name    = $shift->clinic_display_name;
            $tmp_arr[] = array(
                'title' => '<img src="' . asset('') . 'public/backend/ortho/common/image/hospital.png">'.@$clinic_display_name.'<img src="' . asset('') . 'public/backend/ortho/common/image/docter.png">' . $shift->u_name_display,
                'start' => $shift->shift_date,
                'end' => $shift->shift_date + 1,
                'url' => route('ortho.bookings.booking.daily', [ 'clinic_id'=>$clinic_id,'start_date' => $shift->shift_date ]),
            );
        }
        if ( empty($data['clinic_id']) ) {
            $tmp_arr = array();
        }

        $data['bookings'] = json_encode($tmp_arr);

        return view('backend.ortho.bookings.booking_monthly', $data);
    }

    /**
    *Ajax get clinic area id
    **/
    function getClinicByAreaID(){
        $clsClinicArea      = new ClinicAreaModel();
        $area_id            = Input::get('area_id');
        $clinics = $clsClinicArea->list_clinic_by_area($area_id);
        return response()->json($clinics);
    }

    /**
     * get view Dailily
     */
    public function bookingDaily()
    {
        $data                   = array();
        $clinic_id              = Input::get('clinic_id');
        $date_current           = date('Y-m-d');

        if(Input::get('cur')){
            $date_current  = Input::get('cur');
        }

        if ( !empty(Input::get('start_date')) ) {
            $date_current = Input::get('start_date');
        }
        if ( !empty(Input::get('prev')) ) {
            $date_current = Input::get('prev');
        }
        if (  !empty(Input::get('cur')) ) {
            $date_current = Input::get('cur');
        }
        if ( !empty(Input::get('next')) ) {
            $date_current = Input::get('next');
        }
        $data['date_current']   = $date_current;
        $data['times']          = Config::get('constants.TIME');

        $clsShift               = new ShiftModel();
        $clsBooking             = new BookingModel();
        $clsFacility            = new FacilityModel();
        $clsClinic              = new ClinicModel();
        $clsTemplate            = new TemplateModel();
        $clsTreatment1          = new Treatment1Model();
        $clsService             = new ServiceModel();
        $clsClinicService       = new ClinicServiceModel();

        $clsUser                = new UserModel();
        $data['list_doctors']   = $clsUser->get_list_users([1]);
        $data['doctors']        = $clsShift->get_by_belong([1], $date_current);
        $data['hygienists']     = $clsShift->get_by_belong([2,3], $date_current);
        $data['facilitys']      = $clsFacility->getAll($clinic_id);
        $data['clinic']         = $clsClinic->get_by_id($clinic_id);
        $data['times']          = Config::get('constants.TIME');
        $data['treatment1s']    = $clsTreatment1->get_list_treatment();
        $data['services']       = $clsService->get_list();
        $templates              = $clsTemplate->get_all();
        $bookings               = $clsBooking->get_by_clinic($clinic_id, $date_current);

        $arr_bookings           = array();
        foreach ( $data['times'] as $time ) {
            $time_replate = str_replace (':', '', $time);
            foreach ( $data['facilitys'] as $fac ) {
                foreach ( $bookings as $booking ) {
                    if ( $booking->facility_id == $fac->facility_id && $booking->booking_start_time == $time_replate ) {
                        $arr_bookings[$fac->facility_id][$time] = $booking;
                    }
                }
            }
        }
        $data['arr_bookings']       = $arr_bookings;
        return view('backend.ortho.bookings.booking_daily', $data);
    }

    /**
     * get view bookingResultCalendar
     */
    public function bookingResultCalendar()
    {
        $data                   = array();
        $date_current           = date('Y-m-d');
        if ( !empty(Input::get('prev')) ) {
            $date_current = Input::get('prev');
        }
        if (  !empty(Input::get('cur')) ) {
            $date_current = Input::get('cur');
        }
        if ( !empty(Input::get('next')) ) {
            $date_current = Input::get('next');
        }
        $data['date_current']   = $date_current;

        $clinic_id = Input::get('clinic_id');

        if ( empty($clinic_id) ) {
            return redirect()->route('ortho.bookings.booking_search');
        }

        $clsShift               = new ShiftModel();
        $clsBooking             = new BookingModel();
        $clsFacility            = new FacilityModel();
        $clsClinic              = new ClinicModel();
        $clsService             = new ServiceModel();
        $clsTreatment1          = new Treatment1Model();
        $clsUser                = new UserModel();
        $data['list_doctors']   = $clsUser->get_list_users([1]);
        $data['doctors']        = $clsShift->get_by_belong([1], $date_current);
        $data['hygienists']     = $clsShift->get_by_belong([2,3], $date_current);
        $data['facilitys']      = $clsFacility->getAll($clinic_id);
        $data['clinic']         = $clsClinic->get_by_id($clinic_id);
        $data['services']       = $clsService->get_list();
        $data['treatment1s']    = $clsTreatment1->get_list_treatment();

        $data['times']          = Config::get('constants.TIME');

        $where['clinic_id']     = $clinic_id;
        $where['booking_date']  = $date_current;
        $bookings               = $clsBooking->get_all($where);
        // $data['bookings']       = $bookings;
        $arr_bookings           = array();
        foreach ( $data['times'] as $time ) {
            $fullTime = str_replace(':', '', $time);
            $tmpTime = explode(':', $time);
            $tmpHour = $tmpTime[0];
            $tmpMin = $tmpTime[1];
            foreach ( $data['facilitys'] as $fac ) {
                foreach ( $bookings as $booking ) {
                    if ( $booking->facility_id == $fac->facility_id && $booking->booking_start_time == $fullTime ) {
                        // if ( $booking->booking_total_time < $tmpMin ) {
                            $arr_bookings[$fac->facility_id][$fullTime] = $booking;
                        // }
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

    public function bookingCancelCnf($id)
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

        return view('backend.ortho.bookings.booking_cancel_cnf', $data);
    }

    public function bookingCancel($id){
        $clsBooking                         = new BookingModel();
        $booking                            = $clsBooking->get_by_id($id);
        $dataUpdate = array(
            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => DELETE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id
        );

        $listBookingGroup = $clsBooking->get_by_group($booking->booking_group_id);
        $status = true;
        foreach ( $listBookingGroup as $item ) {
            if ( !$clsBooking->update($item->booking_id, $dataUpdate) ) {
                $status = false;
            }
        }

        if ( $status ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.bookings.booking.result.list');
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.ortho.bookings.booking_cancel_cnf', $id);
        }
    }

    public function getEdit($id)
    {
        $data                       = array();
        $clsBooking                 = new BookingModel();
        if($clsBooking->checkExistID($id)){
            $data                       = array();
            $clsUser                    = new UserModel();
            $clsClinicService           = new ClinicServiceModel();
            $clsTreatment1              = new Treatment1Model();
            $data['booking']            = $clsBooking->get_by_id($id);
            $data['doctors']            = $clsUser->get_by_belong([1]);
            $data['hygienists']         = $clsUser->get_by_belong([2,3]);
            $clsService                 = new ServiceModel();
            $data['services']           = $clsService->get_list();
            // $clsTreatment1              = new Treatment1Model();
            // $data['treatment1s']        = $clsTreatment1->get_list_treatment();
            $clsTreatment1              = new Treatment1Model();
            $data['treatment1s']        = $clsTreatment1->get_treatment_search();
            $clsFacility                = new FacilityModel();
            $data['facilities']         = $clsFacility->list_facility_all();
            $clsEquipment               = new EquipmentModel();
            $data['equipments']         = $clsEquipment->get_list();
            $clsInspection              = new InspectionModel();
            $data['inspections']        = $clsInspection->get_list();
            $clsInsurance               = new InsuranceModel();
            $data['insurances']         = $clsInsurance->get_list();
            return view('backend.ortho.bookings.booking_edit', $data);
        }else{
            return response()->view('errors.404', [], 404);
        }
    }

    public function postEdit($id)
    {
        $clsBooking                 = new BookingModel();
        $booking                    = $clsBooking->get_by_id($id);
        $arr_gid                    = array();
        $arr_gid[]                  = $booking->booking_group_id;
        $bookingGroups              = $clsBooking->get_by_group($arr_gid);
        
        $service_1 = $service_1_kind = '';

        if(!empty(Input::get('service_1'))){
            $s1k = explode('_', Input::get('service_1'));
            $s1_kind            = str_split($s1k[1], 3);
            $service_1_kind     = $s1_kind[1];

            if($service_1_kind == 2){
                $st1 = explode('#', $s1k[0]);
                $service_1      = $st1[0];
                $treatment_time_1 = $st1[1];
            }else{
                $service_1      = $s1k[0];
            }
        }

        // if(!empty(Input::get('service_2'))){
        //     $s2k = explode('_', Input::get('service_2'));
        //     $s2_kind            = str_split($s2k[1], 3);
        //     $service_2_kind     = $s2_kind[1];

        //     if($service_2_kind == 2){
        //         $st2 = explode('#', $s2k[0]);
        //         $service_2      = $st2[0];
        //         $treatment_time_2 = $st2[1];
        //     }else{
        //         $service_2      = $s2k[0];
        //     }
        // }

        $dataInput = array(
                // 'facility_id'               => Input::get('facility_id'),
                'doctor_id'                 => Input::get('doctor_id'),
                'hygienist_id'              => Input::get('hygienist_id'),
                'equipment_id'              => Input::get('equipment_id'),
                'service_1'                 => $service_1,
                'service_1_kind'            => $service_1_kind,
                // 'service_2'                 => $service_2,
                // 'service_2_kind'            => $service_2_kind,
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

        $status = true;
        foreach ( $bookingGroups as $item ) {
            if ( !$clsBooking->update($item->booking_id, $dataInput) ) {
                $status = false;
            }
        }

        if ( $status ) {
            $where                          = array();
            $where['clinic_id']             = $booking->clinic_id;
            $where['cur']                   = $booking->booking_date;
            return redirect()->route('ortho.bookings.booking.daily', $where);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.booking.edit', $id);
        }
    }

    public function getRegist($id)
    {
        $data                       = array();
        $clsBooking                 = new BookingModel();
        if($clsBooking->checkExistID($id)){
            $data                       = array();
            $clsUser                    = new UserModel();
            $clsClinicService           = new ClinicServiceModel();
            $clsTreatment1              = new Treatment1Model();
            $data['booking']            = $clsBooking->get_by_id($id);
            $data['doctors']            = $clsUser->get_by_belong([1]);
            $data['hygienists']         = $clsUser->get_by_belong([2,3]);
            $clsService                 = new ServiceModel();
            $data['services']           = $clsService->get_list();
            $clsTreatment1              = new Treatment1Model();
            $data['treatment1s']        = $clsTreatment1->get_treatment_search();
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
        }else{
            return response()->view('errors.404', [], 404);
        }
    }

    public function postRegist($id)
    {
        $clsBooking                 = new BookingModel();
        $clsTreatment1              = new Treatment1Model();
        $clsTemplate                = new TemplateModel();
        $booking                    = $clsBooking->get_by_id($id);

        $service_1 = $service_1_kind = $service_2 = $service_2_kind = null;

        if(!empty(Input::get('service_1'))){
            $s1k = explode('_', Input::get('service_1'));
            $s1_kind            = str_split($s1k[1], 3);
            $service_1_kind     = $s1_kind[1];

            if($service_1_kind == 2){
                $st1 = explode('#', $s1k[0]);
                $service_1      = $st1[0];
                $treatment_time_1 = $st1[1];
            }else{
                $service_1      = $s1k[0];
            }
        }

        if(!empty(Input::get('service_2'))){
            $s2k = explode('_', Input::get('service_2'));
            $s2_kind            = str_split($s2k[1], 3);
            $service_2_kind     = $s2_kind[1];

            if($service_2_kind == 2){
                $st2 = explode('#', $s2k[0]);
                $service_2      = $st2[0];
                $treatment_time_2 = $st2[1];
            }else{
                $service_2      = $s2k[0];
            }
        }

        $dataInput = array(
                // 'facility_id'               => Input::get('facility_id'),
                'patient_id'                => Input::get('p_id', null),
                'doctor_id'                 => Input::get('doctor_id', null),
                'hygienist_id'              => Input::get('hygienist_id', null),
                'equipment_id'              => Input::get('equipment_id', null),
                // 'service_1'                 => $service_1,
                // 'service_1_kind'            => $service_1_kind,
                // 'service_2'                 => $service_2,
                // 'service_2_kind'            => $service_2_kind,
                'inspection_id'             => Input::get('inspection_id', null),
                'insurance_id'              => Input::get('insurance_id', null),
                'emergency_flag'            => (Input::get('emergency_flag') == 'on') ? 1 : NULL,
                'booking_status'            => Input::get('booking_status'),
                'booking_recall_ym'         => Input::get('booking_recall_ym'),
                'booking_memo'              => Input::get('booking_memo'),
                'last_date'                 => date('y-m-d H:i:s'),
                'last_kind'                 => UPDATE,
                'last_ipadrs'               => CLIENT_IP_ADRS,
                'last_user'                 => Auth::user()->id
            );
        if ( $dataInput['patient_id'] == 0 ) {
            $dataInput['patient_id'] = null;
        }
        if ( $dataInput['doctor_id'] == 0 ) {
            $dataInput['doctor_id'] = null;
        }
        if ( $dataInput['hygienist_id'] == 0 ) {
            $dataInput['hygienist_id'] = null;
        }
        if ( $dataInput['equipment_id'] == 0 ) {
            $dataInput['equipment_id'] = null;
        }
        if ( $dataInput['inspection_id'] == 0 ) {
            $dataInput['inspection_id'] = null;
        }
        if ( $dataInput['insurance_id'] == 0 ) {
            $dataInput['insurance_id'] = null;
        }

        $status = true;
        // update by child group
        $whereChildGroups               = array(
            'booking_group_id'          => $booking->booking_group_id,
            'booking_childgroup_id'     => $booking->booking_childgroup_id,
        );
        $bookingChildGroups = $clsBooking->get_where($whereChildGroups);
        foreach ( $bookingChildGroups as $item ) {
            if ( !$clsBooking->update($item->booking_id, $dataInput) ) {
                $status = false;
            }
        }

        // update service_1
        $dataInput['service_1'] = $service_1;
        $dataInput['service_1_kind'] = $service_1_kind;
        if ( $service_1_kind == 2 ) {

            // no change service
            $treatment1                 = $clsTreatment1->get_by_id($service_1);
            $bookingStartTime           = $booking->booking_start_time;
            $treatment1TotalTime        = $treatment1->treatment_time;

            $mm = hourMin2Min($bookingStartTime);
            $mm = $mm + $treatment1TotalTime;
            $hhmmBookingEndTime = (int)min2HourMin($mm);

            $listBookingUpdate = $clsBooking->get_for_update_treatment1($booking->booking_date, $booking->clinic_id, $booking->facility_id, $bookingStartTime, $hhmmBookingEndTime);

            // update treatment1
            if ( count($listBookingUpdate) && (count($listBookingUpdate) >= $treatment1TotalTime/15) ) {
                // ok update
                // $dataInput['booking_group_id'] = 'group_' . $booking->booking_start_time . '_' . $hhmmBookingEndTime . '_' . $booking->clinic_id . '_' . $booking->facility_id . '_' . $booking->booking_date;
                $end = count($listBookingUpdate) - 1;
                if ( $end == 0 ) {
                    $end = 1;
                }
                // check continuity
                $statusContinuity = true;

                if ( $end > 1 ) {
                    for ( $i = 0; $i < $end ; $i++ ) {
                        if ( $listBookingUpdate[$i]->booking_start_time + 15 != $listBookingUpdate[$i + 1]->booking_start_time ) {
                            $statusContinuity = false;
                            break;
                        }
                    }
                }
                
                if ( $statusContinuity ) {
                    for ( $i = 0; $i < $end ; $i++ ) {
                        if ( !$clsBooking->update($listBookingUpdate[$i]->booking_id, $dataInput) ) {
                            $status = false;
                        }
                    }
                } else {
                    $status = false;
                }
            } else {
                $status = false;
            }
        }
        
        if ( $status ) {
            Session::flash('success', trans('common.message_regist_success'));
            $where                          = array();
            $where['clinic_id']             = @Session::get('where_booking')['clinic_id'];
            $where['doctor_id']             = @Session::get('where_booking')['doctor_id'];
            $where['hygienist_id']          = @Session::get('where_booking')['hygienist_id'];
            $where['booking_date']          = @Session::get('where_booking')['booking_date'];
            $where['week_later']            = @Session::get('where_booking')['week_later'];
            $where['clinic_service_name']   = @Session::get('where_booking')['clinic_service_name'];
            return redirect()->route('ortho.bookings.booking.result.list', $where);
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('ortho.bookings.booking.regist', ['booking_id' => $id]);
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
        $clsBooking             = new BookingModel();
        $clsInterview           = new InterviewModel();
        $clsTreatment1          = new Treatment1Model();
        $booking                = $clsBooking->get_by_id($id);
        $service_1 = $service_1_kind = $service_2 = $service_2_kind = null;

        $rules = $clsPatient->Rules();
        unset($rules['p_name']);
        unset($rules['p_name_kana']);
        unset($rules['p_sex']);
        unset($rules['p_tel']);
        unset($rules['p_email']);

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

        $validator                  = Validator::make($patientInst, $rules, $clsPatient->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.bookings.booking.1st.regist', [ $id ])->withErrors($validator)->withInput();
        }
        $p_id = $clsPatient->insert_get_id($patientInst);

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
        $service_1          = null;
        $service_1_kind     = null;
        if(!empty($s_1_kind)){
            $s1k = explode('#', $s_1_kind);
            $service_1          = $s1k[0];
            $s1_kind            = str_split($s1k[1], 3);
            $service_1_kind     = $s1_kind[1];
        }
        $s_2_kind = Input::get('service_2');
        $service_2          = null;
        $service_2_kind     = null;
        if ( !empty($s_2_kind) ) {
            $s2k = explode('#', $s_2_kind);
            $service_2          = $s2k[0];
            $s2_kind            = str_split($s2k[1], 3);
            $service_2_kind     = $s2_kind[1];
        }

        $dataInput = array(
            'patient_id'                => $p_id,
            // 'facility_id'               => Input::get('facility_id'),
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
        if ( $dataInput['patient_id'] == 0 ) {
            $dataInput['patient_id'] = null;
        }
        if ( $dataInput['doctor_id'] == 0 ) {
            $dataInput['doctor_id'] = null;
        }
        if ( $dataInput['hygienist_id'] == 0 ) {
            $dataInput['hygienist_id'] = null;
        }
        if ( $dataInput['equipment_id'] == 0 ) {
            $dataInput['equipment_id'] = null;
        }
        if ( $dataInput['inspection_id'] == 0 ) {
            $dataInput['inspection_id'] = null;
        }
        if ( $dataInput['insurance_id'] == 0 ) {
            $dataInput['insurance_id'] = null;
        }

        // check total time of treatment1
        if ( $service_1_kind == 2 ) {
            // no change service
            // if ( $booking-> ) {

            // } else {

            // }
            $treatment1                 = $clsTreatment1->get_by_id($service_1);
            $bookingStartTime           = $booking->booking_start_time;
            $treatment1TotalTime        = $treatment1->treatment_time;

            $mm = hourMin2Min($bookingStartTime);
            $mm = $mm + $treatment1TotalTime;
            $hhmmBookingEndTime = (int)min2HourMin($mm);

            $listBookingUpdate = $clsBooking->get_for_update_treatment1($booking->booking_date, $booking->clinic_id, $booking->facility_id, $bookingStartTime, $hhmmBookingEndTime);

            // update treatment1
            $status = true;
            if ( count($listBookingUpdate) && (count($listBookingUpdate) >= $treatment1TotalTime/15) ) {
                // ok update
                // $dataInput['booking_group_id'] = 'group_' . $booking->booking_start_time . '_' . $hhmmBookingEndTime . '_' . $booking->clinic_id . '_' . $booking->facility_id . '_' . $booking->booking_date;
                foreach ( $listBookingUpdate as $item ) {
                    if ( count($listBookingUpdate) == 1 ) {
                        if ( !$clsBooking->update($item->booking_id, $dataInput) ) {
                            $status = false;
                        }
                    } elseif ( $key < (count($listBookingUpdate) - 1) ) {
                        if ( !$clsBooking->update($item->booking_id, $dataInput) ) {
                            $status = false;
                        }
                    }
                }

                if ( $status ) {
                    Session::flash('success', trans('common.message_regist_success'));
                    return redirect()->route('ortho.bookings.booking.regist', ['booking_id' => $id]);
                } else {
                    Session::flash('danger', trans('common.message_regist_danger'));
                    return redirect()->route('ortho.bookings.booking.regist', ['booking_id' => $id]);
                }
            } else {
                Session::flash('danger', trans('common.message_regist_danger'));
                return redirect()->route('ortho.bookings.booking.regist', ['booking_id' => $id]);
            }

        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('ortho.bookings.booking.regist', ['booking_id' => $id]);
        }
    }

    public function getChangeDate($id)
    {
        if (Session::has('booking_change')) 
            Session::forget('booking_change');

        $clsBooking                 = new BookingModel();
        $data['booking']            = $clsBooking->get_by_id($id);
        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_list_clinic();
        $clsUser                    = new UserModel();
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
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
        if(!empty(Input::get('clinic_id')))
            $dataInput['clinic_id']         = Input::get('clinic_id');
        if(!empty(Input::get('doctor_id')))
            $dataInput['doctor_id']         = Input::get('doctor_id');
        if (!empty(Input::get('hygienist_id')))
            $dataInput['hygienist_id']      = Input::get('hygienist_id');

        switch (Input::get('week_later')) {
            case 'one_week':
                $dataInput['booking_recall_ym']   = date2YearMonth(booking_change_date($date, 'week_later'));
                $dataInput['booking_date_change'] = booking_change_date($date, 'one_week');
                break;
            case 'one_month':
                $dataInput['booking_recall_ym']   = date2YearMonth(booking_change_date($date, 'one_month'));
                $dataInput['booking_date_change'] = booking_change_date($date, 'one_month');
                break;
            case 'two_month':
                $dataInput['booking_recall_ym']   = date2YearMonth(booking_change_date($date, 'two_month'));
                $dataInput['booking_date_change'] = booking_change_date($date, 'two_month');
                break;
            case 'week_specified':
                $date_option = Input::get('week_later_option');
                $dataInput['booking_recall_ym']   = date2YearMonth(booking_change_date($date, $date_option));
                $dataInput['booking_date_change'] = booking_change_date($date, $date_option);
                break;
            case 'date_picker':
                $datepicker = Input::get('date_picker_option');
                $dataInput['booking_recall_ym']   = date('Ym', strtotime($datepicker));
                $dataInput['booking_date_change'] = $datepicker;
                break;
            default:
                $dataInput['booking_recall_ym']   = '';
                $dataInput['booking_date_change'] = $date;
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

        if(empty($dataInput['booking_recall_ym']))
            unset($dataInput['booking_recall_ym']);

        $dataInput['last_date']         = date('Y-m-d H:i:s');
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
        $dataInput                  = Session::get('booking_change');
        unset($dataInput['booking_date_change']);
        unset($dataInput['booking_id']);
        $clsBooking                 = new BookingModel();
        $booking                   = $clsBooking->get_by_id($id);
        $booking_id_arr[]          = $booking->booking_group_id;
        $bookingGroups = $clsBooking->get_by_group($booking_id_arr);

        $flag = false;
         foreach ( $bookingGroups as $item ) {
            if ($clsBooking->update($item->booking_id, $dataInput) ) {
                $flag = true;
            }
        }

        if ($flag) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.bookings.booking.edit',[$id]);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.booking.change', $id);
        }
        if (Session::has('booking_change'))
        {
            Session::forget('booking_change');
        }
    }

    //Booking Search
    public function getSearch(){
        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_list_clinic();
        $clsUser                    = new UserModel();
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
        $clsClinicService           = new ClinicServiceModel();
        $data['services']           = $clsClinicService->get_service();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_treatment_search();
        return view('backend.ortho.bookings.booking_search', $data);
    }

    public function postSearch()
     {
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

    /**
     * Booking Result List
     */
    public function bookingResultList()
    {
        $where = array();
        if(Input::get('clinic_id') != null){
            $where['clinic_id']           = Input::get('clinic_id');
            $data['clinic_id']            = Input::get('clinic_id');
        }
        if(Input::get('doctor_id') != null){
            $where['doctor_id']           = Input::get('doctor_id');
            $data['doctor_id']            = Input::get('doctor_id');
        }
        if(Input::get('hygienist_id') != null){
            $where['hygienist_id']        = Input::get('hygienist_id');
            $data['hygienist_id']         = Input::get('hygienist_id');
        }
        if(Input::get('booking_date') != null){
            $where['booking_date']        = Input::get('booking_date');
            $data['booking_date']         = Input::get('booking_date');
        }
        if(Input::get('week_later') != null){
            $where['week_later']          = Input::get('week_later');
            $data['week_later']           = Input::get('week_later');
        }
        if(Input::get('clinic_service_name') != null){
            $where['clinic_service_name'] = Input::get('clinic_service_name');
            $data['clinic_service_name']  = Input::get('clinic_service_name');
        }
        Session::put('where_booking', $where);

        $clsBooking                       = new BookingModel();
        $data['bookings']                 = $clsBooking->get_booking_list($where);
        $clsFacility                      = new FacilityModel();
        $data['facilities']               = $clsFacility->list_facility_all();
        $clsTreatment1                    = new Treatment1Model();
        $data['treatment1s']              = $clsTreatment1->get_list_treatment();
        $clsService                       = new ServiceModel();
        $data['services']                 = $clsService->get_list();
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
