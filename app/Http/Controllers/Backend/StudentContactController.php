<?php namespace App\Http\Controllers\Backend;
use App\Http\Models\ContactModel;
use App\Http\Models\UserModel;
use App\Http\Controllers\BackendController;
use App\Http\Models\StudentModel;
use Input;
use Session;
use Validator;
use Auth;

class StudentContactController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($stu_id=null){
		$data['title'] 			= trans('common.stu_contact_title_index');
		$data['stu_id'] 			= $stu_id;
		$contactModel = new ContactModel();
		$userModel = new UserModel();
		$data['contacts'] = $contactModel->get_all($stu_id);
		$data['users'] = $userModel->get_list();
		return view('backend.students.contact.index', $data);
	}

	public function detail($stu_id=null, $contact_id=null){
		$data['title'] 			= trans('common.stu_contact_title_detail');
		$data['stu_id'] 		= $stu_id;
		$data['contact_id'] 	= $contact_id;
		$contactModel = new ContactModel();
		$userModel = new UserModel();
		$data['contact'] = $contactModel->get_contact_by_id($stu_id);
		$data['users'] = $userModel->get_list();

		return view('backend.students.contact.detail', $data);
	}

	public function getRegist($stu_id=null){
		$data['title'] 			= trans('common.stu_contact_title_regist');
		$data['stu_id'] 			= $stu_id;
		return view('backend.students.contact.regist', $data);
	}

	public function postRegist($stu_id=null){

		echo "<pre>";print_r(Input::all());die;
		$dataInsert = array(
				'stu_id'				=> $stu_id,
			);
	}

	public function deleteCnf($stu_id=null){
		$data['title'] 			= trans('common.stu_contact_title_del_cnf');

		return view('backend.students.contact.delete_cnf', $data);
	}

	public function delete($stu_id=null){
		$data['title'] 			= trans('common.stu_contact_title_del_cnf');

		return view('backend.students.contact.delete', $data);
	}

}