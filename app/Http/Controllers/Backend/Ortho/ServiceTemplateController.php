<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Models\Ortho\ServiceTemplateModel;
use App\Http\Models\Ortho\FacilityModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\ClinicServiceModel;

use Request;
use Auth;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class ServiceTemplateController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function index($clinic_id, $service_id)
    {
        // $clsTreatment1  = new ServiceTemplateModel();
        // $data['temp_services']      = $clsTreatment1->get_all($clinic_id, $service_id);
        $data['clinic_id']          = $clinic_id;
        $data['service_id']         = $service_id;

        return view('backend.ortho.clinics.services.template_list', $data);
    }

    /**
     * 
    */
    // public function getRegist($clinic_id, $service_id)
    // {
    //     $data['clinic_id']              = $clinic_id;
    //     $data['service_id']             = $service_id;
    //     $clsFacility                    = new FacilityModel();
    //     $data['facilities']             = $clsFacility->get_list($clinic_id, 2);
    //     return view('backend.ortho.clinics.services.template_regist',$data);
    // }

    /**
     * 
     */
    // public function postRegist($clinic_id, $service_id)
    // {
    //     $clsServiceTemp = new ServiceTemplateModel();
    //     $rules = $clsServiceTemp->Rules();
       
    //     $sf1_chair  = Input::get('service_facility_1_chair');
    //     if($sf1_chair != '1') unset($rules['service_facility_1']);
       
    //     $sf2_chair  = Input::get('service_facility_2_chair');
    //     if($sf2_chair != '1') unset($rules['service_facility_2']);
       
    //     $sf3_chair  = Input::get('service_facility_3_chair');
    //     if($sf3_chair != '1') unset($rules['service_facility_3']);
       
    //     $sf4_chair  = Input::get('service_facility_4_chair');
    //     if($sf4_chair != '1') unset($rules['service_facility_4']);
        
    //     $sf5_chair  = Input::get('service_facility_5_chair');
    //     if($sf5_chair != '1') unset($rules['service_facility_5']);

    //     $inputs         = Input::all();
    //     $validator      = Validator::make($inputs, $rules, $clsServiceTemp->Messages());
    //     if ($validator->fails()) {
    //         return redirect()->route('ortho.clinics.services.template_regist',[$clinic_id, $service_id])
    //                         ->withErrors($validator)
    //                         ->withInput();
    //     }

    //     // insert
    //     $dataInsert = array(
    //         'clinic_id'                     => $clinic_id,
    //         'service_id'                    => $service_id,
    //         'service_facility_1'            => (Input::get('service_facility_1_chair') == -1) ? '-1' : Input::get('service_facility_1'),
    //         'service_time_1'                => Input::get('service_time_1'),
    //         'service_facility_2'            => (Input::get('service_facility_2_chair') == -1) ? '-1' : Input::get('service_facility_2'),
    //         'service_time_2'                => Input::get('service_time_2'),
    //         'service_facility_3'            => (Input::get('service_facility_3_chair') == -1) ? '-1' : Input::get('service_facility_3'),
    //         'service_time_3'                => Input::get('service_time_3'),
    //         'service_facility_4'            => (Input::get('service_facility_4_chair') == -1) ? '-1' : Input::get('service_facility_4'),
    //         'service_time_4'                => Input::get('service_time_4'),
    //         'service_facility_5'            => (Input::get('service_facility_5_chair') == -1) ? '-1' : Input::get('service_facility_5'),
    //         'service_time_5'                => Input::get('service_time_5'),
    //         'last_kind'                     => INSERT,
    //         'last_ipadrs'                   => CLIENT_IP_ADRS,
    //         'last_date'                     => date('y-m-d H:i:s'),
    //         'last_user'                     => Auth::user()->id
    //     );

    //     if ( $clsServiceTemp->insert($dataInsert) ) {
    //         Session::flash('success', trans('common.message_regist_success'));
    //         return redirect()->route('ortho.clinics.services.index',[$clinic_id]);
    //     } else {
    //         Session::flash('danger', trans('common.message_regist_danger'));
    //         return redirect()->route('ortho.clinics.services.template_regist', [$clinic_id, $service_id]);
    //     }
    // }

    /**
     * 
     */
    public function getEdit($clinic_id, $service_id, $id)
    {
        $clsFacility                    = new FacilityModel();
        $clsClinic                      = new ClinicModel();
        $clsService                     = new ServiceModel();
        $clsClinicService               = new ClinicServiceModel();
        $data['facilities']             = $clsFacility->get_list($clinic_id, 2);
        $data['clinic']                 = $clsClinic->get_by_id($clinic_id);
        $data['service']                = $clsService->get_by_id($service_id);

        if ( $id == 0 ) {
            // insert
            $data['clinic_service']     = 0;

            return view('backend.ortho.clinics.services.template_regist', $data);
        } else {
            // update
            $data['clinic_service']     = $clsClinicService->get_by_id($id);

            return view('backend.ortho.clinics.services.template_edit', $data);
        }
    }

    /**
     * 
     */
    public function postEdit($clinic_id, $service_id, $id)
    {
        $clsServiceTemp           = new ServiceTemplateModel();
        $rules = $clsServiceTemp->Rules();
       
        $sf1_chair  = Input::get('service_facility_1_chair');
        if($sf1_chair != '1') unset($rules['service_facility_1']);
       
        $sf2_chair  = Input::get('service_facility_2_chair');
        if($sf2_chair != '1') unset($rules['service_facility_2']);
       
        $sf3_chair  = Input::get('service_facility_3_chair');
        if($sf3_chair != '1') unset($rules['service_facility_3']);
       
        $sf4_chair  = Input::get('service_facility_4_chair');
        if($sf4_chair != '1') unset($rules['service_facility_4']);
        
        $sf5_chair  = Input::get('service_facility_5_chair');
        if($sf5_chair != '1') unset($rules['service_facility_5']);
        $inputs                   = Input::all();

        $validator                = Validator::make($inputs, $rules, $clsServiceTemp->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.clinics.services.template_edit', [$clinic_id, $service_id, $id])->withErrors($validator)->withInput();
        }

        $dataUpdate = array(
            'clinic_id'                     => $clinic_id,
            'service_id'                    => $service_id,

            'service_facility_1'            => (Input::get('service_facility_1_chair') == -1) ? '-1' : Input::get('service_facility_1'),
            'service_time_1'                => Input::get('service_time_1'),
            'service_facility_2'            => (Input::get('service_facility_2_chair') == -1) ? '-1' : Input::get('service_facility_2'),
            'service_time_2'                => Input::get('service_time_2'),
            'service_facility_3'            => (Input::get('service_facility_3_chair') == -1) ? '-1' : Input::get('service_facility_3'),
            'service_time_3'                => Input::get('service_time_3'),
            'service_facility_4'            => (Input::get('service_facility_4_chair') == -1) ? '-1' : Input::get('service_facility_4'),
            'service_time_4'                => Input::get('service_time_4'),
            'service_facility_5'            => (Input::get('service_facility_5_chair') == -1) ? '-1' : Input::get('service_facility_5'),

            'service_time_5'                => Input::get('service_time_5'),
            'last_kind'                     => UPDATE,
            'last_ipadrs'                   => CLIENT_IP_ADRS,
            'last_date'                     => date('y-m-d H:i:s'),
            'last_user'                     => Auth::user()->id
        );

        if ( $id == 0 ) {
            // insert
            if ( $clsServiceTemp->insert($dataUpdate) ) {
                Session::flash('success', trans('common.message_regist_success'));
                return redirect()->route('ortho.clinics.services.index', $clinic_id);
            } else {
                Session::flash('danger', trans('common.message_regist_danger'));
                return redirect()->route('ortho.clinics.services.index', [$clinic_id]);
            }
        } else {
            // update
            if ( $clsServiceTemp->update($id, $dataUpdate) ) {
                Session::flash('success', trans('common.message_edit_success'));
                return redirect()->route('ortho.clinics.services.index', $clinic_id);
            } else {
                Session::flash('danger', trans('common.message_edit_danger'));
                return redirect()->route('ortho.clinics.services.index', [$clinic_id]);
            }
        }
    }

    /**
     * 
     */
    public function delete($clinic_id, $service_id, $id)
    {
        $clsServiceTemp         = new ServiceTemplateModel();
        $dataDelete             = array(
            'service_id'        => null,

            'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id,
            'last_date'         => date('y-m-d H:i:s'),
        );

        if ( $clsServiceTemp->update($id, $dataDelete) ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.clinics.services.index', $clinic_id);
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.clinics.services.index', [ $clinic_id ]);
        }
    }
}
