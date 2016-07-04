<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\X3dctModel;
use App\Http\Models\Ortho\XrayModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\PatientModel;

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
    public function getRegist($patient_id)
    {
        $clsUser                    = new UserModel();
        $clsPatient                 = new PatientModel();
        $data['users']              = $clsUser->get_for_select();
        $data['patient']            = $clsPatient->get_by_id($patient_id);

        $data['prevYear']           = (int)date("Y")-1;
        $data['currYear']           = (int)date("Y");
        $data['nextYear']           = (int)date("Y")+1;

        if ( empty($data['patient']) ) {
            return redirect()->route('ortho.xrays.index', [ $patient_id ]);
        }

        return view('backend.ortho.xrays.x3dct.regist', $data);
    }

    /**
     * 
     */
    public function postRegist($patient_id)
    {
        $clsX3dct                  = new X3dctModel();

        $dataInsert                = array(
            'p_id'                 => $patient_id,
            'ct_date'              => '', //after
            'u_id'                 => Input::get('u_id'),

            'ct_cat_1'             => Input::get('ct_cat_1'),
            'ct_cat_2'             => Input::get('ct_cat_2'),
            'ct_cat_3'             => Input::get('ct_cat_3'),
            'ct_cat_4'             => Input::get('ct_cat_4'),
            'ct_cat_5'             => Input::get('ct_cat_5'),
            'ct_cat_6'             => Input::get('ct_cat_6'),
            'ct_cat_7'             => Input::get('ct_cat_7'),
            
            'ct_mode_1'            => Input::get('ct_mode_1'),
            'ct_mode_2'            => Input::get('ct_mode_2'),
            'ct_mode_3'            => Input::get('ct_mode_3'),

            'ct_condition_1'       => Input::get('ct_condition_1'),
            'ct_condition_2'       => Input::get('ct_condition_2'),
            'ct_condition_3'       => Input::get('ct_condition_3'),
            'ct_condition_4'       => Input::get('ct_condition_4'),
            'ct_condition_5'       => Input::get('ct_condition_5'),

            'ct_memo_1'            => Input::get('ct_memo_1'),
            'ct_memo_2'            => Input::get('ct_memo_2'),
            'ct_memo_3'            => Input::get('ct_memo_3'),
            'ct_memo_4'            => Input::get('ct_memo_4'),
            'ct_memo_5'            => Input::get('ct_memo_5'),
            'ct_memo_6'            => Input::get('ct_memo_6'),
            'ct_memo_7'            => Input::get('ct_memo_7'),
            'ct_memo'              => Input::get('ct_memo'),

            'last_kind'            => INSERT,
            'last_ipadrs'          => CLIENT_IP_ADRS,
            'last_date'            => date('y-m-d H:i:s'),
            'last_user'            => Auth::user()->id
        );
        if ( !empty(Input::get('year')) && !empty(Input::get('month')) && !empty(Input::get('day')) ) {
            $dataInsert['ct_date'] = Input::get('year') . '-' . Input::get('month') . '-' . Input::get('day');
        }

        $validator      = Validator::make($dataInsert, $clsX3dct->Rules(), $clsX3dct->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.xrays.x3dct.regist', [ $patient_id ])->withErrors($validator)->withInput();
        }

        if ( $clsX3dct->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('ortho.xrays.detail', [ $patient_id ]);
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('ortho.xrays.detail', [ $patient_id ]);
        }
    }

    /**
     * 
     */
    public function getEdit($patient_id, $id)
    {
        $clsX3dct                   = new X3dctModel();
        $clsPatient                 = new PatientModel();
        $clsUser                    = new UserModel();
        $data['users']              = $clsUser->get_for_select();
        $data['patient']            = $clsPatient->get_by_id($patient_id);
        $data['ct']                 = $clsX3dct->get_by_id($id);
        $data['ct_year']            = date('Y', strtotime($data['ct']->ct_date));
        $data['ct_month']           = date('m', strtotime($data['ct']->ct_date));
        $data['ct_day']             = date('d', strtotime($data['ct']->ct_date));
        $data['number_day']         = $this->cal_days_in_month(1, $data['ct_month'], $data['ct_year']);

        $data['prevYear']           = (int)date("Y")-1;
        $data['currYear']           = (int)date("Y");
        $data['nextYear']           = (int)date("Y")+1;

        return view('backend.ortho.xrays.x3dct.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($patient_id, $id)
    {
        $clsX3dct                  = new X3dctModel();

        $dataInsert                = array(
            'p_id'                 => $patient_id,
            'ct_date'              => '', //after
            'u_id'                 => Input::get('u_id'),

            'ct_cat_1'             => Input::get('ct_cat_1'),
            'ct_cat_2'             => Input::get('ct_cat_2'),
            'ct_cat_3'             => Input::get('ct_cat_3'),
            'ct_cat_4'             => Input::get('ct_cat_4'),
            'ct_cat_5'             => Input::get('ct_cat_5'),
            'ct_cat_6'             => Input::get('ct_cat_6'),
            'ct_cat_7'             => Input::get('ct_cat_7'),
            
            'ct_mode_1'            => Input::get('ct_mode_1'),
            'ct_mode_2'            => Input::get('ct_mode_2'),
            'ct_mode_3'            => Input::get('ct_mode_3'),

            'ct_condition_1'       => Input::get('ct_condition_1'),
            'ct_condition_2'       => Input::get('ct_condition_2'),
            'ct_condition_3'       => Input::get('ct_condition_3'),
            'ct_condition_4'       => Input::get('ct_condition_4'),
            'ct_condition_5'       => Input::get('ct_condition_5'),

            'ct_memo_1'            => Input::get('ct_memo_1'),
            'ct_memo_2'            => Input::get('ct_memo_2'),
            'ct_memo_3'            => Input::get('ct_memo_3'),
            'ct_memo_4'            => Input::get('ct_memo_4'),
            'ct_memo_5'            => Input::get('ct_memo_5'),
            'ct_memo_6'            => Input::get('ct_memo_6'),
            'ct_memo_7'            => Input::get('ct_memo_7'),
            'ct_memo'              => Input::get('ct_memo'),

            'last_kind'            => UPDATE,
            'last_ipadrs'          => CLIENT_IP_ADRS,
            'last_date'            => date('y-m-d H:i:s'),
            'last_user'            => Auth::user()->id
        );
        if ( !empty(Input::get('year')) && !empty(Input::get('month')) && !empty(Input::get('day')) ) {
            $dataInsert['ct_date'] = Input::get('year') . '-' . Input::get('month') . '-' . Input::get('day');
        }

        $validator      = Validator::make($dataInsert, $clsX3dct->Rules(), $clsX3dct->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.xrays.x3dct.edit', [ $patient_id, $id ])->withErrors($validator)->withInput();
        }

        if ( $clsX3dct->update($id, $dataInsert) ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.xrays.detail', [ $patient_id ]);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.xrays.detail', [ $patient_id ]);
        }
    }


    public function getDelete($patient_id, $id)
    {
        $clsX3dct                  = new X3dctModel();
        $dataInsert                = array(
            'last_kind'            => DELETE,
            'last_ipadrs'          => CLIENT_IP_ADRS,
            'last_date'            => date('y-m-d H:i:s'),
            'last_user'            => Auth::user()->id
        );

        if ( $clsX3dct->update($id, $dataInsert) ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.xrays.detail', [ $patient_id ]);
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.xrays.detail', [ $patient_id ]);
        }
    }


    function cal_days_in_month($calendar, $month, $year) 
    { 
        return date('t', mktime(0, 0, 0, $month, 1, $year)); 
    }
}
