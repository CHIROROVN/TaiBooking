<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\BelongModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class UserController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function index()
    {
        //if forget account, let's remove comment after here
        //$this->create_default_accout();

        $clsUser            = new UserModel();
        $clsBelong          = new BelongModel();
        $data['users']      = $clsUser->get_all();
        $data['belongs']    = $clsBelong->get_all();

        return view('backend.ortho.users.index', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        $clsBelong          = new BelongModel();
        $data['belongs']    = $clsBelong->get_all();

        return view('backend.ortho.users.regist', $data);
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsUser        = new UserModel();
        $inputs         = Input::all();
        $validator      = Validator::make($inputs, $clsUser->Rules(), $clsUser->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.users.regist')->withErrors($validator)->withInput();
        }

        // insert
        $dataInsert = array(
            'u_name'            => Input::get('u_name'),
            'u_name_yomi'       => Input::get('u_name_yomi'),
            'u_name_display'    => Input::get('u_name_display'),
            'u_login'           => Input::get('u_login'),
            'password'          => Hash::make(Input::get('password')),
            'u_belong'          => Input::get('u_belong'),
            'u_power1'          => Input::get('u_power1'),
            'u_power2'          => Input::get('u_power2'),
            'u_power3'          => Input::get('u_power3'),
            'u_power4'          => Input::get('u_power4'),
            'u_power5'          => Input::get('u_power5'),
            'u_power6'          => Input::get('u_power6'),
            'u_power7'          => Input::get('u_power7'),
            'u_power8'          => Input::get('u_power8'),
            'u_power9'          => Input::get('u_power9'),
            'u_power10'         => Input::get('u_power10'),
            'u_human_flg'       => Input::get('u_human_flg'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id,
        );
        
        if ( $clsUser->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.users.index');
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsUser            = new UserModel();
        $clsBelong          = new BelongModel();
        $data['user']       = $clsUser->get_by_id($id);
        $data['belongs']    = $clsBelong->get_all();

        return view('backend.ortho.users.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsUser    = new UserModel();
        $user       = $clsUser->get_by_id($id);
        $inputs     = Input::all();
        $rules      = $clsUser->Rules();

        if($user->u_login == Input::get('u_login'))
        {
            unset($rules['u_login']);
        }
        if ( empty(Input::get('password')) ) {
            unset($rules['password']);
        }
        $validator = Validator::make($inputs, $rules, $clsUser->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.users.edit', [$id])->withErrors($validator)->withInput();
        }

        // update
        $dataUpdate = array(
            'u_name'            => Input::get('u_name'),
            'u_name_yomi'       => Input::get('u_name_yomi'),
            'u_name_display'    => Input::get('u_name_display'),
            'u_login'           => Input::get('u_login'),
            'password'          => Hash::make(Input::get('password')),
            'u_belong'          => Input::get('u_belong'),
            'u_power1'          => Input::get('u_power1'),
            'u_power2'          => Input::get('u_power2'),
            'u_power3'          => Input::get('u_power3'),
            'u_power4'          => Input::get('u_power4'),
            'u_power5'          => Input::get('u_power5'),
            'u_power6'          => Input::get('u_power6'),
            'u_power7'          => Input::get('u_power7'),
            'u_power8'          => Input::get('u_power8'),
            'u_power9'          => Input::get('u_power9'),
            'u_power10'         => Input::get('u_power10'),
            'u_human_flg'       => Input::get('u_human_flg'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id,
        );
        if ( empty(Input::get('password')) ) {
            unset($dataUpdate['password']);
        }

        if ( $clsUser->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.users.index');
    }

    /**
     * 
     */
    public function getDelete($id)
    {
        $clsUser = new UserModel();

        // update
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id,
        );
        
        if ( $clsUser->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('ortho.users.index');
    }


    /**
     * when foget accout login to admin
     * let's run this function
     * user: chiroro
     * pass: 123456
     */
    public function create_default_accout()
    {
        $clsUser            = new UserModel();

        $dataInsert = array(
            'u_name'            => 'Chiroro Net Viet',
            'u_name_yomi'       => 'ぁあぃい',
            'u_name_display'    => 'Chiroro Admin',
            'u_login'           => 'chiroro',
            'password'          => Hash::make('123456'),
            'u_belong'          => 1,
            'u_power1'          => 1,
            'u_power2'          => 1,
            'u_power3'          => 1,
            'u_power4'          => 1,
            'u_power5'          => 1,
            'u_power6'          => 1,
            'u_power7'          => 1,
            'u_power8'          => 1,
            'u_power9'          => 1,
            'u_power10'         => 1,
            'u_human_flg'       => '',

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => 1,
        );

        $clsUser->insert($dataInsert);
    }
}
