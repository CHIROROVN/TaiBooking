<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Models\BunyaModel;
use Input;
use Session;
use Validator;
use Auth;

class BunyaController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * get list bunyas
	 */
	public function index() {
		// search
		$data['s_bunya_code'] 			= Input::get('s_bunya_code');
		$data['s_bunya_name'] 			= Input::get('s_bunya_name');
		$data['s_bunya_kind_pro'] 		= Input::get('s_bunya_kind_pro', null);
		$data['s_bunya_kind_stu'] 		= Input::get('s_bunya_kind_stu', null);
		$data['s_bunya_class_main'] 	= Input::get('s_bunya_class_main');
		$data['s_bunya_class_sub'] 		= Input::get('s_bunya_class_sub');

		$clsBunya 		= new BunyaModel();
		$data['bunyas'] = $clsBunya->get_all(true, Input::all())['db'];
		$data['title']  = trans('common.bunya_title_index');

		$data['count_all']		= $clsBunya->count();
		$data['total_count'] 	= $clsBunya->get_all(true, Input::all())['total_count'];
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

		return view('backend.bunyas.index', $data);
	}


	/**
	 * get view regist
	 */
	public function getRegist() {
		$data['title']  = trans('common.bunya_title_regist');
		return view('backend.bunyas.regist', $data);
	}


	/**
	 * insert database
	 */
	public function postRegist() {
		$clsBunya             	= new BunyaModel();
        $dataInsert             = array(
            'bunya_code'      	=> Input::get('bunya_code'),
            'bunya_name'      	=> Input::get('bunya_name'),
            'bunya_kind'      	=> Input::get('bunya_kind'),
            'bunya_class'      	=> Input::get('bunya_class'),

            'last_date'         => date('Y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
        );

        $validator  = Validator::make($dataInsert, $clsBunya->Rules(), $clsBunya->Messages());
        if ($validator->fails()) {
            return redirect()->route('backend.bunyas.regist')->withErrors($validator)->withInput();
        }

        if ( $clsBunya->insert($dataInsert) ) {
        	Session::flash('success', trans('common.message_regist_success'));
        } else {
        	Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('backend.bunyas.index');
	}


	/**
	 * get view edit
	 * $id: id record
	 */
	public function getEdit($id) {
		// search
		$data['s_bunya_code'] 			= Input::get('s_bunya_code');
		$data['s_bunya_name'] 			= Input::get('s_bunya_name');
		$data['s_bunya_kind_pro'] 		= Input::get('s_bunya_kind_pro', null);
		$data['s_bunya_kind_stu'] 		= Input::get('s_bunya_kind_stu', null);
		$data['s_bunya_class_main'] 	= Input::get('s_bunya_class_main');
		$data['s_bunya_class_sub'] 		= Input::get('s_bunya_class_sub');
		$data['page'] 					= Input::get('page');

		$clsBunya 		= new BunyaModel();
		$data['bunya'] 	= $clsBunya->get_by_id($id);
		$data['title']  = trans('common.bunya_title_edit');

		return view('backend.bunyas.edit', $data);
	}


	/**
	 * update database
	 * $id: id record
	 */
	public function postEdit($id) {
		$clsBunya             	= new BunyaModel();
		$bunya 					= $clsBunya->get_by_id($id);
        $dataInsert             = array(
            'bunya_code'      	=> Input::get('bunya_code'),
            'bunya_name'      	=> Input::get('bunya_name'),
            'bunya_kind'      	=> Input::get('bunya_kind'),
            'bunya_class'      	=> Input::get('bunya_class'),

            'last_date'         => date('Y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
        );
        $rule = $clsBunya->Rules();
        if ( $bunya->bunya_code == Input::get('bunya_code') ) {
        	unset($rule['bunya_code']);
        }

        $validator  = Validator::make($dataInsert, $rule, $clsBunya->Messages());
        if ($validator->fails()) {
            return redirect()->route('backend.bunyas.edit', [$id, 
            		's_bunya_code' 			=> Input::get('s_bunya_code'),
			        's_bunya_name' 			=> Input::get('s_bunya_name'),
			        's_bunya_kind_pro' 		=> Input::get('s_bunya_kind_pro', null),
			        's_bunya_kind_stu' 		=> Input::get('s_bunya_kind_stu', null),
			        's_bunya_class_main' 	=> Input::get('s_bunya_class_main'),
			        's_bunya_class_sub' 	=> Input::get('s_bunya_class_sub'),
			        'page' 					=> Input::get('page')
            	])->withErrors($validator)->withInput();
        }

		if ( $clsBunya->update($id, $dataInsert) ) {
			Session::flash('success', trans('common.message_edit_success'));
		} else {
			Session::flash('danger', trans('common.message_edit_danger'));
		}

		return redirect()->route('backend.bunyas.index', [
			's_bunya_code' 			=> Input::get('s_bunya_code'),
			's_bunya_name' 			=> Input::get('s_bunya_name'),
			's_bunya_kind_pro' 		=> Input::get('s_bunya_kind_pro', null),
			's_bunya_kind_stu' 		=> Input::get('s_bunya_kind_stu', null),
			's_bunya_class_main' 	=> Input::get('s_bunya_class_main'),
			's_bunya_class_sub' 	=> Input::get('s_bunya_class_sub'),
			'page' 					=> Input::get('page')
		]);
	}


	/**
	 * update database
	 * $id: id record
	 */
	public function delete($id) {
		$clsBunya             	= new BunyaModel();
		$dataUpdate 			= array(
			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => DELETE,
			'last_ipadrs'       => CLIENT_IP_ADRS,
			'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
		);
		
		if ( $clsBunya->update($id, $dataUpdate) ) {
			Session::flash('success', trans('common.message_delete_success'));
		} else {
			Session::flash('danger', trans('common.message_delete_danger'));
		}

		// set page current
		$page = $this->set_page($clsBunya, Input::get('page'));

		return redirect()->route('backend.bunyas.index', [
			's_bunya_code' 			=> Input::get('s_bunya_code'),
			's_bunya_name' 			=> Input::get('s_bunya_name'),
			's_bunya_kind_pro' 		=> Input::get('s_bunya_kind_pro', null),
			's_bunya_kind_stu' 		=> Input::get('s_bunya_kind_stu', null),
			's_bunya_class_main' 	=> Input::get('s_bunya_class_main'),
			's_bunya_class_sub' 	=> Input::get('s_bunya_class_sub'),
			'page' 					=> $page
		]);
	}


	/**
	 * search where
	 * return index() function
	 */
	public function search()
	{
		// search
		$data['s_bunya_code'] 			= Input::get('s_bunya_code');
		$data['s_bunya_name'] 			= Input::get('s_bunya_name');
		$data['s_bunya_kind_pro'] 		= Input::get('s_bunya_kind_pro', null);
		$data['s_bunya_kind_stu'] 		= Input::get('s_bunya_kind_stu', null);
		$data['s_bunya_class_main'] 	= Input::get('s_bunya_class_main');
		$data['s_bunya_class_sub'] 		= Input::get('s_bunya_class_sub');

		// reset where
		if (Input::get('where') == 'null') {
			// search
			$data['s_bunya_code'] 			= null;
			$data['s_bunya_name'] 			= null;
			$data['s_bunya_kind_pro'] 		= null;
			$data['s_bunya_kind_stu'] 		= null;
			$data['s_bunya_class_main'] 	= null;
			$data['s_bunya_class_sub'] 		= null;

			return redirect()->route('backend.bunyas.search');
		}

		$data['title']  = trans('common.bunya_title_search');
		return view('backend.bunyas.search', $data);
	}
}