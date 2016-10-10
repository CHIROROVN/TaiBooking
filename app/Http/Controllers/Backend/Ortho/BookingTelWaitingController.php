<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Models\Ortho\BookingTelWaitingModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\PatientModel;

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
        $clsBookingTelWaiting           = new BookingTelWaitingModel();
        $clsClinic                      = new ClinicModel();
        $clsPatient                     = new PatientModel();

        $data['list1_list']             = $clsBookingTelWaiting->get_all();
        $data['clinics']                = $clsClinic->get_for_select_only_user();
        $data['patients']               = $clsPatient->get_for_select();

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
        // update table area
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        $status = $clsBookingTelWaiting->update($id, $dataUpdate);
        
        if ( $status ) {
            Session::flash('success', trans('common.message_delete_success'));
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
        }
        return redirect()->route('ortho.list1_list.index');
    }
}
