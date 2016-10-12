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

        $data['clinics']                = $clsClinic->get_for_select_only_user();
        $data['patients']               = $clsPatient->get_for_select();
        $tmpList1_list                  = $clsBookingTelWaiting->get_all($data);
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
        $data['list1_list']             = $tmp;

        return view('backend.ortho.list1_list.index', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        $clsClinic                      = new ClinicModel();
        $clsPatient                     = new PatientModel();

        $data['clinics']                = $clsClinic->get_for_select_only_user();
        $data['patients']               = $clsPatient->get_for_select();

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
            'telephone'         => Input::get('telephone'),
            'free_text'         => Input::get('free_text'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );

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

        $data['list1']                  = $clsBookingTelWaiting->get_by_id($id);
        $data['clinics']                = $clsClinic->get_for_select_only_user();
        $data['patients']               = $clsPatient->get_for_select();

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
            'telephone'         => Input::get('telephone'),
            'free_text'         => Input::get('free_text'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );

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
        
        
        if ( $status ) {
            Session::flash('success', trans('common.message_delete_success'));
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
        }
        return redirect()->route('ortho.list1_list.index');
    }
}