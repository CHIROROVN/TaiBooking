<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use Session;
// use App\User;
// use App\Http\Models\Ortho\UserModel;
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
}
