<?php namespace App\Http\Models;

use DB;

class CustomerModel
{
    protected $table = 'm_customer';

    public function Rules()
    {
        return array(
            'cus_code'                      => 'required|unique:m_customer',
            'cus_name'                      => 'required',
            'cus_name_kana'                 => 'required|regex:/^[\x{3041}-\x{3096}]+$/u',
            'cus_pay'                       => 'required',
            'cus_kind'                      => 'required',
            'cus_owner'                     => 'required',
//            'ent_id'                        => 'required',
            'cus_staff1_name'               => 'required',
            'cus_staff1_name_kana'          => 'regex:/^[\x{3041}-\x{3096}]+$/u',
            'cus_staff1_email'              => 'email',
            'cus_staff2_name_kana'          => 'regex:/^[\x{3041}-\x{3096}]+$/u',
            'cus_staff2_email'              => 'email',
            'cus_staff3_name_kana'          => 'regex:/^[\x{3041}-\x{3096}]+$/u',
            'cus_staff3_email'              => 'email',
            'cus_login'                     => 'required',
            'cus_passwd'                    => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'cus_code.required'                  => trans('validation.error_cus_code_required'),
            'cus_code.unique'                    => trans('validation.error_cus_code_unique'),
            'cus_name.required'                  => trans('validation.error_cus_name_required'),
            'cus_name_kana.regex'                => trans('validation.error_cus_name_kana_regex'),
            'cus_name_kana.required'             => trans('validation.error_cus_name_kana_required'),
            'cus_pay.required'                   => trans('validation.error_cus_pay_required'),
            'cus_kind.required'                  => trans('validation.error_cus_kind_required'),
            'cus_owner.required'                 => trans('validation.error_cus_owner_required'),
            'cus_login.required'                 => trans('validation.error_cus_login_required'),
            'cus_passwd.required'                => trans('validation.error_cus_passwd_required'),
            'cus_staff1_name.required'           => trans('validation.error_cus_staff1_name_required'),
            'cus_staff1_name_kana.regex'         => trans('validation.error_cus_staff1_name_kana_must_kana'),
            'cus_staff1_email.email'             => trans('validation.error_cus_staff1_email_format'),
            'cus_staff2_name_kana.regex'         => trans('validation.error_cus_staff2_name_kana_must_kana'),
            'cus_staff2_email.email'             => trans('validation.error_cus_staff2_email_format'),
            'cus_staff3_name_kana.regex'         => trans('validation.error_cus_staff3_name_kana_must_kana'),
            'cus_staff3_email.email'             => trans('validation.error_cus_staff3_email_format'),
        );
    }

    public function get_all($where = null)
    {
        $query = DB::table($this->table)
                        ->where('last_kind', '<>', DELETE)
                        ->orderBy('cus_staff1_name_kana', 'asc')
                        ->orderBy('cus_staff2_name_kana', 'asc')
                        ->orderBy('cus_staff3_name_kana', 'asc');

        if(!empty($where['cus_code']))
            $query->where('cus_code', 'LIKE', '%' .$where['cus_code']. '%');

        if(!empty($where['cus_name']))
            $query->where('cus_name', 'LIKE', '%' .$where['cus_name']. '%');

        if(!empty($where['cus_old_name']))
            $query->where('cus_old_name', 'LIKE', '%' .$where['cus_old_name']. '%');

        $results = $query->simplePaginate(PAGINATION);

        return $results;
    }

    public function get_cus_by_cid($whereIn=null){
        if(!empty($whereIn))
        {
            return DB::table($this->table)
                        ->select('cus_id', 'ent_id', 'last_kind', 'last_date', 'last_ipadrs', 'last_user')
                        ->where('last_kind', '<>', DELETE)
                        ->whereIn('cus_id', $whereIn)
                        ->orderBy('cus_id', 'asc')
                        ->get();
        }else{
            return null;
        }
    }

    public function get_for_select()
    {
        $results = DB::table($this->table)->select('cus_id', 'cus_code', 'cus_name')->where('last_kind', '<>', DELETE)->orderBy('cus_code', 'asc')->get();
        return $results;
    }


    public function get_for_autocomplate($key = '')
    {
        $results = DB::table($this->table)
                        ->select('cus_id', 'cus_code', 'cus_name')
                        ->where('last_kind', '<>', DELETE);
        if ( !empty($key) ) {
            $results = $results->where('cus_code', 'like', '%' . $key . '%')
                                ->orWhere('cus_name', 'like', '%' . $key . '%');
        }
        $db = $results->orderBy('cus_code', 'asc')->get();

        return $db;
    }

    public function get_by_ent_id($ent_id=null)
    {
        return DB::table($this->table)->select('cus_id', 'ent_id')->where('last_kind', '<>', DELETE)->where('ent_id', '=', $ent_id)->orderBy('cus_code', 'asc')->get();
    }

    public function count() {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->count();
        return $results;
    }

    public function insert($data)
    {
        $results = DB::table($this->table)->insert($data);
        return $results;
    }

    public function insert_get_id($data)
    {
        $results = DB::table($this->table)->insertGetId($data);
        return $results;
    }

    public function get_by_id($id)
    {
        $results = DB::table($this->table)->where('cus_id', $id)->first();
        return $results;
    }

    public function get_by_code($cus_code)
    {
        $results = DB::table($this->table)->where('cus_code', $cus_code)->first();
        return $results;
    }

    public function get_cus_by_ent_id($ent_id)
    {
        $results = DB::table($this->table)->select('cus_id','cus_name')->where('ent_id', $ent_id)->get();
        return $results;
    }

    public function update($id, $data)
    {
        $results = DB::table($this->table)->where('cus_id', $id)->update($data);
        return $results;
    }

    public function update_ent_id($ent_id, $data)
    {
        return DB::table($this->table)->where('ent_id', $ent_id)->update($data);
    }

    //get list customer
    public function get_cus_by_kana($kana=null){
        if(!empty($kana)){
            switch ($kana) {
                case 'あ':
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%あ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%い%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%う%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%え%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%お%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;
                case 'か':
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%か%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%き%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%く%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%け%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%こ%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;
                case 'さ':
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%さ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%し%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%す%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%せ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%そ%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;
                case 'た':
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%た%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ち%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%つ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%て%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%と%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;
                case 'な':
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%な%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%に%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ぬ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ね%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%の%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;
                case 'は':
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%は%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ひ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ふ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%へ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ほ%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;
                case 'ま':
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ま%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%み%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%む%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%め%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%も%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;
                case 'や':
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%や%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ゆ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%よ%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;
                case 'ら':
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ら%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%り%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%る%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%れ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ろ%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;
                case 'わ':
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%わ%');
                                    $q->orWhere('cus_name_kana', 'LIKE', '%を%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;                
                default:
                return  DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->whereNotNull('last_kind')
                                ->where(function($q){
                                    $q->orWhere('cus_name_kana', 'LIKE', '%ん%');
                                })
                                ->lists('cus_name', 'cus_id');
                    break;
            }
        }
    }

}