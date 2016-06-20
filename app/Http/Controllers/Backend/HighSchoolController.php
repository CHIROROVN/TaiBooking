<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;

use Input;
use Session;
use Validator;
use Auth;

class HighSchoolController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$data['title'] 			= '高等学校情報の検索結果一覧';

		return view('backend.highshools.index', $data);
	}

	public function search(){
		$data['title'] 			= '高等学校の検索';

		return view('backend.highshools.search', $data);
	}

	public function getRegist(){
		$data['title'] 			= '高等学校情報の新規登録';

		return view('backend.highshools.regist', $data);
	}


}