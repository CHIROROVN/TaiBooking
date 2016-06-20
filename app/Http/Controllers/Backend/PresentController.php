<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Models\PresentModel;
use Input;
use Session;
use Validator;
use Auth;

class PresentController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * get view list presents
	 */
	public function index() {
		$clsPresent 		= new PresentModel();
		$data['presents'] 	= $clsPresent->get_all();
		$data['title'] 		= trans('common.present_title_index');

		return view('backend.presents.index', $data);
	}


	/**
	 * get view regist
	 */
	public function getRegist() {
		$data['title'] 		= trans('common.present_title_regist');
		return view('backend.presents.regist', $data);
	}


	/**
	 * insert database
	 */
	public function postRegist() {
		$clsPresent             = new PresentModel();
		$dataInsert             = array(
			'present_code'      => Input::get('present_code'),
			'present_name'      => Input::get('present_name'),

			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => INSERT,
			'last_ipadrs'       => CLIENT_IP_ADRS,
			'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
		);

		$validator  = Validator::make($dataInsert, $clsPresent->Rules(), $clsPresent->Messages());
		if ($validator->fails()) {
			return redirect()->route('backend.presents.regist')->withErrors($validator)->withInput();
		}

		if ( $clsPresent->insert($dataInsert) ) {
			Session::flash('success', trans('common.message_regist_success'));
		} else {
			Session::flash('danger', trans('common.message_regist_danger'));
		}

		return redirect()->route('backend.presents.index');
	}


	/**
	 * get view edit
	 * $id: id record
	 */
	public function getEdit($id) {
		$clsPresent 		= new PresentModel();
		$data['present'] 	= $clsPresent->get_by_id($id);
		$data['title'] 		= trans('common.present_title_edit');
		$data['page']		= Input::get('page');

		return view('backend.presents.edit', $data);
	}


	/**
	 * update database
	 * $id: id record
	 */
	public function postEdit($id) {
		$clsPresent             = new PresentModel();
		$dataInsert             = array(
			'present_code'      => Input::get('present_code'),
			'present_name'      => Input::get('present_name'),

			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => UPDATE,
			'last_ipadrs'       => CLIENT_IP_ADRS,
			'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
		);

		$validator  = Validator::make($dataInsert, $clsPresent->Rules(), $clsPresent->Messages());
		if ($validator->fails()) {
			return redirect()->route('backend.presents.edit', [$id, 'page' => Input::get('page')])->withErrors($validator)->withInput();
		}

		if ( $clsPresent->update($id, $dataInsert) ) {
			Session::flash('success', trans('common.message_edit_success'));
		} else {
			Session::flash('danger', trans('common.message_edit_danger'));
		}

		return redirect()->route('backend.presents.index', ['page' => Input::get('page')]);
	}


	/**
	 * update database
	 * $id: id record
	 */
	public function delete($id) {
		$clsPresent             = new PresentModel();
		$dataUpdate = array(
			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => DELETE,
			'last_ipadrs'       => CLIENT_IP_ADRS,
			'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
		);
		
		if ( $clsPresent->update($id, $dataUpdate) ) {
			Session::flash('success', trans('common.message_delete_success'));
		} else {
			Session::flash('danger', trans('common.message_delete_danger'));
		}

		// set page current
		$page = $this->set_page($clsPresent, Input::get('page'));

		return redirect()->route('backend.presents.index', ['page' => $page]);
	}
}