<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\X3dctModel;
use Auth;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class X3dctController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function getRegist()
    {
        $data['prevYear']           = (int)date("Y")-1;
        $data['currYear']           = (int)date("Y");
        $data['nextYear']           = (int)date("Y")+1;
        return view('backend.ortho.xrays.x3dct.regist', $data);
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsX3dct = new X3dctModel();
        $inputs         = Input::all();
        $validator      = Validator::make($inputs, $clsX3dct->Rules(), $clsX3dct->Messages());

        if ($validator->fails()) {
            return redirect()->route('backend.ortho.xrays.x3dct.regist')->withErrors($validator)->withInput();
        }

        // insert
        $max = $clsX3dct->get_max();
        $dataInsert = array(
            'x3dct_date'         => Input::get('x3dct_date'),
            'last_kind'            => INSERT,
            'last_ipadrs'          => CLIENT_IP_ADRS,
            'last_date'            => date('y-m-d H:i:s'),
            'last_user'            => Auth::user()->id
        );

        if ( $clsX3dct->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('backend.ortho.xrays.x3dct.regist');
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('backend.ortho.xrays.x3dct.regist');
        }
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsX3dct = new X3dctModel();
        $data['service']           = $clsX3dct->get_by_id($id);
        return view('backend.ortho.xrays.x3dct.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsX3dct = new X3dctModel();
        $inputs                 = Input::all();
        $validator              = Validator::make($inputs, $clsX3dct->Rules(), $clsX3dct->Messages());
        if ($validator->fails()) {
            return redirect()->route('backend.ortho.xrays.x3dct.edit', $id)->withErrors($validator)->withInput();
        }
        $dataUpdate = array(
            'service_name'          => Input::get('service_name'),
            'last_kind'             => UPDATE,
            'last_ipadrs'           => CLIENT_IP_ADRS,
            'last_user'             => Auth::user()->id,
            'last_date'             => date('y-m-d H:i:s'),
        );
        if ( $clsX3dct->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('backend.ortho.xrays.x3dct.edit');
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('backend.ortho.xrays.x3dct.edit', $id);
        }
    }

}
