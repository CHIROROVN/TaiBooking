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
        $data                   = array();
        $yearNow                = date('Y');
        $monthNow               = date('m');
        $days                   = getDay($monthNow, $yearNow);
        if ( Input::get('next') ) {
            $input = explode('-', Input::get('next'));
            $yearNow                = $input[0];
            $monthNow               = $input[1];
            $days                   = getDay($monthNow, $yearNow);
            $data['next']           = Input::get('next');
        } elseif ( Input::get('prev') ) {
            $input = explode('-', Input::get('prev'));
            $yearNow                = $input[0];
            $monthNow               = $input[1];
            $days                   = getDay($monthNow, $yearNow);
            $data['prev']           = Input::get('prev');
        }

        $clsClinic              = new ClinicModel();
        $clsBelong              = new BelongModel();
        $clsUser                = new UserModel();
        $clsShift               = new ShiftModel();
        $data['clinics']        = $clsClinic->get_for_select();
        $data['yearNow']        = $yearNow;
        $data['monthNow']       = convert2Digit($monthNow);
        $data['users']          = $clsUser->get_human();
        $shifts                 = $clsShift->get_all();
        $data['belong_kinds']   = $clsBelong->get_for_select();

        // set day
        $tmpDate = array();
        foreach ($days as $day) {
            $tmpDate[$day] = $monthNow . '/' . $day . '(' . DayJp($yearNow . '-' . $monthNow . '-' . $day) . ')';
        }
        $data['days']           = $tmpDate;
        // set belong user
        $where = array(
            's_belong_kind' => Input::get('s_belong_kind', 1)
        );
        $data['s_belong_kind'] = $where['s_belong_kind'];
        $tmpBelong = $clsBelong->get_for_select($where);
        $tmpUsers = array();
        foreach ( $tmpBelong as $belong ) {
            foreach ( $data['users'] as $user ) {
                if ( $user->u_belong == $belong->belong_id ) {
                    $belong->belong_users[] = $user;
                    $tmpUsers[] = $user;
                }
            }
        }
        $data['belongUsers'] = $tmpBelong;
        $data['users'] = $tmpUsers;
        $tmpShift               = array();
        foreach ( $shifts as $shift ) {
            $tmpShift[$shift->u_id . '|' . $shift->shift_date . '|' . $shift->clinic_id] = $shift;
        }
        $data['shifts'] = $tmpShift;

        // Optimal show list user
        $strUser = '';
        foreach ( $data['belongUsers'] as $belongUser ) {
            if ( isset($belongUser->belong_users) ) {
                foreach( $belongUser->belong_users as $u ) {
                    $strUser .= '<td>' . $u->u_name . '</td>';
                }
            }
        }
        $data['strUser'] = $strUser;
        
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
        $update = true;
        $update1 = true;
        $update2 = true;
        foreach ( $inputs as $key => $value ) {
            if ( !empty($value) ) {
                $tmpCount++;
                $tmp                        = explode('|', $value);
                $dataInput['u_id']          = $tmp[0];
                $dataInput['shift_date']    = $tmp[1];
                $dataInput['clinic_id']     = $tmp[2];

                if ( $dataInput['clinic_id'] == 0 ) {
                    // delete
                    $dataInput['last_kind'] = DELETE;
                    $clsShift->update_by_uid_shiftdate($dataInput['u_id'], $dataInput['shift_date'], $dataInput);
                    // unset($dataInput['clinic_id']);
                } elseif ( $dataInput['clinic_id'] != 0 ) {
                    // (1) udpate
                    // (2) if not already is insert
                    $status = $clsShift->check_exist_by_uid_shiftdate($dataInput['u_id'], $dataInput['shift_date']);
                    if ( $status ) {
                        // (1)
                        $dataInput['last_kind'] = UPDATE;
                        $update1 = $clsShift->update_by_uid_shiftdate($dataInput['u_id'], $dataInput['shift_date'], $dataInput);
                    } else {
                        // (2)
                        $dataInput['last_kind'] = INSERT;
                        $update2 = $clsShift->insert($dataInput);
                    }
                }
            }
        }

        $link                       = array();
        $link['s_belong_kind']      = Input::get('s_belong_kind');
        $link['date']               = Input::get('date');
        $link['next']               = (Input::get('next')) ? Input::get('next') : null;
        $link['prev']               = (Input::get('prev')) ? Input::get('prev') : null;
        
        if ( $update ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.shifts.list_edit', $link);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.shifts.list_edit', $link);
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
     public function search(){
        return view('backend.ortho.shifts.search');
     }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsShift                   = new ShiftModel();
        $data['shift']              = $clsShift->get_by_id($id);
        return view('backend.ortho.shifts.edit', $data);
    }


    public function getUpdateFree()
    {
        $clsShift = new ShiftModel();

        $dataUpdate = array(
            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => UPDATE,
            'last_ipadrs'           => $_SERVER['REMOTE_ADDR'],
            'last_user'             => Auth::user()->id
        );

        if ( !empty(Input::get('u_id_old')) ) {
            $where = array(
                'u_id'                  => Input::get('u_id_old'),
                'shift_date'            => Input::get('shift_date'),
                'clinic_id'             => Input::get('clinic_id')
            );
        } else {
            $where = array(
                'u_id'                  => Input::get('u_id'),
                'shift_date'            => Input::get('shift_date'),
                'clinic_id'             => Input::get('clinic_id')
            );
        }
        $shift = $clsShift->checkExist($where);

        $status = '';
        if ( !empty($shift) ) {
            // add
            if ( Input::get('u_id') != -1 ) {
                if ( empty($shift->shift_free1) ) {
                    $dataUpdate['shift_free1'] = Input::get('facility_id');
                } else {
                    if ( empty($shift->shift_free2) ) {
                        $dataUpdate['shift_free2'] = Input::get('facility_id');
                    } else {
                        if ( empty($shift->shift_free3) ) {
                            $dataUpdate['shift_free3'] = Input::get('facility_id');
                        } else {
                            if ( empty($shift->shift_free4) ) {
                                $dataUpdate['shift_free4'] = Input::get('facility_id');
                            } else {
                                if ( empty($shift->shift_free5) ) {
                                    $dataUpdate['shift_free5'] = Input::get('facility_id');
                                }
                            }
                            
                        }
                        
                    }   
                }
                $status = $clsShift->update($shift->shift_id, $dataUpdate);

                // update
                // if ( !empty($shift->shift_free1) && !empty($shift->shift_free2) && !empty($shift->shift_free3) && !empty($shift->shift_free4) && !empty($shift->shift_free5) ) {
                //     if ( $shift->shift_free1 == Input::get('facility_id') ) {
                //         $dataUpdate['shift_free1'] = Input::get('facility_id');
                //     } else {
                //         if ( $shift->shift_free2 == Input::get('facility_id') ) {
                //             $dataUpdate['shift_free2'] = Input::get('facility_id');
                //         } else {
                //             if ( $shift->shift_free3 == Input::get('facility_id') ) {
                //                 $dataUpdate['shift_free3'] = Input::get('facility_id');
                //             } else {
                //                 if ( $shift->shift_free4 == Input::get('facility_id') ) {
                //                     $dataUpdate['shift_free4'] = Input::get('facility_id');
                //                 } else {
                //                     if ( $shift->shift_free5 == Input::get('facility_id') ) {
                //                         $dataUpdate['shift_free5'] = Input::get('facility_id');
                //                     }
                //                 }
                                
                //             }
                            
                //         }
                        
                //     }
                // }
                // $status = $clsShift->update($shift->shift_id, $dataUpdate);
            }

            // delete
            if ( Input::get('u_id') == -1 ) {
                $dataUpdate = array(
                    'last_date'             => date('y-m-d H:i:s'),
                    'last_kind'             => UPDATE,
                    'last_ipadrs'           => $_SERVER['REMOTE_ADDR'],
                    'last_user'             => Auth::user()->id
                );

                if ( $shift->shift_free1 == Input::get('facility_id') ) {
                    $dataUpdate['shift_free1'] = null;
                } else {
                    if ( $shift->shift_free2 == Input::get('facility_id') ) {
                        $dataUpdate['shift_free2'] = null;
                    } else {
                        if ( $shift->shift_free3 == Input::get('facility_id') ) {
                            $dataUpdate['shift_free3'] = null;
                        } else {
                            if ( $shift->shift_free4 == Input::get('facility_id') ) {
                                $dataUpdate['shift_free4'] = null;
                            } else {
                                if ( $shift->shift_free5 == Input::get('facility_id') ) {
                                    $dataUpdate['shift_free5'] = null;
                                }
                            }
                            
                        }
                        
                    }
                }

                $status = $clsShift->update($shift->shift_id, $dataUpdate);
            }
        }

        echo json_encode(array('status', $status));
    }


    // public function getAutoInsert()
    // {
    //     $clsShift = new ShiftModel();
    //     $clsUser = new UserModel();
    //     $users = $clsUser->get_by_belong([1]);
    //     $data = array(
    //         'clinic_id'         => 13,

    //         'last_kind'         => INSERT,
    //         'last_ipadrs'       => CLIENT_IP_ADRS,
    //         'last_user'         => Auth::user()->id,
    //         'last_date'         => date('y-m-d H:i:s'),
    //     );

    //     foreach ( $users as $user ) {
    //         for ( $i = 1; $i <= 31; $i++ ) {
    //             $data['u_id']          = $user->id;
    //             $data['shift_date']    = '2016-08-' . sprintf("%02d", $i);

    //             $clsShift->autoInsert($data);
    //         }
    //     }

    //     echo 'ok';die;
    // }
}
