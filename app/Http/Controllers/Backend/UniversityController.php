<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Models\UniversityModel;
use App\Http\Models\PrefModel;
use Input;
use Session;
use Validator;
use Auth;

class UniversityController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * show list universities
	 */
	public function index() {
		// search
		$data['s_univ_code'] 			= Input::get('s_univ_code');
		$data['s_univ_name'] 			= Input::get('s_univ_name');
		$data['s_univ_pref_id'] 		= Input::get('s_univ_pref_id');
		
		$clsUniversity 					= new UniversityModel();
		$data['universities'] 			= $clsUniversity->get_all(true, Input::all())['db'];
		$data['title'] 					= trans('common.university_title_index');

		$data['count_all']				= $clsUniversity->count();
		$data['total_count'] 			= $clsUniversity->get_all(true, Input::all())['total_count'];
		$page_current 					= Input::get('page', 1);
		$data['record_from'] 			= (($page_current - 1) * PAGINATION) + 1;
		$data['record_to'] 				= $data['record_from'] - 1;
		if ( $data['count_all'] == 0 ) {
			$data['record_from'] 	= 0;
		}
		if ( $data['total_count'] == 0 ) {
			$data['record_to'] = 0;
			$data['record_from'] 	= 0;
		}

		return view('backend.universities.index', $data);
	}


	/**
	 * get view regist
	 */
	public function getRegist() {
		$clsPref			= new PrefModel();
		$data['title'] 		= trans('common.university_title_regist');
		$data['prefs']		= $clsPref->get_for_select();

		return view('backend.universities.regist', $data);
	}


	/**
	 * insert database
	 */
	public function postRegist() {
		$clsUniversity             	= new UniversityModel();
        $dataInsert             = array(
            'univ_code'      	=> Input::get('univ_code'),
            'univ_name'      	=> Input::get('univ_name'),
            'univ_name_kana'    => Input::get('univ_name_kana'),
            'univ_pref_id'      => Input::get('univ_pref_id'),

            'last_date'         => date('Y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
        );

        $validator  = Validator::make($dataInsert, $clsUniversity->Rules(), $clsUniversity->Messages());
        if ($validator->fails()) {
            return redirect()->route('backend.universities.regist')->withErrors($validator)->withInput();
        }

        if ( $clsUniversity->insert($dataInsert) ) {
        	Session::flash('success', trans('common.message_regist_success'));
        } else {
        	Session::flash('danger', trans('common.message_regist_danger'));
        }

        return redirect()->route('backend.universities.index');
	}


	/**
	 * get view edit
	 * $id: id university record
	 */
	public function getEdit($id) {
		// search
		$data['s_univ_code'] 			= Input::get('s_univ_code');
		$data['s_univ_name'] 			= Input::get('s_univ_name');
		$data['s_univ_pref_id'] 		= Input::get('s_univ_pref_id');
		$data['page'] 					= Input::get('page');

		$clsUniversity 					= new UniversityModel();
		$clsPref						= new PrefModel();
		$data['university'] 			= $clsUniversity->get_by_id($id);
		$data['prefs']					= $clsPref->get_for_select();
		$data['title'] 					= trans('common.university_title_edit');

		return view('backend.universities.edit', $data);
	}


	/**
	 * update database
	 * $id: id university record
	 */
	public function postEdit($id) {
		$clsUniversity          = new UniversityModel();
		$university 			= $clsUniversity->get_by_id($id);

        $dataInsert             = array(
            'univ_code'      	=> Input::get('univ_code'),
            'univ_name'      	=> Input::get('univ_name'),
            'univ_name_kana'    => Input::get('univ_name_kana'),
            'univ_pref_id'      => Input::get('univ_pref_id'),

            'last_date'         => date('Y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
        );
        $rules = $clsUniversity->Rules();
        if ( $dataInsert['univ_code'] == $university->univ_code ) {
        	unset($rules['univ_code']);
        }

        $validator  = Validator::make($dataInsert, $rules, $clsUniversity->Messages());
        if ($validator->fails()) {
            return redirect()->route('backend.universities.edit', array($id, 
        		's_univ_code' 		=> Input::get('s_univ_code'),
		        's_univ_name' 		=> Input::get('s_univ_name'),
		        's_univ_pref_id' 	=> Input::get('s_univ_pref_id'),
		        'page' 				=> Input::get('page')
        	))->withErrors($validator)->withInput();
        }

        if ( $clsUniversity->update($id, $dataInsert) ) {
        	Session::flash('success', trans('common.message_edit_success'));
        } else {
        	Session::flash('danger', trans('common.message_edit_danger'));
        }

        return redirect()->route('backend.universities.index', array(
    		's_univ_code' 		=> Input::get('s_univ_code'),
	        's_univ_name' 		=> Input::get('s_univ_name'),
	        's_univ_pref_id' 	=> Input::get('s_univ_pref_id'),
	        'page' 				=> Input::get('page')
    	));
	}


	/**
	 * update database
	 * $id: id university record
	 */
	public function delete($id) {
		$clsUniversity          = new UniversityModel();
		$dataUpdate 			= array(
			'last_date'         => date('Y-m-d H:i:s'),
			'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : 0,
		);
		
		if ( $clsUniversity->update($id, $dataUpdate) ) {
			Session::flash('success', trans('common.message_delete_success'));
		} else {
			Session::flash('danger', trans('common.message_delete_danger'));
		}

		// set page current
		$page = $this->set_page($clsUniversity, Input::get('page'));

        return redirect()->route('backend.universities.index', array(
    		's_univ_code' 		=> Input::get('s_univ_code'),
        	's_univ_name' 		=> Input::get('s_univ_name'),
        	's_univ_pref_id' 	=> Input::get('s_univ_pref_id'),
	        'page' 						=> $page
    	));
	}


	/**
	 * search and where
	 * return index()
	 */
	public function search()
	{
		// search
		$data['s_univ_code'] 			= Input::get('s_univ_code');
		$data['s_univ_name'] 			= Input::get('s_univ_name');
		$data['s_univ_pref_id'] 		= Input::get('s_univ_pref_id');

		// reset where
		if (Input::get('where') == 'null') {
			// search
			$data['s_univ_code'] 		= null;
			$data['s_univ_name'] 		= null;
			$data['s_univ_pref_id'] 	= null;

			return redirect()->route('backend.universities.search');
		}

		$clsPref			= new PrefModel();
		$data['title'] 		= trans('common.university_title_search');
		$data['prefs']		= $clsPref->get_for_select();
		
		return view('backend.universities.search', $data);
	}
}