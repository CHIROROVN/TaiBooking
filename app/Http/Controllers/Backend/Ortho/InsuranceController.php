<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\InsuranceModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class InsuranceController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }


    /**
     * get list insurances
     */
    public function index()
    {
        $clsInsurence           = new InsuranceModel();
        $data['insurances']    = $clsInsurence->get_all();

        return view('backend.ortho.insurances.index', $data);
    }

    /**
     * get view regist
     */
    public function getRegist()
    {
        return view('backend.ortho.insurances.regist');
    }

    /**
     * insert database to table
     */
    public function postRegist()
    {
        $clsInsurence          = new InsuranceModel();
        $inputs                 = Input::all();
        $validator              = Validator::make($inputs, $clsInsurence->Rules(), $clsInsurence->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.insurances.regist')->withErrors($validator)->withInput();
        }

        // insert
        $max = $clsInsurence->get_max();
        $dataInsert = array(
            'insurance_name'           => Input::get('insurance_name'),
            'insurance_sort_no'        => $max + 1,

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => INSERT,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id
        );

        if ( $clsInsurence->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.insurances.index');
    }

    /**
     * get view edit
     * $id: ID record
     */
    public function getEdit($id)
    {
        $clsInsurence                = new InsuranceModel();
        $data['insurance']           = $clsInsurence->get_by_id($id);

        return view('backend.ortho.insurances.edit', $data);
    }

    /**
     * update database to table
     * $id: ID record
     */
    public function postEdit($id)
    {
        $clsInsurence                   = new InsuranceModel();
        $insurance                      = $clsInsurence->get_by_id($id);
        $inputs                         = Input::all();

        $validator                      = Validator::make($inputs, $clsInsurence->Rules(), $clsInsurence->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.insurances.edit', [$insurance->insurance_id])->withErrors($validator)->withInput();
        }

        // update
        $dataUpdate = array(
            'insurance_name'           => Input::get('insurance_name'),

            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id
        );
        
        if ( $clsInsurence->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.insurances.index');
    }

    /**
     * update database to table
     * $id: ID record
     */
    public function getDelete($id)
    {
        $clsInsurence                = new InsuranceModel();

        // update table
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        
        if ( $clsInsurence->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.insurances.index');
    }

    /**
     * 
     */
    public function orderby_top()
    {
        $clsInsurence      = new InsuranceModel();
        $id                 = Input::get('id');

        $this->top($clsInsurence, $id, 'insurance_sort_no');

        return redirect()->route('ortho.insurances.index');
    }

    /**
     * 
     */
    public function orderby_last()
    {
        $clsInsurence = new InsuranceModel();
        $id = Input::get('id');
        
        $this->last($clsInsurence, $id, 'insurance_sort_no');

        return redirect()->route('ortho.insurances.index');
    }

    /**
     * 
     */
    public function orderby_up()
    {
        $clsInsurence      = new InsuranceModel();
        $id                 = Input::get('id');
        $insurances        = $clsInsurence->get_all();
        
        $this->up($clsInsurence, $id, $insurances, 'insurance_id', 'insurance_sort_no');

        return redirect()->route('ortho.insurances.index');
    }

    /**
     * 
     */
    public function orderby_down()
    {
        $clsInsurence      = new InsuranceModel();
        $id                 = Input::get('id');
        $insurances        = $clsInsurence->get_all();
        
        $this->down($clsInsurence, $id, $insurances, 'insurance_id', 'insurance_sort_no');

        return redirect()->route('ortho.insurances.index');
    }
}
