<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Models\Ortho\ForumModel;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class ForumController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['except' => ['index', 'getAddComment', 'postAddComment']]);
    }

    /**
     * get list inspections
     */
    public function index()
    {
        $data                 = array();
        $clsForumModel        = new ForumModel();
        $data['forums']       = $clsForumModel->getAllForum();
        return view('backend.ortho.forums.forum_list', $data);
    }

    public static function countReply($forum_id)
    {
        $clsForumModel        = new ForumModel();
        return $clsForumModel->countComments($forum_id);
    }

    /**
     * get view regist
     */
    public function getAddComment()
    {
        return view('backend.ortho.forums.forum_regist');
    }

    /**
     * insert database to table
     */
    public function postAddComment()
    {
        $dataInput              = array();
        $clsForum               = new ForumModel();
        $inputs                 = Input::all();
        $rules                  = $clsForum->Rules();
        if(!Input::hasFile('forum_file_path')){
            unset($rules['forum_file_path']);
            unset($rules['forum_file_name']);
        }

        $validator              = Validator::make($inputs, $rules, $clsForum->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.forums.forum_regist')->withErrors($validator)->withInput();
        }

        $dataInput['forum_title']               = Input::get('forum_title');
        $dataInput['forum_contents']            = Input::get('forum_contents');
        $dataInput['forum_file_name']           = Input::get('forum_file_name');

        if (Input::hasFile('forum_file_path')){
            $forum_file = Input::file('forum_file_path');
            $extFile  = $forum_file->getClientOriginalExtension();
            if(!empty(Input::get('forum_file_name'))){
                $flag  = $clsForum->checkFileValid(trim(Input::get('forum_file_name')));
                if($flag == true){
                    $fn = Input::get('forum_file_name').'.'.$extFile;
                }else{
                    $fn = Input::get('forum_file_name').'_'.rand(9999,9999).$extFile;
                }
            }else{
                $fn       = 'file'.'_'.rand(time(),time()).'.'.$extFile;
            }

            $path_file = public_path().'/backend/uploads/comments/';
            $forum_file->move($path_file, $fn);
            $dataInput['forum_file_path'] = $path_file.$fn;
         }

         $dataInput['last_date']          = date('y-m-d H:i:s');
         $dataInput['last_kind']          = INSERT;
         $dataInput['last_ipadrs']        = $_SERVER['REMOTE_ADDR'];
         $dataInput['last_user']          = !empty(Auth::user()->id) ? Auth::user()->id : '';

        if ( $clsForum->insert($dataInput) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.forums.forum_list');
    }

    /**
     * get view edit
     * $id: ID record
     */
    public function getEdit($id)
    {
        $clsInspection                = new InspectionModel();
        $data['inspection']           = $clsInspection->get_by_id($id);
        return view('backend.ortho.inspections.edit', $data);
    }

    /**
     * update database to table
     * $id: ID record
     */
    public function postEdit($id)
    {
        $clsInspection                  = new InspectionModel();
        $inspection                     = $clsInspection->get_by_id($id);
        $inputs                         = Input::all();
        $validator                      = Validator::make($inputs, $clsInspection->Rules(), $clsInspection->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.inspections.edit', [$inspection->inspection_id])->withErrors($validator)->withInput();
        }

        // update
        $dataUpdate = array(
            'inspection_name'           => Input::get('inspection_name'),
            'last_date'                 => date('y-m-d H:i:s'),
            'last_kind'                 => UPDATE,
            'last_ipadrs'               => $_SERVER['REMOTE_ADDR'],
            'last_user'                 => Auth::user()->id
        );
        
        if ( $clsInspection->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * update database to table
     * $id: ID record
     */
    public function getDelete($id)
    {
        $clsInspection                = new InspectionModel();
        // update table
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        
        if ( $clsInspection->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * 
     */
    public function orderby_top()
    {
        $clsInspection      = new InspectionModel();
        $id                 = Input::get('id');
        $this->top($clsInspection, $id, 'inspection_sort_no');
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * 
     */
    public function orderby_last()
    {
        $clsInspection = new InspectionModel();
        $id = Input::get('id');        
        $this->last($clsInspection, $id, 'inspection_sort_no');
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * 
     */
    public function orderby_up()
    {
        $clsInspection      = new InspectionModel();
        $id                 = Input::get('id');
        $inspections        = $clsInspection->get_all();        
        $this->up($clsInspection, $id, $inspections, 'inspection_id', 'inspection_sort_no');
        return redirect()->route('ortho.inspections.index');
    }

    /**
     * 
     */
    public function orderby_down()
    {
        $clsInspection      = new InspectionModel();
        $id                 = Input::get('id');
        $inspections        = $clsInspection->get_all();        
        $this->down($clsInspection, $id, $inspections, 'inspection_id', 'inspection_sort_no');
        return redirect()->route('ortho.inspections.index');
    }
}
