<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\EquipmentModel;
use Auth;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class EquipmentController extends BackendController
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
        $clsEquipment = new EquipmentModel();
        $data['equipments'] = $clsEquipment->get_all();

        return view('backend.ortho.equipments.index', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        return view('backend.ortho.equipments.regist');
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsEquipment = new EquipmentModel();
        $inputs         = Input::all();
        $validator      = Validator::make($inputs, $clsEquipment->Rules(), $clsEquipment->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.equipments.regist')->withErrors($validator)->withInput();
        }

        // insert
        $max = $clsEquipment->get_max();
        $dataInsert = array(
            'equipment_name'         => Input::get('equipment_name'),
            'equipment_sort_no'      => $max + 1,
            'last_kind'            => INSERT,
            'last_ipadrs'          => CLIENT_IP_ADRS,
            'last_user'            => Auth::user()->id
        );

        if ( $clsEquipment->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('ortho.equipments.index');
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('backend.equipments.regist');
        }
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsEquipment = new EquipmentModel();
        $data['equipment']           = $clsEquipment->get_by_id($id);
        return view('backend.ortho.equipments.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsEquipment = new EquipmentModel();
        $inputs                 = Input::all();
        $validator              = Validator::make($inputs, $clsEquipment->Rules(), $clsEquipment->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.equipments.edit', $id)->withErrors($validator)->withInput();
        }
        $dataUpdate = array(
            'equipment_name'          => Input::get('equipment_name'),
            'last_kind'             => UPDATE,
            'last_ipadrs'           => CLIENT_IP_ADRS,
            'last_user'             => Auth::user()->id
        );
        if ( $clsEquipment->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.equipments.index');
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.equipments.edit', $id);
        }
    }

    /**
     * 
     */
    public function delete($id)
    {
        $clsEquipment = new EquipmentModel();
        $dataDelete = array(
            'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id
        );

        if ( $clsEquipment->update($id, $dataDelete) ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.equipments.index');
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.equipments.edit',$id);
        }
    }

    /**
     * 
     */
    public function orderby_top()
    {
        $clsEquipment = new EquipmentModel();
        $id = Input::get('id');
        $this->top($clsEquipment, $id, 'equipment_sort_no');
        return redirect()->route('ortho.equipments.index');
    }

    /**
     * 
     */
    public function orderby_last()
    {
        $clsEquipment = new EquipmentModel();
        $id = Input::get('id');        
        $this->last($clsEquipment, $id, 'equipment_sort_no');
        return redirect()->route('ortho.equipments.index');
    }

    /**
     * 
     */
    public function orderby_up()
    {
        $clsEquipment = new EquipmentModel();
        $id = Input::get('id');
        $equipments = $clsEquipment->get_all();
        
        $this->up($clsEquipment, $id, $equipments, 'equipment_id', 'equipment_sort_no');

        return redirect()->route('ortho.equipments.index');
    }

    /**
     * 
     */
    public function orderby_down()
    {
        $clsEquipment = new EquipmentModel();
        $id = Input::get('id');
        $equipments = $clsEquipment->get_all();        
        $this->down($clsEquipment, $id, $equipments, 'equipment_id', 'equipment_sort_no');
        return redirect()->route('ortho.equipments.index');
    }
}
