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
use App\Http\Models\Ortho\DdrModel;
use App\Http\Models\Ortho\MemoModel;
use App\Http\Models\Ortho\BookingTelWaitingModel;
use App\Http\Models\Ortho\BelongModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;
use Response;
use Redirect;

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
        $clsBelong              = new BelongModel();
        $tmp_arr                = array();
        // $bookings               = $clsBooking->get_all($data);
        $data['areas']          = $clsAreaModel->get_list();
        $data['doctors']        = $clsUser->get_by_belong([1]);
        $belongDoctor           = $clsBelong->get_for_select(['s_belong_kind' => 1]);
        $tmpBelongDoctor        = array();
        foreach ( $belongDoctor as $item ) {
            $tmpBelongDoctor[$item->belong_id] = $item;
        }
        $shifts                 = $clsShift->get_all($data);

        foreach ( $shifts as $shift ) {
            if ( isset($tmpBelongDoctor[$shift->u_belong]) ) {
                // $booking_id     = $shift->booking_id;
                $clinic_id              = $shift->clinic_id;
                $clinic_display_name    = $shift->clinic_display_name;
                $tmp_arr[] = array(
                    'title' => '<img src="' . asset('') . 'public/backend/ortho/common/image/hospital.png">'.@$clinic_display_name.'<img src="' . asset('') . 'public/backend/ortho/common/image/docter.png">' . $shift->u_name_display,
                    'start' => $shift->shift_date,
                    'end' => (int)$shift->shift_date + 1,
                    'url' => route('ortho.bookings.booking.daily', [ 'clinic_id'=>$clinic_id,'start_date' => $shift->shift_date ]),
                ); 
            }
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
    *Ajax
    **/
    function getUserByClinic(){
        $clsUser                = new UserModel();
        $clinic_id              = Input::get('clinic_id');
        $users                  = $clsUser->list_user_by_clinic($clinic_id);
        return response()->json($users);
    }

    /**
     * get view Dailily
     */
    public function bookingDaily()
    {
        $data                   = array();
        $clinic_id              = Input::get('clinic_id');
        $date_current           = date('Y-m-d');

        if ( empty($clinic_id) ) {
            return redirect()->route('ortho.bookings.booking.monthly');
        }

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
        $clsDdr                 = new DdrModel();
        $clsMemo                = new MemoModel();
        $clsBelong              = new BelongModel();
        

        $data['list_doctors']   = $clsUser->get_list_users([1]);
        $data['doctors']        = $clsShift->get_by_belong([1], $date_current);
        $data['hygienists']     = $clsShift->get_by_belong([2,3], $date_current);
        $facilitys              = $clsFacility->getAll($clinic_id);
        $data['clinic']         = $clsClinic->get_by_id($clinic_id);
        $data['times']          = Config::get('constants.TIME');
        $data['treatment1s']    = $clsTreatment1->get_list_treatment();
        $data['services']       = $clsService->get_list();
        $templates              = $clsTemplate->get_all();
        $bookings               = $clsBooking->get_by_clinic($clinic_id, $date_current);
        $data['ddrs']           = $clsDdr->get_by_start_date($date_current);
        $data['memos']          = $clsMemo->get_list_by_memo_date($date_current);
        //$data['facilitys_popup']    = $clsFacility->getAll($clinic_id); //$clsFacility->getAll($clinic_id, 1)
        $shift_user             = $clsShift->get_user_shift2($clinic_id, $date_current);
        $belongs                = $clsBelong->get_all();

        $where['clinic_id']     = $clinic_id;
        $where['booking_date']  = $date_current;
        $bookings               = $clsBooking->get_all($where);

        // set facility specal
        $facilitysSpecal            = $clsFacility->get_specal_for_clinic($clinic_id);
        $tmpFacilitys               = array();
        foreach ( $facilitys as $item ) {
            $tmpFacilitys[] = $item;
        }
        if ( count($facilitysSpecal) > 0 ) {
            foreach ( $facilitysSpecal as $item ) {
                $tmpFacilitys[] = $item;
            }
        }
        $data['facilitys']          = $tmpFacilitys;
        $data['facilitys_popup']    = $tmpFacilitys;

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
        $data['arr_bookings']       = $arr_bookings;

        // shift_user, belongs
        $dataShiftUser = array();
        foreach ( $belongs as $belong ) {
            foreach ( $shift_user as $item ) {
                if ( $item->u_belong == $belong->belong_id ) {
                    $dataShiftUser[$belong->belong_name][] = $item;
                }
            }
        }
        $data['dataShiftUser'] = $dataShiftUser;

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

        $clsShift                   = new ShiftModel();
        $clsBooking                 = new BookingModel();
        $clsFacility                = new FacilityModel();
        $clsClinic                  = new ClinicModel();
        $clsService                 = new ServiceModel();
        $clsTreatment1              = new Treatment1Model();
        $clsUser                    = new UserModel();
        $data['list_doctors']       = $clsUser->get_list_users([1]);
        $data['doctors']            = $clsShift->get_by_belong([1], $date_current, $clinic_id);
        $data['hygienists']         = $clsShift->get_by_belong([2,3], $date_current, $clinic_id);
        $facilitys                  = $clsFacility->getAll($clinic_id);
        $data['clinic']             = $clsClinic->get_by_id($clinic_id);
        $data['services']           = $clsService->get_list();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        //$data['facilitys_popup']    = $clsFacility->getAll($clinic_id);

        $data['times']              = Config::get('constants.TIME');

        $where['clinic_id']         = $clinic_id;
        $where['booking_date']      = $date_current;
        $where['booking_free1']     = $date_current;
        $bookings                   = $clsBooking->get_all($where);


        // set facility specal
        $facilitysSpecal            = $clsFacility->get_specal_for_clinic($clinic_id);
        $tmpFacilitys               = array();
        foreach ( $facilitys as $item ) {
            $tmpFacilitys[] = $item;
        }
        if ( count($facilitysSpecal) > 0 ) {
            foreach ( $facilitysSpecal as $item ) {
                $tmpFacilitys[] = $item;
            }
        }
        $data['facilitys']          = $tmpFacilitys;
        $data['facilitys_popup']    = $tmpFacilitys;

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

        //facilitys zero
        // if ( count($facilitys) == 0 ) {
        //     return redirect()->route('ortho.bookings.booking.result.calendar');
        // }

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
        $data['list_doctors']       = $clsUser->get_list();
        $data['booking']            = $clsBooking->get_by_id($id);
        if ( !empty($data['booking']) ) {
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
        }else{
            return response()->view('errors.404', [], 404);
        }
    }

    public function bookingCancelCnf($id)
    {
        $data                       = array();
        $clsBooking                 = new BookingModel();
        $clsUser                    = new UserModel();
        $clsClinicService           = new ClinicServiceModel();
        $clsTreatment1              = new Treatment1Model();
        $data['list_doctors']   = $clsUser->get_list_users([1]);
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
        $clsBookingTelWaiting               = new BookingTelWaitingModel();
        $booking                            = $clsBooking->get_by_id($id);
        $dataUpdate = array(
            'service_1'                 => -1,
            'service_1_kind'            => 2,
            'service_2'                 => null,
            'service_2_kind'            => null,
            'patient_id'                => null,
            'booking_childgroup_id'     => null,
            'doctor_id'                 => null,
            'hygienist_id'              => null,
            'equipment_id'              => null,
            'inspection_id'             => null,
            'insurance_id'              => null,
            'booking_memo'              => null,
            'booking_status'            => null,

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id
        );

        $where = array(
            'clinic_id'                 => $booking->clinic_id,
            //'booking_group_id'          => $booking->booking_group_id,
            'booking_childgroup_id'     => $booking->booking_childgroup_id,
            'booking_date'              => $booking->booking_date,
        );
        if ( $booking->service_1_kind == 2 ) {
            $where['facility_id']       = $booking->facility_id;
        }
        $listBookingGroup = $clsBooking->get_where($where);
        $status = true;
        if ( empty($booking->booking_childgroup_id) ) {
            if ( !$clsBooking->update($booking->booking_id, $dataUpdate) ) {
                $status = false;
            }
        } else {
            foreach ( $listBookingGroup as $item ) {
                $statusUpdate = null;
                if ( $item->service_1_kind == 1 ) {
                    // service
                    $dataUpdateService = array(
                        'patient_id'                => null,
                        'doctor_id'                 => null,
                        'hygienist_id'              => null,
                        'equipment_id'              => null,
                        'inspection_id'             => null,
                        'insurance_id'              => null,
                        'booking_memo'              => null,
                        'booking_status'            => null,

                        'last_date'                 => date('y-m-d H:i:s'),
                        'last_kind'                 => UPDATE,
                        'last_ipadrs'               => CLIENT_IP_ADRS,
                        'last_user'                 => Auth::user()->id
                    );

                    //update specal
                    $whereChildGroupsSpecal         = array(
                        //'booking_group_id'          => $item->booking_group_id,
                        //'booking_childgroup_id'     => $item->booking_childgroup_id,
                        'clinic_id'                 => $item->booking_free1,
                        'facility_id'               => $item->facility_id,
                        'booking_date'              => $item->booking_date,
                        'booking_free1'             => $item->clinic_id,
                        'booking_start_time'        => $item->booking_start_time,
                    );
                    $bookingChildGroupsSpecal = $clsBooking->get_where($whereChildGroupsSpecal);
                    foreach ( $bookingChildGroupsSpecal as $itemSpecal ) {
                        $clsBooking->update($itemSpecal->booking_id, $dataUpdate);
                    }
                    //end update specal

                    $statusUpdate = $clsBooking->update($item->booking_id, $dataUpdateService);
                } else {
                    // treatment

                    //update specal
                    $whereChildGroupsSpecal         = array(
                        //'booking_group_id'          => $item->booking_group_id,
                        //'booking_childgroup_id'     => $item->booking_childgroup_id,
                        'clinic_id'                 => $item->booking_free1,
                        'facility_id'               => $item->facility_id,
                        'booking_date'              => $item->booking_date,
                        'booking_free1'             => $item->clinic_id,
                        'booking_start_time'        => $item->booking_start_time,
                    );
                    $bookingChildGroupsSpecal = $clsBooking->get_where($whereChildGroupsSpecal);
                    foreach ( $bookingChildGroupsSpecal as $itemSpecal ) {
                        $clsBooking->update($itemSpecal->booking_id, $dataUpdate);
                    }
                    //end update specal

                    $statusUpdate = $clsBooking->update($item->booking_id, $dataUpdate);
                }
                if ( $statusUpdate == null || !$statusUpdate ) {
                    $status = false;
                } else {
                    // and insert to table "t_booking_tell_waiting"
                    $item->insert_date = date('Y-m-d');
                    $bookingTelWaiting = (array)$item;
                    $clsBookingTelWaiting->insert($bookingTelWaiting);
                }
            }
        }

        if ( $status ) {
            Session::flash('success', trans('common.message_delete_success'));
            $where                          = array();
            $where['clinic_id']             = $booking->clinic_id;
            $where['cur']                   = $booking->booking_date;
            return redirect()->route('ortho.bookings.booking.daily', $where);
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.ortho.bookings.booking_cancel_cnf', $id);
        }
    }

    public function getEdit($id)
    {
        $data                       = array();
        $clsBooking                 = new BookingModel();
        if($clsBooking->checkExistID2($id)){
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
        $clsTreatment1              = new Treatment1Model();
        $clsFacility                = new FacilityModel();
        $booking                    = $clsBooking->get_by_id($id);
        $bookingDeleteForUpdate     = array();

        $service_1 = $service_1_kind = null;

        if ( !empty(Input::get('service_1')) && Input::get('service_1') != -1 ) {
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

        $dataUpdate = array(
            'patient_id'                => $booking->patient_id, //only regist
            'doctor_id'                 => (Input::get('doctor_id') == 0) ? null : Input::get('doctor_id'),
            'hygienist_id'              => (Input::get('hygienist_id') == 0) ? null : Input::get('hygienist_id'),
            'equipment_id'              => (Input::get('equipment_id') == 0) ? null : Input::get('equipment_id'),
            //'service_1'                 => $service_1, //only treatment
            //'service_1_kind'            => $service_1_kind, //only treatment
            'inspection_id'             => (Input::get('inspection_id') == 0) ? null : Input::get('inspection_id'),
            'insurance_id'              => (Input::get('insurance_id') == 0) ? null : Input::get('insurance_id'),
            'emergency_flag'            => (Input::get('emergency_flag') == 1) ? 1 : NULL,
            'booking_status'            => Input::get('booking_status'),
            'booking_recall_ym'         => Input::get('booking_recall_ym', null),
            'booking_memo'              => Input::get('booking_memo', null),
            //'booking_childgroup_id'     => 'group_' . $booking->booking_start_time, //only treatment

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id,

            //'first_user'                => (empty($booking->first_user)) ? Auth::user()->id : $booking->first_user, //only regist
            //'first_date'                => (empty($booking->first_date)) ? date('y-m-d H:i:s') : $booking->first_date, //only regist
        );
        $dataDelete = array(
            'service_1'                 => -1,
            'service_1_kind'            => 2,
            'service_2'                 => null,
            'service_2_kind'            => null,
            'patient_id'                => null,
            'booking_childgroup_id'     => null,
            'doctor_id'                 => null,
            'hygienist_id'              => null,
            'equipment_id'              => null,
            'inspection_id'             => null,
            'insurance_id'              => null,
            'booking_memo'              => null,

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id
        );

        //service not same treatment
        if ( $booking->service_1_kind == 1 ) {
            //service
            $whereChildGroups               = array(
                //'booking_group_id'          => $booking->booking_group_id,
                'booking_childgroup_id'     => $booking->booking_childgroup_id,
                'clinic_id'                 => $booking->clinic_id,
                'booking_date'              => $booking->booking_date,
            );
            $bookingChildGroups = $clsBooking->get_where($whereChildGroups);
            $status = true;
            if ( $status ) {
                foreach ( $bookingChildGroups as $item ) {
                    $clsBooking->update($item->booking_id, $dataUpdate);
                }
                $where                          = array();
                $where['clinic_id']             = $booking->clinic_id;
                $where['cur']                   = $booking->booking_date;
                $where['top']                   = Session::get('top');
                $where['topTable']              = Session::get('topTable');
                return redirect()->route('ortho.bookings.booking.daily', $where);
            } else {
                Session::flash('danger', trans('common.message_time_danger'));
                return redirect()->route('ortho.bookings.booking.edit', $id);
            }
        } else {
            //treatment
            $rules = array(
                'service_1' => 'required'
            );
            $messages = array(
                'service_1.required'     => trans('validation.error_service_1_required'),
            );
            $val = array(
                'service_1' => $service_1
            );
            $validator      = Validator::make($val, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->route('ortho.bookings.booking.edit', $id)->withErrors($validator)->withInput();
            }

            //step 1: get list booking will update
            $treatment1                 = $clsTreatment1->get_by_id($service_1);
            $bookingStartTime           = $booking->booking_start_time;
            $treatment1TotalTime        = $treatment1->treatment_time;
            $oldTreatment1              = $clsTreatment1->get_by_id($booking->service_1);
            $timeOldTreatment1          = 0;
            if ( !empty($oldTreatment1) ) {
                $timeOldTreatment1      = $oldTreatment1->treatment_time;
            }
            $mm = hourMin2Min($bookingStartTime);
            $mm = $mm + $treatment1TotalTime;
            $hhmmBookingEndTime = (int)min2HourMin($mm);
            $listBookingWillUpdate = $clsBooking->get_for_update_treatment1($booking->booking_date, $booking->clinic_id, $booking->facility_id, $bookingStartTime, $hhmmBookingEndTime);

            $status = true;
            //case: 1
            //check allow update
            $tmpBookingWillDelete = array();
            foreach ( $listBookingWillUpdate as $item ) {
                //check empty booking (booking_childgroup_id)
                //booking_id = booking_id is ok
                //empty patient_id is ok
                if ( !empty($item->booking_childgroup_id) && $item->booking_id != $id && !empty($item->patient_id) ) {
                    $status = false;

                    //only in edit
                    if ( $item->booking_childgroup_id == $booking->booking_childgroup_id ) {
                        $status = true;
                    }
                    //end only in edit

                    if ( !$status ) {
                        break;
                    }
                }

                //case specil: IF no patient_id but already in the child group -> need delete group
                if ( empty($item->patient_id) && !empty($item->booking_childgroup_id) ) {
                    $tmpBookingWillDelete[] = $item;
                }

                //only edit
                if ( $item->booking_childgroup_id == $booking->booking_childgroup_id ) {
                    $tmpBookingWillDelete[] = $item;
                }
                //end only edit
            }
            
            //case: 2
            //check how many box booking for treatment, 1 box = 15 min
            if ( ($treatment_time_1 / 15) > count($listBookingWillUpdate) ) {
                $status = false;
            }

            //delete old booking in group treatment IF booking_childgroup_id NOT NULL
            if ( $status ) {
                //exp:
                //group 1: 10:30 -> 10:45. Group regist: 10:15 -> 10:30
                //need delete group 1 and regist group regist
                //$tmopBookingWillDelete = group 1
                foreach ( $tmpBookingWillDelete as $item ) {
                    $whereChildGroups               = array(
                        //'booking_group_id'          => $item->booking_group_id,
                        'booking_childgroup_id'     => $item->booking_childgroup_id,
                        'clinic_id'                 => $item->clinic_id,
                        'facility_id'               => $item->facility_id,
                        'booking_date'              => $item->booking_date, //20170406
                    );
                    $bookingChildGroups = $clsBooking->get_where($whereChildGroups);
                    foreach ( $bookingChildGroups as $key => $value ) {
                        $bookingDeleteForUpdate[] = $value;

                        //update specal
                        //only for treatment1
                        $whereChildGroupsSpecal         = array(
                            //'booking_group_id'          => $value->booking_group_id,
                            'booking_childgroup_id'     => $value->booking_childgroup_id,
                            'clinic_id'                 => $value->booking_free1,
                            'facility_id'               => $value->facility_id,
                            'booking_date'              => $value->booking_date,
                            'booking_free1'             => $value->clinic_id,
                            'booking_start_time'        => $value->booking_start_time,
                        );
                        $bookingChildGroupsSpecal = $clsBooking->get_where($whereChildGroupsSpecal);
                        foreach ( $bookingChildGroupsSpecal as $itemSpecal ) {
                            $clsBooking->update($itemSpecal->booking_id, $dataDelete);
                        }
                        //end update specal

                        $clsBooking->update($value->booking_id, $dataDelete);
                    }
                }
            }
            //Session::put('bookingDeleteForUpdate', $bookingDeleteForUpdate);
            //end step 1

            //step 2: regist
            $dataUpdate['service_1'] = $service_1;
            $dataUpdate['service_1_kind'] = $service_1_kind;
            $dataUpdate['booking_childgroup_id'] = 'group_' . $booking->booking_start_time;
            if ( $status ) {
                foreach ( $listBookingWillUpdate as $item ) {
                    //update specal
                    $whereChildGroupsSpecal         = array(
                        //'booking_group_id'          => $item->booking_group_id,
                        //'booking_childgroup_id'     => $item->booking_childgroup_id,
                        'clinic_id'                 => $item->booking_free1,
                        'facility_id'               => $item->facility_id,
                        'booking_date'              => $item->booking_date,
                        'booking_free1'             => $item->clinic_id,
                        'booking_start_time'        => $item->booking_start_time,
                    );
                    $bookingChildGroupsSpecal = $clsBooking->get_where($whereChildGroupsSpecal);
                    foreach ( $bookingChildGroupsSpecal as $itemSpecal ) {
                        $clsBooking->update($itemSpecal->booking_id, $dataUpdate);
                    }
                    //end update specal

                    $clsBooking->update($item->booking_id, $dataUpdate);
                }

                $where                          = array();
                $where['clinic_id']             = $booking->clinic_id;
                $where['cur']                   = $booking->booking_date;
                $where['top']                   = Session::get('top');
                $where['topTable']              = Session::get('topTable');
                return redirect()->route('ortho.bookings.booking.daily', $where);
            } else {
                Session::flash('danger', trans('common.message_time_danger'));
                return redirect()->route('ortho.bookings.booking.edit', $id);
            }
            //end step 2
        }
    }

    public function getRegist($id)
    {
        $data                           = array();
        $clsBooking                     = new BookingModel();
        if($clsBooking->checkExistID2($id)){
            $data                       = array();
            $clsUser                    = new UserModel();
            $clsClinicService           = new ClinicServiceModel();
            $clsTreatment1              = new Treatment1Model();
            $clsPatient                 = new PatientModel();
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

            // sent booking from booked
            if ( Session::has('booking_id') ) {
                $data['bookingFromBooked'] = $clsBooking->get_by_id(Session::get('booking_id'));
                $data['patient'] = $clsPatient->get_by_id($data['bookingFromBooked']->patient_id);
            }

            return view('backend.ortho.bookings.booking_regist', $data);
        }else{
            return response()->view('errors.404', [], 404);
        }
    }

    public function postRegist($id)
    {
        $clsBooking                 = new BookingModel();
        $clsTreatment1              = new Treatment1Model();
        $booking                    = $clsBooking->get_by_id($id);
        $bookingDeleteForUpdate     = array();

        $service_1 = $service_1_kind = null;

        if ( !empty(Input::get('service_1')) && Input::get('service_1') != -1 ) {
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

        $dataUpdate = array(
            'patient_id'                => (Input::get('p_id') == 0) ? null : Input::get('p_id'),
            'doctor_id'                 => (Input::get('doctor_id') == 0) ? null : Input::get('doctor_id'),
            'hygienist_id'              => (Input::get('hygienist_id') == 0) ? null : Input::get('hygienist_id'),
            'equipment_id'              => (Input::get('equipment_id') == 0) ? null : Input::get('equipment_id'),
            //'service_1'                 => $service_1, //only treatment
            //'service_1_kind'            => $service_1_kind, //only treatment
            'inspection_id'             => (Input::get('inspection_id') == 0) ? null : Input::get('inspection_id'),
            'insurance_id'              => (Input::get('insurance_id') == 0) ? null : Input::get('insurance_id'),
            'emergency_flag'            => (Input::get('emergency_flag') == 1) ? 1 : NULL,
            'booking_status'            => Input::get('booking_status'),
            'booking_recall_ym'         => Input::get('booking_recall_ym', null),
            'booking_memo'              => Input::get('booking_memo', null),
            //'booking_childgroup_id'     => 'group_' . $booking->booking_start_time, //only treatment

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id,

            'first_user'                => (empty($booking->first_user)) ? Auth::user()->id : $booking->first_user,
            'first_date'                => (empty($booking->first_date)) ? date('y-m-d H:i:s') : $booking->first_date,
        );
        $dataDelete = array(
            'service_1'                 => -1,
            'service_1_kind'            => 2,
            'service_2'                 => null,
            'service_2_kind'            => null,
            'patient_id'                => null,
            'booking_childgroup_id'     => null,
            'doctor_id'                 => null,
            'hygienist_id'              => null,
            'equipment_id'              => null,
            'inspection_id'             => null,
            'insurance_id'              => null,
            'booking_memo'              => null,

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id
        );

        //service not same treatment
        if ( $booking->service_1_kind == 1 ) {
            //service
            $whereChildGroups               = array(
                //'booking_group_id'          => $booking->booking_group_id,
                'booking_childgroup_id'     => $booking->booking_childgroup_id,
                'clinic_id'                 => $booking->clinic_id,
                'booking_date'              => $booking->booking_date,
            );
            $bookingChildGroups = $clsBooking->get_where($whereChildGroups);
            $status = true;
            if ( $status ) {
                foreach ( $bookingChildGroups as $item ) {
                    $clsBooking->update($item->booking_id, $dataUpdate);
                }
                $where                          = array();
                $where['clinic_id']             = $booking->clinic_id;
                $where['cur']                   = $booking->booking_date;
                $where['top']                   = Session::get('top');
                $where['topTable']              = Session::get('topTable');
                return redirect()->route('ortho.bookings.booking.daily', $where);
            } else {
                Session::flash('danger', trans('common.message_time_danger'));
                return redirect()->route('ortho.bookings.booking.regist', $id);
            }
        } else {
            //treatment
            $rules = array(
                'service_1' => 'required'
            );
            $messages = array(
                'service_1.required'     => trans('validation.error_service_1_required'),
            );
            $val = array(
                'service_1' => $service_1
            );
            $validator      = Validator::make($val, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->route('ortho.bookings.booking.regist', $id)->withErrors($validator)->withInput();
            }

            //step 1: get list booking will update
            $treatment1                 = $clsTreatment1->get_by_id($service_1);
            $bookingStartTime           = $booking->booking_start_time;
            $treatment1TotalTime        = $treatment1->treatment_time;
            $oldTreatment1              = $clsTreatment1->get_by_id($booking->service_1);
            $timeOldTreatment1          = 0;
            if ( !empty($oldTreatment1) ) {
                $timeOldTreatment1      = $oldTreatment1->treatment_time;
            }
            $mm = hourMin2Min($bookingStartTime);
            $mm = $mm + $treatment1TotalTime;
            $hhmmBookingEndTime = (int)min2HourMin($mm);
            $listBookingWillUpdate = $clsBooking->get_for_update_treatment1($booking->booking_date, $booking->clinic_id, $booking->facility_id, $bookingStartTime, $hhmmBookingEndTime);

            $status = true;
            //case: 1
            //check allow update
            $tmpBookingWillDelete = array();
            foreach ( $listBookingWillUpdate as $item ) {
                //check empty booking (booking_childgroup_id)
                //booking_id = booking_id is ok
                //empty patient_id is ok
                if ( !empty($item->booking_childgroup_id) && $item->booking_id != $id && !empty($item->patient_id) ) {
                    $status = false;
                    break;
                }

                //case specil: IF no patient_id but already in the child group -> need delete group
                if ( empty($item->patient_id) && !empty($item->booking_childgroup_id) ) {
                    $tmpBookingWillDelete[] = $item;
                }
            }
            
            //case: 2
            //check how many box booking for treatment, 1 box = 15 min
            if ( ($treatment_time_1 / 15) > count($listBookingWillUpdate) ) {
                $status = false;
            }

            //delete old booking in group treatment IF booking_childgroup_id NOT NULL
            if ( $status ) {
                //exp:
                //group 1: 10:30 -> 10:45. Group regist: 10:15 -> 10:30
                //need delete group 1 and regist group regist
                //$tmopBookingWillDelete = group 1
                foreach ( $tmpBookingWillDelete as $item ) {
                    $whereChildGroups               = array(
                        //'booking_group_id'          => $item->booking_group_id,
                        'booking_childgroup_id'     => $item->booking_childgroup_id,
                        'clinic_id'                 => $item->clinic_id,
                        'facility_id'               => $item->facility_id,
                        'booking_date'              => $item->booking_date, //this is resolve
                    );
                    $bookingChildGroups = $clsBooking->get_where($whereChildGroups);
                    foreach ( $bookingChildGroups as $key => $value ) {
                        $bookingDeleteForUpdate[] = $value;
                        
                        //update specal
                        //only for treatment1
                        $whereChildGroupsSpecal         = array(
                            //'booking_group_id'          => $value->booking_group_id,
                            'booking_childgroup_id'     => $value->booking_childgroup_id,
                            'clinic_id'                 => $value->booking_free1,
                            'facility_id'               => $value->facility_id,
                            'booking_date'              => $value->booking_date,
                            'booking_free1'             => $value->clinic_id,
                            'booking_start_time'        => $value->booking_start_time,
                        );
                        $bookingChildGroupsSpecal = $clsBooking->get_where($whereChildGroupsSpecal);
                        foreach ( $bookingChildGroupsSpecal as $itemSpecal ) {
                            $clsBooking->update($itemSpecal->booking_id, $dataDelete);
                        }
                        //end update specal

                        $clsBooking->update($value->booking_id, $dataDelete);
                    }    
                }
            }
            //Session::put('bookingDeleteForUpdate', $bookingDeleteForUpdate);
            //end step 1

            //step 2: regist
            $dataUpdate['service_1'] = $service_1;
            $dataUpdate['service_1_kind'] = $service_1_kind;
            $dataUpdate['booking_childgroup_id'] = 'group_' . $booking->booking_start_time;
            if ( $status ) {
                foreach ( $listBookingWillUpdate as $item ) {
                    $clsBooking->update($item->booking_id, $dataUpdate);

                    //update specal
                    //only for treatment1
                    $whereChildGroupsSpecal         = array(
                        //'booking_group_id'          => $item->booking_group_id,
                        //'booking_childgroup_id'     => $item->booking_childgroup_id,
                        'clinic_id'                 => $item->booking_free1,
                        'facility_id'               => $item->facility_id,
                        'booking_date'              => $item->booking_date,
                        'booking_free1'             => $item->clinic_id,
                        'booking_start_time'        => $item->booking_start_time,
                    );
                    $bookingChildGroupsSpecal = $clsBooking->get_where($whereChildGroupsSpecal);
                    foreach ( $bookingChildGroupsSpecal as $itemSpecal ) {
                        $clsBooking->update($itemSpecal->booking_id, $dataUpdate);
                    }
                    //end update specal
                }
                $where                          = array();
                $where['clinic_id']             = $booking->clinic_id;
                $where['cur']                   = $booking->booking_date;
                $where['top']                   = Session::get('top');
                $where['topTable']              = Session::get('topTable');
                return redirect()->route('ortho.bookings.booking.daily', $where);
            } else {
                Session::flash('danger', trans('common.message_time_danger'));
                return redirect()->route('ortho.bookings.booking.regist', $id);
            }
            //end step 2
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

        return view('backend.ortho.bookings.booking_1st_regist', $data);
    }

    public function post1stRegist($id)
    {
        $clsBooking                 = new BookingModel();
        $clsTreatment1              = new Treatment1Model();
        $clsPatient                 = new PatientModel();
        $clsInterview               = new InterviewModel();
        $booking                    = $clsBooking->get_by_id($id);
        $bookingDeleteForUpdate     = array();

        // insert new patient
        $dataPatient = array(
            // 'p_name'                 => Input::get('p_name'),
            // 'p_name_kana'            => Input::get('p_name_kana'),
            'p_name_f'                  => Input::get('p_name_f'),
            'p_name_g'                  => Input::get('p_name_g'),
            'p_name_f_kana'             => Input::get('p_name_f_kana'),
            'p_name_g_kana'             => Input::get('p_name_g_kana'),
            'p_sex'                     => Input::get('p_name'),
            'p_tel'                     => Input::get('p_tel'),

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => INSERT,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id
        );
        $p_id = $clsPatient->insert_get_id($dataPatient);

        // insert to table "Interview"
        if ( Input::get('insert_to_tbl_first') == 1 ) {
            $dataInterview = array(
                'patient_id'                => $p_id,
                'booking_id'                => $booking->booking_id,

                'last_date'                 => date('y-m-d H:i:s'),
                'last_kind'                 => INSERT,
                'last_ipadrs'               => CLIENT_IP_ADRS,
                'last_user'                 => Auth::user()->id
            );
            $clsInterview->insert($dataInterview);
        }

        $service_1 = $service_1_kind = null;

        if ( !empty(Input::get('service_1')) && Input::get('service_1') != -1 ) {
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

        $dataUpdate = array(
            'patient_id'                => $p_id,
            'doctor_id'                 => (Input::get('doctor_id') == 0) ? null : Input::get('doctor_id'),
            'hygienist_id'              => (Input::get('hygienist_id') == 0) ? null : Input::get('hygienist_id'),
            'equipment_id'              => (Input::get('equipment_id') == 0) ? null : Input::get('equipment_id'),
            //'service_1'                 => $service_1, //only treatment
            //'service_1_kind'            => $service_1_kind, //only treatment
            'inspection_id'             => (Input::get('inspection_id') == 0) ? null : Input::get('inspection_id'),
            'insurance_id'              => (Input::get('insurance_id') == 0) ? null : Input::get('insurance_id'),
            'emergency_flag'            => (Input::get('emergency_flag') == 1) ? 1 : NULL,
            'booking_status'            => Input::get('booking_status'),
            'booking_recall_ym'         => Input::get('booking_recall_ym', null),
            'booking_memo'              => Input::get('booking_memo', null),
            //'booking_childgroup_id'     => 'group_' . $booking->booking_start_time, //only treatment

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id,

            'first_user'                => (empty($booking->first_user)) ? Auth::user()->id : $booking->first_user,
            'first_date'                => (empty($booking->first_date)) ? date('y-m-d H:i:s') : $booking->first_date,
        );
        $dataDelete = array(
            'service_1'                 => -1,
            'service_1_kind'            => 2,
            'service_2'                 => null,
            'service_2_kind'            => null,
            'patient_id'                => null,
            'booking_childgroup_id'     => null,
            'doctor_id'                 => null,
            'hygienist_id'              => null,
            'equipment_id'              => null,
            'inspection_id'             => null,
            'insurance_id'              => null,
            'booking_memo'              => null,

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id
        );

        //service not same treatment
        if ( $booking->service_1_kind == 1 ) {
            //service
            $whereChildGroups               = array(
                //'booking_group_id'          => $booking->booking_group_id,
                'booking_childgroup_id'     => $booking->booking_childgroup_id,
                'clinic_id'                 => $booking->clinic_id,
                'booking_date'              => $booking->booking_date,
            );
            $bookingChildGroups = $clsBooking->get_where($whereChildGroups);
            $status = true;
            if ( $status ) {
                foreach ( $bookingChildGroups as $item ) {
                    $clsBooking->update($item->booking_id, $dataUpdate);
                }
                $where                          = array();
                $where['clinic_id']             = $booking->clinic_id;
                $where['cur']                   = $booking->booking_date;
                $where['top']                   = Session::get('top');
                $where['topTable']              = Session::get('topTable');
                return redirect()->route('ortho.bookings.booking.daily', $where);
            } else {
                Session::flash('danger', trans('common.message_time_danger'));
                return redirect()->route('oortho.bookings.booking.1st.regist', $id);
            }
        } else {
            //treatment
            $rules = array(
                'service_1' => 'required'
            );
            $messages = array(
                'service_1.required'     => trans('validation.error_service_1_required'),
            );
            $val = array(
                'service_1' => $service_1
            );
            $validator      = Validator::make($val, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->route('ortho.bookings.booking.1st.regist', $id)->withErrors($validator)->withInput();
            }

            //step 1: get list booking will update
            $treatment1                 = $clsTreatment1->get_by_id($service_1);
            $bookingStartTime           = $booking->booking_start_time;
            $treatment1TotalTime        = $treatment1->treatment_time;
            $oldTreatment1              = $clsTreatment1->get_by_id($booking->service_1);
            $timeOldTreatment1          = 0;
            if ( !empty($oldTreatment1) ) {
                $timeOldTreatment1      = $oldTreatment1->treatment_time;
            }
            $mm = hourMin2Min($bookingStartTime);
            $mm = $mm + $treatment1TotalTime;
            $hhmmBookingEndTime = (int)min2HourMin($mm);
            $listBookingWillUpdate = $clsBooking->get_for_update_treatment1($booking->booking_date, $booking->clinic_id, $booking->facility_id, $bookingStartTime, $hhmmBookingEndTime);

            $status = true;
            //case: 1
            //check allow update
            $tmpBookingWillDelete = array();
            foreach ( $listBookingWillUpdate as $item ) {
                //check empty booking (booking_childgroup_id)
                //booking_id = booking_id is ok
                //empty patient_id is ok
                if ( !empty($item->booking_childgroup_id) && $item->booking_id != $id && !empty($item->patient_id) ) {
                    $status = false;
                    break;
                }

                //case specil: IF no patient_id but already in the child group -> need delete group
                if ( empty($item->patient_id) && !empty($item->booking_childgroup_id) ) {
                    $tmpBookingWillDelete[] = $item;
                }
            }
            
            //case: 2
            //check how many box booking for treatment, 1 box = 15 min
            if ( ($treatment_time_1 / 15) > count($listBookingWillUpdate) ) {
                $status = false;
            }

            //delete old booking in group treatment IF booking_childgroup_id NOT NULL
            if ( $status ) {
                //exp:
                //group 1: 10:30 -> 10:45. Group regist: 10:15 -> 10:30
                //need delete group 1 and regist group regist
                //$tmopBookingWillDelete = group 1
                foreach ( $tmpBookingWillDelete as $item ) {
                    $whereChildGroups               = array(
                        //'booking_group_id'          => $item->booking_group_id,
                        'booking_childgroup_id'     => $item->booking_childgroup_id,
                        'clinic_id'                 => $item->clinic_id,
                        'facility_id'               => $item->facility_id,
                        'booking_date'              => $item->booking_date, //this is resolve
                    );
                    $bookingChildGroups = $clsBooking->get_where($whereChildGroups);
                    foreach ( $bookingChildGroups as $key => $value ) {
                        $bookingDeleteForUpdate[] = $value;
                        $clsBooking->update($value->booking_id, $dataDelete);
                        
                    }    
                }
            }
            //Session::put('bookingDeleteForUpdate', $bookingDeleteForUpdate);
            //end step 1

            //step 2: regist
            $dataUpdate['service_1'] = $service_1;
            $dataUpdate['service_1_kind'] = $service_1_kind;
            $dataUpdate['booking_childgroup_id'] = 'group_' . $booking->booking_start_time;
            if ( $status ) {
                foreach ( $listBookingWillUpdate as $item ) {

                    //update specal
                    //only for treatment1
                    $whereChildGroupsSpecal         = array(
                        //'booking_group_id'          => $item->booking_group_id,
                        //'booking_childgroup_id'     => $item->booking_childgroup_id,
                        'clinic_id'                 => $item->booking_free1,
                        'facility_id'               => $item->facility_id,
                        'booking_date'              => $item->booking_date,
                        'booking_free1'             => $item->clinic_id,
                        'booking_start_time'        => $item->booking_start_time,
                    );
                    $bookingChildGroupsSpecal = $clsBooking->get_where($whereChildGroupsSpecal);
                    foreach ( $bookingChildGroupsSpecal as $itemSpecal ) {
                        $clsBooking->update($itemSpecal->booking_id, $dataUpdate);
                    }
                    //end update specal

                    $clsBooking->update($item->booking_id, $dataUpdate);
                }
                $where                          = array();
                $where['clinic_id']             = $booking->clinic_id;
                $where['cur']                   = $booking->booking_date;
                $where['top']                   = Session::get('top');
                $where['topTable']              = Session::get('topTable');
                return redirect()->route('ortho.bookings.booking.daily', $where);
            } else {
                Session::flash('danger', trans('common.message_time_danger'));
                return redirect()->route('ortho.bookings.booking.1st.regist', $id);
            }
            //end step 2
        }
    }

    public function getBookingChange($booking_id)
    {
        if(Session::has('where_booking_change')) Session::forget('where_booking_change');
        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_list_clinic();
        $clsUser                    = new UserModel();
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
        $clsClinicService           = new ClinicServiceModel();
        $data['services']           = $clsClinicService->get_service();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_treatment_search();
        $data['booking_id']         = $booking_id;
        $clsBooking                 = new BookingModel();
        $data['booking']            = $clsBooking->get_by_id($booking_id);

        return view('backend.ortho.bookings.booking_change', $data);
    }

    public function postBookingChange($booking_id)
    {
        $condition = array();
        if(Input::has('BookingCalendar')){
            if(!empty(Input::get('clinic_id'))){
                $condition['clinic_id']         = Input::get('clinic_id');
            }

            if(!empty(Input::get('week_later'))){
                if(Input::get('week_later') == 'week_specified'){
                    $condition['next'] = cal_date(Input::get('week_later_option'));
                }elseif (Input::get('week_later') == 'date_picker') {
                    $condition['next'] = formatDate(Input::get('date_picker_option'), '-');
                }else{
                    $condition['next'] = cal_date(Input::get('week_later'));
                }
            }

            return redirect()->route('ortho.bookings.booking.result.calendar', $condition);

        }else if(Input::has('BookingList')){
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

            if(!empty(Input::get('bk_start_hour')) && !empty(Input::get('bk_start_min'))){
                $condition['booking_start_time']    = (int) Input::get('bk_start_hour').Input::get('bk_start_min');
            }else if(!empty(Input::get('bk_start_hour')) && empty(Input::get('bk_start_min'))){
                $condition['booking_start_time']    = (int) Input::get('bk_start_hour').'00';
            }else if(empty(Input::get('bk_start_hour')) && !empty(Input::get('bk_start_min'))){
                $condition['booking_start_time']    = (int) '00'.Input::get('bk_start_min');
            }
        }

        if(!empty(Input::get('clinic_service_name')))
            $condition['clinic_service_name']         = Input::get('clinic_service_name');

        $condition['booking_id']                      = $booking_id;

        return redirect()->route('ortho.bookings.booking_change_list', $condition);
        }
    }

    public function bookingChangeList($booking_id)
    {
        if(Session::has('where_booking_change')) Session::forget('where_booking_change');
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
        if(Input::get('booking_start_time') != null){
            $where['booking_start_time']          = (int)Input::get('booking_start_time');
            $data['booking_start_time']           = (int)Input::get('booking_start_time');
        }
        if(Input::get('clinic_service_name') != null){
            $where['clinic_service_name'] = Input::get('clinic_service_name');
            $data['clinic_service_name']  = Input::get('clinic_service_name');
        }

        Session::put('where_booking_change', $where);

        $clsBooking                       = new BookingModel();
        $booking                          = $clsBooking->get_by_id($booking_id);
        $where['service_1']               = $booking->service_1;
        $where['service_1_kind']          = $booking->service_1_kind;

        $bookings                         = $clsBooking->get_booking_list2($where);

        $clsFacility                      = new FacilityModel();
        $data['facilities']               = $clsFacility->list_facility_all();
        $clsTreatment1                    = new Treatment1Model();
        $data['treatment1s']              = $clsTreatment1->get_list_treatment();
        $clsService                       = new ServiceModel();
        $data['services']                 = $clsService->get_list();

        $data['booking_id']               = $booking_id;

        if(!empty(Input::get('week_later'))){
            $data['week_later']           =  cal_change_date(Input::get('week_later'));
        }


        if(!empty(Input::get('clinic_service_name'))){
            $sk = explode('_', Input::get('clinic_service_name'));
            $service           = $sk[0];
            $s_kind            = str_split($sk[1], 2);
            $service_kind      = $s_kind[1];
            
            if($service_kind == 2){ 
                //refine booking----------------------------------------
                // get treatment
                $treatment = null;
                $timeTreatment = 0;
                if ( Input::get('clinic_service_name') ) {
                    $idTreatment = explode('#', Input::get('clinic_service_name'));
                    $idTreatment = $idTreatment[0];
                    $treatment = $clsTreatment1->get_by_id($idTreatment);
                    $timeTreatment = $treatment->treatment_time;
                }

                // get booking: ($bookings) andcheck booking
                $typeFacility = array();
                foreach ( $bookings as $item ) {
                    if ( !in_array($item->facility_id, $typeFacility) ) {
                        $typeFacility[] = $item->facility_id;
                    }
                }

                $tmpBookings = array();
                foreach ( $typeFacility as $itemFac ) {
                    $tmp = array();
                    foreach ( $bookings as $item ) {
                        if ( $item->facility_id == $itemFac ) {
                            $tmp[] = $item;
                        }
                    }
                    $tmpBookings[$itemFac] = $tmp;
                }

                // return list booking is ok
                $tmpBookingTimeOk = array();
                $timeTreatmentNumber = $timeTreatment / 15;
                foreach ( $tmpBookings as $key => $values ) {
                    foreach ( $values as $keyBooking => $itemBooking ) {
                        $where = true;
                        for ( $i = 0; $i < $timeTreatmentNumber; $i++ ) {
                            if ( !isset($values[$keyBooking + $i]) ) {
                                $where = false;
                                break;
                            }
                        }
                        if ( $where ) {
                            $whereTime = true;
                            for ( $i = 0; $i < $timeTreatmentNumber - 1; $i++ ) {
                                if ( convertStartTime($values[$keyBooking + $i]->booking_start_time + 15) != convertStartTime($values[$keyBooking + $i + 1]->booking_start_time) ) {
                                    $whereTime = false;
                                }
                            }
                            //(convertStartTime($values[$keyBooking]->booking_start_time + 15)) == convertStartTime($values[$keyBooking + 1]->booking_start_time) && (convertStartTime($values[$keyBooking + 1]->booking_start_time + 15)) == convertStartTime($values[$keyBooking + 2]->booking_start_time)
                            if ( $whereTime ) {
                                $tmpBookingTimeOk[] = $values[$keyBooking];
                            }
                        }
                    }
                }

                $data['bookings'] = $tmpBookingTimeOk;
                //refine booking----------------------------------------
            }else if($service_kind == 1){
                //Service
                $data['bookings'] = $bookings;
            }

        }else{
            $data['bookings'] = $bookings;
        }

        return view('backend.ortho.bookings.booking_change_list', $data);
    }

    public function getConfirm($booking_id, $id)
    {
        $clsBooking                         = new BookingModel();
        if($clsBooking->checkExistID2($booking_id) || $clsBooking->checkExistID2($id)){
            $curr_booking                   = $clsBooking->get_by_id($booking_id);
            $data['booking']                = $curr_booking;

            $clsClinic                      = new ClinicModel();
            $data['clinics']                = $clsClinic->get_list_clinic();
            $clsUser                        = new UserModel();
            $data['doctors']                = $clsUser->get_list();
            $data['hygienists']             = $clsUser->get_list();
            $clsService                     = new ServiceModel();
            $data['services']               = $clsService->get_list();
            $clsTreatment1                  = new Treatment1Model();
            $data['treatment1s']            = $clsTreatment1->get_list_treatment();
            $clsEquipment                   = new EquipmentModel();
            $data['equipments']             = $clsEquipment->get_list();
            $clsInspection                  = new InspectionModel();
            $data['inspections']            = $clsInspection->get_list();
            $clsInsurance                   = new InsuranceModel();
            $data['insurances']             = $clsInsurance->get_list();
            $clsFacility                    = new FacilityModel();
            $data['facilities']             = $clsFacility->list_facility_all();

            $data['booking_id']             = $booking_id;
            $data['id']                     = $id;

            $new_booking                    = $clsBooking->get_by_id($id);

            $new_booking_date               = $new_booking->booking_date;
            $new_facility_id                = $new_booking->facility_id;
            $new_facility_name              = $new_booking->facility_name;
            $new_booking_start_time         = $new_booking->booking_start_time;

            $data['booking_change']         = (Object)array_merge((array)$curr_booking, array(
                                            'booking_date'          => $new_booking_date,
                                            'booking_start_time'    => $new_booking_start_time,
                                            'facility_id'           => $new_facility_id,
                                            'facility_Name'         => $new_facility_name,
                                            'last_date'             => date('Y-m-d H:i:s'),
                                            'last_user'             => Auth::user()->id,
                                            ));
            return view('backend.ortho.bookings.booking_change_confirm', $data);
        }else{
            return response()->view('errors.404', [], 404);
        }
    }

    public function postConfirm($booking_id, $id)
    {
        $clsBooking                     = new BookingModel();

        //Booking New
        $new_booking                    = $clsBooking->get_by_id($id);
        $new_booking_date               = $new_booking->booking_date;
        $new_facility_id                = $new_booking->facility_id;
        $new_booking_start_time         = $new_booking->booking_start_time;
        $new_booking_group              = $new_booking->booking_group_id;
        $new_booking_childgroup_id      = $new_booking->booking_childgroup_id;
        $new_service_1_kind             = $new_booking->service_1_kind;

        //Booking Old
        $old_booking                    = $clsBooking->get_by_id($booking_id);
        $old_booking_childgroup_id      = $old_booking->booking_childgroup_id;
        $old_booking_group_id           = $old_booking->booking_group_id;
        $old_patient_id                 = $old_booking->patient_id;
        $old_facility_id                = $old_booking->facility_id;
        $old_service_1                  = $old_booking->service_1;
        $old_service_kind               = $old_booking->service_1_kind;
        $old_booking_date               = $old_booking->booking_date;
        $old_booking_start_time         = $old_booking->booking_start_time;

        //Condition
        $condition                      = array();
        $condition['clinic_id']         = $old_booking->clinic_id;
        $condition['next']              = $new_booking_date;

        //new booking_group_id
        if(!empty($new_booking_group)){
            $tmpGroup                       = explode('_', $new_booking_group);
            $booking_group_id = $tmpGroup[0].'_'.$new_booking_date;
        }else{
            $booking_group_id = $old_booking_group_id;
        }

        //new booking_childgroup_id
        $tmpChildGroup                  = explode('_', $old_booking_childgroup_id);
        if(!empty($tmpChildGroup[1])){
            $booking_childgroup_id = 'group_'.$new_booking_start_time.(!empty($tmpChildGroup[2]) ? '_'.$tmpChildGroup[2] : '').(!empty($tmpChildGroup[3]) ? '_'.$tmpChildGroup[3] : '').(!empty($tmpChildGroup[4]) ? '_'.$tmpChildGroup[4] : '');
        }else{
            $booking_childgroup_id = 'group_'.$new_booking_start_time;
        }

        $old_start_time  = (int)$old_booking_start_time;

        //old booking group
        $oldGroupBooking                  = $clsBooking->get_by_child_group2($old_patient_id, $old_booking_group_id, $old_booking_childgroup_id, $old_facility_id, $old_start_time);
        
        //count old booking
        $limit = count($oldGroupBooking);

        $new_start_time = (int)$new_booking_start_time;
        $newGroupBooking                = $clsBooking->get_new_booking_child_group($new_booking_date, $new_start_time, $new_facility_id, $new_booking_group, $new_booking_childgroup_id, $new_service_1=-1, $new_service_1_kind, $limit);

        $data_bk_change     = array();
        $where              = Session::get('where_booking_change');

        if(!empty($where['clinic_id'])) $data_bk_change['clinic_id'] = $where['clinic_id'];
        if(!empty($where['doctor_id'])) $data_bk_change['doctor_id'] = $where['doctor_id'];
        if(!empty($where['hygienist_id'])) $data_bk_change['hygienist_id'] = $where['hygienist_id'];

        if(!empty($where['clinic_service_name'])){
            $tmp_service        = explode('_', $where['clinic_service_name']);
            $service            = $tmp_service[0];
            $s_kind             = str_split($tmp_service[1], 2);
            $service_kind       = $s_kind[1];

            $data_bk_change['service_1']        = $service;
            $data_bk_change['service_1_kind']   = $service_kind;
        }

        $flag = false;

        //update new booking
        foreach ($newGroupBooking as $key=>$newbk) {
            if( $clsBooking->update($newbk->booking_id, array_merge($data_bk_change ,array(
                                        'patient_id'            => $old_patient_id,
                                        'booking_date'          => $new_booking_date,
                                        'booking_start_time'    => $new_start_time,
                                        'booking_group_id'      => $booking_group_id,
                                        'booking_childgroup_id' => $booking_childgroup_id,
                                        'first_date'            => $old_booking->first_date,
                                        'last_date'             => date('Y-m-d H:i:s'),
                                        'last_user'             => Auth::user()->id,
                                        'last_kind'             => UPDATE
                                    ))) ){
                $flag = true;
            }

            $new_start_time                  = convertStartTime($new_start_time + 15);
        }

        // delete old booking
        foreach ($oldGroupBooking as $gbk) {
            if ($clsBooking->update($gbk->booking_id, array(
                                        'patient_id'            => NULL,
                                        'booking_date'          => $old_booking_date,
                                        'booking_start_time'    => $old_start_time,
                                        'booking_group_id'      => $old_booking_group_id,
                                        'booking_childgroup_id' => NULL,
                                        // 'facility_id'           => !empty(@$newFacility[$key]) ? @$newFacility[$key] : $old_facility_id,
                                        'service_1'             => -1,
                                        'last_date'             => date('Y-m-d H:i:s'),
                                        'last_user'             => Auth::user()->id,
                                        'last_kind'             => UPDATE
                                    )) ) {
                
            }

            $old_start_time = convertStartTime($old_start_time + 15);
        }

        if ($flag == true) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.bookings.booking.result.calendar', $condition);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.booking_change_list', array_merge(array('booking_id'=>$booking_id),$where));
            if(Session::has('where_booking_change')) Session::forget('where_booking_change');
        }
        if(Session::has('where_booking_change')) Session::forget('where_booking_change');
    }

    //Booking Search
    public function getSearch(){
        if ( Input::get('booking_id') ) {
            Session::put('booking_id', Input::get('booking_id'));
        }

        if ( Input::get('search') ) {
            $data['search']         = Input::get('search');
        }

        $clsBooking                 = new BookingModel();
        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_list_clinic();
        $clsUser                    = new UserModel();
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
        $clsClinicService           = new ClinicServiceModel();
        $data['services']           = $clsClinicService->get_service();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_treatment_search();

        if ( Input::get('booking_id') ) {
            $data['booking']        = $clsBooking->get_by_id(Input::get('booking_id'));
        }

        return view('backend.ortho.bookings.booking_search', $data);
    }

    public function postSearch()
     {
        $clsTreatment1              = new Treatment1Model();

        $condition = array();
        if(Input::has('BookingCalendar')){
            if(!empty(Input::get('clinic_id')))
                $condition['clinic_id'] = Input::get('clinic_id');

            if(!empty(Input::get('week_later'))){
                if(Input::get('week_later') == 'week_specified'){
                $condition['next'] = cal_date(Input::get('week_later_option'));
                }elseif (Input::get('week_later') == 'date_picker') {
                    $condition['next'] = formatDate(Input::get('date_picker_option'), '-');
                }else{
                    $condition['next'] = cal_date(Input::get('week_later'));
                }
            }
            return redirect()->route('ortho.bookings.booking.result.calendar', $condition);
        }else if(Input::has('BookingList')){
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
        $bookings                         = $clsBooking->get_booking_list2($where);

        $clsFacility                      = new FacilityModel();
        $data['facilities']               = $clsFacility->list_facility_all();
        $clsTreatment1                    = new Treatment1Model();
        $data['treatment1s']              = $clsTreatment1->get_list_treatment();
        $clsService                       = new ServiceModel();
        $data['services']                 = $clsService->get_list();

        // research booking is ok treatment time : only treatment
        // get treatment
        $treatment = null;
        $timeTreatment = 0;
        if ( Input::get('clinic_service_name') && !empty(Input::get('clinic_service_name')) ) {
            $idTreatment = explode('#', Input::get('clinic_service_name'));
            $idTreatment = $idTreatment[0];
            $treatment = $clsTreatment1->get_by_id($idTreatment);
            $timeTreatment = $treatment->treatment_time;
        }
        
        // get booking: ($bookings) and check booking
        //get facility_id in list bookings
        // echo '<pre>';
        // print_r($bookings);
        // echo '</pre>';
        // die;
        // $typeFacility = array();
        // foreach ( $bookings as $item ) {
        //     if ( !in_array($item->facility_id, $typeFacility) ) {
        //         $typeFacility[] = $item->facility_id;
        //     }
        // }

        // $tmpBookings = array();
        // foreach ( $typeFacility as $itemFac ) {
        //     $tmp = array();
        //     foreach ( $bookings as $item ) {
        //         if ( $item->facility_id == $itemFac ) {
        //             $tmp[] = $item;
        //         }
        //     }
        //     $tmpBookings[$itemFac] = $tmp;
        // }


        // // return list booking is ok
        // $tmpBookingTimeOk = array();
        // $timeTreatmentNumber = $timeTreatment / 15;
        // foreach ( $tmpBookings as $key => $values ) {
        //     foreach ( $values as $keyBooking => $itemBooking ) {
        //         $where = true;
        //         for ( $i = 0; $i < $timeTreatmentNumber; $i++ ) {
        //             if ( !isset($values[$keyBooking + $i]) ) {
        //                 $where = false;
        //                 break;
        //             }
        //         }
                
        //         if ( $where ) {
        //             $whereTime = true;
        //             for ( $i = 0; $i < $timeTreatmentNumber - 1; $i++ ) {
        //                 if ( convertStartTime($values[$keyBooking + $i]->booking_start_time + 15) != convertStartTime($values[$keyBooking + $i + 1]->booking_start_time) ) {
        //                     $whereTime = false;
        //                 }
        //             }
        //             //(convertStartTime($values[$keyBooking]->booking_start_time + 15)) == convertStartTime($values[$keyBooking + 1]->booking_start_time) && (convertStartTime($values[$keyBooking + 1]->booking_start_time + 15)) == convertStartTime($values[$keyBooking + 2]->booking_start_time)
        //             if ( $whereTime ) {
        //                 $tmpBookingTimeOk[] = $values[$keyBooking];
        //             }
        //         }
        //     }
        // }

        // order by by hand make --------------------------------------------------------
        // step 1: arrangement by date from list bookings
        // step 1.1: get array date
        // $tmpDate = array();
        // foreach ( $tmpBookingTimeOk as $item ) {
        //     if ( !in_array($item->booking_date, $tmpDate) ) {
        //         $tmpDate[] =  $item->booking_date;
        //     }
        // }
        // for ( $i = 0; $i < count($tmpDate) - 1; $i++ ) {
        //     for ( $j = $i + 1; $j < count($tmpDate); $j++ ) {
        //         if ( strtotime($tmpDate[$j]) < strtotime($tmpDate[$i]) ) {
        //             $temp = $tmpDate[$j];
        //             $tmpDate[$j] = $tmpDate[$i];
        //             $tmpDate[$i] = $temp;
        //         }
        //     }
        // }
        // // step 1.2: arrangement date
        // $tmpBookingTimeOkArrangement = array();
        // foreach ( $tmpDate as $date ) {
        //     foreach ( $tmpBookingTimeOk as $booking ) {
        //         if ( $booking->booking_date == $date ) {
        //             $tmpBookingTimeOkArrangement[] = $booking;
        //         }
        //     }
        // }
        // end step 1
        // step 2: arrangement by time
        // step 2.1: group by date by list booking arrangement date
        // $tmp1 = array();
        // foreach ( $tmpDate as $date ) {
        //     foreach ( $tmpBookingTimeOkArrangement as $booking ) {
        //         if ( $booking->booking_date == $date ) {
        //             $tmp1[$date][] = $booking;
        //         }
        //     }
        // }
        // $tmp11 = array();
        // foreach ( $tmp1 as $key1 => $value1 ) {
        //     foreach ( $value1 as $key2 => $value2 ) {
        //         for ( $i = 0; $i < count($value1) - 1; $i++ ) {
        //             for ( $j = $i + 1; $j < count($value1); $j++ ) {
        //                 if ( $value1[$j]->booking_start_time < $value1[$i]->booking_start_time ) {
        //                     $temp = $value1[$j];
        //                     $value1[$j] = $value1[$i];
        //                     $value1[$i] = $temp;
        //                     echo $value1[$j]->booking_start_time .'---'.$value1[$i]->booking_start_time;die;
        //                 }
        //             }
        //         }
        //     }
        // }
        // echo '<pre>';
        // print_r($tmp1);
        // echo '</pre>';
        // die;
        // die;
        

                    
        $result = $bookings;


        // echo '<pre>';
        // print_r($tmpBookingTimeOkArrangement);
        // echo '</pre>';
        // end order by by hand make --------------------------------------------------------
        // echo count($bookings);
        // echo '----';
        // echo count($tmpBookingTimeOk);
        // echo '----';
        // echo count($tmpBookingTimeOkArrangement);
        //die;


        $data['bookings'] = $result;
        // end research booking is ok treatment time

        return view('backend.ortho.bookings.booking_result_list', $data);
    }

    /**
     * List1 list
     */
    // public function list1_list(){
    //     $clsBooking             = new BookingModel();
    //     $data['list1']          = $clsBooking->get_list1_list();
    //     $clsService             = new ServiceModel();
    //     $data['services']       = $clsService->get_list();
    //     $clsTreatment1          = new Treatment1Model();
    //     $data['treatment1s']    = $clsTreatment1->get_list_treatment();
    //     return view('backend.ortho.bookings.list1_list', $data);
    // }

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

    public function getList2Search($id){
        $data = array();
        $data['booking_id'] = $id;
        $clsBooking                 = new BookingModel();
        $data['booking']            = $clsBooking->get_by_id($id);
        return view('backend.ortho.bookings.list2_search', $data);
    }

    public function postList2Search($id){
        if(Input::has('BookingCalendar')){
            $clsBooking                  = new BookingModel();
            $booking                     = $clsBooking->get_by_id($id);
            $condition['clinic_id'] = $booking->clinic_id;
            
            if(!empty(Input::get('week_later'))){
                if(Input::get('week_later') == 'week_specified'){
                    $condition['next'] = cal_date(Input::get('week_later_option'));
                }elseif (Input::get('week_later') == 'date_picker') {
                    $condition['next'] = formatDate(Input::get('date_picker_option'), '-');
                }else{
                    $condition['next'] = cal_date(Input::get('week_later'));
                }
            }

            return redirect()->route('ortho.bookings.booking.result.calendar', $condition);

        }else if(Input::has('BookingList')){

        $condition['booking_id'] = $id;

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

            return redirect()->route('ortho.bookings.list2_change', $condition);
        }
    }

    public function getList2Change($id){
        $clsBooking                       = new BookingModel();
        $clsFacility                      = new FacilityModel();
        $data['facilities']               = $clsFacility->list_facility_all();
        $data['id']                       = $id;
        $where                            = array();
        $old_booking                      = $clsBooking->get_by_id($id);
        $service_1_kind                   = $old_booking->service_1_kind;

        if(!empty($service_1_kind))
            $where['service_1_kind']      = $service_1_kind;
        if(!empty(Input::get('booking_date')))
            $where['booking_date']        = Input::get('booking_date');
        if(!empty(Input::get('week_later')))
            $where['week_later']          = Input::get('week_later');

        $data['bookings']                 = $clsBooking->get_booking_list2($where);

        return view('backend.ortho.bookings.list2_change_list', $data);
    }

    public function list2ChangeConfirm($id){
        $clsBooking                         = new BookingModel();
        if($clsBooking->checkExistID2($id) || $clsBooking->checkExistID2($id)){
            $curr_booking                   = $clsBooking->get_by_id($id);
            $data['booking']                = $curr_booking;

            $clsClinic                      = new ClinicModel();
            $data['clinics']                = $clsClinic->get_list_clinic();
            $clsUser                        = new UserModel();
            $data['doctors']                = $clsUser->get_list();
            $data['hygienists']             = $clsUser->get_list();
            $clsService                     = new ServiceModel();
            $data['services']               = $clsService->get_list();
            $clsTreatment1                  = new Treatment1Model();
            $data['treatment1s']            = $clsTreatment1->get_list_treatment();
            $clsEquipment                   = new EquipmentModel();
            $data['equipments']             = $clsEquipment->get_list();
            $clsInspection                  = new InspectionModel();
            $data['inspections']            = $clsInspection->get_list();
            $clsInsurance                   = new InsuranceModel();
            $data['insurances']             = $clsInsurance->get_list();
            $clsFacility                    = new FacilityModel();
            $data['facilities']             = $clsFacility->list_facility_all();

            $data['id']                     = $id;
            $booking_id                     = Input::get('booking_id');
            $data['booking_id']             = $booking_id;

            $new_booking                    = $clsBooking->get_by_id($booking_id);

            $new_booking_date               = $new_booking->booking_date;
            $new_facility_id                = $new_booking->facility_id;
            $new_facility_name              = $new_booking->facility_name;
            $new_booking_start_time         = $new_booking->booking_start_time;

            $data['booking_change']         = (Object)array_merge((array)$curr_booking, array(
                                            'booking_date'          => $new_booking_date,
                                            'booking_start_time'    => $new_booking_start_time,
                                            'facility_id'           => $new_facility_id,
                                            'facility_Name'         => $new_facility_name,
                                            'last_date'             => date('Y-m-d H:i:s'),
                                            'last_user'             => Auth::user()->id,
                                            ));
            return view('backend.ortho.bookings.list2_change_confirm', $data);
        }else{
            return response()->view('errors.404', [], 404);
        }
    }

    public function postList2Cnf($id){
        $clsBooking                     = new BookingModel();
        $clsTreatment1                  = new Treatment1Model();
        $booking_id                     = Input::get('booking_id');

        //Booking New
        $new_booking                    = $clsBooking->get_by_id($booking_id);
        $new_booking_date               = $new_booking->booking_date;
        $new_facility_id                = $new_booking->facility_id;
        $new_booking_start_time         = $new_booking->booking_start_time;
        $new_booking_group_id           = $new_booking->booking_group_id;
        $new_booking_childgroup_id      = $new_booking->booking_childgroup_id;

        //Booking Current
        $curr_booking                   = $clsBooking->get_by_id($id);
        $bk_child_group                 = $curr_booking->booking_childgroup_id;
        $bk_group_id                    = $curr_booking->booking_group_id;
        $patient_id                     = $curr_booking->patient_id;
        $facility_id                    = $curr_booking->facility_id;
        $clinic_id                      = $curr_booking->clinic_id;
        $service_1                      = $curr_booking->service_1;
        $service_1_kind                 = $curr_booking->service_1_kind;
        $bk_booking_date                = $curr_booking->booking_date;
        $bk_booking_start_time          = $curr_booking->booking_start_time;

        $dateProvided                   = $bk_booking_date;
        $yearBkCurr                     = date('Y', strtotime($dateProvided));
        $monthBkCurr                    = date('m', strtotime($dateProvided));

        //new booking_group_id
        if(!empty($new_booking_group_id)){
            $tmpGroup                       = explode('_', $new_booking_group_id);
            $booking_group_id       = '';
            if(!empty($tmpGroup[0])){
                $booking_group_id = $tmpGroup[0].'_'.$new_booking_date;
            }
        }else{
            $booking_group_id = $bk_group_id;
        }

        //new booking_childgroup_id
        $booking_childgroup_id = 'group_'.$new_booking_start_time;

        //new booking_start_time
        $booking_start_time = (int)$new_booking_start_time;

        $booking_end_time  = NULL;
        if($service_1_kind == 2){
            $treatment                  = $clsTreatment1->get_by_id($service_1);
            if(!empty($treatment)){
                $cur_treatment1TotalTime                       = $treatment->treatment_time;
                if(!empty($bk_booking_start_time)){
                    $cur_mm = hourMin2Min($bk_booking_start_time);
                    $cur_mm = $cur_mm + $cur_treatment1TotalTime;
                    $booking_end_time = (int)min2HourMin($cur_mm);
                }
            }
        }

        //list2 booking child group
        $list2_child_groups = $clsBooking->get_by_child_group_list2($clinic_id, $bk_booking_date, $bk_booking_start_time, null, $patient_id, $facility_id, null, $booking_status=2, $booking_end_time);

        $condition                      = array();
        $condition['clinic_id']         = $curr_booking->clinic_id;
        $condition['next']              = $new_booking_date;

        $hhmmBookingEndTime  = NULL;
        if($service_1_kind == 2){
            $treatment                  = $clsTreatment1->get_by_id($service_1);
            if(!empty($treatment)){
                $treatment1TotalTime                       = $treatment->treatment_time;
                if(!empty($new_booking_start_time)){
                    $new_mm = hourMin2Min($new_booking_start_time);
                    $new_mm = $new_mm + $treatment1TotalTime;
                    $hhmmBookingEndTime = (int)min2HourMin($new_mm);
                }
            }
        }

        //New booking group
        $newGroupBooking                = $clsBooking->get_new_booking_child_group2($new_booking_date, $booking_start_time, $service_1_kind, $new_facility_id , null, null, $hhmmBookingEndTime);

        $flag = false;

        $bk_start_time = (int)$new_booking_start_time;

        if(!empty($newGroupBooking))
        {
            foreach ($newGroupBooking as $booking_group) {
                $dataUpdate = array(
                                            'booking_date'          => $bk_booking_date,
                                            'booking_start_time'    => $bk_start_time,
                                            'booking_childgroup_id' => $booking_childgroup_id,
                                            'booking_group_id'      => $booking_group_id,
                                            'patient_id'            => $curr_booking->patient_id,
                                            'doctor_id'             => $curr_booking->doctor_id,
                                            'hygienist_id'          => $curr_booking->hygienist_id,
                                            'equipment_id'          => $curr_booking->equipment_id,
                                            'inspection_id'         => $curr_booking->inspection_id,
                                            'insurance_id'          => $curr_booking->insurance_id,
                                            'facility_id'           => $new_facility_id,
                                            'booking_status'        => NULL,
                                            'booking_memo'          => $curr_booking->booking_memo,
                                            'service_1'             => $curr_booking->service_1,
                                            'service_1_kind'        => $curr_booking->service_1_kind,
                                            'last_date'             => date('Y-m-d H:i:s'),
                                            'last_user'             => Auth::user()->id,
                                            'last_kind'             => UPDATE
                                            );


            if( $clsBooking->update($booking_group->booking_id, $dataUpdate) )
                $flag = true;

                $bk_start_time                  = convertStartTime($bk_start_time + 15);
            }
        }

        //delete booking list 2
        $list2_bk_start_time = (int)$bk_booking_start_time;

        if(!empty($list2_child_groups)){
            foreach ($list2_child_groups as $booking_group) {
                $dataDelete = array(
                                            'booking_date'          => $new_booking_date,
                                            'booking_start_time'    => $list2_bk_start_time,
                                            'booking_childgroup_id' => NULL,
                                            'booking_group_id'      => $bk_child_group,
                                            'patient_id'            => NULL,
                                            'doctor_id'             => NULL,
                                            'facility_id'           => $facility_id,
                                            'booking_status'        => NULL,
                                            'booking_memo'          => $curr_booking->booking_memo,
                                            'service_1'             => ($curr_booking->service_1_kind == 2) ? -1 : $curr_booking->service_1,
                                            'service_1_kind'        => $curr_booking->service_1_kind,
                                            'last_date'             => date('Y-m-d H:i:s'),
                                            'last_user'             => Auth::user()->id,
                                            'last_kind'             => UPDATE
                                            );

                $clsBooking->update($booking_group->booking_id, $dataDelete);
                $list2_bk_start_time                  = convertStartTime($list2_bk_start_time + 15);
            }
        }

        if ($flag == true) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.bookings.list2_list',['booking_date_year'=>$yearBkCurr, 'booking_date_month'=>$monthBkCurr]);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.list2_change', array('booking_id'=>$booking_id));
            if(Session::has('where_booking_change')) Session::forget('where_booking_change');
        }
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

    public function getList1Search($booking_id){
        $data                       = array();
        $data['booking_id']         = $booking_id;
        $clsBooking                 = new BookingModel();
        $data['booking']            = $clsBooking->get_by_id($booking_id);

        return view('backend.ortho.bookings.list1_search', $data);
    }

    public function postList1Search($booking_id){

        $condition['booking_id'] = $booking_id;

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

        return redirect()->route('ortho.bookings.list1_change', $condition);
    }

    public function getList1Change($booking_id){
        $clsBooking                       = new BookingModel();
        $clsFacility                      = new FacilityModel();
        $data['facilities']               = $clsFacility->list_facility_all();
        $data['booking_id']               = $booking_id;
        $where                            = array();
        $old_booking                      = $clsBooking->get_by_id($booking_id);
        $service_1_kind                   = $old_booking->service_1_kind;

        if(!empty($service_1_kind))
            $where['service_1_kind']      = $service_1_kind;
        if(!empty(Input::get('booking_date')))
            $where['booking_date']        = Input::get('booking_date');
        if(!empty(Input::get('week_later')))
            $where['week_later']          = Input::get('week_later');

        $data['bookings']                 = $clsBooking->get_booking_list2($where);

        return view('backend.ortho.bookings.list1_change_list', $data);
    }

    public function list1ChangeConfirm($booking_id, $id){
        $clsBooking                         = new BookingModel();
        $clsBookingTelWaiting               = new BookingTelWaitingModel();
        if($clsBooking->checkExistID2($booking_id) || $clsBooking->checkExistID2($id)){
            $curr_booking                   = $clsBookingTelWaiting->get_by_booking_id($booking_id);
            $data['booking']                = $curr_booking;

            $clsClinic                      = new ClinicModel();
            $data['clinics']                = $clsClinic->get_list_clinic();
            $clsUser                        = new UserModel();
            $data['doctors']                = $clsUser->get_list();
            $data['hygienists']             = $clsUser->get_list();
            $clsService                     = new ServiceModel();
            $data['services']               = $clsService->get_list();
            $clsTreatment1                  = new Treatment1Model();
            $data['treatment1s']            = $clsTreatment1->get_list_treatment();
            $clsEquipment                   = new EquipmentModel();
            $data['equipments']             = $clsEquipment->get_list();
            $clsInspection                  = new InspectionModel();
            $data['inspections']            = $clsInspection->get_list();
            $clsInsurance                   = new InsuranceModel();
            $data['insurances']             = $clsInsurance->get_list();
            $clsFacility                    = new FacilityModel();
            $data['facilities']             = $clsFacility->list_facility_all();

            $data['booking_id']             = $booking_id;
            $data['id']                     = $id;

            $new_booking                    = $clsBooking->get_by_id($id);

            $new_booking_date               = $new_booking->booking_date;
            $new_facility_id                = $new_booking->facility_id;
            $new_facility_name              = $new_booking->facility_name;
            $new_booking_start_time         = $new_booking->booking_start_time;

            $data['booking_change']         = (Object)array_merge((array)$curr_booking, array(
                                            'booking_date'          => $new_booking_date,
                                            'booking_start_time'    => $new_booking_start_time,
                                            'facility_id'           => $new_facility_id,
                                            'facility_Name'         => $new_facility_name,
                                            'last_date'             => date('Y-m-d H:i:s'),
                                            'last_user'             => Auth::user()->id,
                                            ));
            return view('backend.ortho.bookings.list1_change_confirm', $data);
        }else{
            return response()->view('errors.404', [], 404);
        }
    }

    public function postList1Cnf($booking_id, $id){
        $clsBooking                     = new BookingModel();

        //Booking New
        $new_booking                    = $clsBooking->get_by_id($id);
        $new_booking_date               = $new_booking->booking_date;
        $new_facility_id                = $new_booking->facility_id;
        $new_booking_start_time         = $new_booking->booking_start_time;
        $new_booking_group              = $new_booking->booking_group_id;

        //Booking Current
        $curr_booking                   = $clsBooking->get_by_id($booking_id);
        $bk_child_group                 = $curr_booking->booking_childgroup_id;
        $bk_group_id                    = $curr_booking->booking_group_id;
        $patient_id                     = $curr_booking->patient_id;
        $facility_id                    = $curr_booking->facility_id;
        $clinic_id                      = $curr_booking->clinic_id;
        $bk_service                     = $curr_booking->service_1;
        $bk_service_kind                = $curr_booking->service_1_kind;
        $bk_booking_date                = $curr_booking->booking_date;
        $bk_booking_start_time          = $curr_booking->booking_start_time;

        $tmpGroup                       = explode('_', $bk_group_id);

        $tmpChildGroup                  = explode('_', $bk_child_group);

        $booking_group_id               = '';
        if(!empty($tmpGroup[0])){
            $booking_group_id = $tmpGroup[0].'_'.$new_booking_date;
        }

        $booking_childgroup_id  = '';
        if(!empty($tmpChildGroup[1])){
            $booking_childgroup_id = 'group_'.$new_booking_start_time.(!empty($tmpChildGroup[2]) ? '_'.$tmpChildGroup[2] : '').(!empty($tmpChildGroup[3]) ? '_'.$tmpChildGroup[3] : '').(!empty($tmpChildGroup[4]) ? '_'.$tmpChildGroup[4] : '');
        }

        $group_booking                  = $clsBooking->get_by_child_group_list2($clinic_id, $bk_booking_date, $bk_child_group, $patient_id, $facility_id, $bk_group_id, $booking_status=2);

        $condition                      = array();
        $condition['clinic_id']         = $curr_booking->clinic_id;
        $condition['next']              = $new_booking_date;

        $start_time = (int)$new_booking_start_time;
        $flag  = false;

        $limit = count($group_booking);

        $oldFacility = array();
        foreach ($group_booking as $key=>$bk) {
         $oldFacility[$key] = $bk->facility_id;
        }

        $newGroupBooking                = $clsBooking->get_new_booking_child_group($new_booking_date, $start_time, $new_facility_id, $new_booking_group, $limit);

        $bk_start_time  = (int)$bk_booking_start_time;

        foreach ($newGroupBooking as $key=>$newbk) {
            $clsBooking->update($newbk->booking_id, array(
                                        'booking_date'          => $bk_booking_date,
                                        'booking_start_time'    => $bk_start_time,
                                        'booking_group_id'      => $bk_group_id,
                                        'facility_id'           => !empty(@$oldFacility[$key]) ? @$oldFacility[$key] : $facility_id,
                                        'last_date'             => date('Y-m-d H:i:s'),
                                        'last_user'             => Auth::user()->id,
                                        'last_kind'             => UPDATE
                                    ));
            $bk_start_time                  = convertStartTime($bk_start_time + 15);
        }

        $data_bk_change     = array();
        $where              = Session::get('where_booking_change');

        if(!empty($where['clinic_id'])) $data_bk_change['clinic_id'] = $where['clinic_id'];
        if(!empty($where['doctor_id'])) $data_bk_change['doctor_id'] = $where['doctor_id'];
        if(!empty($where['hygienist_id'])) $data_bk_change['hygienist_id'] = $where['hygienist_id'];

        if(!empty($where['clinic_service_name'])){
            $tmp_service        = explode('_', $where['clinic_service_name']);
            $service            = $tmp_service[0];
            $s_kind             = str_split($tmp_service[1], 2);
            $service_kind       = $s_kind[1];

            $data_bk_change['service_1']        = $service;
            $data_bk_change['service_1_kind']   = $service_kind;
        }

        $newFacility = array();
        foreach ($newGroupBooking as $key=>$new_bk) {
         $newFacility[$key] = $new_bk->facility_id;
        }

        foreach ($group_booking as $gbk) {
            if ($clsBooking->update($gbk->booking_id, array_merge($data_bk_change, array(
                                        'booking_date'          => $new_booking_date,
                                        'booking_start_time'    => $start_time,
                                        'booking_group_id'      => $booking_group_id,
                                        'booking_childgroup_id' => $booking_childgroup_id,
                                        'facility_id'           => !empty(@$newFacility[$key]) ? @$newFacility[$key] : $facility_id,
                                        'booking_status'        => NULL,
                                        'last_date'             => date('Y-m-d H:i:s'),
                                        'last_user'             => Auth::user()->id,
                                        'last_kind'             => UPDATE
                                    ))) ) {
                $flag = true;
            }else{
                $flag = false;
            }
            $start_time = convertStartTime($start_time + 15);
        }

        if ($flag == true) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.bookings.list1_list');
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.list1_change', array('booking_id'=>$booking_id));
            if(Session::has('where_booking_change')) Session::forget('where_booking_change');
        }
    }

    // delete single or group booking from booking-result-calendar
    // only no booking (patient_id == null)
    public function deleteSingleGroup()
    {
        $booking_id         = Input::get('booking_id');
        $deleteType         = Input::get('delete_type');
        $clsBooking         = new BookingModel();
        $dataUpdate         = array(
            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => DELETE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id
        );

        if ( $booking_id > 0 ) {
            $booking                    = $clsBooking->get_by_id($booking_id);

            if ( $deleteType === 'single' ) {
                $status = $clsBooking->update($booking_id, $dataUpdate);
                if ( $status ) {
                    return response()->json(['status', $booking]);
                }
            } else {
                $whereChildGroups               = array(
                    //'booking_group_id'          => $booking->booking_group_id,
                    'booking_childgroup_id'     => $booking->booking_childgroup_id,
                    'clinic_id'                 => $booking->clinic_id,
                    'booking_date'              => $booking->booking_date,
                    // 'facility_id'               => $booking->facility_id,
                );
                if ( $booking->service_1_kind == 2 ) {
                    $whereChildGroups['facility_id'] = $booking->facility_id;
                }
                $bookingChildGroups = $clsBooking->get_where($whereChildGroups);

                $status = true;
                foreach ( $bookingChildGroups as $item ) {
                    $status = $clsBooking->update($item->booking_id, $dataUpdate);
                    if ( !$status ) {
                        break;
                    }
                }
                if ( $status ) {
                    return response()->json(['status', $bookingChildGroups]);
                }
            }
        }

        return response()->json(['status', '0']);
    }

    //set position top for page: regist, edit, delete booking
    //jquery for page: regist, edit, delete booking
    public function setPositionTop()
    {
        $top                        = Input::get('top');
        $topTable                   = Input::get('topTable');
        Session::put('top', $top);
        Session::put('topTable', $topTable);
        echo json_encode(['top' => $top, 'topTable' => $topTable]);
    }
}
