<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\ShiftModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\BelongModel;
use App\Http\Models\Ortho\UserModel;

use Auth;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class ShiftController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }


    public function getSListEdit()
    {
        $yearNow                = date('Y');
        $monthNow               = date('m');
        $days                   = getDay($monthNow);
        if ( Input::get('next') ) {
            $input = explode('-', Input::get('next'));
            $yearNow                = $input[0];
            $monthNow               = $input[1];
            $days                   = getDay($monthNow);
        } elseif ( Input::get('prev') ) {
            $input = explode('-', Input::get('prev'));
            $yearNow                = $input[0];
            $monthNow               = $input[1];
            $days                   = getDay($monthNow);
        }

        $clsClinic              = new ClinicModel();
        $clsBelong              = new BelongModel();
        $clsUser                = new UserModel();
        $clsShift               = new ShiftModel();
        $data                   = array();
        $data['clinics']        = $clsClinic->get_for_select();
        $data['yearNow']        = $yearNow;
        $data['monthNow']       = convert2Digit($monthNow);
        $data['users']          = $clsUser->get_for_select(['u_human_flg' => 1]);
        $shifts                 = $clsShift->get_all();

        // set day
        $tmpDate = array();
        foreach ($days as $day) {
            $tmpDate[$day] = $monthNow . '/' . $day . '(' . DayJp($yearNow . '-' . $monthNow . '-' . $day) . ')';
        }
        $data['days']           = $tmpDate;

        // set belong user
        $tmpBelong = $clsBelong->get_for_select();
        foreach ( $tmpBelong as $belong ) {
            foreach ( $data['users'] as $user ) {
                if ( $user->u_belong == $belong->belong_id ) {
                    $belong->belong_users[] = $user;
                }
            }
        }
        $data['belongUsers'] = $tmpBelong;

        // set shift
        // u_id|shift_date|linic_id
        $tmpShift               = array();
        foreach ( $shifts as $shift ) {
            $tmpShift[$shift->u_id . '|' . $shift->shift_date . '|' . $shift->clinic_id] = $shift;
        }
        $data['shifts'] = $tmpShift;

        return view('backend.ortho.shifts.list_edit', $data);
    }


    public function postSListEdit()
    {
        $clsShift       = new ShiftModel();
        $inputs         = Input::get('select');
        $countInputs    = count($inputs);

        $dataInput = array(
            'last_kind'         => INSERT,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id,
            'last_date'         => date('y-m-d H:i:s'),
        );

        $tmpCount = 0;
        $insert = false;
        $update = false;
        foreach ( $inputs as $key => $value ) {
            if ( !empty($value) ) {
                $tmpCount++;
                $tmp                        = explode('|', $value);
                $dataInput['u_id']          = $tmp[0];
                $dataInput['shift_date']    = $tmp[1];
                $dataInput['clinic_id']     = $tmp[2];

                if ( $dataInput['clinic_id'] == 0 ) {
                    // delete
                    unset($dataInput['clinic_id']);
                    $dataInput['last_kind'] = DELETE;
                    $update = $clsShift->update_by_uid_shiftdate($dataInput['u_id'], $dataInput['shift_date'], $dataInput);
                } elseif ( $dataInput['clinic_id'] != '0' ) {
                    // (1) udpate
                    // (2) if not already is insert
                    $status = $clsShift->check_exist_by_uid_shiftdate($dataInput['u_id'], $dataInput['shift_date']);
                    if ( $status ) {
                        // (1)
                        $dataInput['last_kind'] = UPDATE;
                        $update = $clsShift->update_by_uid_shiftdate($dataInput['u_id'], $dataInput['shift_date'], $dataInput);
                    } else {
                        // (2)
                        $dataInput['last_kind'] = INSERT;
                        $update = $clsShift->insert($dataInput);
                    }
                }
            }
        }

        if ( $insert && $update ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.shifts.list_edit');
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.shifts.list_edit');
        }
    }


    /**
     * 
     */
    public function index()
    {
        $clsShift = new ShiftModel();
        $data['shifts'] = $clsShift->get_all();

        return view('backend.ortho.shifts.index', $data);
    }

    /**
     * 
    */
    // public function getRegist()
    // {
    //     return view('backend.ortho.treatments.treatment1.regist');
    // }

    // /**
    //  * 
    //  */
    // public function postRegist()
    // {
    //     $clsShift = new ShiftModel();
    //     $inputs         = Input::all();
    //     $validator      = Validator::make($inputs, $clsShift->Rules(), $clsShift->Messages());

    //     if ($validator->fails()) {
    //         return redirect()->route('ortho.treatments.treatment1.regist')->withErrors($validator)->withInput();
    //     }

    //     // insert
    //     $max = $clsShift->get_max();
    //     $dataInsert = array(
    //         'treatment_name'            => Input::get('treatment_name'),
    //         'treatment_time'            => Input::get('treatment_time'),
    //         'treatment_sort_no'         => $max + 1,
    //         'last_kind'                 => INSERT,
    //         'last_ipadrs'               => CLIENT_IP_ADRS,
    //         'last_date'                 => date('y-m-d H:i:s'),
    //         'last_user'                 => Auth::user()->id
    //     );

    //     if ( $clsShift->insert($dataInsert) ) {
    //         Session::flash('success', trans('common.message_regist_success'));
    //         return redirect()->route('ortho.treatments.treatment1.index');
    //     } else {
    //         Session::flash('danger', trans('common.message_regist_danger'));
    //         return redirect()->route('backend.services.regist');
    //     }
    // }

    
     /**
     * 
     */
     public function search(){
        return view('backend.ortho.shifts.search');
     }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsShift = new ShiftModel();
        $data['shift']           = $clsShift->get_by_id($id);
        return view('backend.ortho.shifts.edit', $data);
    }



    // /**
    //  * 
    //  */
    // public function postEdit($id)
    // {
    //     $clsShift = new ShiftModel();
    //     $inputs                 = Input::all();
    //     $validator              = Validator::make($inputs, $clsShift->Rules(), $clsShift->Messages());
    //     if ($validator->fails()) {
    //         return redirect()->route('ortho.treatments.treatment1.edit', $id)->withErrors($validator)->withInput();
    //     }
    //     $dataUpdate = array(
    //         'treatment_name'            => Input::get('treatment_name'),
    //         'treatment_time'            => Input::get('treatment_time'),
    //         'last_kind'                 => UPDATE,
    //         'last_ipadrs'               => CLIENT_IP_ADRS,
    //         'last_date'                 => date('y-m-d H:i:s'),
    //         'last_user'                 => Auth::user()->id
    //     );
    //     if ( $clsShift->update($id, $dataUpdate) ) {
    //         Session::flash('success', trans('common.message_edit_success'));
    //         return redirect()->route('ortho.treatments.treatment1.index');
    //     } else {
    //         Session::flash('danger', trans('common.message_edit_danger'));
    //         return redirect()->route('ortho.treatments.treatment1.edit', $id);
    //     }
    // }

    // /**
    //  * 
    //  */
    // public function delete($id)
    // {
    //     $clsShift = new ShiftModel();
    //     $dataDelete = array(
    //         'last_kind'         => DELETE,
    //         'last_ipadrs'       => CLIENT_IP_ADRS,
    //         'last_user'         => Auth::user()->id,
    //         'last_date'         => date('y-m-d H:i:s'),
    //     );

    //     if ( $clsShift->update($id, $dataDelete) ) {
    //         Session::flash('success', trans('common.message_delete_success'));
    //         return redirect()->route('ortho.treatments.treatment1.index');
    //     } else {
    //         Session::flash('danger', trans('common.message_delete_danger'));
    //         return redirect()->route('ortho.treatments.treatment1.edit',$id);
    //     }
    // }

    // /**
    //  * 
    //  */
    // public function orderby_top()
    // {
    //     $clsShift = new ShiftModel();
    //     $id = Input::get('id');
    //     $this->top($clsShift, $id, 'treatment_sort_no');
    //     return redirect()->route('ortho.treatments.treatment1.index');
    // }

    // /**
    //  * 
    //  */
    // public function orderby_last()
    // {
    //     $clsShift = new ShiftModel();
    //     $id = Input::get('id');        
    //     $this->last($clsShift, $id, 'treatment_sort_no');
    //     return redirect()->route('ortho.treatments.treatment1.index');
    // }

    // /**
    //  * 
    //  */
    // public function orderby_up()
    // {
    //     $clsShift = new ShiftModel();
    //     $id = Input::get('id');
    //     $treatment1s = $clsShift->get_all();
        
    //     $this->up($clsShift, $id, $treatment1s, 'treatment_id', 'treatment_sort_no');

    //     return redirect()->route('ortho.treatments.treatment1.index');
    // }

    // /**
    //  * 
    //  */
    // public function orderby_down()
    // {
    //     $clsShift = new ShiftModel();
    //     $id = Input::get('id');
    //     $treatment1s = $clsShift->get_all();
    //     $this->down($clsShift, $id, $treatment1s, 'treatment_id', 'treatment_sort_no');
    //     return redirect()->route('ortho.treatments.treatment1.index');
    // }


    // public function getDate()
    // {
        
    // }
}
