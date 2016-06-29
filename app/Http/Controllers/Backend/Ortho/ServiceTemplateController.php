<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Models\Ortho\ServiceTemplateModel;
use App\Http\Models\Ortho\FacilityModel;
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
        $clsTreatment1  = new ServiceTemplateModel();
        $data['temp_services']      = $clsTreatment1->get_all($clinic_id, $service_id);
        $data['clinic_id']          = $clinic_id;
        $data['service_id']         = $service_id;

        return view('backend.ortho.treatments.treatment1.index', $data);
    }

    /**
     * 
    */
    public function getRegist($clinic_id, $service_id)
    {
        return view('backend.ortho.treatments.treatment1.regist',$clinic_id, $service_id);
    }

    /**
     * 
     */
    public function postRegist($clinic_id, $service_id)
    {
        $clsTreatment1 = new ServiceTemplateModel();
        $inputs         = Input::all();
        $validator      = Validator::make($inputs, $clsTreatment1->Rules(), $clsTreatment1->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.treatments.treatment1.regist',$clinic_id, $service_id)->withErrors($validator)->withInput();
        }

        // insert
        $max = $clsTreatment1->get_max();
        $dataInsert = array(
            'treatment_name'            => Input::get('treatment_name'),
            'treatment_time'            => Input::get('treatment_time'),
            'treatment_sort_no'         => $max + 1,
            'last_kind'                 => INSERT,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_date'                 => date('y-m-d H:i:s'),
            'last_user'                 => Auth::user()->id
        );

        if ( $clsTreatment1->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('ortho.treatments.treatment1.index',$clinic_id, $service_id);
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('backend.services.regist',$clinic_id, $service_id);
        }
    }

    /**
     * 
     */
    public function getEdit($clinic_id, $service_id, $id)
    {
        $clsServiceTemp                 = new ServiceTemplateModel();
        $clsFacility                    = new FacilityModel();
        $data['facilities']             = $clsFacility->get_list($clinic_id, 2);
        $data['clinic_service']         = $clsServiceTemp->get_by_id($id);
        $data['clinic_id']              = $clinic_id;
        $data['service_id']             = $service_id;
        return view('backend.ortho.clinics.services.template_edit', $data);
    }

    /**
     * 
     */
    public function postEdit($clinic_id, $service_id, $id)
    {
        $clsServiceTemp           = new ServiceTemplateModel();
        $inputs                   = Input::all();
        $validator                = Validator::make($inputs, $clsServiceTemp->Rules(), $clsServiceTemp->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.clinics.services.template_edit', $clinic_id, $service_id, $id)->withErrors($validator)->withInput();
        }
        $dataUpdate = array(
            'service_facility_1'            => Input::get('service_facility_1'),
            'service_time_1'                => Input::get('service_time_1'),
            'service_facility_2'            => Input::get('service_facility_2'),
            'service_time_2'                => Input::get('service_time_2'),
            'service_facility_3'            => Input::get('service_facility_3'),
            'service_time_3'                => Input::get('service_time_3'),
            'service_facility_4'            => Input::get('service_facility_4'),
            'service_time_4'                => Input::get('service_time_4'),
            'service_facility_5'            => Input::get('service_facility_5'),
            'service_time_5'                => Input::get('service_time_5'),
            'last_kind'                     => UPDATE,
            'last_ipadrs'                   => CLIENT_IP_ADRS,
            'last_date'                     => date('y-m-d H:i:s'),
            'last_user'                     => Auth::user()->id
        );
        if ( $clsServiceTemp->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.clinics.services.index',$clinic_id);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.clinics.services.template_edit', $clinic_id, $service_id, $id);
        }
    }

    /**
     * 
     */
    public function delete($clinic_id, $service_id, $id)
    {
        $clsTreatment1 = new ServiceTemplateModel();
        $dataDelete = array(
            'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id,
            'last_date'         => date('y-m-d H:i:s'),
        );

        if ( $clsTreatment1->update($id, $dataDelete) ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.treatments.treatment1.index');
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.treatments.treatment1.edit',$clinic_id, $service_id, $id);
        }
    }

    /**
     * 
     */
    public function orderby_top($clinic_id, $service_id)
    {
        $clsTreatment1 = new ServiceTemplateModel();
        $id = Input::get('id');
        $this->top($clsTreatment1, $id, 'treatment_sort_no');
        return redirect()->route('ortho.treatments.treatment1.index',$clinic_id, $service_id);
    }

    /**
     * 
     */
    public function orderby_last($clinic_id, $service_id)
    {
        $clsTreatment1 = new ServiceTemplateModel();
        $id = Input::get('id');        
        $this->last($clsTreatment1, $id, 'treatment_sort_no');
        return redirect()->route('ortho.treatments.treatment1.index');
    }

    /**
     * 
     */
    public function orderby_up($clinic_id, $service_id)
    {
        $clsTreatment1 = new ServiceTemplateModel();
        $id = Input::get('id');
        $treatment1s = $clsTreatment1->get_all();
        
        $this->up($clsTreatment1, $id, $treatment1s, 'treatment_id', 'treatment_sort_no');

        return redirect()->route('ortho.treatments.treatment1.index',$clinic_id, $service_id);
    }

    /**
     * 
     */
    public function orderby_down($clinic_id, $service_id)
    {
        $clsTreatment1 = new ServiceTemplateModel();
        $id = Input::get('id');
        $treatment1s = $clsTreatment1->get_all();
        $this->down($clsTreatment1, $id, $treatment1s, 'treatment_id', 'treatment_sort_no');
        return redirect()->route('ortho.treatments.treatment1.index',$clinic_id, $service_id);
    }
}
