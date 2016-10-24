<?php namespace App\Http\Controllers\Backend\Ortho;
use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Models\Ortho\PatientModel;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\InterviewModel;
use App\Http\Models\Ortho\ResultModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\Treatment1Model;
use App\Http\Models\Ortho\BookingModel;
use App\Http\Models\Ortho\ClinicServiceModel;
use App\Http\Models\Ortho\BookingTelWaitingModel;
use App\Http\Models\Ortho\RecallModel;
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

        $where['p_no']          = Input::get('p_no');
        $where['p_name_f']      = Input::get('p_name_f');
        $where['p_name_g']      = Input::get('p_name_g');
        $where['p_name_f_kana'] = Input::get('p_name_f_kana');
        $where['p_name_g_kana'] = Input::get('p_name_g_kana');
        $where['p_tel']         = Input::get('p_tel');
        $where['p_mobile']      = Input::get('p_mobile');
        $where['p_hos']         = Input::get('p_hos');
        $where['p_hos_memo']    = Input::get('p_hos_memo');
        // set where
        Session::put('where', $where);

        $clsPatient             = new PatientModel();
        $clsInterview           = new InterviewModel();
        $data['patients']       = $clsPatient->get_all($where);
        $data['keyword']        = $keyword;
        $data['keyword_id']     = $keyword_id;
        $data['p_no']           = Input::get('p_no');
        $data['p_name_f']       = Input::get('p_name_f');
        $data['p_name_g']       = Input::get('p_name_g');
        $data['p_name_f_kana']  = Input::get('p_name_f_kana');
        $data['p_name_g_kana']  = Input::get('p_name_g_kana');
        $data['p_tel']          = Input::get('p_tel');
        $data['p_mobile']       = Input::get('p_mobile');
        $data['p_hos']          = Input::get('p_hos');
        $data['p_hos_memo']     = Input::get('p_hos_memo');
        $data['page']           = Input::get('page');

        $interviews = $clsInterview->get_all();
        $tmpInterviews = array();
        foreach ( $interviews as $interview ) {
            $tmpInterviews[$interview->patient_id] = $interview;
        }
        $data['interviews'] = $tmpInterviews;
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
            // 'p_name'                => Input::get('p_name'),
            // 'p_name_kana'           => Input::get('p_name_kana'),
            'p_name_f'              => Input::get('p_name_f'),
            'p_name_g'              => Input::get('p_name_g'),
            'p_name_f_kana'         => Input::get('p_name_f_kana'),
            'p_name_g_kana'         => Input::get('p_name_g_kana'),
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
        $rules                      = $clsPatient->Rules();
        $cur_p_no                   = Input::get('cur_p_no');
        if($cur_p_no == Input::get('p_no')) unset($rules['p_no']);

        $dataInsert                 = array(
            'p_no'                  => Input::get('p_no'),
            'p_dr'                  => Input::get('p_dr'),
            'p_hos_memo'            => Input::get('p_hos_memo'),
            'p_hos'                 => Input::get('p_hos'),
            // 'p_name'                => Input::get('p_name'),
            // 'p_name_kana'           => Input::get('p_name_kana'),
            'p_name_f'              => Input::get('p_name_f'),
            'p_name_g'              => Input::get('p_name_g'),
            'p_name_f_kana'         => Input::get('p_name_f_kana'),
            'p_name_g_kana'         => Input::get('p_name_g_kana'),
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

        $validator      = Validator::make($dataInsert, $rules, $clsPatient->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.patients.edit', $id)->withErrors($validator)->withInput();
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

        if(Session::has('where')) Session::forget('where');
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
        $clsInterview               = new InterviewModel();
        $data['patient']            = $clsPatient->get_by_id($id);
        $data['prefs']              = Config::get('constants.PREF');
        $interviews                 = $clsInterview->get_all();
        $tmpInterviews              = array();
        foreach ( $interviews as $interview ) {
            $tmpInterviews[$interview->patient_id] = $interview;
        }
        $data['interviews'] = $tmpInterviews;
        
        return view('backend.ortho.patients.detail', $data);
    }


    public function getSearch()
    {
        $data                       = array();
        $data['p_no']               = Input::get('p_no');
        $data['p_name_f']           = Input::get('p_name_f');
        $data['p_name_g']           = Input::get('p_name_g');
        $data['p_name_f_kana']      = Input::get('p_name_f_kana');
        $data['p_name_g_kana']      = Input::get('p_name_g_kana');
        $data['p_tel']              = Input::get('p_tel');
        $data['p_mobile']           = Input::get('p_mobile');
        $data['p_hos']              = Input::get('p_hos');
        $data['p_hos_memo']         = Input::get('p_hos_memo');

        $clsClinic                  = new ClinicModel();
        $data['clinics']            = $clsClinic->get_for_select();

        return view('backend.ortho.patients.search', $data);
    }

    /**
     * Patient Booking List
    */
    public function bookingList($p_id){
        $clsBooking                 = new BookingModel();
        $data['bookings']           = $clsBooking->getBookByPatientID($p_id);
        $clsUser                    = new UserModel();
        $data['doctors']            = $clsUser->get_list_users([1]);
        $data['hygienists']         = $clsUser->get_list_users([2,3]);
        $clsClinicService           = new ClinicServiceModel();
        $data['services']           = $clsClinicService->get_list_service();
        $clsTreatment1              = new Treatment1Model();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();

        return view('backend.ortho.patients.patient_booking_list', $data);
    }

    public function getVisitList($id)
    {
        $clsResult                  = new ResultModel();
        $clsPatient                 = new PatientModel();
        $clsUser                    = new UserModel();
        $clsService                 = new ServiceModel();
        $clsTreatment1              = new Treatment1Model();
        $data                       = array();
        $data['patient']            = $clsPatient->get_by_id($id);
        $data['results']            = $clsResult->get_by_patientID($id);
        $data['services']           = $clsService->get_list();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();

        // set doctor
        $doctors            = $clsUser->get_by_belong([1]);
        $tmpDoctors = array();
        foreach ( $doctors as $doctor ) {
            $tmpDoctors[$doctor->id] = $doctor;
        }
        $data['doctors'] = $tmpDoctors;

        // set hygienist
        $hygienists         = $clsUser->get_by_belong([2,3]);
        $tmpHygienists = array();
        foreach ( $hygienists as $hygienist ) {
            $tmpHygienists[$hygienist->id] = $hygienist;
        }
        $data['hygienists'] = $tmpHygienists;
        return view('backend.ortho.patients.visit_list', $data);
    }

    public function getRegisteredList($id)
    {
        // where
        $data                       = array();

        $keyword                    = Input::get('keyword', null);
        $keyword_id                 = Input::get('keyword_id', null);
        if ( empty($keyword) ) {
            $keyword_id = null;
        }
        $data['keyword']           = $keyword;
        $data['keyword_id']        = $keyword_id;

        $data['p_no']              = Input::get('p_no');
        $data['p_name_f']          = Input::get('p_name_f');
        $data['p_name_g']          = Input::get('p_name_g');
        $data['p_name_f_kana']     = Input::get('p_name_f_kana');
        $data['p_name_g_kana']     = Input::get('p_name_g_kana');
        $data['p_tel']             = Input::get('p_tel');
        $data['p_mobile']          = Input::get('p_mobile');
        $data['p_hos']             = Input::get('p_hos');
        $data['p_hos_memo']        = Input::get('p_hos_memo');
        $data['page']              = Input::get('page');

        $clsPatient                = new PatientModel();
        $clsBookingTelWaiting      = new BookingTelWaitingModel();
        $clsRecall                 = new RecallModel();
        $clsBooking                = new BookingModel();
        $data['patient']           = $clsPatient->get_by_id($id);
        $data['bookingTelWaiting'] = $clsBookingTelWaiting->get_by_patient_id($id);
        $data['recall']            = $clsRecall->get_by_patient_id($id);
        $data['list2list']         = $clsBooking->get_list2_list_by_patient_id($id);
        $data['list4list']         = $clsBooking->get_list4_list_by_patient_id($id);
        $data['list5list']         = $clsBooking->get_list5_list_by_patient_id($id);

        return view('backend.ortho.patients.registered_list', $data);
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

    public static function patientByID($p_id){
        $clsPatient       = new PatientModel();
        $patient          = $clsPatient->get_patient_by_id($p_id);
        return $patient;
    }

    public static function getSexByID(){
        $p_id = Input::get('p_id');
        $clsPatient       = new PatientModel();
        $patient          = $clsPatient->get_p_sex_by_id($p_id);
        return response()->json(array('p_sex'=>$patient));

    }
}
