<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\BrotherModel;
use App\Http\Models\Ortho\PatientModel;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;

class BrotherController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * get view list
     */
    public function index($patient_id)
    {
        $data               = array();
        $clsBrother         = new BrotherModel();
        $clsPatient         = new PatientModel();
        $brothers1          = $clsBrother->get_all($patient_id);
        $data['patient']    = $clsPatient->get_by_id($patient_id);

        // set relation brother
        $tmpBrothers    = array();
        foreach ( $brothers1 as $key => $item ) {
            $tmpBrothers[] = $item;
            // switch ( $item->brother_relation ) {
            //     case 1:
            //         if ( $item->p_sex == 1 ) {
            //             $tmpBrothers[$key]->brother_relation = 2;
            //         } else {
            //             $tmpBrothers[$key]->brother_relation = 4;
            //         }
            //         break;
            //     case 2:
            //         if ( $item->p_sex == 1 ) {
            //             $tmpBrothers[$key]->brother_relation = 1;
            //         } else {
            //             $tmpBrothers[$key]->brother_relation = 3;
            //         }
            //         break;
            //     case 3:
            //         if ( $item->p_sex == 1 ) {
            //             $tmpBrothers[$key]->brother_relation = 2;
            //         } else {
            //             $tmpBrothers[$key]->brother_relation = 4;
            //         }
            //         break;
            //     case 4:
            //         if ( $item->p_sex == 1 ) {
            //             $tmpBrothers[$key]->brother_relation = 1;
            //         } else {
            //             $tmpBrothers[$key]->brother_relation = 3;
            //         }
            //         break;
            //     case 5:
            //         $tmpBrothers[$key]->brother_relation = 5;
            //         break;
            //     default:
            //         # code...
            //         break;
            // }
        }
        if ( empty($data['brothers']) || count($data['brothers']) == 0 ) {
            $brothers2      = $clsBrother->get_all_me($patient_id);
            foreach ( $brothers2 as $key => $item ) {
                $tmpBrothers[] = $item;
                switch ( $item->brother_relation ) {
                    case 1:
                        if ( $item->p_sex == 1 ) {
                            $tmpBrothers[$key]->brother_relation = 2;
                        } else {
                            $tmpBrothers[$key]->brother_relation = 4;
                        }
                        break;
                    case 2:
                        if ( $item->p_sex == 1 ) {
                            $tmpBrothers[$key]->brother_relation = 1;
                        } else {
                            $tmpBrothers[$key]->brother_relation = 3;
                        }
                        break;
                    case 3:
                        if ( $item->p_sex == 1 ) {
                            $tmpBrothers[$key]->brother_relation = 2;
                        } else {
                            $tmpBrothers[$key]->brother_relation = 4;
                        }
                        break;
                    case 4:
                        if ( $item->p_sex == 1 ) {
                            $tmpBrothers[$key]->brother_relation = 1;
                        } else {
                            $tmpBrothers[$key]->brother_relation = 3;
                        }
                        break;
                    case 5:
                        $tmpBrothers[$key]->brother_relation = 5;
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
        $data['brothers']   = $tmpBrothers;

        return view('backend.ortho.patients.brothers.index', $data);
    }

    /**
     * get view regist
     */
    public function getRegist($patient_id)
    {
        $data               = array();
        $data['patient_id'] = $patient_id;
        return view('backend.ortho.patients.brothers.regist', $data);
    }

    /**
     * insert database to table
     */
    public function postRegist($patient_id)
    {
        $clsBrother                 = new BrotherModel();
        $dataInsert                 = array(
            'p_id'                  => Input::get('p_id'),
            'p_relation_name'       => Input::get('p_relation_name'),
            'p_relation_id'         => Input::get('p_relation_id'),
            'brother_relation'      => Input::get('brother_relation'),
            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => INSERT,
            'last_ipadrs'           => $_SERVER['REMOTE_ADDR'],
            'last_user'             => Auth::user()->id
        );

        if ( empty($dataInsert['p_relation_name']) ) {
            $dataInsert['p_relation_id'] = null;
        }

        $validator      = Validator::make($dataInsert, $clsBrother->Rules(), $clsBrother->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.patients.brothers.regist', [ $dataInsert['p_id'] ])->withErrors($validator)->withInput();
        }

        // insert
        unset($dataInsert['p_relation_name']);
        if ( $clsBrother->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.patients.brothers.index', [ $dataInsert['p_id'] ]);
    }

    /**
     * get view edit
     * $id: ID record
     */
    public function getEdit($id, $patient_id)
    {
        $clsBrother                 = new BrotherModel();
        $data                       = array();
        $data['brother']            = $clsBrother->get_by_id($id);
        $data['patient_id']         = $patient_id;
        return view('backend.ortho.patients.brothers.edit', $data);
    }

    /**
     * udpate database to table
     * $id: ID record
     */
    public function postEdit($id, $patient_id)
    {
        $clsBrother                 = new BrotherModel();        
        $dataInsert                 = array(
            // 'p_id'                  => Input::get('p_id'),
            'p_relation_name'       => Input::get('p_relation_name'),
            'p_relation_id'         => Input::get('p_relation_id'),
            'brother_relation'      => Input::get('brother_relation'),
            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => UPDATE,
            'last_ipadrs'           => $_SERVER['REMOTE_ADDR'],
            'last_user'             => Auth::user()->id
        );

        if ( empty($dataInsert['p_relation_name']) ) {
            $dataInsert['p_relation_id'] = null;
        }

        $validator      = Validator::make($dataInsert, $clsBrother->Rules(), $clsBrother->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.patients.brothers.edit', [ $id, $patient_id ])->withErrors($validator)->withInput();
        }

        // update
        unset($dataInsert['p_relation_name']);
        if ( $clsBrother->update($id, $dataInsert) ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }

        return redirect()->route('ortho.patients.brothers.index', [ $patient_id ]);
    }

    /**
     * update database to table
     * $id: ID record
     */
    public function getDelete($id, $patient_id)
    {
        $clsBrother             = new BrotherModel();
        // update table
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        if ( $clsBrother->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_delete_success'));
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
        }
        return redirect()->route('ortho.patients.brothers.index', [ $patient_id ]);
    }

    // autocomplete patient
    public function AutoCompletePatient()
    {
        $key            = Input::get('key', '');
        $id_not_me      = Input::get('id_not_me', 0);
        $clsPatient     = new PatientModel();
        $patients       = $clsPatient->get_for_autocomplate($key, $id_not_me);
        $tmp = array();
        foreach ( $patients as $patient ) {
            $tmp[] = (object)array(
                'value'     => $patient->p_id,
                'label'     => $patient->p_no . ' ' . $patient->p_name . '(' . $patient->p_name_kana . ')',
                'desc'      => $patient->p_no . ' ' . $patient->p_name . '(' . $patient->p_name_kana . ')',
            );
        }
        echo json_encode($tmp);
    }
}
