<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Models\Ortho\BookingTelWaitingModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\PatientModel;
use App\Http\Models\Ortho\BookingModel;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\Treatment1Model;
use App\Http\Models\Ortho\FacilityModel;
use App\Http\Models\Ortho\EquipmentModel;
use App\Http\Models\Ortho\InspectionModel;
use App\Http\Models\Ortho\InsuranceModel;

use Form;
use Html;
use Input;
use Validator;
use Session;

class BookingTelWaitingController extends BackendController
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
        // search
        $data                           = array();
        $data['p_id']                   = Input::get('p_id');
        $data['patient']                = Input::get('patient');
        $data['insert_date']            = Input::get('insert_date');
        if ( empty($data['patient']) ) {
            $data['p_id'] = null;
        }

        $clsBookingTelWaiting           = new BookingTelWaitingModel();
        $clsClinic                      = new ClinicModel();
        $clsPatient                     = new PatientModel();
        $clsService                     = new ServiceModel();
        $clsTreatment1                  = new Treatment1Model();
        $clsUser                        = new UserModel();

        $data['clinics']                = $clsClinic->get_for_select_only_user();
        $patients                       = $clsPatient->get_for_select();
        $tmpList1_list                  = $clsBookingTelWaiting->get_all($data);
        $data['list_doctors']           = $clsUser->get_list_users([1]);
        $data['services']               = $clsService->get_list();
        $data['treatment1s']            = $clsTreatment1->get_list_treatment();

        $tmp = array();
        foreach ( $patients as $item ) {
            $tmp[$item->p_id] = $item;
        }
        $data['patients'] = $tmp;

        $tmp = array();
        $tmpGroup = array();
        foreach ( $tmpList1_list as $item ) {
            if ( isset($item->booking_childgroup_id) ) {
                if ( !in_array($item->booking_date . '|' . $item->booking_childgroup_id . '|' . $item->clinic_id, $tmpGroup) ) {
                    $tmpGroup[] = $item->booking_date . '|' . $item->booking_childgroup_id . '|' . $item->clinic_id;
                    $tmp[] = (object)$item;
                }
            } else {
                $tmp[] = (object)$item;
            }
        }
        $data['list1_list'] = $tmp;

        return view('backend.ortho.list1_list.index', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        $clsClinic                      = new ClinicModel();
        $clsPatient                     = new PatientModel();
        $clsUser                        = new UserModel();
        $clsService                     = new ServiceModel();
        $clsTreatment1                  = new Treatment1Model();

        $data['clinics']                = $clsClinic->get_for_select_only_user();
        $data['patients']               = $clsPatient->get_for_select();
        $data['doctors']                = $clsUser->get_by_belong([1]);
        $data['services']               = $clsService->get_list();
        $data['treatment1s']            = $clsTreatment1->get_treatment_search();

        return view('backend.ortho.list1_list.regist', $data);
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsBookingTelWaiting           = new BookingTelWaitingModel();
        $inputs                         = Input::all();
        $validator                      = Validator::make($inputs, $clsBookingTelWaiting->Rules(), $clsBookingTelWaiting->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.list1_list.regist')->withErrors($validator)->withInput();
        }

        // insert
        $dataInsert = array(
            'clinic_id'         => Input::get('clinic_id'),
            'patient_id'        => Input::get('p_id'),
            'doctor_id'         => Input::get('doctor_id'),
            'booking_memo'      => Input::get('booking_memo'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id,

            'insert_date'      => date('y-m-d H:i:s'),
        );
        $service_1 = Input::get('service_1');
        if ( !empty($service_1) ) {
            $tmp = explode('_', $service_1);
            if ( $tmp[1] == 'service' ) {
                // service
                $dataInsert['service_1'] = $tmp[0];
                $dataInsert['service_1_kind'] = 1;
            } else {
                // treatment
                $dataInsert['service_1'] = $tmp[0];
                $dataInsert['service_1_kind'] = 2;
            }
        }

        $status_insert = $clsBookingTelWaiting->insert($dataInsert);

        if ( $status_insert ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.list1_list.index');
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsBookingTelWaiting           = new BookingTelWaitingModel();
        $clsClinic                      = new ClinicModel();
        $clsPatient                     = new PatientModel();
        $clsUser                        = new UserModel();
        $clsService                     = new ServiceModel();
        $clsTreatment1                  = new Treatment1Model();

        $data['list1']                  = $clsBookingTelWaiting->get_by_id($id);
        $data['clinics']                = $clsClinic->get_for_select_only_user();
        $data['doctors']                = $clsUser->get_by_belong([1]);
        $data['services']               = $clsService->get_list();
        $data['treatment1s']            = $clsTreatment1->get_treatment_search();
        $patients                       = $clsPatient->get_for_select();

        $tmp = array();
        foreach ( $patients as $item ) {
            $tmp[$item->p_id] = $item->p_no . ' ' . $item->p_name_f . ' ' . $item->p_name_g . ' (' . $item->p_name_f_kana . ' ' . $item->p_name_g_kana . ')';
        }
        $data['patients'] = $tmp;

        return view('backend.ortho.list1_list.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsBookingTelWaiting           = new BookingTelWaitingModel();
        $bookingTelWaiting              = $clsBookingTelWaiting->get_by_id($id);
        $inputs                         = Input::all();
        $validator                      = Validator::make($inputs, $clsBookingTelWaiting->Rules(), $clsBookingTelWaiting->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.list1_list.edit', [ $bookingTelWaiting->id ])->withErrors($validator)->withInput();
        }

        // insert
        $dataInsert = array(
            'clinic_id'         => Input::get('clinic_id'),
            'patient_id'        => Input::get('p_id'),
            'doctor_id'         => Input::get('doctor_id'),
            'booking_memo'      => Input::get('booking_memo'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id,

            'insert_date'      => date('y-m-d H:i:s'),
        );
        $service_1 = Input::get('service_1');
        if ( !empty($service_1) ) {
            $tmp = explode('_', $service_1);
            if ( $tmp[1] == 'service' ) {
                // service
                $dataInsert['service_1'] = $tmp[0];
                $dataInsert['service_1_kind'] = 1;
            } else {
                // treatment
                $dataInsert['service_1'] = $tmp[0];
                $dataInsert['service_1_kind'] = 2;
            }
        }

        $status_insert = $clsBookingTelWaiting->update($id, $dataInsert);

        if ( $status_insert ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }

        return redirect()->route('ortho.list1_list.index');
    }

    /**
     * 
     */
    public function getDelete($id)
    {
        $clsBookingTelWaiting   = new BookingTelWaitingModel();
        $booking                = $clsBookingTelWaiting->get_by_id($id);

        if ( empty($booking->booking_group_id) && empty($booking->booking_childgroup_id) ) {
            $status = true;
            $dataUpdate = array(
                'last_date'         => date('y-m-d H:i:s'),
                'last_kind'         => DELETE,
                'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
                'last_user'         => Auth::user()->id
            );

            if ( !$clsBookingTelWaiting->update($booking->id, $dataUpdate) ) {
                $status = false;
            }
        } else {
            $where = array(
                'clinic_id'                 => $booking->clinic_id,
                'booking_group_id'          => $booking->booking_group_id,
                'booking_childgroup_id'     => $booking->booking_childgroup_id
            );
            if ( $booking->service_1_kind == 2 ) {
                $where['facility_id']       = $booking->facility_id;
            }
            $listBookingGroup = $clsBookingTelWaiting->get_where($where);

            $status = true;
            foreach ( $listBookingGroup as $item ) {
                // update table area
                $dataUpdate = array(
                    'last_date'         => date('y-m-d H:i:s'),
                    'last_kind'         => DELETE,
                    'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
                    'last_user'         => Auth::user()->id
                );

                if ( !$clsBookingTelWaiting->update($item->id, $dataUpdate) ) {
                    $status = false;
                }
            }
        }
        
        if ( $status ) {
            Session::flash('success', trans('common.message_delete_success'));
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
        }
        return redirect()->route('ortho.list1_list.index');
    }

    public function getList1Search($id)
    {
        $data['id']         = $id;
        return view('backend.ortho.list1_list.search', $data);
    }

    public function postList1Search($id)
    {
        $clsBookingTel                  = new BookingTelWaitingModel();
        $bookingTel                     = $clsBookingTel->get_by_id($id);


        $condition['id']                = $id;
        $condition['clinic_id']         = $bookingTel->clinic_id;

        if(Input::has('BookingCalendar')){

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
        }else{
            
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
            return redirect()->route('ortho.list1_list.change', $condition);
        }
    }

    public function telList1Change($id)
    {
        $clsBooking                       = new BookingModel();
        $clsFacility                      = new FacilityModel();
        $data['facilities']               = $clsFacility->list_facility_all();
        $data['id']                       = $id;
        $where                            = array();

        //Treatment
        $where['service_1_kind']          = 2;
        
        if(!empty(Input::get('booking_date')))
            $where['booking_date']        = Input::get('booking_date');
        if(!empty(Input::get('week_later')))
            $where['week_later']          = Input::get('week_later');

        $data['bookings']                 = $clsBooking->get_booking_list2($where);

        return view('backend.ortho.list1_list.change', $data);
    }

    public function list1ChangeConfirm($id)
    {
        $clsUser                        = new UserModel();
        $clsEquipment                   = new EquipmentModel();
        $data['equipments']             = $clsEquipment->get_list();
        $clsInspection                  = new InspectionModel();
        $data['inspections']            = $clsInspection->get_list();
        $clsInsurance                   = new InsuranceModel();
        $data['insurances']             = $clsInsurance->get_list();
        $clsFacility                    = new FacilityModel();
        $data['facilities']             = $clsFacility->list_facility_all();
        $data['doctors']                = $clsUser->get_list();
        $data['hygienists']             = $clsUser->get_list();
        $clsService                     = new ServiceModel();
        $data['services']               = $clsService->get_list();
        $clsTreatment1                  = new Treatment1Model();
        $data['treatment1s']            = $clsTreatment1->get_list_treatment();

        $data['id']                     = $id;
        $data['booking_id']             = Input::get('booking_id');
        $clsBookingTel                  = new BookingTelWaitingModel();
        $bookingtel                     = $clsBookingTel->get_by_id($id);

        $p_id                           = $bookingtel->patient_id;

        $clsPatient                     = new PatientModel();
        $data['patient']                = $clsPatient->get_by_id($p_id);

        $data['bookingtel']             = $bookingtel;

        $clsClinic                      = new ClinicModel();
        $data['clinics']                = $clsClinic->get_list_clinic();

        $clsBooking                     = new BookingModel();
        $new_booking                    = $clsBooking->get_by_id(Input::get('booking_id'));
        $booking_tel_memo               = $bookingtel->booking_memo;

        $data['bookingtel_change']             = (Object)array_merge((array)$new_booking, array(
                                            'booking_memo'          => $booking_tel_memo,
                                            'patient_id'            => $p_id,
                                            'last_date'             => date('Y-m-d H:i:s'),
                                            'last_user'             => Auth::user()->id,
                                            ));

        return view('backend.ortho.list1_list.change_confirm', $data);  
    }

    public function postList1Cnf($id)
    {
        $clsBooking                     = new BookingModel();

        $clsBookingTel                  = new BookingTelWaitingModel();

        $bookingtel                     = $clsBookingTel->get_by_id($id);

        $booking_id                     = Input::get('booking_id');

        $facility_id                    = $bookingtel->facility_id;
        $service_1_kind                 = $bookingtel->service_1_kind;

        $booking_childgroup_id          = $bookingtel->booking_childgroup_id;

        $new_booking                    = $clsBooking->get_by_id($booking_id); 

        $new_booking_start_time         = $new_booking->booking_start_time;
        $new_booking_date               = $new_booking->booking_date;
        $new_facility_id                = $new_booking->facility_id;    

        $bk_group_id                    = $new_booking->booking_group_id;

        $tmpGroup                       = explode('_', $bk_group_id);

        $booking_group_id       = '';
        if(!empty($tmpGroup[0])){
            $booking_group_id = $tmpGroup[0].'_'.$new_booking_date;
        }

        $bk_child_group                 = $new_booking->booking_childgroup_id;
        $booking_childgroup_id  = '';
        if(!empty($tmpGroup[1])){
            $booking_childgroup_id = 'group_'.$new_booking_start_time;
        }

        $start_time = (int)$new_booking_start_time;

        $tel_booking_childgroup_id          = $bookingtel->booking_childgroup_id;
        $tel_booking_group_id               = $bookingtel->booking_group_id;


        //tel child group
        $tel_child_groups = $clsBookingTel->getTelChildGroup($bookingtel->patient_id, $tel_booking_childgroup_id, $tel_booking_group_id, $facility_id);
        
        $limit = count($tel_child_groups);

        $newGroupBooking                = $clsBooking->get_new_booking_child_group2($new_booking_date, $start_time, $service_1_kind, $new_facility_id , $bk_group_id, $limit);

        $flag = false;

        //delete booking tel
        foreach ($tel_child_groups as $telgroup) {
            $clsBookingTel->update($telgroup->id, array(
                                    'last_date'             => date('Y-m-d H:i:s'),
                                    'last_user'             => Auth::user()->id,
                                    'last_kind'             => DELETE)); 
        }

        $bk_start_time = (int)$new_booking_start_time;

        if(!empty($newGroupBooking))
        {
            foreach ($newGroupBooking as $booking_group) {
                $dataUpdate = array(
                                            'booking_date'          => $new_booking_date,
                                            'booking_start_time'    => $bk_start_time,
                                            'booking_childgroup_id' => $booking_group_id,
                                            'booking_group_id'      => $booking_childgroup_id,
                                            'patient_id'            => $bookingtel->patient_id,
                                            'doctor_id'             => $bookingtel->doctor_id,
                                            'facility_id'           => $new_facility_id,
                                            'booking_status'        => NULL,
                                            'booking_memo'          => $bookingtel->booking_memo,
                                            'service_1'             => $bookingtel->service_1,
                                            'service_1_kind'        => $bookingtel->service_1_kind,
                                            'last_date'             => date('Y-m-d H:i:s'),
                                            'last_user'             => Auth::user()->id,
                                            'last_kind'             => UPDATE
                                            );

                if(!empty($booking_childgroup_id)){
                    array_merge($dataUpdate, array('booking_childgroup_id'=>$booking_childgroup_id));
                }

                if( $clsBooking->update($booking_group->booking_id, $dataUpdate) )
                $flag = true;                   

                $bk_start_time                  = convertStartTime($bk_start_time + 15);
            }

            if($flag){
                    Session::flash('success', trans('common.message_edit_success'));
                    return redirect()->route('ortho.list1_list.index');
            }else{
                Session::flash('danger', trans('common.message_edit_danger'));
                return redirect()->route('ortho.list1_list.change', array('id'=>$id));
            } 
        }

    }
}
