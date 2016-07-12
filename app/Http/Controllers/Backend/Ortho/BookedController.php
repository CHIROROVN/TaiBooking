<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\BookingModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\Treatment1Model;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\ClinicServiceModel;
use App\Http\Models\Ortho\ResultModel;

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
        // where
        $data                       = array();
        $data['s_clinic_id']        = Input::get('s_clinic_id');
        $data['s_booking_date']     = Input::get('s_booking_date');

        $clsBooking                 = new BookingModel();
        $clsClinic                  = new ClinicModel();
        $clsService                 = new ServiceModel();
        $clsTreatment1              = new Treatment1Model();
        $clsResult                  = new ResultModel();
        $data['bookeds']            = $clsBooking->get_all($data, true);
        $data['clinics']            = $clsClinic->get_for_select();
        $data['services']           = $clsService->get_list();
        $data['results']            = $clsResult->get_list();
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        $data['dates']              = getSomeDayFromDay(date('Y-m-d'), 10);
        $data['currentDay']         = date('Y-m-d');

        return view('backend.ortho.bookeds.history', $data);
    }

    /**
     * 
     */
    public function getRegistHistory()
    {
    //     $clsClinic          = new ClinicModel();
    //     $data['clinics']    = $clsClinic->get_all();

    //     return view('backend.ortho.bookeds.regist', $data);
    }

    /**
     * 
     */
    public function postRegistHistory()
    {
    //     $clsBooking        = new BookingModel();
    //     $clsClinicArea  = new ClinicBookingModel();
    //     $inputs         = Input::all();
    //     $validator      = Validator::make($inputs, $clsBooking->Rules(), $clsBooking->Messages());

    //     if ($validator->fails()) {
    //         return redirect()->route('ortho.bookeds.regist')->withErrors($validator)->withInput();
    //     }

    //     // insert
    //     $max = $clsBooking->get_max();
    //     $dataInsert = array(
    //         'area_name'         => Input::get('area_name'),

    //         'last_date'         => date('y-m-d H:i:s'),
    //         'area_sort_no'      => $max + 1,
    //         'last_kind'         => INSERT,
    //         'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
    //         'last_user'         => Auth::user()->id
    //     );
    //     $id_area = $clsBooking->insert_get_id($dataInsert);

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
    }

    /**
     * 
     */
    public function getEditHistory($id)
    {
        $clsBooking                 = new BookingModel();
        $clsClinic                  = new ClinicModel();
        $clsUser                    = new UserModel();
        $clsTreatment1              = new Treatment1Model();
        $clsClinicService           = new ClinicServiceModel();
        $clsResult                  = new ResultModel();
        $data['booked']             = $clsBooking->get_by_id($id);
        $data['clinics']            = $clsClinic->get_for_select();
        $data['doctors']            = $clsUser->get_by_belong([1]);
        $data['hygienists']         = $clsUser->get_by_belong([2,3]);
        $data['treatment1s']        = $clsTreatment1->get_list_treatment();
        $data['services']           = $clsClinicService->get_service();
        $data['result']             = $clsResult->get_by_id($id);
        $data['dates']              = getSomeDayFromDay(date('Y-m-d'), 10);
        $data['currentDay']         = date('Y-m-d');

        
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';die;

        return view('backend.ortho.bookeds.history_edit', $data);
    }

    /**
     * 
     */
    public function postEditHistory($id)
    {
    //     $clsBooking                = new BookingModel();
    //     $clsClinicArea          = new ClinicBookingModel();
    //     $inputs                 = Input::all();

    //     $validator              = Validator::make($inputs, $clsBooking->Rules(), $clsBooking->Messages());

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
    //     $clsBooking->update($id, $dataUpdate);

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
    }

    /**
     * 
     */
    // public function getDelete($id)
    // {
    //     $clsBooking                = new BookingModel();
    //     $clsClinicArea          = new ClinicBookingModel();

    //     // update table area
    //     $dataUpdate = array(
    //         'last_date'         => date('y-m-d H:i:s'),
    //         'last_kind'         => DELETE,
    //         'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
    //         'last_user'         => Auth::user()->id
    //     );
    //     $clsBooking->update($id, $dataUpdate);

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
