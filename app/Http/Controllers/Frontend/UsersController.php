<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;

use Input;
use Session;
use Validator;
use Auth;

class UsersController extends FrontendController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getLogin() {
		$title = 'Login';
		return view('frontend.users.login', compact('title'));
	}

	public function postLogin() {
		
	}

	public function getLogout() {
		$title = 'Logout';
		return view('frontend.users.logout', compact('title'));
	}

	public function getChangePasswd() {
		return view('frontend.users.change_passwd');
	}

	public function changePasswd() {
		
	}

	public function logout() {
		
	}
}