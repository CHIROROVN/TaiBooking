<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\clinic;
use App\Http\Models\Ortho\XrayModel;
use App\Http\Models\Ortho\ClinicModel;

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

        $clsXray            = new XrayModel();
        $data['xrays']      = $clsXray->get_all(false);

        return view('backend.ortho.xrays.index', $data);
    }

    /**
     * get view regist
     */
    public function getRegist()
    {
        $clsClinic          = new ClinicModel();
        $data['clinics']    = $clsClinic->get_for_select();

        return view('backend.ortho.xrays.regist', $data);
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsXray                        = new XrayModel();
        $dataInsert                     = array(
            'xray_date'                 => '',
            'xray_place'                => (Input::get('xray_place') != 0) ? Input::get('xray_place') : '',
            'p_id'                      => (Input::get('p_id') != 0) ? Input::get('p_id') : 0, // 0 => ''
            'xray_memo'                 => Input::get('xray_memo'),
            'u_id'                      => '',

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
            return redirect()->route('ortho.xrays.regist')->withErrors($validator)->withInput();
        }

        // insert
        if ( $clsXray->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.xrays.index');
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        // $clsXray                   = new XrayModel();
        // $clsArea                     = new AreaModel();
        // $clsXrayArea               = new ClinicAreaModel();
        // $data['clinic']              = $clsXray->get_by_id($id);
        // $data['areas']               = $clsArea->get_all();
        // $data['clinic_am_starts']    = Config::get('constants.CLINIC_AM_START');
        // $data['clinic_am_ends']      = Config::get('constants.CLINIC_AM_END');
        // $data['clinic_pms']          = Config::get('constants.CLINIC_PM');
        // $data['clinic_ms']           = Config::get('constants.CLINIC_M');
        // $area_xrays                = $clsXrayArea->get_by_clinic($id);
        // $tmp                         = array();
        // foreach($area_xrays as $area_clinic)
        // {
        //     $tmp[$area_clinic->area_id] = $area_clinic->area_id;
        // }
        // $data['area_xrays']   = $tmp;

        // return view('backend.ortho.xrays.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        // $clsXray              = new XrayModel();
        // $clsXrayArea          = new ClinicAreaModel();
        // $clinic                 = $clsXray->get_by_id($id);
        // $inputs                 = Input::all();

        // $validator              = Validator::make($inputs, $clsXray->Rules(), $clsXray->Messages());

        // if ($validator->fails()) {
        //     return redirect()->route('ortho.xrays.edit', [$id])->withErrors($validator)->withInput();
        // }

        // // update
        // $dataUpdate = array(
        //     'clinic_name'               => Input::get('clinic_name'),
        //     'clinic_name_yomi'          => Input::get('clinic_name_yomi'),
        //     'clinic_display_name'       => Input::get('clinic_display_name'),
        //     'clinic_status1'            => (Input::get('clinic_status1') == 1) ? 1 : NULL,
        //     'clinic_status2'            => (Input::get('clinic_status2') == 1) ? 1 : NULL,
        //     'clinic_status3'            => (Input::get('clinic_status3') == 1) ? 1 : NULL,
        //     'clinic_status4'            => (Input::get('clinic_status4') == 1) ? 1 : NULL,
        //     'clinic_status5'            => (Input::get('clinic_status5') == 1) ? 1 : NULL,
        //     'clinic_zip3'               => Input::get('clinic_zip3'),
        //     'clinic_zip4'               => Input::get('clinic_zip4'),
        //     'clinic_address1'           => Input::get('clinic_address1'),
        //     'clinic_address2'           => Input::get('clinic_address2'),
        //     'clinic_ownername'          => Input::get('clinic_ownername'),
        //     'clinic_tel'                => Input::get('clinic_tel'),
        //     'clinic_tel_ip'             => Input::get('clinic_tel_ip'),
        //     'clinic_fax'                => Input::get('clinic_fax'),
        //     'clinic_email'              => Input::get('clinic_email'),
        //     'clinic_memo'               => Input::get('clinic_memo'),
        //     // sunday
        //     'clinic_sun_work'           => (Input::get('clinic_sun_work') == 1) ? 1 : NULL,
        //     'clinic_sun_am_start_h'     => Input::get('clinic_sun_am_start_h'),
        //     'clinic_sun_am_start_m'     => Input::get('clinic_sun_am_start_m'),
        //     'clinic_sun_am_end_h'       => Input::get('clinic_sun_am_end_h'),
        //     'clinic_sun_am_end_m'       => Input::get('clinic_sun_am_end_m'),
        //     'clinic_sun_pm_start_h'     => Input::get('clinic_sun_pm_start_h'),
        //     'clinic_sun_pm_start_m'     => Input::get('clinic_sun_pm_start_m'),
        //     'clinic_sun_pm_end_h'       => Input::get('clinic_sun_pm_end_h'),
        //     'clinic_sun_pm_end_m'       => Input::get('clinic_sun_pm_end_m'),
        //     // monday
        //     'clinic_mon_work'           => (Input::get('clinic_mon_work') == 1) ? 1 : NULL,
        //     'clinic_mon_am_start_h'     => Input::get('clinic_mon_am_start_h'),
        //     'clinic_mon_am_start_m'     => Input::get('clinic_mon_am_start_m'),
        //     'clinic_mon_am_end_h'       => Input::get('clinic_mon_am_end_h'),
        //     'clinic_mon_am_end_m'       => Input::get('clinic_mon_am_end_m'),
        //     'clinic_mon_pm_start_h'     => Input::get('clinic_mon_pm_start_h'),
        //     'clinic_mon_pm_start_m'     => Input::get('clinic_mon_pm_start_m'),
        //     'clinic_mon_pm_end_h'       => Input::get('clinic_mon_pm_end_h'),
        //     'clinic_mon_pm_end_m'       => Input::get('clinic_mon_pm_end_m'),
        //     // tueday
        //     'clinic_tue_work'           => (Input::get('clinic_tue_work') == 1) ? 1 : NULL,
        //     'clinic_tue_am_start_h'     => Input::get('clinic_tue_am_start_h'),
        //     'clinic_tue_am_start_m'     => Input::get('clinic_tue_am_start_m'),
        //     'clinic_tue_am_end_h'       => Input::get('clinic_tue_am_end_h'),
        //     'clinic_tue_am_end_m'       => Input::get('clinic_tue_am_end_m'),
        //     'clinic_tue_pm_start_h'     => Input::get('clinic_tue_pm_start_h'),
        //     'clinic_tue_pm_start_m'     => Input::get('clinic_tue_pm_start_m'),
        //     'clinic_tue_pm_end_h'       => Input::get('clinic_tue_pm_end_h'),
        //     'clinic_tue_pm_end_m'       => Input::get('clinic_tue_pm_end_m'),
        //     // wednesday
        //     'clinic_wed_work'           => (Input::get('clinic_wed_work') == 1) ? 1 : NULL,
        //     'clinic_wed_am_start_h'     => Input::get('clinic_wed_am_start_h'),
        //     'clinic_wed_am_start_m'     => Input::get('clinic_wed_am_start_m'),
        //     'clinic_wed_am_end_h'       => Input::get('clinic_wed_am_end_h'),
        //     'clinic_wed_am_end_m'       => Input::get('clinic_wed_am_end_m'),
        //     'clinic_wed_pm_start_h'     => Input::get('clinic_wed_pm_start_h'),
        //     'clinic_wed_pm_start_m'     => Input::get('clinic_wed_pm_start_m'),
        //     'clinic_wed_pm_end_h'       => Input::get('clinic_wed_pm_end_h'),
        //     'clinic_wed_pm_end_m'       => Input::get('clinic_wed_pm_end_m'),
        //     // thurday
        //     'clinic_thu_work'           => (Input::get('clinic_thu_work') == 1) ? 1 : NULL,
        //     'clinic_thu_am_start_h'     => Input::get('clinic_thu_am_start_h'),
        //     'clinic_thu_am_start_m'     => Input::get('clinic_thu_am_start_m'),
        //     'clinic_thu_am_end_h'       => Input::get('clinic_thu_am_end_h'),
        //     'clinic_thu_am_end_m'       => Input::get('clinic_thu_am_end_m'),
        //     'clinic_thu_pm_start_h'     => Input::get('clinic_thu_pm_start_h'),
        //     'clinic_thu_pm_start_m'     => Input::get('clinic_thu_pm_start_m'),
        //     'clinic_thu_pm_end_h'       => Input::get('clinic_thu_pm_end_h'),
        //     'clinic_thu_pm_end_m'       => Input::get('clinic_thu_pm_end_m'),
        //     // friday
        //     'clinic_fri_work'           => (Input::get('clinic_fri_work') == 1) ? 1 : NULL,
        //     'clinic_fri_am_start_h'     => Input::get('clinic_fri_am_start_h'),
        //     'clinic_fri_am_start_m'     => Input::get('clinic_fri_am_start_m'),
        //     'clinic_fri_am_end_h'       => Input::get('clinic_fri_am_end_h'),
        //     'clinic_fri_am_end_m'       => Input::get('clinic_fri_am_end_m'),
        //     'clinic_fri_pm_start_h'     => Input::get('clinic_fri_pm_start_h'),
        //     'clinic_fri_pm_start_m'     => Input::get('clinic_fri_pm_start_m'),
        //     'clinic_fri_pm_end_h'       => Input::get('clinic_fri_pm_end_h'),
        //     'clinic_fri_pm_end_m'       => Input::get('clinic_fri_pm_end_m'),
        //     // satuday
        //     'clinic_sat_work'           => (Input::get('clinic_sat_work') == 1) ? 1 : NULL,
        //     'clinic_sat_am_start_h'     => Input::get('clinic_sat_am_start_h'),
        //     'clinic_sat_am_start_m'     => Input::get('clinic_sat_am_start_m'),
        //     'clinic_sat_am_end_h'       => Input::get('clinic_sat_am_end_h'),
        //     'clinic_sat_am_end_m'       => Input::get('clinic_sat_am_end_m'),
        //     'clinic_sat_pm_start_h'     => Input::get('clinic_sat_pm_start_h'),
        //     'clinic_sat_pm_start_m'     => Input::get('clinic_sat_pm_start_m'),
        //     'clinic_sat_pm_end_h'       => Input::get('clinic_sat_pm_end_h'),
        //     'clinic_sat_pm_end_m'       => Input::get('clinic_sat_pm_end_m'),

        //     'last_date'                 => date('y-m-d H:i:s'),
        //     'last_kind'                 => UPDATE,
        //     'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
        //     'last_user'                 => Auth::user()->id,
        // );
        
        // if ( $clsXray->update($id, $dataUpdate) ) {
        //     Session::flash('success', trans('common.message_regist_success'));
        // } else {
        //     Session::flash('danger', trans('common.message_regist_danger'));
        // }

        // // update to table clinic_area
        // $areas = Input::get('area');
        // if(!$clsXrayArea->exist_area_clinic($areas, $id))
        // {
        //     $dataInsert = array(
        //         'area_id'           => $areas,
        //         'clinic_id'         => $id,

        //         'last_date'         => date('y-m-d H:i:s'),
        //         'last_kind'         => UPDATE,
        //         'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
        //         'last_user'         => Auth::user()->id
        //     );
        //     $clsXrayArea->update_by_clinic($id, $dataInsert);
        // }

        // return redirect()->route('ortho.xrays.index');
    }

    /**
     * 
     */
    public function getDelete($id)
    {
        // $clsXray              = new XrayModel();
        // $clsXrayArea          = new ClinicAreaModel();

        // // update
        // $dataUpdate = array(
        //     'last_date'                 => date('y-m-d H:i:s'),
        //     'last_kind'                 => DELETE,
        //     'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
        //     'last_user'                 => Auth::user()->id,
        // );
        // $clsXray->update($id, $dataUpdate);

        // // update to table clinic_area
        // $dataInsert = array(
        //     'clinic_id'         => $id,

        //     'last_date'         => date('y-m-d H:i:s'),
        //     'last_kind'         => DELETE,
        //     'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
        //     'last_user'         => Auth::user()->id
        // );
        
        // if ( $clsXrayArea->update_by_clinic($id, $dataInsert) ) {
        //     Session::flash('success', trans('common.message_regist_success'));
        // } else {
        //     Session::flash('danger', trans('common.message_regist_danger'));
        // }

        // return redirect()->route('ortho.xrays.index');
    }


    /**
     * get view detail
     * $id: ID record
     */
    public function getDetail($id)
    {
        $clsXray            = new XrayModel();
        $data['xray']       = $clsXray->get_by_id($id);

        return view('backend.ortho.xrays.detail', $data);
    }


    public function getSearch()
    {
        // search
        $data['s_p_name']                       = Input::get('s_p_name');
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
            $number             = cal_days_in_month(CAL_GREGORIAN, $month, $year_current);
            for ( $i = 1; $i <= $number; $i++ ) {
                $day_arr[] = $i;
            }
        }

        echo json_encode($day_arr);
    }
}
