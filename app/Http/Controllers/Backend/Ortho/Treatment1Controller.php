<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\Treatment1Model;
use Auth;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class Treatment1Controller extends BackendController
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
        $clsTreatment1 = new Treatment1Model();
        $data['treatment1s'] = $clsTreatment1->get_all();

        return view('backend.ortho.treatments.treatment1.index', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        return view('backend.ortho.treatments.treatment1.regist');
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsTreatment1 = new Treatment1Model();
        $inputs         = Input::all();
        $validator      = Validator::make($inputs, $clsTreatment1->Rules(), $clsTreatment1->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.treatments.treatment1.regist')->withErrors($validator)->withInput();
        }

        // insert
        $max = $clsTreatment1->get_max();
        $dataInsert = array(
            'service_name'         => Input::get('service_name'),
            'service_sort_no'      => $max + 1,
            'last_kind'            => INSERT,
            'last_ipadrs'          => CLIENT_IP_ADRS,
            'last_date'            => date('y-m-d H:i:s'),
            'last_user'            => Auth::user()->id
        );

        if ( $clsTreatment1->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('ortho.services.index');
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('backend.services.regist');
        }
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsTreatment1 = new Treatment1Model();
        $data['treatment1']           = $clsTreatment1->get_by_id($id);
        return view('backend.ortho.treatments.treatment1.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsTreatment1 = new Treatment1Model();
        $inputs                 = Input::all();
        $validator              = Validator::make($inputs, $clsTreatment1->Rules(), $clsTreatment1->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.services.edit', $id)->withErrors($validator)->withInput();
        }
        $dataUpdate = array(
            'service_name'          => Input::get('service_name'),
            'last_kind'             => UPDATE,
            'last_ipadrs'           => CLIENT_IP_ADRS,
            'last_user'             => Auth::user()->id,
            'last_date'             => date('y-m-d H:i:s'),
        );
        if ( $clsTreatment1->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.services.index');
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.services.edit', $id);
        }
    }

    /**
     * 
     */
    public function delete($id)
    {
        $clsTreatment1 = new Treatment1Model();
        $dataDelete = array(
            'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id,
            'last_date'         => date('y-m-d H:i:s'),
        );

        if ( $clsTreatment1->update($id, $dataDelete) ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.services.index');
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.services.edit',$id);
        }
    }

    /**
     * 
     */
    public function orderby_top()
    {
        $clsTreatment1 = new Treatment1Model();
        $id = Input::get('id');
        $this->top($clsTreatment1, $id, 'service_sort_no');
        return redirect()->route('ortho.services.index');
    }

    /**
     * 
     */
    public function orderby_last()
    {
        $clsTreatment1 = new Treatment1Model();
        $id = Input::get('id');        
        $this->last($clsTreatment1, $id, 'service_sort_no');
        return redirect()->route('ortho.services.index');
    }

    /**
     * 
     */
    public function orderby_up()
    {
        $clsTreatment1 = new Treatment1Model();
        $id = Input::get('id');
        $services = $clsTreatment1->get_all();
        
        $this->up($clsTreatment1, $id, $services, 'service_id', 'service_sort_no');

        return redirect()->route('ortho.services.index');
    }

    /**
     * 
     */
    public function orderby_down()
    {
        $clsTreatment1 = new Treatment1Model();
        $id = Input::get('id');
        $services = $clsTreatment1->get_all();        
        $this->down($clsTreatment1, $id, $services, 'service_id', 'service_sort_no');
        return redirect()->route('ortho.services.index');
    }
}
