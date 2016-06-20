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

class AuthController extends Controller
{

    private $Rules = array(
            'u_login'   => 'required',
            'password'  => 'required',
        );
    private $Messages = array(
            'u_login.required'   => 'このフィールドに記入してください。',
            'password.required'  => 'このフィールドに記入してください。',
        );


    public function __construct()
    {
        parent::__construct();

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

        $validator = Validator::make($inputs, $this->Rules, $this->Messages);
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
            Session::flash('error', 'User id or password invalid.');
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
