<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\ServiceModel;
use Auth;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class ServiceController extends BackendController
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
        $clsService = new ServiceModel();
        $data['services'] = $clsService->get_all();

        return view('backend.ortho.services.index', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        return view('backend.ortho.services.regist');
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsService = new ServiceModel();
        $inputs         = Input::all();
        $validator      = Validator::make($inputs, $clsService->Rules(), $clsService->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.services.regist')->withErrors($validator)->withInput();
        }

        // insert
        $max = $clsService->get_max();
        $dataInsert = array(
            'service_name'         => Input::get('service_name'),
            'service_sort_no'      => $max + 1,
            'last_kind'            => INSERT,
            'last_ipadrs'          => CLIENT_IP_ADRS,
            'last_date'            => date('y-m-d H:i:s'),
            'last_user'            => Auth::user()->id
        );

        if ( $clsService->insert($dataInsert) ) {
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
        $clsService = new ServiceModel();
        $data['service']           = $clsService->get_by_id($id);
        return view('backend.ortho.services.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsService = new ServiceModel();
        $inputs                 = Input::all();
        $validator              = Validator::make($inputs, $clsService->Rules(), $clsService->Messages());
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
        if ( $clsService->update($id, $dataUpdate) ) {
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
        $clsService = new ServiceModel();
        $dataDelete = array(
            'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id,
            'last_date'         => date('y-m-d H:i:s'),
        );

        if ( $clsService->update($id, $dataDelete) ) {
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
        $clsService = new ServiceModel();
        $id = Input::get('id');
        $this->top($clsService, $id, 'service_sort_no');
        return redirect()->route('ortho.services.index');
    }

    /**
     * 
     */
    public function orderby_last()
    {
        $clsService = new ServiceModel();
        $id = Input::get('id');        
        $this->last($clsService, $id, 'service_sort_no');
        return redirect()->route('ortho.services.index');
    }

    /**
     * 
     */
    public function orderby_up()
    {
        $clsService = new ServiceModel();
        $id = Input::get('id');
        $services = $clsService->get_all();
        
        $this->up($clsService, $id, $services, 'service_id', 'service_sort_no');

        return redirect()->route('ortho.services.index');
    }

    /**
     * 
     */
    public function orderby_down()
    {
        $clsService = new ServiceModel();
        $id = Input::get('id');
        $services = $clsService->get_all();        
        $this->down($clsService, $id, $services, 'service_id', 'service_sort_no');
        return redirect()->route('ortho.services.index');
    }
}
