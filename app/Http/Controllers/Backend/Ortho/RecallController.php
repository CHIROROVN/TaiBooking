<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Http\Models\Ortho\RecallModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\Treatment1Model;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\BookingModel;
use App\Http\Models\Ortho\FacilityModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Response;
use Redirect;

class RecallController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * booking recall
     */
    public function index()
    {
        $where              = array();
        $clsRecall          = new RecallModel();
        $ynow = date('Y');
        $ynext      = $ynow + 3;
        $yoption    = '';
        $data['oldmonth']           = Input::get('month');
        for($i=$ynow; $i<=$ynext; $i++){
            if(Input::get('year') == $i){
                $select = 'selected=""';
            }else{
                $select = '';
            }
            $yoption .= "<option value='".$i."' ".$select." >".$i."</option>";
        }

        $data['yoption']            = $yoption;

        if(!empty(Input::get('p_id'))){
            $data['p_id']           = Input::get('p_id');
            $data['patient']        = Input::get('patient');
            $where['patient_id']    = Input::get('p_id');
         }

        if(!empty(Input::get('year'))){
            if(!empty(Input::get('month')))
                $smonth = Input::get('month');
            else
                $smonth = '00';
            
            $where['booking_recall_ym']     = Input::get('year').$smonth;
        }

        $data['recalls']    = $clsRecall->get_recall_list($where);

        return view('backend.ortho.bookings.booking_recall', $data);
    }

    /**
     * get booking recall regist
     */
    public function getRegist()
    {
        $data  = array();
        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_list_clinic();
        return view('backend.ortho.bookings.booking_recall_regist', $data);
    }

    /**
     * post booking recall regist
     */
    public function postRegist()
    {
        $clsRecall      = new RecallModel();
        $inputs         = Input::all();
        $validator      = Validator::make($inputs, $clsRecall->Rules(), $clsRecall->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.bookings.booking_recall_regist')->withErrors($validator)->withInput();
        }

        $input                          = array();
        $input['clinic_id']             = Input::get('clinic_id');
        $input['patient_id']            = Input::get('p_id');
        $input['booking_recall_ym']     = Input::get('booking_recall_ym');
        $input['booking_memo']          = Input::get('booking_memo');
        $input['last_kind']             = INSERT;
        $input['last_ipadrs']           = CLIENT_IP_ADRS;
        $input['last_date']             = date('y-m-d H:i:s');
        $input['last_user']             = Auth::user()->id;

        if ( $clsRecall->insert($input) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('ortho.bookings.booking_recall');
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('ortho.bookings.booking_recall_regist');
        }
    }

    /**
     * get booking recall edit
     */
    public function getEdit($id)
    {
        $data                   = array();
        $clsRecall              = new RecallModel();
        $data['id']             = $id;
        $clsClinic              = new ClinicModel();
        $data['clinics']        = $clsClinic->get_list_clinic();
        $data['recall']         = $clsRecall->get_by_id($id);

        return view('backend.ortho.bookings.booking_recall_edit', $data);
    }

    /**
     * post booking recall edit
     */
    public function postEdit($id)
    {
        $clsRecall      = new RecallModel();
        $inputs         = Input::all();
        $validator      = Validator::make($inputs, $clsRecall->Rules(), $clsRecall->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.bookings.booking_recall_edit',$id)->withErrors($validator)->withInput();
        }

        $input                          = array();
        $input['clinic_id']             = Input::get('clinic_id');
        $input['patient_id']            = Input::get('p_id');
        $input['booking_recall_ym']     = Input::get('booking_recall_ym');
        $input['booking_memo']          = Input::get('booking_memo');
        $input['last_kind']             = UPDATE;
        $input['last_ipadrs']           = CLIENT_IP_ADRS;
        $input['last_date']             = date('y-m-d H:i:s');
        $input['last_user']             = Auth::user()->id;

        if ( $clsRecall->update($id, $input) ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.bookings.booking_recall');
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.booking_recall_edit',$id);
        }
    }

    public function getSearch($id)
    {
        $data['id']         = $id;
        return view('backend.ortho.bookings.booking_recall_search', $data);
    }

    public function postSearch($id)
    {
        $clsRecall                      = new RecallModel();
        $recall                         = $clsRecall->get_by_id($id);
        $condition['id']                = $recall->id;
        $condition['clinic_id']         = $recall->clinic_id;

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
            return redirect()->route('ortho.bookings.booking_recall_change', $condition);
        }
    }

    public function recallListChange($id)
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

        return view('backend.ortho.bookings.booking_recall_change', $data);
    }

    public function getRecallChangeCnf($id)
    {
        $data['id']                     = $id;
        $data['booking_id']             = Input::get('booking_id');
        $clsRecall                      = new RecallModel();
        $recall                         = $clsRecall->get_by_id($id);
        $data['recall']                 = $recall;
        $clsClinic                      = new ClinicModel();
        $data['clinics']                = $clsClinic->get_list_clinic();

        $clsBooking                     = new BookingModel();
        $new_booking                    = $clsBooking->get_by_id(Input::get('booking_id'));
        $new_patient_id                 = $recall->patient_id;
        $recall_memo                    = $recall->booking_memo;
        $data['recall_change']          = (Object)array_merge((array)$new_booking, array(
                                            'booking_memo'          => $recall_memo,
                                            'patient_id'            => $new_patient_id,
                                            'last_date'             => date('Y-m-d H:i:s'),
                                            'last_user'             => Auth::user()->id,
                                            ));

        return view('backend.ortho.bookings.booking_recall_change_confirm', $data);
    }

    public function postRecallChangeCnf($id)
    {
        $clsBooking                     = new BookingModel();
        $clsRecall                      = new RecallModel();

        $recall                         = $clsRecall->get_by_id($id);
        $booking_id                     = Input::get('booking_id');
        $new_booking                    = $clsBooking->get_by_id($booking_id);
        
        // $new_booking_childgroup_id      = $new_booking->booking_childgroup_id;
        // $new_booking_group_id           = $new_booking->booking_group_id;
        // $newGroupBooking                = $clsBooking->get_recall_booking_child_group($new_booking_group_id, $new_booking_childgroup_id);

        $dataUpdate                    =  array(
                                            'booking_memo'          => $recall->booking_memo,
                                            'patient_id'            => $recall->patient_id,
                                            'booking_status'        => NULL,
                                            'last_date'             => date('Y-m-d H:i:s'),
                                            'last_user'             => Auth::user()->id,
                                            'last_kind'             => UPDATE
                                            );
        //delete recall
        $clsRecall->update($id, array(
                                    'last_date'             => date('Y-m-d H:i:s'),
                                    'last_user'             => Auth::user()->id,
                                    'last_kind'             => DELETE));
        //update booking
        if ($clsBooking->update($booking_id, $dataUpdate)) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.bookings.booking_recall');
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.bookings.booking_recall_change', array('id'=>$booking_id));
        }

    }

    public function recalDelete($id)
    {
        $clsRecall                      = new RecallModel();
        $dataDelete = array(
            'last_kind'             => DELETE,
            'last_ipadrs'           => CLIENT_IP_ADRS,
            'last_user'             => Auth::user()->id,
            'last_date'             => date('y-m-d H:i:s'),
        );

        if ( $clsRecall->update($id, $dataDelete) ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.bookings.booking_recall');
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.bookings.booking_recall_edit',$id);
        }
    }

}
