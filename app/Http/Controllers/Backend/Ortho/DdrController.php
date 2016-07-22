<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\DdrModel;
use App\Http\Models\Ortho\ShiftModel;
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
        $color = array(
            '1' => '#000',
            '2' => '#F00',
            '3' => '#00F',
            '4' => '#390',
            '5' => '#F90',
        );
        $tmpDdrs           = array();
        foreach ( $ddrs as $ddr ) {
            $kind = '<span style="color: ' . $color[$ddr->ddr_kind] . ';">■</span>';
            $start_time = splitHourMin($ddr->ddr_start_time);
            $end_time = splitHourMin($ddr->ddr_end_time);
            if ( $start_time == '00:00' ) {
                $start_time = null;
            }
            if ( $end_time == '00:00' ) {
                $end_time = null;
            }
            $tmpDdrs[]      = array(
                'title'     => $kind . ' ' . $start_time . '~' . $end_time . ' ' . $ddr->ddr_contents,
                'start'     => $ddr->ddr_start_date,
                'end'       => $ddr->ddr_start_date + 1,
                'url'       => route('ortho.ddrs.edit', [ $ddr->ddr_id ]),
                'color'     => 'transparent',
                'border'    => 'none',
            );
        }
        $data['ddrs']      = json_encode($tmpDdrs);

        return view('backend.ortho.ddrs.calendar', $data);
    }

    /**
     * 
     */
    public function myCalendar()
    {
        $clsDdr            = new DdrModel();
        $clsShift          = new ShiftModel();
        $ddrs              = $clsDdr->get_all();
        $shifts            = $clsShift->get_all(['u_id' => Auth::user()->id]);
        $color = array(
            '1' => '#000',
            '2' => '#F00',
            '3' => '#00F',
            '4' => '#390',
            '5' => '#F90',
        );
        $tmpDdrs           = array();
        foreach ( $ddrs as $ddr ) {
            $kind = '<span style="color: ' . $color[$ddr->ddr_kind] . ';">■</span>';
            $start_time = splitHourMin($ddr->ddr_start_time);
            $end_time = splitHourMin($ddr->ddr_end_time);
            if ( $start_time == '00:00' ) {
                $start_time = null;
            }
            if ( $end_time == '00:00' ) {
                $end_time = null;
            }
            $tmpDdrs[]      = array(
                'title'     => $kind . ' ' . $start_time . '~' . $end_time . ' ' . $ddr->ddr_contents,
                'start'     => $ddr->ddr_start_date,
                'end'       => $ddr->ddr_start_date + 1,
                'url'       => '',
                'color'     => 'transparent',
                'border'    => 'none',
            );
        }
        $colorClinic = '#99CCFF';
        $textClinic = '';
        foreach ( $shifts as $shift ) {
            if ( $shift->clinic_id == -1 ) {
                $colorClinic = '#FFDFBF';
                $textClinic = '休み';
            } else {
                $colorClinic = '#99CCFF';
                $textClinic = $shift->clinic_name;
            }
            $tmpDdrs[]      = array(
                'title'     => '<img src="' . asset('') . 'public/backend/ortho/common/image/hospital.png" width="13" height="11">' . $textClinic,
                'start'     => $shift->shift_date,
                'end'       => $shift->shift_date + 1,
                'url'       => '',
                'color'     => $colorClinic,
            );
        }
        $data['ddrs']      = json_encode($tmpDdrs);
        return view('backend.ortho.ddrs.mycalendar', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        $ddr_start_date = Input::get('start_date');
        if ( empty($ddr_start_date) ) {
            return redirect()->route('ortho.ddrs.calendar');
        }
        $clsDdr = new DdrModel();
        $data = array();
        $data['ddr_start_date']     = $ddr_start_date;
        $data['start_date']         = $ddr_start_date;
        $data['ddr_start_date_y']   = date('Y', strtotime($ddr_start_date));
        $data['ddr_start_date_m']   = date('m', strtotime($ddr_start_date));
        $data['ddr_start_date_d']   = date('d', strtotime($ddr_start_date));
        // set hour
        $tmpHours = array();
        for ( $i = 1; $i <= 12; $i++ ) {
            $tmpHours[$i] = convert2Digit($i);
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
        $clsDdr                 = new DdrModel();
        $input                  = Input::all();
        $dataInsert             = array(
            'ddr_start_date'    => Input::get('ddr_start_year') . '-' . Input::get('ddr_start_month') . '-' . Input::get('ddr_start_day'),
            'ddr_start_time'    => Input::get('ddr_start_hh') . Input::get('ddr_start_mm'),
            'ddr_end_date'      => Input::get('ddr_end_year') . '-' . Input::get('ddr_end_month') . '-' . Input::get('ddr_end_day'),
            'ddr_end_time'      => Input::get('ddr_end_hh') . Input::get('ddr_end_mm'),
            'ddr_kind'          => Input::get('ddr_kind'),
            'ddr_contents'      => Input::get('ddr_contents'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        if ( empty(Input::get('ddr_start_hh')) && empty(Input::get('ddr_start_mm')) ) {
            $dataInsert['ddr_start_time'] = null;
        }
        if ( empty(Input::get('ddr_end_hh')) && empty(Input::get('ddr_end_mm')) ) {
            $dataInsert['ddr_end_time'] = null;
        }
        if ( empty(Input::get('ddr_end_year')) && empty(Input::get('ddr_end_month')) && empty(Input::get('ddr_end_day')) ) {
            $dataInsert['ddr_end_date'] = null;
        }

        $input['ddr_start_date'] = $dataInsert['ddr_start_date'];
        if ( empty(Input::get('ddr_start_year')) && empty(Input::get('ddr_start_month')) && empty(Input::get('ddr_start_day')) ) {
            $input['ddr_start_date'] = '';
        }

        $validator      = Validator::make($input, $clsDdr->Rules(), $clsDdr->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.ddrs.regist', [ 'start_date' => $input['start_date'] ])->withErrors($validator)->withInput();
        }
        
        if ( $clsDdr->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.ddrs.calendar');
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsDdr                     = new DdrModel();
        $ddr                        = $clsDdr->get_by_id($id);
        $ddr_start_date             = $ddr->ddr_start_date;
        $ddr_end_date               = $ddr->ddr_end_date;

        $data = array();
        $data['ddr']                = $ddr;
        $data['ddr_start_date']     = $ddr_start_date;
        $data['ddr_start_date_y']   = date('Y', strtotime($ddr_start_date));
        $data['ddr_start_date_m']   = date('m', strtotime($ddr_start_date));
        $data['ddr_start_date_d']   = date('d', strtotime($ddr_start_date));
        $data['ddr_start_time_hh']  = substr($ddr->ddr_start_time, 0, 2);
        $data['ddr_start_time_mm']  = substr($ddr->ddr_start_time, 2, 4);
        $data['ddr_end_time_hh']    = substr($ddr->ddr_end_time, 0, 2);
        $data['ddr_end_time_mm']    = substr($ddr->ddr_end_time, 2, 4);
        $data['ddr_end_date_y']     = date('Y', strtotime($ddr_end_date));
        $data['ddr_end_date_m']     = date('m', strtotime($ddr_end_date));
        $data['ddr_end_date_d']     = date('d', strtotime($ddr_end_date));

        // set hour
        $tmpHours = array();
        for ( $i = 1; $i <= 12; $i++ ) {
            $tmpHours[$i] = convert2Digit($i);
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
        return view('backend.ortho.ddrs.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsDdr                 = new DdrModel();
        $input                  = Input::all();
        $dataInsert             = array(
            'ddr_start_date'    => Input::get('ddr_start_year') . '-' . Input::get('ddr_start_month') . '-' . Input::get('ddr_start_day'),
            'ddr_start_time'    => Input::get('ddr_start_hh') . Input::get('ddr_start_mm'),
            'ddr_end_date'      => Input::get('ddr_end_year') . '-' . Input::get('ddr_end_month') . '-' . Input::get('ddr_end_day'),
            'ddr_end_time'      => Input::get('ddr_end_hh') . Input::get('ddr_end_mm'),
            'ddr_kind'          => Input::get('ddr_kind'),
            'ddr_contents'      => Input::get('ddr_contents'),
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        if ( empty(Input::get('ddr_start_hh')) && empty(Input::get('ddr_start_mm')) ) {
            $dataInsert['ddr_start_time'] = null;
        }
        if ( empty(Input::get('ddr_end_hh')) && empty(Input::get('ddr_end_mm')) ) {
            $dataInsert['ddr_end_time'] = null;
        }
        if ( empty(Input::get('ddr_end_year')) && empty(Input::get('ddr_end_month')) && empty(Input::get('ddr_end_day')) ) {
            $dataInsert['ddr_end_date'] = null;
        }

        $input['ddr_start_date'] = $dataInsert['ddr_start_date'];
        if ( empty(Input::get('ddr_start_year')) && empty(Input::get('ddr_start_month')) && empty(Input::get('ddr_start_day')) ) {
            $input['ddr_start_date'] = '';
        }

        $validator      = Validator::make($input, $clsDdr->Rules(), $clsDdr->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.ddrs.edit', [ $id ])->withErrors($validator)->withInput();
        }
        if ( $clsDdr->update($id, $dataInsert) ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }
        return redirect()->route('ortho.ddrs.calendar');
    }

    /**
     * 
     */
    public function getDelete($id)
    {
        $clsDdr                 = new DdrModel();
        // update table area
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        if ( $clsDdr->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_delete_success'));
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
        }
        return redirect()->route('ortho.ddrs.calendar');
    }
}
