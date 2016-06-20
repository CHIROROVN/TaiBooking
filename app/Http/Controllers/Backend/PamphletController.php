<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Models\PamphletModel;
use App\Http\Models\PrefModel;
use App\Http\Models\AreaModel;
use App\Http\Models\BunyaModel;
use App\Http\Models\CustomerModel;
use Input;
use Session;
use Validator;
use Auth;

class PamphletController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * show list pamphlets
	 */
	public function index() {
		// search
		$data['s_pamph_number'] 			= Input::get('s_pamph_number');
		$data['s_pamph_name'] 				= Input::get('s_pamph_name');
		$data['s_pamph_kind_school'] 		= Input::get('s_pamph_kind_school', null);
		$data['s_pamph_kind_reserve'] 		= Input::get('s_pamph_kind_reserve', null);
		$data['s_pamph_kind_bundle'] 		= Input::get('s_pamph_kind_bundle', null);
		$data['s_pamph_class_unused'] 		= Input::get('s_pamph_class_unused');
		$data['s_pamph_class_used'] 		= Input::get('s_pamph_class_used');
		$data['s_pamph_cus_id'] 			= Input::get('s_pamph_cus_id');
		$data['s_pamph_cus_name'] 			= Input::get('s_pamph_cus_name');
		if ( empty($data['s_pamph_cus_name']) ) {
			$data['s_pamph_cus_id'] = null;
		}
		$data['s_pamph_send_none'] 			= Input::get('s_pamph_send_none');
		$data['s_pamph_send_yes'] 			= Input::get('s_pamph_send_yes');
		$data['s_pamph_bunya_id'] 			= Input::get('s_pamph_bunya_id');
		$data['s_pamph_bunya_name'] 		= Input::get('s_pamph_bunya_name');
		if ( empty($data['s_pamph_bunya_name']) ) {
			$data['s_pamph_bunya_id'] = null;
		}
		$data['s_pamph_pref'] 				= Input::get('s_pamph_pref');
		$data['s_pamph_area'] 				= Input::get('s_pamph_area');
		$data['s_pamph_sex_unspecified'] 	= Input::get('s_pamph_sex_unspecified');
		$data['s_pamph_sex_men'] 			= Input::get('s_pamph_sex_men');
		$data['s_pamph_sex_women'] 			= Input::get('s_pamph_sex_women');
		$data['page'] 						= Input::get('page');

		$clsPamphlet 					= new PamphletModel();
		$clsBunya						= new BunyaModel();
		$clsCustomer 					= new CustomerModel();
		$clsArea 						= new AreaModel();
		$clsPref 						= new PrefModel();
		$data['pamphlets'] 				= $clsPamphlet->get_all(true, $data)['db'];
		$data['pamphlets_distinct'] 	= $clsPamphlet->get_all_distinct();
		
		// set bunyas
		$bunyas 				= $clsBunya->get_for_select();
		$tmp = array();
		foreach ( $bunyas as $bunya ) {
			$tmp[$bunya->bunya_id] = $bunya->bunya_name;
		}
		$data['bunyas']			= $tmp;
		
		// set customers
		$customers 				= $clsCustomer->get_for_select();
		$tmp = array();
		foreach ( $customers as $customer ) {
			$tmp[$customer->cus_id] = $customer->cus_name;
		}
		$data['customers']		= $tmp;
		
		// set area
		$areas 					= $clsArea->get_for_select();
		$tmp = array();
		foreach ( $areas as $area ) {
			$tmp[$area->area_id] = $area->area_name;
		}
		$data['areas'] 			= $tmp;
		
		// set pref
		$prefs 					= $clsPref->get_for_select();
		$tmp = array();
		foreach ( $prefs as $pref ) {
			$tmp[$pref->pref_id] = $pref->pref_name;
		}
		$data['prefs'] 			= $tmp;

		$data['title'] 			= trans('common.pamphlet_title_index');

		$data['count_all']		= $clsPamphlet->count_distinct();
		$data['total_count'] 	= $clsPamphlet->get_all(true, Input::all())['total_count'];
		$page_current 			= Input::get('page', 1);
		$data['record_from'] 	= (($page_current - 1) * PAGINATION) + 1;
		$data['record_to'] 		= $data['record_from'] - 1;
		if ( $data['count_all'] == 0 ) {
			$data['record_from'] = 0;
		}
		if ( $data['total_count'] == 0 ) {
			$data['record_to'] = 0;
			$data['record_from'] = 0;
		}

		return view('backend.pamphlets.index', $data);
	}


	/**
	 * get view regist
	 */
	public function getRegist() {
		$clsPref 					= new PrefModel();
		$clsArea 					= new AreaModel();
		$clsBunya 					= new BunyaModel();
		$clsCustomer 				= new CustomerModel();
		$data['prefs'] 				= $clsPref->get_for_select();
		$data['areas']				= $clsArea->get_for_select();
		$data['title'] 				= trans('common.pamphlet_title_regist');
		$data['bunyas']				= $clsBunya->get_for_select();
		$data['customers']			= $clsCustomer->get_for_select();

		return view('backend.pamphlets.regist', $data);
	}


	/**
	 * insert database
	 */
	public function postRegist() {
		$clsPamphlet			= new PamphletModel();
		$clsBunya 				= new BunyaModel();
		$clsCustomer 			= new CustomerModel();

		$pamph_cus_id 			= Input::get('pamph_cus_id');
		if ( $pamph_cus_id[0] == null ) {
			$pamph_cus_id = '';
		}

		$dataInsert             = array(
			'pamph_number'      => Input::get('pamph_number'),
			'pamph_name'      	=> Input::get('pamph_name'),
			'pamph_kind'      	=> Input::get('pamph_kind', null),
			'pamph_class'      	=> Input::get('pamph_class', null),
			'pamph_cus_id'     	=> $pamph_cus_id,
			'pamph_send'      	=> Input::get('pamph_send'),
			'pamph_bunya_id'    => Input::get('pamph_bunya_id'),
			'pamph_sex'      	=> Input::get('pamph_sex'),

			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => INSERT,
			'last_ipadrs'       => CLIENT_IP_ADRS,
			'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
		);

		$dataInsert['pamph_pref'] 		= Input::get('pamph_pref');
		$dataInsert['pamph_area'] 		= Input::get('pamph_area');
		$dataInsert['pamph_bunya_name'] = Input::get('pamph_bunya_name');
		$dataInsert['pamph_cus_name'] 	= Input::get('pamph_cus_name');

		// set value for pamph_area_pref
		if ( $dataInsert['pamph_pref'] == 0 && $dataInsert['pamph_area'] == 0 ) {
			$dataInsert['pamph_area'] = '';
			$dataInsert['pamph_pref'] = '';
		} else {
			$dataInsert['pamph_area'] = $dataInsert['pamph_area'];
			$dataInsert['pamph_pref'] = $dataInsert['pamph_pref'];
		}

		$validator  = Validator::make($dataInsert, $clsPamphlet->Rules(), $clsPamphlet->Messages());
		if ($validator->fails()) {
			return redirect()->route('backend.pamphlets.regist')->withErrors($validator)->withInput();
		}

		// check select only pamph_pref and pamph_area
		if ( $dataInsert['pamph_pref'] != 0 && $dataInsert['pamph_area'] != 0 ) {
			Session::flash('error-input', trans('common.pamphlet_message_select_only'));
			return redirect()->route('backend.pamphlets.regist')->withErrors($validator)->withInput();
		} else {
			$dataInsert['pamph_area'] = $dataInsert['pamph_area'];
			$dataInsert['pamph_pref'] = $dataInsert['pamph_pref'];
		}

		unset($dataInsert['pamph_bunya_name']);
		unset($dataInsert['pamph_cus_name']);

		// insert from array customer ID
		$tmp_cus_id = array();
		if ( !empty($pamph_cus_id) ) {
			$status_insert = true;
			foreach ( $pamph_cus_id as $item ) {
				if ( !in_array($item, $tmp_cus_id) ) {
					$tmp_cus_id[] = $item;
					$dataInsert['pamph_cus_id'] 	= $item;
					if ( !$clsPamphlet->insert($dataInsert) ) {
						$status_insert = false;
					}
				}
			}
			if ( $status_insert ) {
				Session::flash('success', trans('common.message_regist_success'));
			} else {
				Session::flash('danger', trans('common.message_regist_danger'));
			}
		} else {
			if ( $clsPamphlet->insert($dataInsert) ) {
				Session::flash('success', trans('common.message_regist_success'));
			} else {
				Session::flash('danger', trans('common.message_regist_danger'));
			}

		}

		return redirect()->route('backend.pamphlets.index');
	}


	/**
	 * get view edit
	 * $id: id baitai record
	 */
	public function getEdit($id) {
		// search
		$data['s_pamph_number'] 			= Input::get('s_pamph_number');
		$data['s_pamph_name'] 				= Input::get('s_pamph_name');
		$data['s_pamph_kind_school'] 		= Input::get('s_pamph_kind_school');
		$data['s_pamph_kind_reserve'] 		= Input::get('s_pamph_kind_reserve');
		$data['s_pamph_kind_bundle'] 		= Input::get('s_pamph_kind_bundle');
		$data['s_pamph_class_unused'] 		= Input::get('s_pamph_class_unused');
		$data['s_pamph_class_used'] 		= Input::get('s_pamph_class_used');
		$data['s_pamph_cus_id'] 			= Input::get('s_pamph_cus_id');
		$data['s_pamph_cus_name'] 			= Input::get('s_pamph_cus_name');
		if ( empty($data['s_pamph_cus_name']) ) {
			$data['s_pamph_cus_id'] = null;
		}
		$data['s_pamph_send_none'] 			= Input::get('s_pamph_send_none');
		$data['s_pamph_send_yes'] 			= Input::get('s_pamph_send_yes');
		$data['s_pamph_bunya_id'] 			= Input::get('s_pamph_bunya_id');
		$data['s_pamph_bunya_name'] 		= Input::get('s_pamph_bunya_name');
		if ( empty($data['s_pamph_bunya_name']) ) {
			$data['s_pamph_bunya_id'] = null;
		}
		$data['s_pamph_pref'] 				= Input::get('s_pamph_pref');
		$data['s_pamph_area'] 				= Input::get('s_pamph_area');
		$data['s_pamph_sex_unspecified'] 	= Input::get('s_pamph_sex_unspecified');
		$data['s_pamph_sex_men'] 			= Input::get('s_pamph_sex_men');
		$data['s_pamph_sex_women'] 			= Input::get('s_pamph_sex_women');
		$data['page'] 						= Input::get('page');

		$clsPamphlet 		= new PamphletModel();
		$clsArea			= new AreaModel();
		$clsPref			= new PrefModel();
		$clsBunya 			= new BunyaModel();
		$clsCustomer 		= new CustomerModel();
		$data['pamphlet'] 	= $clsPamphlet->get_by_id($id);

		$data['prefs'] 		= $clsPref->get_for_select();
		$data['areas']		= $clsArea->get_for_select();
		$bunyas 			= $clsBunya->get_for_select();
		$customers 			= $clsCustomer->get_for_select();
		$data['title'] 		= trans('common.pamphlet_title_edit');

		// set bunyas
		$tmp = array();
		foreach ( $bunyas as $bunya ) {
			$tmp[$bunya->bunya_id] = $bunya->bunya_name;
		}
		$data['bunyas_old']			= $tmp;
		
		// set customers
		$tmp = array();
		foreach ( $customers as $customer ) {
			$tmp[$customer->cus_id] = $customer->cus_name;
		}
		$data['customers_old']		= $tmp;

		// edit all by pamph number
		if ( !empty(Input::get('type')) ) {
			$data['list_customers'] = $clsPamphlet->get_by_pamph_number(Input::get('type'));
		}

		return view('backend.pamphlets.edit', $data);
	}


	/**
	 * update database
	 * $id: id baitai record
	 */
	public function postEdit($id) {
		$clsPamphlet            = new PamphletModel();
		$clsBunya 				= new BunyaModel();
		$clsCustomer 			= new CustomerModel();

		$pamph_bunya_id 		= Input::get('pamph_bunya_id');
		if ( empty(Input::get('pamph_bunya_name')) ) {
			$pamph_bunya_id = '';
		}

		$pamph_cus_id 			= Input::get('pamph_cus_id');

		if ( empty($pamph_cus_id) || $pamph_cus_id[0] == null || empty(Input::get('pamph_cus_name')) ) {
			$pamph_cus_id = '';
		}

		$dataInsert             = array(
			'pamph_number'      => Input::get('pamph_number'),
			'pamph_name'      	=> Input::get('pamph_name'),
			'pamph_kind'      	=> Input::get('pamph_kind', null),
			'pamph_class'      	=> Input::get('pamph_class', null),
			'pamph_cus_id'     	=> $pamph_cus_id,
			'pamph_send'      	=> Input::get('pamph_send'),
			'pamph_bunya_id'    => $pamph_bunya_id,
			'pamph_sex'      	=> Input::get('pamph_sex'),

			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => UPDATE,
			'last_ipadrs'       => CLIENT_IP_ADRS,
			'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
		);
		$dataInsert['pamph_pref'] 		= Input::get('pamph_pref');
		$dataInsert['pamph_area'] 		= Input::get('pamph_area');
		$dataInsert['pamph_bunya_name'] = Input::get('pamph_bunya_name');
		$dataInsert['pamph_cus_name'] 	= Input::get('pamph_cus_name');

		// set value for pamph_area_pref
		if ( $dataInsert['pamph_pref'] == 0 && $dataInsert['pamph_area'] == 0 ) {
			$dataInsert['pamph_area'] = '';
			$dataInsert['pamph_pref'] = '';
		} else {
			$dataInsert['pamph_area'] = $dataInsert['pamph_area'];
			$dataInsert['pamph_pref'] = $dataInsert['pamph_pref'];
		}

		$validator  = Validator::make($dataInsert, $clsPamphlet->Rules(), $clsPamphlet->Messages());
		if ($validator->fails()) {
			return redirect()->route('backend.pamphlets.edit', array($id, 
				's_pamph_number' 			=> Input::get('s_pamph_number'),
				's_pamph_name' 				=> Input::get('s_pamph_name'),
				's_pamph_kind_school' 		=> Input::get('s_pamph_kind_school'),
				's_pamph_kind_reserve' 		=> Input::get('s_pamph_kind_reserve'),
				's_pamph_kind_bundle' 		=> Input::get('s_pamph_kind_bundle'),
				's_pamph_class_unused' 		=> Input::get('s_pamph_class_unused'),
				's_pamph_class_used' 		=> Input::get('s_pamph_class_used'),
				's_pamph_cus_id' 			=> Input::get('s_pamph_cus_id'),
				's_pamph_cus_name' 			=> Input::get('s_pamph_cus_name'),
				's_pamph_send_none' 		=> Input::get('s_pamph_send_none'),
				's_pamph_send_yes' 			=> Input::get('s_pamph_send_yes'),
				's_pamph_bunya_id' 			=> Input::get('s_pamph_bunya_id'),
				's_pamph_bunya_name' 		=> Input::get('s_pamph_bunya_name'),
				's_pamph_pref' 				=> Input::get('s_pamph_pref'),
				's_pamph_area' 				=> Input::get('s_pamph_area'),
				's_pamph_sex_unspecified' 	=> Input::get('s_pamph_sex_unspecified'),
				's_pamph_sex_men' 			=> Input::get('s_pamph_sex_men'),
				's_pamph_sex_women' 		=> Input::get('s_pamph_sex_women'),
				// 's_pamph_area' 				=> Input::get('s_pamph_area'),
				'page' 						=> Input::get('page')
			))->withErrors($validator)->withInput();
		}

		// check select only pamph_pref and pamph_area
		if ( $dataInsert['pamph_pref'] != 0 && $dataInsert['pamph_area'] != 0 ) {
			Session::flash('error-input-area-pref', trans('common.pamphlet_message_select_only'));
			return redirect()->route('backend.pamphlets.edit', [$id, 
				's_pamph_number' 			=> Input::get('s_pamph_number'),
				's_pamph_name' 				=> Input::get('s_pamph_name'),
				's_pamph_kind_school' 		=> Input::get('s_pamph_kind_school'),
				's_pamph_kind_reserve' 		=> Input::get('s_pamph_kind_reserve'),
				's_pamph_kind_bundle' 		=> Input::get('s_pamph_kind_bundle'),
				's_pamph_class_unused' 		=> Input::get('s_pamph_class_unused'),
				's_pamph_class_used' 		=> Input::get('s_pamph_class_used'),
				's_pamph_cus_id' 			=> Input::get('s_pamph_cus_id'),
				's_pamph_cus_name' 			=> Input::get('s_pamph_cus_name'),
				's_pamph_send_none' 		=> Input::get('s_pamph_send_none'),
				's_pamph_send_yes' 			=> Input::get('s_pamph_send_yes'),
				's_pamph_bunya_id' 			=> Input::get('s_pamph_bunya_id'),
				's_pamph_bunya_name' 		=> Input::get('s_pamph_bunya_name'),
				's_pamph_pref' 				=> Input::get('s_pamph_pref'),
				's_pamph_area' 				=> Input::get('s_pamph_area'),
				's_pamph_sex_unspecified' 	=> Input::get('s_pamph_sex_unspecified'),
				's_pamph_sex_men' 			=> Input::get('s_pamph_sex_men'),
				's_pamph_sex_women' 		=> Input::get('s_pamph_sex_women'),
				// 's_pamph_area' 				=> Input::get('s_pamph_area'),
				'page' 						=> Input::get('page')
			])->withErrors($validator)->withInput();
		} else {
			$dataInsert['pamph_area'] = $dataInsert['pamph_area'];
			$dataInsert['pamph_pref'] = $dataInsert['pamph_pref'];
		}

		unset($dataInsert['pamph_bunya_name']);
		unset($dataInsert['pamph_cus_name']);

		// $tmp = $dataInsert['pamph_cus_id'];
		// foreach ( $tmp as $item ) {
		// 	$dataInsert['pamph_cus_id'] = $item;
		// 	$clsPamphlet->update($id, $dataInsert);
		// }
		// $dataInsert['pamph_cus_id'] = Input::get('pamph_cus_id');

		if ( $clsPamphlet->update($id, $dataInsert) ) {
			Session::flash('success', trans('common.message_edit_success'));
		} else {
			Session::flash('danger', trans('common.message_edit_danger'));
		}

		return redirect()->route('backend.pamphlets.index', array(
			's_pamph_number' 			=> Input::get('s_pamph_number'),
			's_pamph_name' 				=> Input::get('s_pamph_name'),
			's_pamph_kind_school' 		=> Input::get('s_pamph_kind_school'),
			's_pamph_kind_reserve' 		=> Input::get('s_pamph_kind_reserve'),
			's_pamph_kind_bundle' 		=> Input::get('s_pamph_kind_bundle'),
			's_pamph_class_unused' 		=> Input::get('s_pamph_class_unused'),
			's_pamph_class_used' 		=> Input::get('s_pamph_class_used'),
			's_pamph_cus_id' 			=> Input::get('s_pamph_cus_id'),
			's_pamph_cus_name' 			=> Input::get('s_pamph_cus_name'),
			's_pamph_send_none' 		=> Input::get('s_pamph_send_none'),
			's_pamph_send_yes' 			=> Input::get('s_pamph_send_yes'),
			's_pamph_bunya_id' 			=> Input::get('s_pamph_bunya_id'),
			's_pamph_bunya_name' 		=> Input::get('s_pamph_bunya_name'),
			's_pamph_pref' 				=> Input::get('s_pamph_pref'),
			's_pamph_area' 				=> Input::get('s_pamph_area'),
			's_pamph_sex_unspecified' 	=> Input::get('s_pamph_sex_unspecified'),
			's_pamph_sex_men' 			=> Input::get('s_pamph_sex_men'),
			's_pamph_sex_women' 		=> Input::get('s_pamph_sex_women'),
			// 's_pamph_area' 				=> Input::get('s_pamph_area'),
			'page' 						=> Input::get('page')
		));
	}


	/**
	 * update database
	 * $id: id baitai record
	 */
	public function delete($id) {
		$clsPamphlet            = new PamphletModel();
		$dataUpdate 			= array(
			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => DELETE,
			'last_ipadrs'       => CLIENT_IP_ADRS,
			'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
		);

		// delete all
		if ( !empty(Input::get('type')) ) {
			$clsPamphlet->update_by_pamph_number(Input::get('type'), $dataUpdate);
		} else {
			if ( $clsPamphlet->update($id, $dataUpdate) ) {
				Session::flash('success', trans('common.message_delete_success'));
			} else {
				Session::flash('danger', trans('common.message_delete_danger'));
			}
		}

		// set page current
		$page = $this->set_page($clsPamphlet, Input::get('page'));

		return redirect()->route('backend.pamphlets.index', array(
			's_pamph_number' 			=> Input::get('s_pamph_number'),
			's_pamph_name' 				=> Input::get('s_pamph_name'),
			's_pamph_kind_school' 		=> Input::get('s_pamph_kind_school'),
			's_pamph_kind_reserve' 		=> Input::get('s_pamph_kind_reserve'),
			's_pamph_kind_bundle' 		=> Input::get('s_pamph_kind_bundle'),
			's_pamph_class_unused' 		=> Input::get('s_pamph_class_unused'),
			's_pamph_class_used' 		=> Input::get('s_pamph_class_used'),
			's_pamph_cus_id' 			=> Input::get('s_pamph_cus_id'),
			's_pamph_cus_name' 			=> Input::get('s_pamph_cus_name'),
			's_pamph_send_none' 		=> Input::get('s_pamph_send_none'),
			's_pamph_send_yes' 			=> Input::get('s_pamph_send_yes'),
			's_pamph_bunya_id' 			=> Input::get('s_pamph_bunya_id'),
			's_pamph_bunya_name' 		=> Input::get('s_pamph_bunya_name'),
			's_pamph_pref' 				=> Input::get('s_pamph_pref'),
			's_pamph_area' 				=> Input::get('s_pamph_area'),
			's_pamph_sex_unspecified' 	=> Input::get('s_pamph_sex_unspecified'),
			's_pamph_sex_men' 			=> Input::get('s_pamph_sex_men'),
			's_pamph_sex_women' 		=> Input::get('s_pamph_sex_women'),
			// 's_pamph_area' 				=> Input::get('s_pamph_area'),
			'page' 						=> Input::get('page')
		));
	}


	/**
	 * search and where
	 * return index()
	 */
	public function search()
	{
		// search
		$data['s_pamph_number'] 			= Input::get('s_pamph_number');
		$data['s_pamph_name'] 				= Input::get('s_pamph_name');
		$data['s_pamph_kind_school'] 		= Input::get('s_pamph_kind_school');
		$data['s_pamph_kind_reserve'] 		= Input::get('s_pamph_kind_reserve');
		$data['s_pamph_kind_bundle'] 		= Input::get('s_pamph_kind_bundle');
		$data['s_pamph_class_unused'] 		= Input::get('s_pamph_class_unused');
		$data['s_pamph_class_used'] 		= Input::get('s_pamph_class_used');
		$data['s_pamph_cus_id'] 			= Input::get('s_pamph_cus_id');
		$data['s_pamph_cus_name'] 			= Input::get('s_pamph_cus_name');
		if ( empty($data['s_pamph_cus_name']) ) {
			$data['s_pamph_cus_id'] = null;
		}
		$data['s_pamph_send_none'] 			= Input::get('s_pamph_send_none');
		$data['s_pamph_send_yes'] 			= Input::get('s_pamph_send_yes');
		$data['s_pamph_bunya_id'] 			= Input::get('s_pamph_bunya_id');
		$data['s_pamph_bunya_name'] 		= Input::get('s_pamph_bunya_name');
		if ( empty($data['s_pamph_bunya_name']) ) {
			$data['s_pamph_bunya_id'] = null;
		}
		$data['s_pamph_pref'] 				= Input::get('s_pamph_pref');
		$data['s_pamph_area'] 				= Input::get('s_pamph_area');
		$data['s_pamph_sex_unspecified'] 	= Input::get('s_pamph_sex_unspecified');
		$data['s_pamph_sex_men'] 			= Input::get('s_pamph_sex_men');
		$data['s_pamph_sex_women'] 			= Input::get('s_pamph_sex_women');
		$data['page'] 						= Input::get('page');

		// reset where
		if (Input::get('where') == 'null') {
			// search
			$data['s_pamph_number'] 			= null;
			$data['s_pamph_name'] 				= null;
			$data['s_pamph_kind_school'] 		= null;
			$data['s_pamph_kind_reserve'] 		= null;
			$data['s_pamph_kind_bundle'] 		= null;
			$data['s_pamph_class_unused'] 		= null;
			$data['s_pamph_class_used'] 		= null;
			$data['s_pamph_cus_id'] 			= null;
			$data['s_pamph_cus_name'] 			= null;
			$data['s_pamph_send_none'] 			= null;
			$data['s_pamph_send_yes'] 			= null;
			$data['s_pamph_bunya_id'] 			= null;
			$data['s_pamph_bunya_name'] 		= null;
			$data['s_pamph_pref'] 				= null;
			$data['s_pamph_area'] 				= null;
			$data['s_pamph_sex_unspecified'] 	= null;
			$data['s_pamph_sex_men'] 			= null;
			$data['s_pamph_sex_women'] 			= null;

			return redirect()->route('backend.pamphlets.search');
		}

		$clsCustomer 		= new CustomerModel();
		$clsBunya 			= new BunyaModel();
		$clsPref			= new PrefModel();
		$clsArea			= new AreaModel();
		$bunyas				= $clsBunya->get_for_select();
		$customers			= $clsCustomer->get_for_select();
		$data['title'] 		= trans('common.pamphlet_title_search');
		$data['prefs']		= $clsPref->get_for_select();
		$data['areas']		= $clsArea->get_for_select();

		return view('backend.pamphlets.search', $data);
	}


	public function AutoCompleteBunya()
	{
		$key 			= Input::get('key', '');
		$clsBunya 		= new BunyaModel();
		$bunyas 		= $clsBunya->get_for_autocomplate($key);
		$tmp = array();
		foreach ( $bunyas as $bunya ) {
			$tmp[] = (object)array(
				'value' 	=> $bunya->bunya_id,
				'label' 	=> $bunya->bunya_code . '_' . $bunya->bunya_name,
				'desc' 		=> $bunya->bunya_code . '_' . $bunya->bunya_name
			);
		}
		echo json_encode($tmp);
	}


	public function AutoCompleteCustomer()
	{
		$key 			= Input::get('key', '');
		$clsCustomer 	= new CustomerModel();
		$customers 		= $clsCustomer->get_for_autocomplate($key);
		$tmp = array();
		foreach ( $customers as $customer ) {
			$tmp[] = (object)array(
				'value' 	=> $customer->cus_id,
				'label' 	=> $customer->cus_code . '_' . $customer->cus_name,
				'desc' 		=> $customer->cus_code . '_' . $customer->cus_name
			);
		}
		echo json_encode($tmp);
	}
}