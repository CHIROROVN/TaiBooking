<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Http\Models\Ortho\RecallModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\Treatment1Model;
use App\Http\Models\Ortho\ClinicModel;

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

         if(!empty(Input::get('p_id'))){
            $data['p_id']           = Input::get('p_id');
            $data['patient']        = Input::get('patient');
            $where['patient_id']    = Input::get('p_id');
         }

        if(!empty(Input::get('insert_date'))){
            $data['insert_date']    = Input::get('insert_date');
            $where['last_date']     = Input::get('insert_date');
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
        $input['p_tel']                 = Input::get('p_tel');
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
        $input['p_tel']                 = Input::get('p_tel');
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
}
