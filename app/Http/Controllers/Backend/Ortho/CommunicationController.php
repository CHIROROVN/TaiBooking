<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Http\Models\Ortho\CommunicationModel;
use App\Http\Models\Ortho\PatientModel;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\ClinicModel;
use Auth;
use Hash;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;

class CommunicationController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * get view list
     */
    public function index($patient_id)
    {
        $data                       = array();
        $ClsCommunication           = new CommunicationModel();
        $clsPatient                 = new PatientModel();
        $data['communications']     = $ClsCommunication->get_all($patient_id);
        $data['patient']            = $clsPatient->get_by_id($patient_id);

        return view('backend.ortho.patients.communications.index', $data);
    }

    /**
     * get view regist
     */
    public function getRegist($patient_id)
    {
        $data                       = array();
        $data['patient_id']         = $patient_id;

        return view('backend.ortho.patients.communications.regist', $data);
    }

    /**
     * insert database to table
     */
    public function postRegist()
    {
        $ClsCommunication           = new CommunicationModel();
        $dataInsert                 = array(
            'p_id'                  => Input::get('p_id'),
            'u_id'                  => Auth::user()->id,
            'com_title'             => Input::get('com_title'),
            'com_contents'          => Input::get('com_contents'),

            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => INSERT,
            'last_ipadrs'           => $_SERVER['REMOTE_ADDR'],
            'last_user'             => Auth::user()->id
        );

        $validator      = Validator::make($dataInsert, $ClsCommunication->Rules(), $ClsCommunication->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.patients.communications.regist', [ $dataInsert['p_id'] ])->withErrors($validator)->withInput();
        }

        // insert
        if ( $ClsCommunication->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.patients.communications.index', [ $dataInsert['p_id'] ]);
    }

    /**
     * get view edit
     * $id: ID record
     */
    public function getEdit($id, $patient_id)
    {
        $ClsCommunication                   = new CommunicationModel();
        $data['communication']              = $ClsCommunication->get_by_id($id);
        $data['patient_id']                 = $patient_id;
        return view('backend.ortho.patients.communications.edit', $data);
    }

    /**
     * udpate database to table
     * $id: ID record
     */
    public function postEdit($id, $patient_id)
    {
       $ClsCommunication           = new CommunicationModel();
        $dataUpdate                 = array(
            'p_id'                  => Input::get('p_id'),
            'u_id'                  => Auth::user()->id,
            'com_title'             => Input::get('com_title'),
            'com_contents'          => Input::get('com_contents'),
            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => UPDATE,
            'last_ipadrs'           => CLIENT_IP_ADRS,
            'last_user'             => Auth::user()->id
        );

        $validator      = Validator::make($dataUpdate, $ClsCommunication->Rules(), $ClsCommunication->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.patients.communications.edit',[$id,$patient_id])->withErrors($validator)->withInput();
        }

        // update
        if ( $ClsCommunication->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }
        return redirect()->route('ortho.patients.communications.index', $patient_id);
    }

    /**
     * update database to table
     * $id: ID record
     */
    public function getDelete($id, $patient_id)
    {
        $ClsCommunication           = new CommunicationModel();
        $dataDelete = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id
        );
        
        if ( $ClsCommunication->update($id, $dataDelete) ) {
            Session::flash('success', trans('common.message_delete_success'));
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
        }
        return redirect()->route('ortho.patients.communications.index', $patient_id);
    }


    /**
     * get view detail
     * $id: ID record
     */
    public function getDetail($id, $patient_id)
    {
        $ClsCommunication                   = new CommunicationModel();
        $data['communication']              = $ClsCommunication->get_by_id($id);
        $data['patient_id']                 = $patient_id;
        return view('backend.ortho.patients.communications.detail', $data);
    }
}
