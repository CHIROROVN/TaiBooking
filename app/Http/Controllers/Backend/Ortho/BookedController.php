<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\BookingModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class BookedController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function getHistory()
    {
        $clsBooked = new BookingModel();
        $data['bookeds'] = $clsBooked->get_all();

        return view('backend.ortho.bookeds.history', $data);
    }

    /**
     * 
     */
    // public function getRegist()
    // {
    //     $clsClinic          = new ClinicModel();
    //     $data['clinics']    = $clsClinic->get_all();

    //     return view('backend.ortho.bookeds.regist', $data);
    // }

    /**
     * 
     */
    // public function postRegist()
    // {
    //     $clsBooked        = new BookingModel();
    //     $clsClinicArea  = new ClinicBookingModel();
    //     $inputs         = Input::all();
    //     $validator      = Validator::make($inputs, $clsBooked->Rules(), $clsBooked->Messages());

    //     if ($validator->fails()) {
    //         return redirect()->route('ortho.bookeds.regist')->withErrors($validator)->withInput();
    //     }

    //     // insert
    //     $max = $clsBooked->get_max();
    //     $dataInsert = array(
    //         'area_name'         => Input::get('area_name'),

    //         'last_date'         => date('y-m-d H:i:s'),
    //         'area_sort_no'      => $max + 1,
    //         'last_kind'         => INSERT,
    //         'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
    //         'last_user'         => Auth::user()->id
    //     );
    //     $id_area = $clsBooked->insert_get_id($dataInsert);

    //     // insert to table clinic_area
    //     $clinics = Input::get('clinic');
    //     if(!empty($clinics))
    //     {
    //         $status_insert = false;
    //         foreach($clinics as $clinic)
    //         {
    //             if(!$clsClinicArea->exist_area_clinic($id_area, $clinic)) // && !$clsClinicArea->exist_clinic($clinic)
    //             {
    //                 $dataInsert = array(
    //                     'area_id'           => $id_area,
    //                     'clinic_id'         => $clinic,

    //                     'last_date'         => date('y-m-d H:i:s'),
    //                     'last_kind'         => INSERT,
    //                     'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
    //                     'last_user'         => Auth::user()->id
    //                 );
    //                 if ( $clsClinicArea->insert($dataInsert) ) {
    //                     $status_insert = true;
    //                 } else {
    //                     $status_insert = false;
    //                 }
    //             }
    //         }
    //     }
    //     if ( $status_insert ) {
    //         Session::flash('success', trans('common.message_regist_success'));
    //     } else {
    //         Session::flash('danger', trans('common.message_regist_danger'));
    //     }

    //     return redirect()->route('ortho.bookeds.index');
    // }

    /**
     * 
     */
    // public function getEdit($id)
    // {
    //     $clsBooked                = new BookingModel();
    //     $clsClinic              = new ClinicModel();
    //     $clsClinicArea          = new ClinicBookingModel();
    //     $data['area']           = $clsBooked->get_by_id($id);
    //     $data['clinics']        = $clsClinic->get_all();
    //     $area_clinics           = $clsClinicArea->get_by_area($id);
    //     $tmp                    = array();
    //     foreach($area_clinics as $area_clinic)
    //     {
    //         $tmp[$area_clinic->clinic_id] = $area_clinic->clinic_id;
    //     }
    //     $data['area_clinics']   = $tmp;

    //     return view('backend.ortho.bookeds.edit', $data);
    // }

    /**
     * 
     */
    // public function postEdit($id)
    // {
    //     $clsBooked                = new BookingModel();
    //     $clsClinicArea          = new ClinicBookingModel();
    //     $inputs                 = Input::all();

    //     $validator              = Validator::make($inputs, $clsBooked->Rules(), $clsBooked->Messages());

    //     if ($validator->fails()) {
    //         return redirect()->route('ortho.bookeds.edit', [$id])->withErrors($validator)->withInput();
    //     }

    //     // update table area
    //     $dataUpdate = array(
    //         'area_name'         => Input::get('area_name'),

    //         'last_date'         => date('y-m-d H:i:s'),
    //         'last_kind'         => UPDATE,
    //         'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
    //         'last_user'         => Auth::user()->id
    //     );
    //     $clsBooked->update($id, $dataUpdate);

    //     // before update table clinic_area
    //     $clinics = Input::get('clinic');
    //     if(!empty($clinics))
    //     {
    //         $status_insert = false;
    //         foreach($clinics as $clinic)
    //         {
    //             if($clsClinicArea->exist_clinic($clinic))
    //             {
    //                 // update
    //                 $data = array(
    //                     'area_id'           => $id,
    //                     'clinic_id'         => $clinic,

    //                     'last_date'         => date('y-m-d H:i:s'),
    //                     'last_kind'         => UPDATE,
    //                     'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
    //                     'last_user'         => Auth::user()->id
    //                 );
    //                 if ( $clsClinicArea->update_by_clinic($clinic, $data) ) {
    //                     $status_insert = true;
    //                 } else {
    //                     $status_insert = false;
    //                 }
    //             }
    //             else
    //             {
    //                 // add new
    //                 $dataInsert = array(
    //                     'area_id'           => $id,
    //                     'clinic_id'         => $clinic,

    //                     'last_date'         => date('y-m-d H:i:s'),
    //                     'last_kind'         => INSERT,
    //                     'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
    //                     'last_user'         => Auth::user()->id
    //                 );
    //                 if ( $clsClinicArea->insert($dataInsert) ) {
    //                     $status_insert = true;
    //                 } else {
    //                     $status_insert = false;
    //                 }
    //             }
    //         } 
    //     }
    //     if ( $status_insert ) {
    //         Session::flash('success', trans('common.message_regist_success'));
    //     } else {
    //         Session::flash('danger', trans('common.message_regist_danger'));
    //     }

    //     return redirect()->route('ortho.bookeds.index');
    // }

    /**
     * 
     */
    // public function getDelete($id)
    // {
    //     $clsBooked                = new BookingModel();
    //     $clsClinicArea          = new ClinicBookingModel();

    //     // update table area
    //     $dataUpdate = array(
    //         'last_date'         => date('y-m-d H:i:s'),
    //         'last_kind'         => DELETE,
    //         'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
    //         'last_user'         => Auth::user()->id
    //     );
    //     $clsBooked->update($id, $dataUpdate);

    //     // update to table clinic_area
    //     $dataUpdate = array(
    //         'last_date'         => date('y-m-d H:i:s'),
    //         'last_kind'         => DELETE,
    //         'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
    //         'last_user'         => Auth::user()->id
    //     );
        
    //     if ( $clsClinicArea->update_by_area($id, $dataUpdate) ) {
    //         Session::flash('success', trans('common.message_regist_success'));
    //     } else {
    //         Session::flash('danger', trans('common.message_regist_danger'));
    //     }


    //     return redirect()->route('ortho.bookeds.index');
    // }
}
