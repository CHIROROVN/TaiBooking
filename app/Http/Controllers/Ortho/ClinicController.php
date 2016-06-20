<?php namespace App\Http\Controllers\Ortho;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\clinic;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\AreaModel;
use App\Http\Models\Ortho\ClinicAreaModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Config;

class ClinicController extends Controller
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
        $clsClinic          = new ClinicModel();

        // search
        $keyword = Input::get('keyword');
        $data['keyword'] = $keyword;
        if(Input::get('search') && !empty($keyword))
        { 
            $data['clinics']    = $clsClinic->get_all(true, $keyword);
        }
        else
        {
            $data['clinics']    = $clsClinic->get_all(true);
        }

        return view('ortho.clinics.index', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        $clsArea                     = new AreaModel();
        $data['areas']               = $clsArea->get_all();
        $data['clinic_am_starts']    = Config::get('constants.CLINIC_AM_START');
        $data['clinic_am_ends']      = Config::get('constants.CLINIC_AM_END');
        $data['clinic_pms']          = Config::get('constants.CLINIC_PM');
        $data['clinic_ms']           = Config::get('constants.CLINIC_M');

        return view('ortho.clinics.regist', $data);
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsClinic              = new ClinicModel();
        $clsClinicArea          = new ClinicAreaModel();
        $inputs                 = Input::all();
        $validator              = Validator::make($inputs, $clsClinic->Rules(), $clsClinic->Messages());

        if ($validator->fails()) {
            return redirect('ortho/clinics/regist')->withErrors($validator)->withInput();
        }

        // insert
        $dataInsert = array(
            'clinic_name'               => Input::get('clinic_name'),
            'clinic_name_yomi'          => Input::get('clinic_name_yomi'),
            'clinic_display_name'       => Input::get('clinic_display_name'),
            'clinic_status1'            => (Input::get('clinic_status1') == 1) ? 1 : NULL,
            'clinic_status2'            => (Input::get('clinic_status2') == 1) ? 1 : NULL,
            'clinic_status3'            => (Input::get('clinic_status3') == 1) ? 1 : NULL,
            'clinic_status4'            => (Input::get('clinic_status4') == 1) ? 1 : NULL,
            'clinic_status5'            => (Input::get('clinic_status5') == 1) ? 1 : NULL,
            'clinic_zip3'               => Input::get('clinic_zip3'),
            'clinic_zip4'               => Input::get('clinic_zip4'),
            'clinic_address1'           => Input::get('clinic_address1'),
            'clinic_address2'           => Input::get('clinic_address2'),
            'clinic_ownername'          => Input::get('clinic_ownername'),
            'clinic_tel'                => Input::get('clinic_tel'),
            'clinic_tel_ip'             => Input::get('clinic_tel_ip'),
            'clinic_fax'                => Input::get('clinic_fax'),
            'clinic_email'              => Input::get('clinic_email'),
            'clinic_memo'               => Input::get('clinic_memo'),
            // sunday
            'clinic_sun_work'           => (Input::get('clinic_sun_work') == 1) ? 1 : NULL,
            'clinic_sun_am_start_h'     => Input::get('clinic_sun_am_start_h'),
            'clinic_sun_am_start_m'     => Input::get('clinic_sun_am_start_m'),
            'clinic_sun_am_end_h'       => Input::get('clinic_sun_am_end_h'),
            'clinic_sun_am_end_m'       => Input::get('clinic_sun_am_end_m'),
            'clinic_sun_pm_start_h'     => Input::get('clinic_sun_pm_start_h'),
            'clinic_sun_pm_start_m'     => Input::get('clinic_sun_pm_start_m'),
            'clinic_sun_pm_end_h'       => Input::get('clinic_sun_pm_end_h'),
            'clinic_sun_pm_end_m'       => Input::get('clinic_sun_pm_end_m'),
            // monday
            'clinic_mon_work'           => (Input::get('clinic_mon_work') == 1) ? 1 : NULL,
            'clinic_mon_am_start_h'     => Input::get('clinic_mon_am_start_h'),
            'clinic_mon_am_start_m'     => Input::get('clinic_mon_am_start_m'),
            'clinic_mon_am_end_h'       => Input::get('clinic_mon_am_end_h'),
            'clinic_mon_am_end_m'       => Input::get('clinic_mon_am_end_m'),
            'clinic_mon_pm_start_h'     => Input::get('clinic_mon_pm_start_h'),
            'clinic_mon_pm_start_m'     => Input::get('clinic_mon_pm_start_m'),
            'clinic_mon_pm_end_h'       => Input::get('clinic_mon_pm_end_h'),
            'clinic_mon_pm_end_m'       => Input::get('clinic_mon_pm_end_m'),
            // tueday
            'clinic_tue_work'           => (Input::get('clinic_tue_work') == 1) ? 1 : NULL,
            'clinic_tue_am_start_h'     => Input::get('clinic_tue_am_start_h'),
            'clinic_tue_am_start_m'     => Input::get('clinic_tue_am_start_m'),
            'clinic_tue_am_end_h'       => Input::get('clinic_tue_am_end_h'),
            'clinic_tue_am_end_m'       => Input::get('clinic_tue_am_end_m'),
            'clinic_tue_pm_start_h'     => Input::get('clinic_tue_pm_start_h'),
            'clinic_tue_pm_start_m'     => Input::get('clinic_tue_pm_start_m'),
            'clinic_tue_pm_end_h'       => Input::get('clinic_tue_pm_end_h'),
            'clinic_tue_pm_end_m'       => Input::get('clinic_tue_pm_end_m'),
            // wednesday
            'clinic_wed_work'           => (Input::get('clinic_wed_work') == 1) ? 1 : NULL,
            'clinic_wed_am_start_h'     => Input::get('clinic_wed_am_start_h'),
            'clinic_wed_am_start_m'     => Input::get('clinic_wed_am_start_m'),
            'clinic_wed_am_end_h'       => Input::get('clinic_wed_am_end_h'),
            'clinic_wed_am_end_m'       => Input::get('clinic_wed_am_end_m'),
            'clinic_wed_pm_start_h'     => Input::get('clinic_wed_pm_start_h'),
            'clinic_wed_pm_start_m'     => Input::get('clinic_wed_pm_start_m'),
            'clinic_wed_pm_end_h'       => Input::get('clinic_wed_pm_end_h'),
            'clinic_wed_pm_end_m'       => Input::get('clinic_wed_pm_end_m'),
            // thurday
            'clinic_thu_work'           => (Input::get('clinic_thu_work') == 1) ? 1 : NULL,
            'clinic_thu_am_start_h'     => Input::get('clinic_thu_am_start_h'),
            'clinic_thu_am_start_m'     => Input::get('clinic_thu_am_start_m'),
            'clinic_thu_am_end_h'       => Input::get('clinic_thu_am_end_h'),
            'clinic_thu_am_end_m'       => Input::get('clinic_thu_am_end_m'),
            'clinic_thu_pm_start_h'     => Input::get('clinic_thu_pm_start_h'),
            'clinic_thu_pm_start_m'     => Input::get('clinic_thu_pm_start_m'),
            'clinic_thu_pm_end_h'       => Input::get('clinic_thu_pm_end_h'),
            'clinic_thu_pm_end_m'       => Input::get('clinic_thu_pm_end_m'),
            // friday
            'clinic_fri_work'           => (Input::get('clinic_fri_work') == 1) ? 1 : NULL,
            'clinic_fri_am_start_h'     => Input::get('clinic_fri_am_start_h'),
            'clinic_fri_am_start_m'     => Input::get('clinic_fri_am_start_m'),
            'clinic_fri_am_end_h'       => Input::get('clinic_fri_am_end_h'),
            'clinic_fri_am_end_m'       => Input::get('clinic_fri_am_end_m'),
            'clinic_fri_pm_start_h'     => Input::get('clinic_fri_pm_start_h'),
            'clinic_fri_pm_start_m'     => Input::get('clinic_fri_pm_start_m'),
            'clinic_fri_pm_end_h'       => Input::get('clinic_fri_pm_end_h'),
            'clinic_fri_pm_end_m'       => Input::get('clinic_fri_pm_end_m'),
            // satuday
            'clinic_sat_work'           => (Input::get('clinic_sat_work') == 1) ? 1 : NULL,
            'clinic_sat_am_start_h'     => Input::get('clinic_sat_am_start_h'),
            'clinic_sat_am_start_m'     => Input::get('clinic_sat_am_start_m'),
            'clinic_sat_am_end_h'       => Input::get('clinic_sat_am_end_h'),
            'clinic_sat_am_end_m'       => Input::get('clinic_sat_am_end_m'),
            'clinic_sat_pm_start_h'     => Input::get('clinic_sat_pm_start_h'),
            'clinic_sat_pm_start_m'     => Input::get('clinic_sat_pm_start_m'),
            'clinic_sat_pm_end_h'       => Input::get('clinic_sat_pm_end_h'),
            'clinic_sat_pm_end_m'       => Input::get('clinic_sat_pm_end_m'),

            'last_kind'                 => INSERT,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id,
        );
        $clinic_id = $clsClinic->insert_get_id($dataInsert);

        // add to table clinic_area
        $areas = Input::get('area');
        if(!$clsClinicArea->exist_area_clinic($areas, $clinic_id) && !empty($areas))
        {
            $dataInsert = array(
                'area_id'           => $areas,
                'clinic_id'         => $clinic_id,
                'last_kind'         => INSERT,
                'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
                'last_user'         => Auth::user()->id
            );
            $clsClinicArea->insert($dataInsert);
        }

        return redirect()->route('ortho.clinics.index');
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsClinic                   = new ClinicModel();
        $clsArea                     = new AreaModel();
        $clsClinicArea               = new ClinicAreaModel();
        $data['clinic']              = $clsClinic->get_by_id($id);
        $data['areas']               = $clsArea->get_all();
        $data['clinic_am_starts']    = Config::get('constants.CLINIC_AM_START');
        $data['clinic_am_ends']      = Config::get('constants.CLINIC_AM_END');
        $data['clinic_pms']          = Config::get('constants.CLINIC_PM');
        $data['clinic_ms']           = Config::get('constants.CLINIC_M');
        $area_clinics                = $clsClinicArea->get_by_clinic($id);
        $tmp                         = array();
        foreach($area_clinics as $area_clinic)
        {
            $tmp[$area_clinic->area_id] = $area_clinic->area_id;
        }
        $data['area_clinics']   = $tmp;

        return view('ortho.clinics.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsClinic              = new ClinicModel();
        $clsClinicArea          = new ClinicAreaModel();
        $clinic                 = $clsClinic->get_by_id($id);
        $inputs                 = Input::all();

        $validator              = Validator::make($inputs, $clsClinic->Rules(), $clsClinic->Messages());

        if ($validator->fails()) {
            return redirect('ortho/clinics/edit/' . $clinic->id)->withErrors($validator)->withInput();
        }

        // update
        $dataUpdate = array(
            'clinic_name'               => Input::get('clinic_name'),
            'clinic_name_yomi'          => Input::get('clinic_name_yomi'),
            'clinic_display_name'       => Input::get('clinic_display_name'),
            'clinic_status1'            => (Input::get('clinic_status1') == 1) ? 1 : NULL,
            'clinic_status2'            => (Input::get('clinic_status2') == 1) ? 1 : NULL,
            'clinic_status3'            => (Input::get('clinic_status3') == 1) ? 1 : NULL,
            'clinic_status4'            => (Input::get('clinic_status4') == 1) ? 1 : NULL,
            'clinic_status5'            => (Input::get('clinic_status5') == 1) ? 1 : NULL,
            'clinic_zip3'               => Input::get('clinic_zip3'),
            'clinic_zip4'               => Input::get('clinic_zip4'),
            'clinic_address1'           => Input::get('clinic_address1'),
            'clinic_address2'           => Input::get('clinic_address2'),
            'clinic_ownername'          => Input::get('clinic_ownername'),
            'clinic_tel'                => Input::get('clinic_tel'),
            'clinic_tel_ip'             => Input::get('clinic_tel_ip'),
            'clinic_fax'                => Input::get('clinic_fax'),
            'clinic_email'              => Input::get('clinic_email'),
            'clinic_memo'               => Input::get('clinic_memo'),
            // sunday
            'clinic_sun_work'           => (Input::get('clinic_sun_work') == 1) ? 1 : NULL,
            'clinic_sun_am_start_h'     => Input::get('clinic_sun_am_start_h'),
            'clinic_sun_am_start_m'     => Input::get('clinic_sun_am_start_m'),
            'clinic_sun_am_end_h'       => Input::get('clinic_sun_am_end_h'),
            'clinic_sun_am_end_m'       => Input::get('clinic_sun_am_end_m'),
            'clinic_sun_pm_start_h'     => Input::get('clinic_sun_pm_start_h'),
            'clinic_sun_pm_start_m'     => Input::get('clinic_sun_pm_start_m'),
            'clinic_sun_pm_end_h'       => Input::get('clinic_sun_pm_end_h'),
            'clinic_sun_pm_end_m'       => Input::get('clinic_sun_pm_end_m'),
            // monday
            'clinic_mon_work'           => (Input::get('clinic_mon_work') == 1) ? 1 : NULL,
            'clinic_mon_am_start_h'     => Input::get('clinic_mon_am_start_h'),
            'clinic_mon_am_start_m'     => Input::get('clinic_mon_am_start_m'),
            'clinic_mon_am_end_h'       => Input::get('clinic_mon_am_end_h'),
            'clinic_mon_am_end_m'       => Input::get('clinic_mon_am_end_m'),
            'clinic_mon_pm_start_h'     => Input::get('clinic_mon_pm_start_h'),
            'clinic_mon_pm_start_m'     => Input::get('clinic_mon_pm_start_m'),
            'clinic_mon_pm_end_h'       => Input::get('clinic_mon_pm_end_h'),
            'clinic_mon_pm_end_m'       => Input::get('clinic_mon_pm_end_m'),
            // tueday
            'clinic_tue_work'           => (Input::get('clinic_tue_work') == 1) ? 1 : NULL,
            'clinic_tue_am_start_h'     => Input::get('clinic_tue_am_start_h'),
            'clinic_tue_am_start_m'     => Input::get('clinic_tue_am_start_m'),
            'clinic_tue_am_end_h'       => Input::get('clinic_tue_am_end_h'),
            'clinic_tue_am_end_m'       => Input::get('clinic_tue_am_end_m'),
            'clinic_tue_pm_start_h'     => Input::get('clinic_tue_pm_start_h'),
            'clinic_tue_pm_start_m'     => Input::get('clinic_tue_pm_start_m'),
            'clinic_tue_pm_end_h'       => Input::get('clinic_tue_pm_end_h'),
            'clinic_tue_pm_end_m'       => Input::get('clinic_tue_pm_end_m'),
            // wednesday
            'clinic_wed_work'           => (Input::get('clinic_wed_work') == 1) ? 1 : NULL,
            'clinic_wed_am_start_h'     => Input::get('clinic_wed_am_start_h'),
            'clinic_wed_am_start_m'     => Input::get('clinic_wed_am_start_m'),
            'clinic_wed_am_end_h'       => Input::get('clinic_wed_am_end_h'),
            'clinic_wed_am_end_m'       => Input::get('clinic_wed_am_end_m'),
            'clinic_wed_pm_start_h'     => Input::get('clinic_wed_pm_start_h'),
            'clinic_wed_pm_start_m'     => Input::get('clinic_wed_pm_start_m'),
            'clinic_wed_pm_end_h'       => Input::get('clinic_wed_pm_end_h'),
            'clinic_wed_pm_end_m'       => Input::get('clinic_wed_pm_end_m'),
            // thurday
            'clinic_thu_work'           => (Input::get('clinic_thu_work') == 1) ? 1 : NULL,
            'clinic_thu_am_start_h'     => Input::get('clinic_thu_am_start_h'),
            'clinic_thu_am_start_m'     => Input::get('clinic_thu_am_start_m'),
            'clinic_thu_am_end_h'       => Input::get('clinic_thu_am_end_h'),
            'clinic_thu_am_end_m'       => Input::get('clinic_thu_am_end_m'),
            'clinic_thu_pm_start_h'     => Input::get('clinic_thu_pm_start_h'),
            'clinic_thu_pm_start_m'     => Input::get('clinic_thu_pm_start_m'),
            'clinic_thu_pm_end_h'       => Input::get('clinic_thu_pm_end_h'),
            'clinic_thu_pm_end_m'       => Input::get('clinic_thu_pm_end_m'),
            // friday
            'clinic_fri_work'           => (Input::get('clinic_fri_work') == 1) ? 1 : NULL,
            'clinic_fri_am_start_h'     => Input::get('clinic_fri_am_start_h'),
            'clinic_fri_am_start_m'     => Input::get('clinic_fri_am_start_m'),
            'clinic_fri_am_end_h'       => Input::get('clinic_fri_am_end_h'),
            'clinic_fri_am_end_m'       => Input::get('clinic_fri_am_end_m'),
            'clinic_fri_pm_start_h'     => Input::get('clinic_fri_pm_start_h'),
            'clinic_fri_pm_start_m'     => Input::get('clinic_fri_pm_start_m'),
            'clinic_fri_pm_end_h'       => Input::get('clinic_fri_pm_end_h'),
            'clinic_fri_pm_end_m'       => Input::get('clinic_fri_pm_end_m'),
            // satuday
            'clinic_sat_work'           => (Input::get('clinic_sat_work') == 1) ? 1 : NULL,
            'clinic_sat_am_start_h'     => Input::get('clinic_sat_am_start_h'),
            'clinic_sat_am_start_m'     => Input::get('clinic_sat_am_start_m'),
            'clinic_sat_am_end_h'       => Input::get('clinic_sat_am_end_h'),
            'clinic_sat_am_end_m'       => Input::get('clinic_sat_am_end_m'),
            'clinic_sat_pm_start_h'     => Input::get('clinic_sat_pm_start_h'),
            'clinic_sat_pm_start_m'     => Input::get('clinic_sat_pm_start_m'),
            'clinic_sat_pm_end_h'       => Input::get('clinic_sat_pm_end_h'),
            'clinic_sat_pm_end_m'       => Input::get('clinic_sat_pm_end_m'),

            'last_kind'                 => UPDATE,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id,
        );
        $clsClinic->update($id, $dataUpdate);

        // update to table clinic_area
        $areas = Input::get('area');
        if(!$clsClinicArea->exist_area_clinic($areas, $id))
        {
            $dataInsert = array(
                'area_id'           => $areas,
                'clinic_id'         => $id,
                'last_kind'         => UPDATE,
                'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
                'last_user'         => Auth::user()->id
            );
            $clsClinicArea->update_by_clinic($id, $dataInsert);
        }

        return redirect()->route('ortho.clinics.index');
    }

    /**
     * 
     */
    public function getDelete($id)
    {
        $clsClinic              = new ClinicModel();
        $clsClinicArea          = new ClinicAreaModel();

        // update
        $dataUpdate = array(
            'last_kind'                 => DELETE,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id,
        );
        $clsClinic->update($id, $dataUpdate);

        // update to table clinic_area
        $dataInsert = array(
            'clinic_id'         => $id,
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        $clsClinicArea->update_by_clinic($id, $dataInsert);

        return redirect()->route('ortho.clinics.index');
    }
}
