<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\DdrModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class DdrController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function calendar()
    {
        $clsDdr            = new DdrModel();

        $ddrs              = $clsDdr->get_all();
        $tmpddrs           = array();
        foreach ( $ddrs as $memo ) {
            $tmpddrs[] = array(
                'title' => $memo->memo_contents,
                'start' => $memo->ddr_start_date,
                'end'   => $memo->ddr_start_date + 1,
                'url'   => route('ortho.ddrs.edit', [ $memo->memo_id ]),
            );
        }
        $data['ddrs']      = json_encode($tmpddrs);

        return view('backend.ortho.ddrs.calendar', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        $ddr_start_date = Input::get('ddr_start_date');
        if ( empty($ddr_start_date) ) {
            return redirect()->route('ortho.ddrs.calendar');
        }

        $clsDdr = new DdrModel();

        $data = array();
        $data['ddr_start_date'] = $ddr_start_date;
        $data['ddr_start_date_y'] = date('Y', strtotime($ddr_start_date));
        $data['ddr_start_date_m'] = date('m', strtotime($ddr_start_date));
        $data['ddr_start_date_d'] = date('d', strtotime($ddr_start_date));

        // set hour
        $tmpHours = array();
        for ( $i = 1; $i <= 12; $i++ ) {
            $tmpHours[$i] = $i;
        }
        $data['hours'] = $tmpHours;

        // set year
        $tmpYears = array();
        $tmpYearNow = date('Y');
        $tmpYears[$tmpYearNow] = $tmpYearNow;
        for ( $i = 1; $i <= 5; $i++ ) {
            $tmp = $tmpYearNow + $i;
            $tmpYears[$tmp] = $tmp;
        }
        $data['years'] = $tmpYears;

        return view('backend.ortho.ddrs.regist', $data);
    }

    /**
     * 
     */
    public function postRegist()
    {
        // $clsDdr                = new DdrModel();

        // $dataInsert             = array(
        //     'ddr_start_date'         => Input::get('ddr_start_date'),
        //     'memo_contents'     => Input::get('memo_contents'),

        //     'last_date'         => date('y-m-d H:i:s'),
        //     'last_kind'         => INSERT,
        //     'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
        //     'last_user'         => Auth::user()->id
        // );

        // $validator      = Validator::make($dataInsert, $clsDdr->Rules(), $clsDdr->Messages());
        // if ($validator->fails()) {
        //     return redirect()->route('ortho.ddrs.regist')->withErrors($validator)->withInput();
        // }
        
        // if ( $clsDdr->insert($dataInsert) ) {
        //     Session::flash('success', trans('common.message_regist_success'));
        // } else {
        //     Session::flash('danger', trans('common.message_regist_danger'));
        // }

        // return redirect()->route('ortho.ddrs.calendar');
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        // $clsDdr                = new DdrModel();
        // $data                   = array();
        // $data['memo']           = $clsDdr->get_by_id($id);

        // return view('backend.ortho.ddrs.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        // $clsDdr                = new DdrModel();

        // $dataInsert             = array(
        //     'memo_contents'     => Input::get('memo_contents'),

        //     'last_date'         => date('y-m-d H:i:s'),
        //     'last_kind'         => UPDATE,
        //     'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
        //     'last_user'         => Auth::user()->id
        // );

        // $validator      = Validator::make($dataInsert, $clsDdr->Rules(), $clsDdr->Messages());
        // if ($validator->fails()) {
        //     return redirect()->route('ortho.ddrs.edit', [ $id ])->withErrors($validator)->withInput();
        // }
        
        // if ( $clsDdr->update($id, $dataInsert) ) {
        //     Session::flash('success', trans('common.message_edit_success'));
        // } else {
        //     Session::flash('danger', trans('common.message_edit_danger'));
        // }

        // return redirect()->route('ortho.ddrs.calendar');
    }

    /**
     * 
     */
    public function getDelete($id)
    {
        // $clsDdr                = new DdrModel();
        // $clsClinicArea          = new ClinicDdrModel();

        // // update table area
        // $dataUpdate = array(
        //     'last_date'         => date('y-m-d H:i:s'),
        //     'last_kind'         => DELETE,
        //     'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
        //     'last_user'         => Auth::user()->id
        // );
        // $clsDdr->update($id, $dataUpdate);

        // // update to table clinic_area
        // $dataUpdate = array(
        //     'last_date'         => date('y-m-d H:i:s'),
        //     'last_kind'         => DELETE,
        //     'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
        //     'last_user'         => Auth::user()->id
        // );
        
        // if ( $clsClinicArea->update_by_area($id, $dataUpdate) ) {
        //     Session::flash('success', trans('common.message_regist_success'));
        // } else {
        //     Session::flash('danger', trans('common.message_regist_danger'));
        // }


        // return redirect()->route('ortho.ddrs.index');
    }
}
