<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Models\PresentModel;
use Input;
use Session;
use Validator;
use Auth;

class StudentPresentController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}

    /************************************************************************
    * get student present index
    /************************************************************************/
	public function index(){
		$data['title'] 			= '大学情報の検索結果一覧';

		return view('backend.student_present.index', $data);
	}

    /************************************************************************
    * get student present search
    /************************************************************************/
	public function search(){
		$data['title'] 			= '大学の検索';

		return view('backend.student_present.search', $data);
	}

    /************************************************************************
    * get student present regist
    /************************************************************************/
	public function regist(){
		$data['title'] 			= '大学情報の新規登録';

		return view('backend.student_present.regist', $data);
	}

}