<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\PatientModel;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\ClinicModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;

class PatientController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * get view list
     */
    public function index()
    {
        // where
        $keyword                = Input::get('keyword', null);
        $keyword_id             = Input::get('keyword_id', null);
        if ( empty($keyword) ) {
            $keyword_id = null;
        }
        $where                  = array();
        $where['keyword']       = $keyword;
        $where['keyword_id']    = $keyword_id;
        // set where
        Session::put('where', $where);

        $clsPatient             = new PatientModel();
        $data['patients']       = $clsPatient->get_all($where);
        $data['keyword']        = $keyword;
        $data['keyword_id']     = $keyword_id;

        return view('backend.ortho.patients.index', $data);
    }

    /**
     * get view regist
     */
    public function getRegist()
    {
        $clsUser                    = new UserModel();
        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_for_select();
        $data['user_doctors']       = $clsUser->get_by_belong([1]); // belong_kind = 1 = doctor
        $data['prefs']              = Config::get('constants.PREF');

        return view('backend.ortho.patients.regist', $data);
    }

    /**
     * insert database to table
     */
    public function postRegist()
    {
        $clsPatient                 = new PatientModel();
        
        $dataInsert                 = array(
            'p_no'                  => Input::get('p_no'),
            'p_dr'                  => Input::get('p_dr'),
            'p_hos_memo'            => Input::get('p_hos_memo'),
            'p_hos'                 => Input::get('p_hos'),
            'p_name'                => Input::get('p_name'),
            'p_name_kana'           => Input::get('p_name_kana'),
            'p_sex'                 => Input::get('p_sex'),
            'p_birthday'            => date('Y-m-d', strtotime(Input::get('p_birthday'))),
            'p_family_dr'           => Input::get('p_family_dr'),
            'p_introduce'           => Input::get('p_introduce'),
            'p_start'               => Input::get('p_start'),
            'p_start2'              => Input::get('p_start2'),
            'p_place'               => Input::get('p_place'),
            'p_xray'                => Input::get('p_xray'),
            'p_clinic_memo'         => Input::get('p_clinic_memo'),
            'p_personal_memo'       => Input::get('p_personal_memo'),
            'p_used'                => Input::get('p_used'),
            'p_payment'             => Input::get('p_payment'),
            'p_amount'              => Input::get('p_amount'),
            'p_zip'                 => Input::get('p_zip'),
            'p_pref'                => Input::get('p_pref'),
            'p_address1'            => Input::get('p_address1'),
            'p_address_2'           => Input::get('p_address_2'),
            'p_tel'                 => Input::get('p_tel'),
            'p_fax'                 => Input::get('p_fax'),
            'p_mobile'              => Input::get('p_mobile'),
            'p_mobile_owner'        => Input::get('p_mobile_owner'),
            'p_email'               => Input::get('p_email'),
            'p_company'             => Input::get('p_company'),
            'p_parent_name'         => Input::get('p_parent_name'),
            'p_parent_company'      => Input::get('p_parent_company'),
            'p_parent_tel'          => Input::get('p_parent_tel'),
            'p_parent_kind'         => Input::get('p_parent_kind'),
            'p_memo'                => Input::get('p_memo'),

            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => INSERT,
            'last_ipadrs'           => $_SERVER['REMOTE_ADDR'],
            'last_user'             => Auth::user()->id
        );

        $validator      = Validator::make($dataInsert, $clsPatient->Rules(), $clsPatient->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.patients.regist')->withErrors($validator)->withInput();
        }

        // insert
        if ( $clsPatient->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.patients.index');
    }

    /**
     * get view edit
     * $id: ID record
     */
    public function getEdit($id)
    {
        $clsUser                    = new UserModel();
        $clsClinic                  = new ClinicModel();
        $clsPatient                 = new PatientModel();
        $data['patient']            = $clsPatient->get_by_id($id);
        $data['clinics']            = $clsClinic->get_for_select();
        $data['user_doctors']       = $clsUser->get_for_select();
        $data['prefs']              = Config::get('constants.PREF');

        return view('backend.ortho.patients.edit', $data);
    }

    /**
     * udpate database to table
     * $id: ID record
     */
    public function postEdit($id)
    {
        $clsPatient                 = new PatientModel();
        
        $dataInsert                 = array(
            'p_no'                  => Input::get('p_no'),
            'p_dr'                  => Input::get('p_dr'),
            'p_hos_memo'            => Input::get('p_hos_memo'),
            'p_hos'                 => Input::get('p_hos'),
            'p_name'                => Input::get('p_name'),
            'p_name_kana'           => Input::get('p_name_kana'),
            'p_sex'                 => Input::get('p_sex'),
            'p_birthday'            => date('Y-m-d', strtotime(Input::get('p_birthday'))),
            'p_family_dr'           => Input::get('p_family_dr'),
            'p_introduce'           => Input::get('p_introduce'),
            'p_start'               => Input::get('p_start'),
            'p_start2'              => Input::get('p_start2'),
            'p_place'               => Input::get('p_place'),
            'p_xray'                => Input::get('p_xray'),
            'p_clinic_memo'         => Input::get('p_clinic_memo'),
            'p_personal_memo'       => Input::get('p_personal_memo'),
            'p_used'                => Input::get('p_used'),
            'p_payment'             => Input::get('p_payment'),
            'p_amount'              => Input::get('p_amount'),
            'p_zip'                 => Input::get('p_zip'),
            'p_pref'                => Input::get('p_pref'),
            'p_address1'            => Input::get('p_address1'),
            'p_address_2'           => Input::get('p_address_2'),
            'p_tel'                 => Input::get('p_tel'),
            'p_fax'                 => Input::get('p_fax'),
            'p_mobile'              => Input::get('p_mobile'),
            'p_mobile_owner'        => Input::get('p_mobile_owner'),
            'p_email'               => Input::get('p_email'),
            'p_company'             => Input::get('p_company'),
            'p_parent_name'         => Input::get('p_parent_name'),
            'p_parent_company'      => Input::get('p_parent_company'),
            'p_parent_tel'          => Input::get('p_parent_tel'),
            'p_parent_kind'         => Input::get('p_parent_kind'),
            'p_memo'                => Input::get('p_memo'),

            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => UPDATE,
            'last_ipadrs'           => $_SERVER['REMOTE_ADDR'],
            'last_user'             => Auth::user()->id
        );

        $validator      = Validator::make($dataInsert, $clsPatient->Rules(), $clsPatient->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.patients.regist')->withErrors($validator)->withInput();
        }

        // update
        if ( $clsPatient->update($id, $dataInsert) ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }

        return redirect()->route('ortho.patients.index', [
            'keyword'       => Session::get('where')['keyword'],
            'keyword_id'    => Session::get('where')['keyword_id']
        ]);
    }

    /**
     * update database to table
     * $id: ID record
     */
    public function getDelete($id)
    {
        $clsPatient             = new PatientModel();

        // update table
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        
        if ( $clsPatient->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.patients.index', [
            'keyword'       => Session::get('where')['keyword'],
            'keyword_id'    => Session::get('where')['keyword_id']
        ]);
    }


    /**
     * get view detail
     * $id: ID record
     */
    public function getDetail($id)
    {
        $clsPatient                 = new PatientModel();
        $data['patient']            = $clsPatient->get_by_id($id);
        $data['prefs']              = Config::get('constants.PREF');

        return view('backend.ortho.patients.detail', $data);
    }


    // autocomplete patient
    public function AutoCompletePatient()
    {
        $key            = Input::get('key', '');
        $id_not_me      = Input::get('id_not_me', 0);
        $clsPatient     = new PatientModel();
        $patients       = $clsPatient->get_for_autocomplate($key, $id_not_me);
        $tmp = array();
        foreach ( $patients as $patient ) {
            $tmp[] = (object)array(
                'value'     => $patient->p_id,
                'label'     => $patient->p_no . ' ' . $patient->p_name . '(' . $patient->p_name_kana . ')',
                'desc'      => $patient->p_no . ' ' . $patient->p_name . '(' . $patient->p_name_kana . ')',
            );
        }
        echo json_encode($tmp);
    }
}
