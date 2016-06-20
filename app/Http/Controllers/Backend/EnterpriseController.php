<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Models\EnterpriseModel;
use App\Http\Models\CustomerModel;
use Auth;
use Validator;
use Input;
use Redirect;
use Hash;
use Session;
use Response;
use Html;
use DB;
use URL;
use LaravelLocalization;

class EnterpriseController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $clsEnterprise 				= new EnterpriseModel();
        $where['entName']          	= Input::get('ent_name');
        $data['enterprises'] 		= $clsEnterprise->get_all($where);
        $data['title'] 				= trans('common.ent_title_list');
        $data['ent_name']          	= Input::get('ent_name');
        $data['count_all']          = $clsEnterprise->count();
        $data['total_count']        = count($clsEnterprise->get_all($where));
        $page_current               = Input::get('page') ? Input::get('page') : '1';
        if($data['total_count'] == 0){
            $data['record_from']    = 0;
            $data['record_to']      = 0;
        }else{
            $data['record_from']    = (($page_current - 1) * PAGINATION) + 1;
            $data['record_to']      = $data['record_from'] - 1;
        }
        return view('backend.enterprises.index', $data);
    }

    public function search()
    {
        $data['title'] 		= trans('common.ent_title_search');
        return view('backend.enterprises.search', $data);
    }

    public function postSearch()
    {
        $data['ent_name']     = Input::get('ent_name');
        return redirect()->route('backend.enterprises.index', $data);
    }

    public static function getCusName($ent_id=null){
        $cmModel = new CustomerModel();
        return $cmModel->get_cus_by_ent_id($ent_id);
    }

    public function detail($id) {
        $clsEnterprise 			= new EnterpriseModel();
        $data['enterprise'] 	= $clsEnterprise->get_by_id($id);
        $data['title'] 			= trans('common.ent_title_detail');

        return view('backend.enterprises.detail', $data);
    }

    public function getRegist() {
        $data['title']         = trans('common.ent_title_regist');
        $data['cus_name']      = '';
        return view('backend.enterprises.regist', $data);
    }

    function getCusNameAjax(){
        $cmModel = new CustomerModel();
        $cnk = Input::get('cnk');
        $cn_kana = $cmModel->get_cus_by_kana($cnk);
        return Response::json(array('cnk' => $cn_kana));
    }

    public function postRegist() {
        $cns = Input::get('cus_name_lb2');
        $dataInsert             = array(
            'ent_name'      	=> Input::get('ent_name'),
            'ent_login'      	=> Input::get('ent_login'),
            'ent_passwd'        => Input::get('ent_passwd'),

            'last_date'         => date('Y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : '',
        );
        $clsEnterprise          = new EnterpriseModel();
        $max_ent_id = $clsEnterprise->find_max_id() + 1;
        $validator  = Validator::make(Input::all(), $clsEnterprise->Rules(), $clsEnterprise->Messages());

        if ($validator->fails()) {
            return redirect()->route('backend.enterprises.regist')->withErrors($validator)->withInput();
        }else{
            $cmModel = new CustomerModel();
            $customers = $cmModel->get_cus_by_cid($cns);
            if(!empty($customers)){
                foreach($customers as $cus){
                    foreach ($cns as $key=>$cn) {
                        if($cus->cus_id == $cn){
                            $cmModel->update($cn, ['ent_id' => $max_ent_id]);
                        }
                    }
                    
                }
            }

            if ( $clsEnterprise->insert($dataInsert) ){
                Session::flash('success', trans('common.cust_msg_regist_succ'));
                return redirect()->route('backend.enterprises.index');
            } else {
                Session::flash('danger', trans('common.cust_msg_regist_faild'));
                return redirect()->route('backend.enterprises.regist')->with('title', $title);
            }
        }
    }


    public function getEdit($id) {
        $clsEnterprise 			= new EnterpriseModel();
        $data['enterprise'] 		= $clsEnterprise->get_by_id($id);
        $data['title'] 			= trans('common.ent_title_edit');

        return view('backend.enterprises.edit', $data);
    }

    public function postEdit($id) {
        $cns = Input::get('cus_name_lb2');
        $clsEnterprise          = new EnterpriseModel();
        $rules = $clsEnterprise->Rules();

        $data 		= $clsEnterprise->get_by_id($id);
        $ent_login = $data->ent_login;
        if(Input::get('ent_login') == $ent_login)
            unset($rules['ent_login']);
        
        $dataUpdate             = array(
            'ent_name'      	=> Input::get('ent_name'),
            'ent_login'      	=> Input::get('ent_login'),
            'ent_passwd'      	=> Input::get('ent_passwd'),

            'last_date'         => date('Y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : '',
        );

        $validator  = Validator::make(Input::all(), $rules, $clsEnterprise->Messages());
        if ($validator->fails()) {
            return redirect()->route('backend.enterprises.regist')->withErrors($validator)->withInput();
        }else{
            $cmModel = new CustomerModel();
            $customers = $cmModel->get_cus_by_cid($cns);
            $cusByEntID = $cmModel->get_by_ent_id($id);
            if(!empty($cusByEntID)){
                foreach($cusByEntID as $cEntID){
                    $cmModel->update_ent_id($cEntID->ent_id, ['ent_id' => null]);
                }
             }

            if(!empty($customers)){
                foreach($customers as $cus){
                    
                    if(!empty($cns)){
                        foreach ($cns as $cn) {
                            if($cus->cus_id == $cn){
                                $cmModel->update($cn, ['ent_id' => $id]);
                            }
                        }
                    }
                }
            }

            if ( $clsEnterprise->update($id, $dataUpdate) ){
                Session::flash('success', trans('common.cust_msg_edit_succ'));
                return redirect()->route('backend.enterprises.index');
            } else {
                Session::flash('danger', trans('common.cust_msg_edit_faild'));
                return redirect()->route('backend.enterprises.edit')->with('title', $title);
            }
        }
    }

    public function delete($id) {
        $clsEnterprise          = new EnterpriseModel();
        $dataDelete 			= array(
            'last_date'         => date('Y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => (Auth::check()) ? Auth::user()->u_id : '',
        );

        $page = $this->set_page($clsEnterprise, Input::get('page'));

        if ( $clsEnterprise->update($id, $dataDelete) ){
            Session::flash('success', trans('common.cust_msg_del_succ'));
            return redirect()->route('backend.enterprises.index', ['page' => $page]);
        } else {
            Session::flash('danger', trans('common.cust_msg_del_faild'));
            return redirect()->route('backend.enterprises.index')->with('title', $title);
        }
    }

}