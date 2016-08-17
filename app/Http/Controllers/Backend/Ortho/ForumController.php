<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class ForumController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        //$this->middleware('auth');
    }

    /**
     * get list inspections
     */
    public function index()
    {
        $data             = array();
        return view('backend.ortho.forums.forum_list', $data);
    }

    /**
     * get view regist
     */
    public function getRegist()
    {
        return view('backend.ortho.inspections.regist');
    }

    /**
     * insert database to table
     */
    public function postRegist()
    {
        $clsInspection          = new InspectionModel();
        $inputs                 = Input::all();
        $validator              = Validator::make($inputs, $clsInspection->Rules(), $clsInspection->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.inspections.regist')->withErrors($validator)->withInput();
        }

        // insert
        $max = $clsInspection->get_max();
        $dataInsert = array(
            'inspection_name'           => Input::get('inspection_name'),
            'inspection_sort_no'        => $max + 1,
            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => INSERT,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id
        );

        if ( $clsInspection->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * get view edit
     * $id: ID record
     */
    public function getEdit($id)
    {
        $clsInspection                = new InspectionModel();
        $data['inspection']           = $clsInspection->get_by_id($id);
        return view('backend.ortho.inspections.edit', $data);
    }

    /**
     * update database to table
     * $id: ID record
     */
    public function postEdit($id)
    {
        $clsInspection                  = new InspectionModel();
        $inspection                     = $clsInspection->get_by_id($id);
        $inputs                         = Input::all();
        $validator                      = Validator::make($inputs, $clsInspection->Rules(), $clsInspection->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.inspections.edit', [$inspection->inspection_id])->withErrors($validator)->withInput();
        }

        // update
        $dataUpdate = array(
            'inspection_name'           => Input::get('inspection_name'),
            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id
        );
        
        if ( $clsInspection->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * update database to table
     * $id: ID record
     */
    public function getDelete($id)
    {
        $clsInspection                = new InspectionModel();
        // update table
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        
        if ( $clsInspection->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * 
     */
    public function orderby_top()
    {
        $clsInspection      = new InspectionModel();
        $id                 = Input::get('id');
        $this->top($clsInspection, $id, 'inspection_sort_no');
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * 
     */
    public function orderby_last()
    {
        $clsInspection = new InspectionModel();
        $id = Input::get('id');        
        $this->last($clsInspection, $id, 'inspection_sort_no');
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * 
     */
    public function orderby_up()
    {
        $clsInspection      = new InspectionModel();
        $id                 = Input::get('id');
        $inspections        = $clsInspection->get_all();        
        $this->up($clsInspection, $id, $inspections, 'inspection_id', 'inspection_sort_no');
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * 
     */
    public function orderby_down()
    {
        $clsInspection      = new InspectionModel();
        $id                 = Input::get('id');
        $inspections        = $clsInspection->get_all();        
        $this->down($clsInspection, $id, $inspections, 'inspection_id', 'inspection_sort_no');
        return redirect()->route('ortho.inspections.index');
    }
}
