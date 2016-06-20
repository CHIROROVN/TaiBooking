<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Models\BaitaiModel;
use Input;
use Session;
use Validator;
use Auth;

class BaitaiController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * show list baitais
	 */
	public function index() {
		// search
		$data['s_baitai_code'] 			= Input::get('s_baitai_code');
		$data['s_baitai_name'] 			= Input::get('s_baitai_name');
		$data['s_baitai_kind_old'] 		= Input::get('s_baitai_kind_old', null);
		$data['s_baitai_kind_new'] 		= Input::get('s_baitai_kind_new', null);
		$data['s_baitai_year_begin'] 	= Input::get('s_baitai_year_begin');
		$data['s_baitai_year_end'] 		= Input::get('s_baitai_year_end');
		
		$clsBaitai 				= new BaitaiModel();
		$data['baitais'] 		= $clsBaitai->get_all(true, Input::all())['db'];
		$data['title'] 			= trans('common.baitai_title_index');

		$data['count_all']		= $clsBaitai->count();
		$data['total_count'] 	= $clsBaitai->get_all(true, Input::all())['total_count'];
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

		return view('backend.baitais.index', $data);
	}


	/**
	 * get view regist
	 */
	public function getRegist() {
		$data['title'] 		= trans('common.baitai_title_regist');
		return view('backend.baitais.regist', $data);
	}


	/**
	 * insert database
	 */
	public function postRegist() {
		$clsBaitai             	= new BaitaiModel();
        $dataInsert             = array(
            'baitai_code'      	=> Input::get('baitai_code'),
            'baitai_name'      	=> Input::get('baitai_name'),
            'baitai_kind'      	=> Input::get('baitai_kind'),
            'baitai_year'      	=> Input::get('baitai_year'),

            'last_date'         => date('Y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
        );

        $validator  = Validator::make($dataInsert, $clsBaitai->Rules(), $clsBaitai->Messages());
        if ($validator->fails()) {
            return redirect()->route('backend.baitais.regist')->withErrors($validator)->withInput();
        }

        if ( $clsBaitai->insert($dataInsert) ) {
        	Session::flash('success', trans('common.message_regist_success'));
        } else {
        	Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('backend.baitais.index');
	}


	/**
	 * get view edit
	 * $id: id baitai record
	 */
	public function getEdit($id) {
		// search
		$data['s_baitai_code'] 			= Input::get('s_baitai_code');
		$data['s_baitai_name'] 			= Input::get('s_baitai_name');
		$data['s_baitai_kind_old'] 		= Input::get('s_baitai_kind_old', null);
		$data['s_baitai_kind_new'] 		= Input::get('s_baitai_kind_new', null);
		$data['s_baitai_year_begin'] 	= Input::get('s_baitai_year_begin');
		$data['s_baitai_year_end'] 		= Input::get('s_baitai_year_end');
		$data['page'] 					= Input::get('page');

		$clsBaitai 			= new BaitaiModel();
		$data['baitai'] 	= $clsBaitai->get_by_id($id);
		$data['title'] 		= trans('common.baitai_title_edit');

		return view('backend.baitais.edit', $data);
	}


	/**
	 * update database
	 * $id: id baitai record
	 */
	public function postEdit($id) {
		$clsBaitai             	= new BaitaiModel();
        $dataInsert             = array(
            'baitai_code'      	=> Input::get('baitai_code'),
            'baitai_name'      	=> Input::get('baitai_name'),
            'baitai_kind'      	=> Input::get('baitai_kind'),
            'baitai_year'      	=> Input::get('baitai_year'),

            'last_date'         => date('Y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
        );

        $validator  = Validator::make($dataInsert, $clsBaitai->Rules(), $clsBaitai->Messages());
        if ($validator->fails()) {
            return redirect()->route('backend.baitais.edit', array($id, 
            		's_baitai_code' 		=> Input::get('s_baitai_code'),
			        's_baitai_name' 		=> Input::get('s_baitai_name'),
			        's_baitai_kind_old' 	=> Input::get('s_baitai_kind_old', null),
			        's_baitai_kind_new' 	=> Input::get('s_baitai_kind_new', null),
			        's_baitai_year_begin' 	=> Input::get('s_baitai_year_begin'),
			        's_baitai_year_end' 	=> Input::get('s_baitai_year_end'),
			        'page' 					=> Input::get('page')
            	))->withErrors($validator)->withInput();
        }

        if ( $clsBaitai->update($id, $dataInsert) ) {
        	Session::flash('success', trans('common.message_edit_success'));
        } else {
        	Session::flash('danger', trans('common.message_edit_danger'));
        }

        return redirect()->route('backend.baitais.index', array(
        		's_baitai_code' 		=> Input::get('s_baitai_code'),
		        's_baitai_name' 		=> Input::get('s_baitai_name'),
		        's_baitai_kind_old' 	=> Input::get('s_baitai_kind_old', null),
		        's_baitai_kind_new' 	=> Input::get('s_baitai_kind_new', null),
		        's_baitai_year_begin' 	=> Input::get('s_baitai_year_begin'),
		        's_baitai_year_end' 	=> Input::get('s_baitai_year_end'),
		        'page' 					=> Input::get('page')
        	));
	}


	/**
	 * update database
	 * $id: id baitai record
	 */
	public function delete($id) {
		$clsBaitai             	= new BaitaiModel();
		$dataUpdate 			= array(
			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
		);
		
		if ( $clsBaitai->update($id, $dataUpdate) ) {
			Session::flash('success', trans('common.message_delete_success'));
		} else {
			Session::flash('danger', trans('common.message_delete_danger'));
		}

		// set page current
		$page = $this->set_page($clsBaitai, Input::get('page'));

        return redirect()->route('backend.baitais.index', array(
        		's_baitai_code' 		=> Input::get('s_baitai_code'),
		        's_baitai_name' 		=> Input::get('s_baitai_name'),
		        's_baitai_kind_old' 	=> Input::get('s_baitai_kind_old', null),
		        's_baitai_kind_new' 	=> Input::get('s_baitai_kind_new', null),
		        's_baitai_year_begin' 	=> Input::get('s_baitai_year_begin'),
		        's_baitai_year_end' 	=> Input::get('s_baitai_year_end'),
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
		$data['s_baitai_code'] 			= Input::get('s_baitai_code');
		$data['s_baitai_name'] 			= Input::get('s_baitai_name');
		$data['s_baitai_kind_old'] 		= Input::get('s_baitai_kind_old');
		$data['s_baitai_kind_new'] 		= Input::get('s_baitai_kind_new');
		$data['s_baitai_year_begin'] 	= Input::get('s_baitai_year_begin');
		$data['s_baitai_year_end'] 		= Input::get('s_baitai_year_end');

		// reset where
		if (Input::get('where') == 'null') {
			// search
			$data['s_baitai_code'] 		= null;
			$data['s_baitai_name'] 		= null;
			$data['s_baitai_kind_old'] 	= null;
			$data['s_baitai_kind_new'] 	= null;
			$data['s_baitai_year_begin'] 	= null;
			$data['s_baitai_year_end'] 	= null;

			return redirect()->route('backend.baitais.search');
		}

		$data['title'] 		= trans('common.baitai_title_search');
		return view('backend.baitais.search', $data);
	}
}