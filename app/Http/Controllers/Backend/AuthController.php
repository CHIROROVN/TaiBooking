<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use Input;
use Session;
use Validator;
use Auth;
use Config;
use App\Http\Models\UserModel;
use Hash;

class AuthController extends BackendController
{
	public function __construct()
	{
		// parent::__construct();
		$configs = Config::get('constants.DEFINE');
        foreach($configs as $key => $value)
        {
            define($key, $value);
        }
	}

	public function index()
	{

	}

	public function getLogin()
	{
        $title = 'ログイン';
		return view('backend.auth.login', compact('title'));
	}


	public function postLogin()
	{
		$login = array(
            'u_login'        	=> Input::get('u_login'),
            'u_password'        => Input::get('u_password')
        );
        $rules = array(
            'u_login'   	=> 'required',
            'u_password'  	=> 'required',
        );
        $messages = array(
            'u_login.required'   	=> '※ログインIDを入力してください。',
            'u_password.required'  	=> '※パスワードを入力してください。',
        );
        $validator = Validator::make($login, $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('backend.login')->withErrors($validator)->withInput();
        }
        
        $login0 = array(
            'u_login'        	=> Input::get('u_login'),
            'password'        	=> Input::get('u_password'),
            'last_kind'         => INSERT,
        );
        $login1 = array(
            'u_login'        	=> Input::get('u_login'),
            'password'        	=> Input::get('u_password'),
            'last_kind'         => UPDATE,
        );
        if (Auth::attempt($login0, false)) {
            return redirect()->route('backend.menu');
        } elseif (Auth::attempt($login1, false)) {
        	return redirect()->route('backend.menu');
        } else {
            Session::flash('error', 'ログインIDまたはパスワードが間違ってます。');
            return redirect()->route('backend.login')->withErrors($validator)->withInput();
        }
	}


	public function logout()
	{
		Auth::logout();
		return redirect()->route('backend.login');
	}
}