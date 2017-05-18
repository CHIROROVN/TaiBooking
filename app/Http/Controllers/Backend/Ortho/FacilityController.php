<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\FacilityModel;
use App\Http\Models\Ortho\ClinicModel;
use Auth;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class FacilityController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function index($clinic_id)
    {
        $clsFacility = new FacilityModel();
        $data['facilities'] = $clsFacility->get_all($clinic_id);
        $data['clinic_id']  = $clinic_id;
        return view('backend.ortho.facilities.index', $data);
    }

    /**
     * 
    */
    public function getRegist($clinic_id)
    {
        $clsClinic          = new ClinicModel();
        $data               = array();
        $data['clinic']     = $clsClinic->get_by_id($clinic_id);
        $data['clinic_id']  = $clinic_id;
        $data['clinicList'] = $clsClinic->get_for_select_only_user();
        return view('backend.ortho.facilities.regist', $data);
    }

    /**
     * 
     */
    public function postRegist($clinic_id)
    {
        $clsFacility = new FacilityModel();
        $inputs         = Input::all();
        $validator      = Validator::make($inputs, $clsFacility->Rules(), $clsFacility->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.facilities.regist',$clinic_id)->withErrors($validator)->withInput();
        }

        $max = $clsFacility->get_max();
        $dataInsert = array(
            'facility_name'             => Input::get('facility_name'),
            'facility_kind'             => Input::get('facility_kind'),
            'facility_free1'            => (empty(Input::get('clinic_id_specal'))) ? null : Input::get('clinic_id_specal'),
            'clinic_id'                 => $clinic_id,
            'facility_sort_no'          => $max + 1,

            'last_kind'                 => INSERT,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_date'                 => date('y-m-d H:i:s'),
            'last_user'                 => Auth::user()->id
        );

        if ( $clsFacility->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('ortho.facilities.index',$clinic_id);
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('backend.services.regist',$clinic_id);
        }
    }

    /**
     * 
     */
    public function getEdit($clinic_id, $id)
    {
        $clsFacility        = new FacilityModel();
        $clsClinic          = new ClinicModel();
        $data               = array();
        $data['facility']   = $clsFacility->get_by_id($id);
        $data['clinic_id']  = $clinic_id;
        $data['clinic']     = $clsClinic->get_by_id($clinic_id);
        $data['clinicList'] = $clsClinic->get_for_select_only_user();
        return view('backend.ortho.facilities.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($clinic_id, $id)
    {
        $clsFacility = new FacilityModel();
        $inputs                 = Input::all();
        $validator              = Validator::make($inputs, $clsFacility->Rules(), $clsFacility->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.facilities.edit', $clinic_id, $id)->withErrors($validator)->withInput();
        }
        $dataUpdate = array(
            'facility_name'             => Input::get('facility_name'),
            'facility_kind'             => Input::get('facility_kind'),
            'clinic_id'                 => $clinic_id,
            'facility_free1'            => (empty(Input::get('clinic_id_specal'))) ? null : Input::get('clinic_id_specal'),

            'last_kind'                 => UPDATE,
            'last_ipadrs'               => CLIENT_IP_ADRS,
            'last_date'                 => date('y-m-d H:i:s'),
            'last_user'                 => Auth::user()->id
        );
        if ( $clsFacility->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.facilities.index',$clinic_id);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.facilities.edit', $clinic_id, $id);
        }
    }

    /**
     * 
     */
    public function delete($clinic_id, $id)
    {
        $clsFacility = new FacilityModel();
        $dataDelete = array(
            'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id,
            'last_date'         => date('y-m-d H:i:s'),
        );

        if ( $clsFacility->update($id, $dataDelete) ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.facilities.index',$clinic_id);
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.facilities.edit',$clinic_id, $id);
        }
    }

    /**
     * 
    */
    public function orderby_top($clinic_id)
    {
        $clsFacility = new FacilityModel();
        $id = Input::get('id');
        $this->top($clsFacility, $id, 'facility_sort_no');
        return redirect()->route('ortho.facilities.index',$clinic_id);
    }

    /**
     * 
     */
    public function orderby_last($clinic_id)
    {
        $clsFacility = new FacilityModel();
        $id = Input::get('id');        
        $this->last($clsFacility, $id, 'facility_sort_no');
        return redirect()->route('ortho.facilities.index',$clinic_id);
    }

    /**
     * 
     */
    public function orderby_up($clinic_id)
    {
        $clsFacility = new FacilityModel();
        $id = Input::get('id');
        $facilitys = $clsFacility->get_all($clinic_id);
        
        $this->up($clsFacility, $id, $facilitys, 'facility_id', 'facility_sort_no');

        return redirect()->route('ortho.facilities.index',$clinic_id);
    }

    /**
     * 
     */
    public function orderby_down($clinic_id)
    {
        $clsFacility = new FacilityModel();
        $id = Input::get('id');
        $facilitys = $clsFacility->get_all($clinic_id);
        $this->down($clsFacility, $id, $facilitys, 'facility_id', 'facility_sort_no');
        return redirect()->route('ortho.facilities.index',$clinic_id);
    }
}
