<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\clinic;
use App\Http\Models\Ortho\XrayModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\PatientModel;
use App\Http\Models\Ortho\X3dctModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Config;
use Session;

class XrayController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * get view lists
     */
    public function index()
    {
        // search
        $data['s_p_name']                       = Input::get('s_p_name');
        $data['s_p_id']                         = Input::get('s_p_id');
        if ( empty($data['s_p_name']) ) {
            $data['s_p_id'] = '';
        }
        $data['s_p_birthday_year_from']         = Input::get('s_p_birthday_year_from', 0);
        $data['s_p_birthday_month_from']        = Input::get('s_p_birthday_month_from', 0);
        $data['s_p_birthday_day_from']          = Input::get('s_p_birthday_day_from', 0);
        $data['s_p_birthday_year_to']           = Input::get('s_p_birthday_year_to', 0);
        $data['s_p_birthday_month_to']          = Input::get('s_p_birthday_month_to', 0);
        $data['s_p_birthday_day_to']            = Input::get('s_p_birthday_day_to', 0);
        $data['s_p_sex_men']                    = Input::get('s_p_sex_men');
        $data['s_p_sex_women']                  = Input::get('s_p_sex_women');
        $data['s_xray_date_year_from']          = Input::get('s_xray_date_year_from', 0);
        $data['s_xray_date_month_from']         = Input::get('s_xray_date_month_from', 0);
        $data['s_xray_date_day_from']           = Input::get('s_xray_date_day_from', 0);
        $data['s_xray_date_year_to']            = Input::get('s_xray_date_year_to', 0);
        $data['s_xray_date_month_to']           = Input::get('s_xray_date_month_to', 0);
        $data['s_xray_date_day_to']             = Input::get('s_xray_date_day_to', 0);

        $clsXray            = new XrayModel();
        $clsPatient         = new PatientModel();
        $xrays              = $clsXray->get_all(true, $data);

        // $tmp = array();
        // $tmpGroup = array();
        // foreach ( $xrays as $item ) {
        //         if ( !in_array($item->p_id . '|' . $item->xray_date, $tmpGroup) ) {
        //             $tmpGroup[] = $item->p_id . '|' . $item->xray_date;
        //             $tmp[] = (object)$item;
        //         }
        // }
        $data['xrays'] = $xrays;

        return view('backend.ortho.xrays.index', $data);
    }

    /**
     * get view regist
     */
    public function getRegist($id)
    {
        $clsXray                    = new XrayModel();
        $clsUser                    = new UserModel();
        $clsClinic                  = new ClinicModel();
        $clsPatient                 = new PatientModel();
        $data['clinics']            = $clsClinic->get_for_select();
        $data['users']              = $clsUser->get_for_select();
        $data['patient']            = $clsPatient->get_by_id($id);

        return view('backend.ortho.xrays.regist', $data);
    }

    /**
     * 
     */
    public function postRegist($id)
    {
        $clsXray                        = new XrayModel();
        $dataInsert                     = array(
            'xray_date'                 => '',
            'xray_place'                => (Input::get('xray_place') != 0) ? Input::get('xray_place') : '',
            'p_id'                      => (Input::get('p_id') != 0) ? Input::get('p_id') : 0, // 0 => ''
            'xray_memo'                 => Input::get('xray_memo'),
            'u_id'                      => Input::get('u_id'),

            // xray_cats
            'xray_cat_1'                => (Input::get('xray_cat_1') == 1) ? 1 : 0,
            'xray_cat_2'                => (Input::get('xray_cat_2') == 1) ? 1 : 0,
            'xray_cat_3'                => (Input::get('xray_cat_3') == 1) ? 1 : 0,
            'xray_cat_4'                => (Input::get('xray_cat_4') == 1) ? 1 : 0,
            'xray_cat_5'                => (Input::get('xray_cat_5') == 1) ? 1 : 0,
            'xray_cat_6'                => (Input::get('xray_cat_6') == 1) ? 1 : 0,
            'xray_cat_7'                => (Input::get('xray_cat_7') == 1) ? 1 : 0,
            'xray_cat_8'                => (Input::get('xray_cat_8') == 1) ? 1 : 0,
            'xray_cat_9'                => (Input::get('xray_cat_9') == 1) ? 1 : 0,
            'xray_cat_10'               => (Input::get('xray_cat_10') == 1) ? 1 : 0,
            'xray_cat_11'               => (Input::get('xray_cat_11') == 1) ? 1 : 0,
            'xray_cat_12'               => (Input::get('xray_cat_12') == 1) ? 1 : 0,
            'xray_cat_13'               => (Input::get('xray_cat_13') == 1) ? 1 : 0,
            'xray_cat_14'               => (Input::get('xray_cat_14') == 1) ? 1 : 0,
            'xray_cat_15'               => (Input::get('xray_cat_15') == 1) ? 1 : 0,
            'xray_cat_16'               => (Input::get('xray_cat_16') == 1) ? 1 : 0,

            // xray_kinds
            'xray_kind_1'               => (Input::get('xray_kind_1') == 1) ? 1 : 0,
            'xray_kind_2'               => (Input::get('xray_kind_2') == 1) ? 1 : 0,
            'xray_kind_3'               => (Input::get('xray_kind_3') == 1) ? 1 : 0,
            'xray_kind_4'               => (Input::get('xray_kind_4') == 1) ? 1 : 0,
            'xray_kind_5'               => (Input::get('xray_kind_5') == 1) ? 1 : 0,
            'xray_kind_6'               => (Input::get('xray_kind_6') == 1) ? 1 : 0,
            'xray_kind_7'               => (Input::get('xray_kind_7') == 1) ? 1 : 0,
            'xray_kind_8'               => (Input::get('xray_kind_8') == 1) ? 1 : 0,
            'xray_kind_9'               => (Input::get('xray_kind_9') == 1) ? 1 : 0,

            // xray_memos
            'xray_memo_1'               => (Input::get('xray_memo_1') == 1) ? 1 : 0,
            'xray_memo_2'               => (Input::get('xray_memo_2') == 1) ? 1 : 0,
            'xray_memo_3'               => (Input::get('xray_memo_3') == 1) ? 1 : 0,
            'xray_memo_4'               => (Input::get('xray_memo_4') == 1) ? 1 : 0,
            'xray_memo_5'               => (Input::get('xray_memo_5') == 1) ? 1 : 0,
            'xray_memo_6'               => (Input::get('xray_memo_6') == 1) ? 1 : 0,
            'xray_memo_7'               => (Input::get('xray_memo_7') == 1) ? 1 : 0,

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => INSERT,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id,
        );

        if ( Input::get('xray_date_year') != 0 && Input::get('xray_date_month') != 0 && Input::get('xray_date_day') != 0 ) {
            $dataInsert['xray_date'] = Input::get('xray_date_year') . '-' . Input::get('xray_date_month') . '-' . Input::get('xray_date_day');
        }

        $validator              = Validator::make($dataInsert, $clsXray->Rules(), $clsXray->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.xrays.regist', [ $id ])->withErrors($validator)->withInput();
        }

        // insert
        if ( $clsXray->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.xrays.detail', [ $id ]);
    }

    /**
     * 
     */
    public function getEdit($patient_id, $id)
    {
        $clsXray                    = new XrayModel();
        $clsUser                    = new UserModel();
        $clsClinic                  = new ClinicModel();
        $clsPatient                 = new PatientModel();
        $data['clinics']            = $clsClinic->get_for_select();
        $data['xray']               = $clsXray->get_by_id($id);
        $data['users']              = $clsUser->get_for_select();
        $data['patient']            = $clsPatient->get_by_id($patient_id);
        return view('backend.ortho.xrays.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($patient_id, $id)
    {
        $clsXray                        = new XrayModel();
        $dataInsert                     = array(
            'xray_date'                 => '', // after
            'xray_place'                => (Input::get('xray_place') != 0) ? Input::get('xray_place') : '',
            // 'p_id'                      => '',
            'xray_memo'                 => Input::get('xray_memo'),
            'u_id'                      => Input::get('u_id'),

            // xray_cats
            'xray_cat_1'                => (Input::get('xray_cat_1') == 1) ? 1 : 0,
            'xray_cat_2'                => (Input::get('xray_cat_2') == 1) ? 1 : 0,
            'xray_cat_3'                => (Input::get('xray_cat_3') == 1) ? 1 : 0,
            'xray_cat_4'                => (Input::get('xray_cat_4') == 1) ? 1 : 0,
            'xray_cat_5'                => (Input::get('xray_cat_5') == 1) ? 1 : 0,
            'xray_cat_6'                => (Input::get('xray_cat_6') == 1) ? 1 : 0,
            'xray_cat_7'                => (Input::get('xray_cat_7') == 1) ? 1 : 0,
            'xray_cat_8'                => (Input::get('xray_cat_8') == 1) ? 1 : 0,
            'xray_cat_9'                => (Input::get('xray_cat_9') == 1) ? 1 : 0,
            'xray_cat_10'               => (Input::get('xray_cat_10') == 1) ? 1 : 0,
            'xray_cat_11'               => (Input::get('xray_cat_11') == 1) ? 1 : 0,
            'xray_cat_12'               => (Input::get('xray_cat_12') == 1) ? 1 : 0,
            'xray_cat_13'               => (Input::get('xray_cat_13') == 1) ? 1 : 0,
            'xray_cat_14'               => (Input::get('xray_cat_14') == 1) ? 1 : 0,
            'xray_cat_15'               => (Input::get('xray_cat_15') == 1) ? 1 : 0,
            'xray_cat_16'               => (Input::get('xray_cat_16') == 1) ? 1 : 0,

            // xray_kinds
            'xray_kind_1'               => (Input::get('xray_kind_1') == 1) ? 1 : 0,
            'xray_kind_2'               => (Input::get('xray_kind_2') == 1) ? 1 : 0,
            'xray_kind_3'               => (Input::get('xray_kind_3') == 1) ? 1 : 0,
            'xray_kind_4'               => (Input::get('xray_kind_4') == 1) ? 1 : 0,
            'xray_kind_5'               => (Input::get('xray_kind_5') == 1) ? 1 : 0,
            'xray_kind_6'               => (Input::get('xray_kind_6') == 1) ? 1 : 0,
            'xray_kind_7'               => (Input::get('xray_kind_7') == 1) ? 1 : 0,
            'xray_kind_8'               => (Input::get('xray_kind_8') == 1) ? 1 : 0,
            'xray_kind_9'               => (Input::get('xray_kind_9') == 1) ? 1 : 0,

            // xray_memos
            'xray_memo_1'               => (Input::get('xray_memo_1') == 1) ? 1 : 0,
            'xray_memo_2'               => (Input::get('xray_memo_2') == 1) ? 1 : 0,
            'xray_memo_3'               => (Input::get('xray_memo_3') == 1) ? 1 : 0,
            'xray_memo_4'               => (Input::get('xray_memo_4') == 1) ? 1 : 0,
            'xray_memo_5'               => (Input::get('xray_memo_5') == 1) ? 1 : 0,
            'xray_memo_6'               => (Input::get('xray_memo_6') == 1) ? 1 : 0,
            'xray_memo_7'               => (Input::get('xray_memo_7') == 1) ? 1 : 0,

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id,
        );

        if ( Input::get('xray_date_year') != 0 && Input::get('xray_date_month') != 0 && Input::get('xray_date_day') != 0 ) {
            $dataInsert['xray_date'] = Input::get('xray_date_year') . '-' . Input::get('xray_date_month') . '-' . Input::get('xray_date_day');
        }

        $validator              = Validator::make($dataInsert, $clsXray->Rules(), $clsXray->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.xrays.edit', [ $patient_id, $id ])->withErrors($validator)->withInput();
        }

        // update
        if ( $clsXray->update($id, $dataInsert) ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }

        return redirect()->route('ortho.xrays.detail', [ $patient_id, $id ]);
    }

    /**
     * 
     */
    public function getDelete($patient_id, $id)
    {
        $clsXray                        = new XrayModel();

        // update
        $dataUpdate = array(
            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => DELETE,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id,
        );
        
        if ( $clsXray->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }

        return redirect()->route('ortho.xrays.detail', [ $patient_id ]);
    }


    /**
     * get view detail
     * $id: ID record
     */
    public function getDetail($id)
    {
        $clsXray                    = new XrayModel();
        $clsUser                    = new UserModel();
        $clsPatient                 = new PatientModel();
        $cls3dct                    = new X3dctModel();
        $data['users']              = $clsUser->get_for_select();
        $data['patient_xrays']      = $clsXray->get_by_patient_id($id);
        $data['patient']            = $clsPatient->get_by_id($id);
        $data['patient_3dcts']      = $cls3dct->get_by_patient_id($id);

        return view('backend.ortho.xrays.detail', $data);
    }

    public function getSearch()
    {
        // search
        $data['s_p_name']                       = Input::get('s_p_name');
        $data['s_p_id']                         = Input::get('s_p_id');
        if ( empty($data['s_p_name']) ) {
            $data['s_p_id'] = '';
        }
        $data['s_p_birthday_year_from']         = Input::get('s_p_birthday_year_from');
        $data['s_p_birthday_month_from']        = Input::get('s_p_birthday_month_from');
        $data['s_p_birthday_day_from']          = Input::get('s_p_birthday_day_from');
        $data['s_p_birthday_year_to']           = Input::get('s_p_birthday_year_to');
        $data['s_p_birthday_month_to']          = Input::get('s_p_birthday_month_to');
        $data['s_p_birthday_day_to']            = Input::get('s_p_birthday_day_to');
        $data['s_p_sex_men']                    = Input::get('s_p_sex_men');
        $data['s_p_sex_women']                  = Input::get('s_p_sex_women');
        $data['s_xray_date_year_from']          = Input::get('s_xray_date_year_from');
        $data['s_xray_date_month_from']         = Input::get('s_xray_date_month_from');
        $data['s_xray_date_day_from']           = Input::get('s_xray_date_day_from');
        $data['s_xray_date_year_to']            = Input::get('s_xray_date_year_to');
        $data['s_xray_date_month_to']           = Input::get('s_xray_date_month_to');
        $data['s_xray_date_day_to']             = Input::get('s_xray_date_day_to');

        return view('backend.ortho.xrays.search', $data);
    }


    /**
     * get number day by month current
     */
    public function getDay()
    {
        $month              = Input::get('month');
        $year_current       = date('Y');
        $day_arr            = array();
        if ( $month != 0 ) {
            $number             = $this->cal_days_in_month(1, $month, $year_current);
            for ( $i = 1; $i <= $number; $i++ ) {
                $day_arr[] = $i;
            }
        }

        echo json_encode($day_arr);
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
                'label'     => $patient->p_no . ' ' . $patient->p_name_f . ' ' . $patient->p_name_g . '(' . $patient->p_name_f_kana . ' ' . $patient->p_name_g_kana . ')',
                'desc'      => $patient->p_no . ' ' . $patient->p_name_f . ' ' . $patient->p_name_g . '(' . $patient->p_name_f_kana . ' ' . $patient->p_name_g_kana . ')',
            );
        }
        echo json_encode($tmp);
    }


    function cal_days_in_month($calendar, $month, $year) 
    { 
        return date('t', mktime(0, 0, 0, $month, 1, $year)); 
    }
}
