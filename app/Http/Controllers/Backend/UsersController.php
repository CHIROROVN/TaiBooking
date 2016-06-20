<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Models\UserModel;
use Input;
use Session;
use Validator;
use Auth;
use Hash;

class UsersController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * get view list users
	 */
	public function index() {
		$userModel 		= new UserModel();
		$title 			= trans('common.user_title_index');
		$users  		= $userModel->get_all();

		return view('backend.users.index', compact('users', 'title'));
	}


	/**
	 * get view change password
	 */
	public function getChangePasswd(){
		$title 			= trans('common.user_title_change_password');

		return view('backend.users.change_passwd', compact('title'));
	}


	/**
	 * get view regist
	 */
	public function getRegist(){
		$title 			= trans('common.user_title_regist');

		return view('backend.users.regist', compact('title'));
	}


	/**
	 * insert database
	 */
	public function postRegist(){
		$userModel 					= new UserModel();
		$dataInsert 				= array(
			'remember_token'		=> Input::get('_token'),
			'u_name'				=> Input::get('u_name'),
			'u_login'				=> Input::get('u_login'),
			'u_passwd'				=> Hash::make(Input::get('u_passwd')),
			'u_belong'				=> Input::get('u_belong'),
			'u_power'				=> json_encode(Input::get('u_power')),
        	'last_kind'				=> INSERT,
        	'last_date'         	=> date('Y-m-d H:i:s'),
        	'last_ipadrs'       	=> CLIENT_IP_ADRS,
        	'last_user'				=> (Auth::check()) ? Auth::user()->u_id : '',
		);
		$validator  = Validator::make(Input::all(), $userModel->addRules(), $userModel->Messages());
        if ( $validator->fails() ) {
            return redirect()->route('backend.users.regist')->withErrors($validator)->withInput();
        }

        if ( $userModel->insert($dataInsert) ) {
    		Session::flash('success', trans('common.message_regist_success'));
    		return redirect()->route('backend.users.index');
    	} else {
    		Session::flash('danger', trans('common.message_regist_danger'));
			return redirect()->route('backend.users.regist');
    	}
	}


	/**
	 * get view edit
	 * $id: id record
	 */
	public function getUpdate($id){
		$title 						= trans('common.user_title_edit');
		$page 						= Input::get('page');
		$userModel 					= new UserModel();
		$user 						= $userModel->get_by_id($id);

		return view('backend.users.update', compact('user','title', 'page'));
	}


	/**
	 * update database
	 * $id: id record
	 */
	public function postUpdate($id){
		$page 						= Input::get('page');
		$title 						= "ユーザーの新規登録";
		//$id = Auth::user()->u_id;
		$userModel 					= new UserModel();
		$rules 						= $userModel->addRules();
		$passwd 					= Input::get('u_passwd');
		$user 						= $userModel->get_by_id($id);

		$dataUpdate = array();
		$dataUpdate = array(
			// 'remember_token'		=> Input::get('_token'),
			'u_name'				=> Input::get('u_name'),
			'u_login'				=> Input::get('u_login'),
			'u_passwd'				=> Hash::make(Input::get('u_passwd')),
			'u_belong'				=> Input::get('u_belong'),
			'u_power'				=> json_encode(Input::get('u_power')),
        	'last_kind'				=> UPDATE,
        	'last_date'         	=> date('Y-m-d H:i:s'),
        	'last_ipadrs'       	=> CLIENT_IP_ADRS,
        	'last_user'				=> (Auth::check()) ? Auth::user()->u_id : 0,
		);

		// if no update new password
		if ( empty($passwd) ) {
			unset($rules['u_passwd']);
			unset($dataUpdate['u_passwd']);
		}
		// if update your self
		if ( Input::get('u_login') == $user->u_login ) {
			unset($rules['u_login']);
		}

		$validator  = Validator::make(Input::all(), $rules, $userModel->Messages());
        if ($validator->fails()) {
            return redirect()->route('backend.users.update', [$id, 'page' => $page])->withErrors($validator)->withInput();
        }

        if($userModel->update($id, $dataUpdate)){
    		Session::flash('success', trans('common.message_edit_success'));
    		return redirect()->route('backend.users.index', ['page' => $page]);
    	}else{
    		Session::flash('danger', trans('common.message_edit_danger'));
			return redirect()->route('backend.users.update', [$id, 'page' => $page])->with('title', $title);
    	}
	}


	/**
	 * update database
	 * $id: id record
	 */
	public function delete($id){
		$title = "パスワードを変更する";
		$userModel = new UserModel();
		$page = Input::get('page');

		$dataUpdate = array(
        	'u_passwd'				=> Hash::make(Input::get('newpasswd')),
        	'last_kind'				=> DELETE,
        	'last_date'         	=> date('Y-m-d H:i:s'),
        	'last_ipadrs'       	=> CLIENT_IP_ADRS,
        	'last_user'				=> (Auth::check()) ? Auth::user()->u_id : 0,
        	);

    	if($userModel->update($id, $dataUpdate)){
    		// set page current
    		$page = $this->set_page($userModel, $page);

    		Session::flash('success', trans('common.message_delete_success'));
    		return redirect()->route('backend.users.index', ['page' => $page])->with('title', $title);
    	}else{
    		Session::flash('danger', trans('common.message_delete_danger'));
			return redirect()->route('backend.users.index', ['page' => $page])->with('title', $title);
    	}
	}


	/**
	 * update password database
	 */
	public function ChangePasswd(){
		$userModel 					= new UserModel();
		$id 						= Auth::user()->u_id;
		$oldPasswd 					= Auth::user()->password;
		$currPasswd 				= Input::get('currpasswd');		

        if(Hash::check($currPasswd, $oldPasswd)){
        	$validator  = Validator::make(Input::all(), $userModel->Rules(), $userModel->Messages());
	        if ($validator->fails()) {
	            return redirect()->route('backend.users.change_passwd')->withErrors($validator)->withInput();
	        }
	        $dataUpdate = array(
	        	'u_passwd'				=> Hash::make(Input::get('newpasswd')),
	        	'last_kind'				=> UPDATE,
	        	'last_date'         	=> date('Y-m-d H:i:s'),
	        	'last_ipadrs'       	=> CLIENT_IP_ADRS,
	        	'last_user'				=> (Auth::check()) ? Auth::user()->u_id : 0,
	        	);

        	if($userModel->update($id, $dataUpdate)){
        		Session::flash('success', trans('common.user_message_success_login'));
        		return redirect()->route('backend.users.change_passwd');
        	}else{
        		Session::flash('danger', trans('common.user_message_danger_login'));
				return redirect()->route('backend.users.change_passwd');
        	}
		}else{
			Session::flash('danger', trans('common.user_message_danger_change_password'));
			return redirect()->route('backend.users.change_passwd');
		}

	}
}