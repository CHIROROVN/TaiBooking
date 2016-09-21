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

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;
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
        $data['ddrs']           = $clsDdr->get_by_start_date($date_current);
        $data['memos']          = $clsMemo->get_list_by_memo_date($date_current);

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
        $data['list_doctors']       = $clsUser->get_list_users([1]);
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
            'booking_group_id'          => $booking->booking_group_id,
            'booking_childgroup_id'     => $booking->booking_childgroup_id
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
                if ( !$clsBooking->update($item->booking_id, $dataUpdate) ) {
                    $status = false;
                }
            }
        }

        if ( $status ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.bookings.booking.daily', [ 'clinic_id' => $booking->clinic_id ]);
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
        $booking                    = $clsBooking->get_by_id($id);
        // $arr_gid                    = array();
        // $arr_gid[]                  = $booking->booking_group_id;
        // $bookingGroups              = $clsBooking->get_by_group($arr_gid);

        // old version
        // $whereOld = array(
        //     'booking_group_id'      => $booking->booking_group_id,
        //     'clinic_id'             => $booking->clinic_id,
        //     'booking_date'          => $booking->booking_date
        // );
        // $oldBooking                 = $clsBooking->get_where($whereOld, true, 'booking_id');
        // copy old version to insert new version
        // after update new version
        // $idNewVerBooking = array();
        // $lastBookingVer = $clsBooking->getLastBookingRev();
        // foreach ( $oldBooking as $item ) {
        //     $arr = (array)$item;
        //     $arr['booking_rev'] = $lastBookingVer + 1;
        //     unset($arr['booking_id']);
        //     $idNewVerBooking[] = $clsBooking->insert_get_id($arr);
        // }

        
        $service_1 = $service_1_kind = '';

        if(!empty(Input::get('service_1')) && Input::get('service_1') != -1){
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

        if ( $booking->service_1_kind == 2 ) {
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
        }

        $dataInput = array(
            // 'facility_id'               => Input::get('facility_id'),
            'doctor_id'                 => Input::get('doctor_id'),
            'hygienist_id'              => Input::get('hygienist_id'),
            'equipment_id'              => Input::get('equipment_id'),
            // 'service_1'                 => $service_1,
            // 'service_1_kind'            => $service_1_kind,
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
        if ( empty($dataInput['booking_status']) ) {
            $dataInput['booking_status'] = null;
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
        if ( empty($dataInput['booking_recall_ym']) ) {
            $dataInput['booking_recall_ym'] = null;
        }
        if ( empty($dataInput['booking_memo']) ) {
            $dataInput['booking_memo'] = null;
        }

        $validator                  = Validator::make($dataInput, $clsBooking->Rules(), $clsBooking->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.bookings.booking.edit', [ $id ])->withErrors($validator)->withInput();
        }

        $status = true;
        // update by child group
        $whereChildGroups               = array(
            'booking_group_id'          => $booking->booking_group_id,
            'booking_childgroup_id'     => $booking->booking_childgroup_id,
            'clinic_id'                 => $booking->clinic_id,
            // 'facility_id'               => $booking->facility_id,
        );
        if ( $booking->service_1_kind == 2 ) {
            $whereChildGroups['facility_id'] = $booking->facility_id;
        }
        $bookingChildGroups = $clsBooking->get_where($whereChildGroups);
        if ( empty($booking->booking_childgroup_id) ) {
            $tmpBookingChildGroups = array();
            foreach ( $bookingChildGroups as $item ) {
                if ( empty($item->booking_childgroup_id) ) {
                    $tmpBookingChildGroups[] = $item;
                }
            }
            $bookingChildGroups = $tmpBookingChildGroups;
        }

        foreach ( $bookingChildGroups as $item ) {
            if ( !$clsBooking->update($item->booking_id, $dataInput) ) {
                $status = false;
            }
        }

        // update service_1
        $dataInput['service_1']         = $service_1;
        $dataInput['service_1_kind']    = $service_1_kind;

        $bookingChildGroupsTreatment = array();
        if ( $service_1 > 0 ) {
            $whereChildGroupsTreatment      = array(
                'booking_group_id'          => $booking->booking_group_id,
                'booking_childgroup_id'     => $booking->booking_childgroup_id,
                'clinic_id'                 => $booking->clinic_id,
                // 'facility_id'               => $booking->facility_id,
            );
            if ( $booking->service_1_kind == 2 ) {
                $whereChildGroupsTreatment['facility_id'] = $booking->facility_id;
            }
            $bookingChildGroupsTreatment = $clsBooking->get_where($whereChildGroupsTreatment); 

            $treatment1                 = $clsTreatment1->get_by_id($service_1);
            $bookingStartTime           = $booking->booking_start_time;
            $treatment1TotalTime        = $treatment1->treatment_time;

            $mm = hourMin2Min($bookingStartTime);
            $mm = $mm + $treatment1TotalTime;
            $hhmmBookingEndTime = (int)min2HourMin($mm);

            $listBookingUpdate = $clsBooking->get_for_update_treatment1($booking->booking_date, $booking->clinic_id, $booking->facility_id, $bookingStartTime, $hhmmBookingEndTime);
            // foreach ( $listBookingUpdate as $key => $item ) {
            //     if ( $item->service_1 != -1 ) {
            //         unset($listBookingUpdate[$key]);
            //     }
            // }

            // update treatment1
            if ( count($listBookingUpdate) && (count($listBookingUpdate) >= $treatment1TotalTime/15) ) {
                // ok update
                $end = count($listBookingUpdate) - 1;
                // check continuity
                $statusContinuity = true;
                if ( count($listBookingUpdate) >= 1 ) {
                    for ( $i = 0; $i < ($end) ; $i++ ) {
                        $mm = hourMin2Min($listBookingUpdate[$i]->booking_start_time) + 15;
                        $mmNext = hourMin2Min($listBookingUpdate[$i+1]->booking_start_time);

                        if ( $mm != $mmNext ) {
                            $statusContinuity = false;
                            break;
                        }
                    }
                }
                
                if ( $statusContinuity ) {
                    // delete old
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

                        'last_date'                 => date('y-m-d H:i:s'),
                        'last_kind'                 => UPDATE,
                        'last_ipadrs'               => CLIENT_IP_ADRS,
                        'last_user'                 => Auth::user()->id
                    );
                    foreach ( $bookingChildGroupsTreatment as $item ) {
                        $clsBooking->update($item->booking_id, $dataUpdate);
                    }

                    // update new
                    foreach ( $listBookingUpdate as $item) {
                        $dataInput['booking_childgroup_id'] = 'group_' . $booking->booking_start_time;
                        $dataInput['patient_id'] = $booking->patient_id;
                        $clsBooking->update($item->booking_id, $dataInput);
                    }
                    $clsBooking->update($booking->booking_id, $dataInput);

                } else {
                    $status = false;
                }
            } else {
                if ( $booking->service_1 == $service_1 ) {
                    $status = true;
                } else {
                    // $status = false;
                    $treatmentOld                   = $clsTreatment1->get_by_id($booking->service_1);
                    if ( !$treatmentOld ) {
                        $treatmentOldTotalTime          = null;
                    } else {
                        $treatmentOldTotalTime          = $treatmentOld->treatment_time;    
                    }
                    
                    // $listBookingUpdate = $clsBooking->get_for_update_treatment1($booking->booking_date, $booking->clinic_id, $booking->facility_id, $bookingStartTime, $hhmmBookingEndTime);
                    if ( empty($treatmentOldTotalTime) || $treatmentOldTotalTime > $treatment1TotalTime ) {
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

                            'last_date'                 => date('y-m-d H:i:s'),
                            'last_kind'                 => UPDATE,
                            'last_ipadrs'               => CLIENT_IP_ADRS,
                            'last_user'                 => Auth::user()->id
                        );
                        foreach ( $bookingChildGroupsTreatment as $item ) {
                            $clsBooking->update($item->booking_id, $dataUpdate);
                        }

                        // update new
                        foreach ( $listBookingUpdate as $item) {
                            $dataInput['booking_childgroup_id'] = 'group_' . $booking->booking_start_time;
                            $dataInput['patient_id'] = $booking->patient_id;
                            $clsBooking->update($item->booking_id, $dataInput);
                        }
                        $clsBooking->update($booking->booking_id, $dataInput);
                    } else {
                        $status = false;
                    }
                }
                
            }

            if ( !$status ) {
                // return back $bookingChildGroups
                foreach ( $bookingChildGroupsTreatment as $item ) {
                    $tmp = (array)$item;
                    unset($tmp['booking_id']);
                    $clsBooking->update($item->booking_id, $tmp);
                }
            }
        } elseif ( Input::get('service_1') == -1 ) {
            // $dataInput['service_1']                     = -1;
            // $dataInput['service_1_kind']                = 2;
            // $dataInput['booking_childgroup_id']         = null;
            // $dataInput['patient_id']                    = null;
            // $where                          = array(
            //     'booking_group_id'          => $booking->booking_group_id,
            //     'booking_childgroup_id'     => $booking->booking_childgroup_id,
            //     'clinic_id'                 => $booking->clinic_id,
            //     // 'facility_id'               => $booking->facility_id,
            // );
            // if ( $booking->service_1_kind == 2 ) {
            //     $whereChildGroups['facility_id'] = $booking->facility_id;
            // }
            // $listBookingUpdate = $clsBooking->get_where($where);
            // foreach ( $listBookingUpdate as $item ) {
            //     if ( !$clsBooking->update($item->booking_id, $dataInput) ) {
            //         $status = false;
            //     }
            // }
        } elseif ( empty($service_1) ) {
            $status = true;
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

        $service_1 = $service_1_kind = null;

        if(!empty(Input::get('service_1')) && Input::get('service_1') != -1 ){
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

        if ( $booking->service_1_kind == 2 ) {
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
        }

        $dataInput = array(
            // 'facility_id'               => Input::get('facility_id'),
            'patient_id'                => Input::get('p_id'),
            'doctor_id'                 => Input::get('doctor_id'),
            'hygienist_id'              => Input::get('hygienist_id'),
            'equipment_id'              => Input::get('equipment_id'),
            // 'service_1'                 => $service_1,
            // 'service_1_kind'            => $service_1_kind,
            // 'service_2'                 => $service_2,
            // 'service_2_kind'            => $service_2_kind,
            'inspection_id'             => Input::get('inspection_id'),
            'insurance_id'              => Input::get('insurance_id'),
            'emergency_flag'            => (Input::get('emergency_flag') == 'on') ? 1 : NULL,
            'booking_status'            => Input::get('booking_status'),
            'booking_recall_ym'         => Input::get('booking_recall_ym'),
            'booking_memo'              => Input::get('booking_memo'),
            // 'booking_rev'               => $clsBooking->getLastBookingRev() + 1,
            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_user'                 => Auth::user()->id,

            // 'first_user'                => Auth::user()->id,
            // 'first_date'                => date('y-m-d H:i:s')
        );
        // first regist
        if ( empty($booking->first_user) ) {
            $dataInput['first_user'] = Auth::user()->id;
        }
        if ( empty($booking->first_date) ) {
            $dataInput['first_date'] = date('y-m-d H:i:s');
        }
        // end first regist
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
        if ( empty($dataInput['booking_recall_ym']) ) {
            $dataInput['booking_recall_ym'] = null;
        }
        if ( empty($dataInput['booking_memo']) ) {
            $dataInput['booking_memo'] = null;
        }

        $status = true;
        // update by child group
        $whereChildGroups               = array(
            'booking_group_id'          => $booking->booking_group_id,
            'booking_childgroup_id'     => $booking->booking_childgroup_id,
            'clinic_id'                 => $booking->clinic_id,
            // 'facility_id'               => $booking->facility_id,
        );
        if ( $booking->service_1_kind == 2 ) {
            $whereChildGroups['facility_id'] = $booking->facility_id;
        }
        $bookingChildGroups = $clsBooking->get_where($whereChildGroups);
        if ( empty($booking->booking_childgroup_id) ) {
            $tmpBookingChildGroups = array();
            foreach ( $bookingChildGroups as $item ) {
                if ( empty($item->booking_childgroup_id) ) {
                    $tmpBookingChildGroups[] = $item;
                }
            }
            $bookingChildGroups = $tmpBookingChildGroups;
        }

        foreach ( $bookingChildGroups as $item ) {
            if ( !$clsBooking->update($item->booking_id, $dataInput) ) {
            // if ( !$clsBooking->insert($dataInput) ) {
                $status = false;
            }
        }

        // update service_1
        $dataInput['service_1']         = $service_1;
        $dataInput['service_1_kind']    = $service_1_kind;

        if ( $service_1 > 0 ) {

            $treatment1                 = $clsTreatment1->get_by_id($service_1);
            $bookingStartTime           = $booking->booking_start_time;
            $treatment1TotalTime        = $treatment1->treatment_time;

            $mm = hourMin2Min($bookingStartTime);
            $mm = $mm + $treatment1TotalTime;
            $hhmmBookingEndTime = (int)min2HourMin($mm);

            $listBookingUpdate = $clsBooking->get_for_update_treatment1($booking->booking_date, $booking->clinic_id, $booking->facility_id, $bookingStartTime, $hhmmBookingEndTime);
            // foreach ( $listBookingUpdate as $key => $item ) {
            //     if ( $item->service_1 != -1 ) {
            //         unset($listBookingUpdate[$key]);
            //     }
            // }

            // update treatment1
            if ( count($listBookingUpdate) && (count($listBookingUpdate) >= $treatment1TotalTime/15) ) {
                // ok update
                // $dataInput['booking_group_id'] = 'group_' . $booking->booking_start_time . '_' . $hhmmBookingEndTime . '_' . $booking->clinic_id . '_' . $booking->facility_id . '_' . $booking->booking_date;
                $end = count($listBookingUpdate) - 1;
                // check continuity
                $statusContinuity = true;
                if ( count($listBookingUpdate) > 1 ) {
                    for ( $i = 0; $i < ($end) ; $i++ ) {
                        $mm = hourMin2Min($listBookingUpdate[$i]->booking_start_time) + 15;
                        $mmNext = hourMin2Min($listBookingUpdate[$i+1]->booking_start_time);

                        if ( $mm != $mmNext ) {
                            $statusContinuity = false;
                            break;
                        }
                    }
                }
                
                if ( $statusContinuity ) {
                    // delete old
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

                        'last_date'                 => date('y-m-d H:i:s'),
                        'last_kind'                 => UPDATE,
                        'last_ipadrs'               => CLIENT_IP_ADRS,
                        'last_user'                 => Auth::user()->id
                    );
                    foreach ( $bookingChildGroups as $item ) {
                        $clsBooking->update($item->booking_id, $dataUpdate);
                    }

                    // update new
                    foreach ( $listBookingUpdate as $item) {
                        $dataInput['booking_childgroup_id'] = 'group_' . $booking->booking_start_time;
                        // $dataInput['patient_id'] = $booking->patient_id;
                        $clsBooking->update($item->booking_id, $dataInput);
                    }
                    $clsBooking->update($booking->booking_id, $dataInput);
                } else {
                    $status = false;
                }
            } else {
                if ( $booking->service_1 == $service_1 ) {
                    $status = true;
                } else {
                    $status = false;
                }
            }

            if ( !$status ) {
                // return back $bookingChildGroups
                foreach ( $bookingChildGroups as $item ) {
                    $tmp = (array)$item;
                    unset($tmp['booking_id']);
                    $clsBooking->update($item->booking_id, $tmp);
                }
            }
        } elseif ( Input::get('service_1') == -1 ) {
            // $dataInput['service_1']                     = -1;
            // $dataInput['service_1_kind']                = 2;
            // $dataInput['booking_childgroup_id']         = null;
            // $dataInput['patient_id']                    = null;
            // $where                          = array(
            //     'booking_group_id'          => $booking->booking_group_id,
            //     'booking_childgroup_id'     => $booking->booking_childgroup_id,
            //     'clinic_id'                 => $booking->clinic_id,
            //     // 'facility_id'               => $booking->facility_id,
            // );
            // if ( $booking->service_1_kind == 2 ) {
            //     $whereChildGroups['facility_id'] = $booking->facility_id;
            // }
            // $listBookingUpdate = $clsBooking->get_where($where);
            // foreach ( $listBookingUpdate as $item ) {
            //     if ( !$clsBooking->update($item->booking_id, $dataInput) ) {
            //         $status = false;
            //     }
            // }
        } elseif ( empty($service_1) ) {
            $status = true;
        }

        if ( $status ) {
            $where                          = array();
            $where['clinic_id']             = $booking->clinic_id;
            $where['cur']                   = $booking->booking_date;
            return redirect()->route('ortho.bookings.booking.daily', $where);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.booking.regist', $id);
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
        $clsTemplate                = new TemplateModel();
        $clsPatient                 = new PatientModel();
        $clsInterview               = new InterviewModel();
        $booking                    = $clsBooking->get_by_id($id);

        $service_1 = $service_1_kind = null;

        if(!empty(Input::get('service_1')) && Input::get('service_1') != -1 ){
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

        if ( $booking->service_1_kind == 2 ) {
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
        }

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

                'last_date'                 => date('y-m-d H:i:s'),
                'last_kind'                 => UPDATE,
                'last_ipadrs'               => CLIENT_IP_ADRS,
                'last_user'                 => Auth::user()->id
            );
            $clsInterview->insert($dataInterview);
        }
        

        $dataInput = array(
            // 'facility_id'               => Input::get('facility_id'),
            'patient_id'                => $p_id,
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
        // first regist
        if ( empty($booking->first_user) ) {
            $dataInput['first_user'] = Auth::user()->id;
        }
        if ( empty($booking->first_date) ) {
            $dataInput['first_date'] = date('y-m-d H:i:s');
        }
        // end first regist

        if ( empty($dataInput['booking_status']) ) {
            $dataInput['booking_status'] = null;
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
            'clinic_id'                 => $booking->clinic_id,
            // 'facility_id'               => $booking->facility_id,
        );
        if ( $booking->service_1_kind == 2 ) {
            $whereChildGroups['facility_id'] = $booking->facility_id;
        }
        $bookingChildGroups = $clsBooking->get_where($whereChildGroups);
        if ( empty($booking->booking_childgroup_id) ) {
            $tmpBookingChildGroups = array();
            foreach ( $bookingChildGroups as $item ) {
                if ( empty($item->booking_childgroup_id) ) {
                    $tmpBookingChildGroups[] = $item;
                }
            }
            $bookingChildGroups = $tmpBookingChildGroups;
        }

        foreach ( $bookingChildGroups as $item ) {
            if ( !$clsBooking->update($item->booking_id, $dataInput) ) {
                $status = false;
            }
        }

        // update service_1
        $dataInput['service_1'] = $service_1;
        $dataInput['service_1_kind'] = $service_1_kind;

        $bookingChildGroupsTreatment = array();
        if ( $service_1 > 0 ) {

            $treatment1                 = $clsTreatment1->get_by_id($service_1);
            $bookingStartTime           = $booking->booking_start_time;
            $treatment1TotalTime        = $treatment1->treatment_time;

            $mm = hourMin2Min($bookingStartTime);
            $mm = $mm + $treatment1TotalTime;
            $hhmmBookingEndTime = (int)min2HourMin($mm);

            $listBookingUpdate = $clsBooking->get_for_update_treatment1($booking->booking_date, $booking->clinic_id, $booking->facility_id, $bookingStartTime, $hhmmBookingEndTime);
            // foreach ( $listBookingUpdate as $key => $item ) {
            //     if ( $item->service_1 != -1 ) {
            //         unset($listBookingUpdate[$key]);
            //     }
            // }

            // update treatment1
            if ( count($listBookingUpdate) && (count($listBookingUpdate) >= $treatment1TotalTime/15) ) {
                // ok update
                // $dataInput['booking_group_id'] = 'group_' . $booking->booking_start_time . '_' . $hhmmBookingEndTime . '_' . $booking->clinic_id . '_' . $booking->facility_id . '_' . $booking->booking_date;
                $end = count($listBookingUpdate) - 1;
                // check continuity
                $statusContinuity = true;
                if ( count($listBookingUpdate) > 1 ) {
                    for ( $i = 0; $i < ($end) ; $i++ ) {
                        $mm = hourMin2Min($listBookingUpdate[$i]->booking_start_time) + 15;
                        $mmNext = hourMin2Min($listBookingUpdate[$i+1]->booking_start_time);

                        if ( $mm != $mmNext ) {
                            $statusContinuity = false;
                            break;
                        }
                    }
                }
                
                if ( $statusContinuity ) {
                    // delete old
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

                        'last_date'                 => date('y-m-d H:i:s'),
                        'last_kind'                 => UPDATE,
                        'last_ipadrs'               => CLIENT_IP_ADRS,
                        'last_user'                 => Auth::user()->id
                    );
                    foreach ( $bookingChildGroups as $item ) {
                        $clsBooking->update($item->booking_id, $dataUpdate);
                    }

                    // update new
                    foreach ( $listBookingUpdate as $item) {
                        $dataInput['booking_childgroup_id'] = 'group_' . $booking->booking_start_time;
                        $dataInput['patient_id']            = $p_id;
                        $clsBooking->update($item->booking_id, $dataInput);
                    }
                    $clsBooking->update($booking->booking_id, $dataInput);
                } else {
                    $status = false;
                }
            } else {
                if ( $booking->service_1 == $service_1 ) {
                    $status = true;
                } else {
                    $status = false;
                }
            }

            if ( !$status ) {
                // return back $bookingChildGroups
                foreach ( $bookingChildGroups as $item ) {
                    $tmp = (array)$item;
                    unset($tmp['booking_id']);
                    $clsBooking->update($item->booking_id, $tmp);
                }
            }
        } elseif ( Input::get('service_1') == -1 ) {
            // $dataInput['service_1']                     = -1;
            // $dataInput['service_1_kind']                = 2;
            // $dataInput['booking_childgroup_id']         = null;
            // $dataInput['patient_id']                    = null;
            // $where                          = array(
            //     'booking_group_id'          => $booking->booking_group_id,
            //     'booking_childgroup_id'     => $booking->booking_childgroup_id,
            //     'clinic_id'                 => $booking->clinic_id,
            //     // 'facility_id'               => $booking->facility_id,
            // );
            // if ( $booking->service_1_kind == 2 ) {
            //     $whereChildGroups['facility_id'] = $booking->facility_id;
            // }
            // $listBookingUpdate = $clsBooking->get_where($where);
            // foreach ( $listBookingUpdate as $item ) {
            //     if ( !$clsBooking->update($item->booking_id, $dataInput) ) {
            //         $status = false;
            //     }
            // }
        } elseif ( empty($service_1) ) {
            $status = true;
        }

        if ( $status ) {
            $where                          = array();
            $where['clinic_id']             = $booking->clinic_id;
            $where['cur']                   = $booking->booking_date;
            return redirect()->route('ortho.bookings.booking.daily', $where);
        } else {
            $dataDeletePatient = array(
                'last_date'                 => date('Y-m-d H:i:s'),
                'last_kind'                 => DELETE,
                'last_ipadrs'               => CLIENT_IP_ADRS,
                'last_user'                 => Auth::user()->id
            );
            $clsPatient->update($p_id, $dataDeletePatient);

            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.booking.1st.regist', $id);
        }
    }

    public function getBookingChange($booking_id)
    {
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
        }

        if(!empty(Input::get('clinic_service_name')))
            $condition['clinic_service_name']         = Input::get('clinic_service_name');

        $condition['booking_id']                      = $booking_id;

        return redirect()->route('ortho.bookings.booking_change_list', $condition);
        }

    }

    public function bookingChangeList($booking_id)
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
        //Session::put('where_booking', $where);

        $clsBooking                       = new BookingModel();
        $data['bookings']                 = $clsBooking->get_booking_list($where);
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

        return view('backend.ortho.bookings.booking_change_list', $data);
    }

    public function getConfirm($booking_id, $id)
    {
        if (Session::has('booking_change')) Session::forget('booking_change');
        $clsBooking                     = new BookingModel();
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

            $data['booking_id']             = $booking_id;

            $data['booking_change']          = $clsBooking->get_by_id($id);

            $data['booking_change']          = (object) array_merge((array) $data['booking_change'], array(
                                                                        'last_date' => date('Y-m-d H:i:s'),
                                                                        'last_user' => Auth::user()->id,
                                                                        'patient_id' => $curr_booking->patient_id,
                                                                        'p_no' => $curr_booking->p_no,
                                                                        'p_name_f' => $curr_booking->p_name_f,
                                                                        'p_name_g' => $curr_booking->p_name_g,
                                                                        'clinic_name'=> $curr_booking->clinic_name,
                                                                        'facility_name' => $curr_booking->facility_name,
                                                                        'equipment_name' => $curr_booking->equipment_name,
                                                                        'inspection_name' => $curr_booking->inspection_name,
                                                                        'insurance_name' => $curr_booking->insurance_name
                                                                        ) );
            // Session::put('booking_change', $data['booking_change']);
            return view('backend.ortho.bookings.booking_change_confirm', $data);
        }else{
            return response()->view('errors.404', [], 404);
        }
    }

    public function postConfirm($booking_id, $id)
    {
        $clsBooking                 = new BookingModel();
        $new_booking                = $clsBooking->get_by_id($id);

        //update

        $curr_booking               = $clsBooking->get_by_id($booking_id);
        $child_group_booking        = $curr_booking->booking_childgroup_id;

        $group_booking              = $curr_booking->booking_group_id;

        $temp                       = explode('_', $group_booking);

        $condition                  = array();
        $condition['clinic_id']     = $curr_booking->clinic_id;
        $condition['next']          = $new_booking->booking_date;

        $bookingGroups              = $clsBooking->get_by_child_group($child_group_booking);
        $dataInput                  = array(
                                            'booking_date'  => $new_booking->booking_date,
                                            'booking_group_id' => $temp[0].'_'.$new_booking->booking_date,
                                            'last_date'     => date('Y-m-d H:i:s'),
                                            'last_user'     => Auth::user()->id,
                                            'last_kind'     => UPDATE
                                            );
        $flag = false;
        foreach ( $bookingGroups as $item ) {
            if ($clsBooking->update($item->booking_id, $dataInput) ) {
                $flag = true;
            }
        }

        //Delete
        $booking_id_oldgroup        = $new_booking->booking_childgroup_id;
        $bookingOldGroups          = $clsBooking->get_by_child_group($booking_id_oldgroup);
        $bookingOld                 = array(
                                            'patient_id' => '',
                                            'last_date'  => date('Y-m-d H:i:s'),
                                            'last_user'  => Auth::user()->id,
                                            'last_kind'  => DELETE
                                            );

        foreach ( $bookingOldGroups as $bog ) {
            $clsBooking->update($bog->booking_id, $bookingOld);
        }
        //End delete

        if ($flag == true) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.bookings.booking.result.calendar', $condition);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.booking_change_date', [$id]);
        }

        // if($clsBooking->update($id, $dataInput))
        // {
        //     Session::flash('success', trans('common.message_edit_success'));
        //     return redirect()->route('ortho.bookings.booking.result.calendar', $condition);
        // }else{
        //     Session::flash('danger', trans('common.message_edit_danger'));
        //     return redirect()->route('ortho.bookings.booking_change_date', [$id]);
        // }

        if (Session::has('booking_change'))
            Session::forget('booking_change');
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
        $data['services']       = $clsService->get_list();
        $clsTreatment1          = new Treatment1Model();
        $data['treatment1s']    = $clsTreatment1->get_list_treatment();
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
