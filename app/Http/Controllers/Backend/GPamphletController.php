<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Models\GPamphletModel;
use App\Http\Models\PamphletModel;
use Input;
use Session;
use Validator;
use Auth;

class GPamphletController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * show list gpamphlets
	 */
	public function index() {
		// search
		$data['s_gpamph_number'] 			= Input::get('s_gpamph_number');
		$data['s_pamph_name'] 				= Input::get('s_pamph_name');
		$data['s_pamph_id'] 				= Input::get('s_pamph_id');
		if ( empty($data['s_pamph_name']) ) {
			$data['s_pamph_id'] = null;
		}
		
		$clsGPamphlet 					= new GPamphletModel();
		$data['gpamphlets'] 			= $clsGPamphlet->get_all(true, $data)['db'];
		$data['gpamphlets_distinct'] 	= $clsGPamphlet->get_all_distinct();
		$data['title'] 					= trans('common.gpamphlet_title_index');

		$data['count_all']		= $clsGPamphlet->count_distinct();
		$data['total_count'] 	= $clsGPamphlet->get_all(true, Input::all())['total_count'];
		$page_current 			= Input::get('page', 1);
		$data['record_from'] 	= (($page_current - 1) * PAGINATION) + 1;
		$data['record_to'] 		= $data['record_from'] - 1;
		if ( $data['count_all'] == 0 ) {
			$data['record_from'] 	= 0;
		}
		if ( $data['total_count'] == 0 ) {
			$data['record_to'] = 0;
			$data['record_from'] 	= 0;
		}

		return view('backend.gpamphlets.index', $data);
	}


	/**
	 * get view regist
	 */
	public function getRegist() {
		$clsPamphlet 		= new PamphletModel();
		$data['title'] 		= trans('common.gpamphlet_title_regist');

		return view('backend.gpamphlets.regist', $data);
	}


	/**
	 * insert database
	 */
	public function postRegist() {
		$clsGPamphlet         	= new GPamphletModel();
		$dataInsert             = array(
		    'gpamph_number'     => Input::get('gpamph_number'),
		    'pamph_id'      	=> Input::get('pamph_id'),

		    'last_date'         => date('Y-m-d H:i:s'),
		    'last_kind'         => INSERT,
		    'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
		    'last_user'         => (Auth::check()) ? Auth::user()->u_id : 1,
		);

		$validator  = Validator::make($dataInsert, $clsGPamphlet->Rules(), $clsGPamphlet->Messages());
		if ($validator->fails()) {
		    return redirect()->route('backend.gpamphlets.regist')->withErrors($validator)->withInput();
		}

		if ( $clsGPamphlet->insert($dataInsert) ) {
			Session::flash('success', trans('common.message_regist_success'));
		} else {
			Session::flash('danger', trans('common.message_regist_danger'));
		}

		return redirect()->route('backend.gpamphlets.index');
	}


	/**
	 * get view edit
	 * $id: id gpamphlet record
	 */
	public function getEdit($id) {
		// search
		$data['s_gpamph_number'] 				= Input::get('s_gpamph_number');
		$data['s_pamph_name']					= Input::get('s_pamph_name');
		$data['s_pamph_id'] 					= Input::get('s_pamph_id');
		$data['page'] 							= Input::get('page');
		if ( empty($data['s_pamph_name']) ) {
			$data['s_pamph_id'] = null;
		}

		$clsGPamphlet 				= new GPamphletModel();
		$clsPamphlet 				= new PamphletModel();
		$data['gpamphlet'] 			= $clsGPamphlet->get_by_id($id);
		$data['title'] 				= trans('common.gpamphlet_title_edit');

		return view('backend.gpamphlets.edit', $data);
	}


	/**
	 * update database
	 * $id: id gpamphlet record
	 */
	public function postEdit($id) {
		$clsGPamphlet           = new GPamphletModel();
		$dataInsert             = array(
			'gpamph_number'     => Input::get('gpamph_number'),
			'pamph_id'      	=> Input::get('pamph_id'),

			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => UPDATE,
			'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
			'last_user'         => (Auth::check()) ? Auth::user()->u_id : 1,
		);

		$validator  = Validator::make($dataInsert, $clsGPamphlet->Rules(), $clsGPamphlet->Messages());
		if ($validator->fails()) {
		    return redirect()->route('backend.gpamphlets.edit', array($id, 
		    		's_gpamph_number' 		=> Input::get('s_gpamph_number'),
					's_pamph_name' 			=> Input::get('s_pamph_name'),
			        's_pamph_id' 			=> Input::get('s_pamph_id'),
			        'page' 					=> Input::get('page')
		    	))->withErrors($validator)->withInput();
		}

		if ( $clsGPamphlet->update($id, $dataInsert) ) {
			Session::flash('success', trans('common.message_edit_success'));
		} else {
			Session::flash('danger', trans('common.message_edit_danger'));
		}

		return redirect()->route('backend.gpamphlets.index', array(
			's_gpamph_number' 		=> Input::get('s_gpamph_number'),
			's_pamph_name' 			=> Input::get('s_pamph_name'),
			's_pamph_id' 			=> Input::get('s_pamph_id'),
			'page' 					=> Input::get('page')
		));
	}


	/**
	 * update database
	 * $id: id gpamphlet record
	 */
	public function delete($id) {
		$clsGPamphlet         	= new GPamphletModel();
		$dataUpdate 			= array(
			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : 1,
		);

		if ( $clsGPamphlet->update($id, $dataUpdate) ) {
			Session::flash('success', trans('common.message_delete_success'));
		} else {
			Session::flash('danger', trans('common.message_delete_danger'));
		}

		// set page current
		$page = $this->set_page($clsGPamphlet, Input::get('page'));

        return redirect()->route('backend.gpamphlets.index', array(
        		's_gpamph_number' 		=> Input::get('s_gpamph_number'),
        		's_pamph_name' 			=> Input::get('s_pamph_name'),
		        's_pamph_id' 			=> Input::get('s_pamph_id'),
		        'page' 					=> $page
        	));
	}


	/**
	 * search and where
	 * return index()
	 */
	public function search()
	{
		// search
		$data['s_gpamph_number'] 			= Input::get('s_gpamph_number');
		$data['s_pamph_name'] 				= Input::get('s_pamph_name');
		$data['s_pamph_id'] 				= Input::get('s_pamph_id');
		if ( empty($data['s_pamph_name']) ) {
			$data['s_pamph_id'] = null;
		}

		// reset where
		if (Input::get('where') == 'null') {
			// search
			$data['s_gpamph_number'] 		= null;
			$data['s_pamph_name'] 			= null;
			$data['s_pamph_id'] 			= null;

			return redirect()->route('backend.gpamphlets.search');
		}

		$data['title'] 		= trans('common.gpamphlet_title_search');
		return view('backend.gpamphlets.search', $data);
	}


	public function AutoComplete()
	{
		$key 			= Input::get('key', '');
		$clsPamphlet 	= new PamphletModel();
		$pamphlets 		= $clsPamphlet->get_for_autocomplate($key);
		$tmp = array();
		foreach ( $pamphlets as $pamphlet ) {
			$tmp[] = (object)array(
				'value' 	=> $pamphlet->pamph_id,
				'label' 	=> $pamphlet->pamph_number . '_' . $pamphlet->pamph_name,
				'desc' 		=> $pamphlet->pamph_number . '_' . $pamphlet->pamph_name
			);
		}
		echo json_encode($tmp);
	}
}