<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use Session;
// use App\User;
use App\Http\Models\Ortho\UserModel;
// use App\Http\Models\Ortho\BelongModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Config;
use LaravelLocalization;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        LaravelLocalization::setLocale('ja');

        $configs = Config::get('constants.DEFINE');
        foreach($configs as $key => $value)
        {
            define($key, $value);
        }
    }


    /**
     * 
     */
    public function getLogin()
    {
        return view('backend.ortho.auth.login');
    }


    /**
     * 
     */
    public function postLogin()
    {
        $inputs = Input::all();

        $Rules = array(
            'u_login'   => 'required',
            'password'  => 'required',
        );
        $Messages = array(
            'u_login.required'   => trans('validation.error_u_login_required'),
            'password.required'  => trans('validation.error_password_required')
        );

        $validator = Validator::make($inputs, $Rules, $Messages);
        if ($validator->fails()) {
            return redirect()->route('ortho.login')->withErrors($validator)->withInput();
        }

        $login = array(
            'u_login'         => Input::get('u_login'),
            'password'        => Input::get('password'),
            'last_kind'       => INSERT,
        );
        $login2 = array(
            'u_login'         => Input::get('u_login'),
            'password'        => Input::get('password'),
            'last_kind'       => UPDATE,
        );
        
        if (Auth::attempt($login, false)) {
            return redirect()->route('ortho.menus.index');
        } elseif(Auth::attempt($login2, false)) {
            return redirect()->route('ortho.menus.index');
        } else {
            Session::flash('error', trans('common.message_login_fail'));
            return redirect()->route('ortho.login')->withErrors($validator)->withInput();
        }
    }


    /**
     * 
     */
    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('ortho.login');
    }


    /**
     * get view change password
     * $id: ID user logining
     */
    public function getChangePassword($id)
    {
        if ( !Auth::check() ) {
            return redirect()->route('ortho.login');
        }

        return view('backend.ortho.auth.change_pass');
    }


    /**
     * update new password
     * $id: ID user logining
     */
    public function postChangePassword($id)
    {
        $clsUser                    = new UserModel();
        $user                       = $clsUser->get_by_id($id);
        $inputs                     = Input::all();

        $Rules = array(
            'password'                          => 'required',
            'new_password'                      => 'required',
            'confim_new_password'               => 'required|same:new_password',
        );
        $Messages = array(
            'password.required'                 => trans('validation.error_password_required'),
            'new_password.required'             => trans('validation.error_new_password_required'),
            'confim_new_password.required'      => trans('validation.error_confim_new_password_required'),
            'confim_new_password.same'          => trans('validation.error_confim_new_password_same'),
        );

        $validator      = Validator::make($inputs, $Rules, $Messages);

        if ($validator->fails()) {
            return redirect()->route('ortho.change.password', [$id])->withErrors($validator)->withInput();
        }

        if ( !Hash::check(Input::get('password'), $user->password) ) {
            Session::flash('password-wrong', trans('common.message_change_password_wrong'));
            return redirect()->route('ortho.change.password', [$id])->withErrors($validator)->withInput();
        }

        $dataUpdate = array(
            'password'          => Hash::make(Input::get('new_password')),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => (Auth::check()) ? Auth::user()->id : 0
        );

        if ( $clsUser->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.change.password', [$id]);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.change.password', [$id])->withErrors($validator)->withInput();
        }
    }
}
