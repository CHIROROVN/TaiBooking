<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Models\Ortho\ForumModel;
use App\Http\Models\Ortho\ForumReadModel;
use Carbon;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Response;

class ForumController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
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

    public static function reader($forum_id)
    {
        $clsForumRead                 = new ForumReadModel();
        return $clsForumRead->read_comment($forum_id);
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

        if (Input::hasFile('forum_file_path'))
        {
            $forum_file = Input::file('forum_file_path');
            $extFile  = $forum_file->getClientOriginalExtension();
            if(!empty(Input::get('forum_file_name'))){
                $flag  = $clsForum->checkFileValid(trim(Input::get('forum_file_name')));
                if($flag == true){
                    $fn = Input::get('forum_file_name').'.'.$extFile;
                }else{
                    $fn = Input::get('forum_file_name').'_'.rand(time(),time()).'.'.$extFile;
                }
            }else{
                $fn       = 'file'.'_'.rand(time(),time()).'.'.$extFile;
            }

            $path = '/backend/ortho/forums/comments/detail/files/';
            $forum_file->move(public_path().$path, $fn);
            $dataInput['forum_file_path'] = '/public'.$path.$fn;
        }
        $dataInput['forum_user_id']       = !empty(Auth::user()->id) ? Auth::user()->id : '';
        $dataInput['forum_time']          = date('y-m-d H:i:s');
        $dataInput['last_date']           = date('y-m-d H:i:s');
        $dataInput['last_kind']           = INSERT;
        $dataInput['last_ipadrs']         = $_SERVER['REMOTE_ADDR'];
        $dataInput['last_user']           = !empty(Auth::user()->id) ? Auth::user()->id : '';

        $max_forum_id                = $clsForum->get_max();
        if(empty( $max_forum_id)) $max_forum_id = 0;

        //insert to t_forum_read
        $fread                       = array();
        $fread['forum_id']           = $max_forum_id + 1;
        $fread['last_date']          = date('y-m-d H:i:s');
        $fread['last_kind']          = INSERT;
        $fread['last_ipadrs']        = $_SERVER['REMOTE_ADDR'];
        $fread['last_user']          = !empty(Auth::user()->id) ? Auth::user()->id : '';


        if ( $clsForum->insert($dataInput) ) {
            //insert to t_forum_read
            $clsForumRead                = new ForumReadModel();
            $clsForumRead->insert($fread);

            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.forums.forum_list');
    }

    public function detail($id)
    {

        $clsForumRead                 = new ForumReadModel();
        $fread                        = array();
        $fread['forum_read_user_id']  = !empty(Auth::user()->id) ? Auth::user()->id : '';
        $fread['forum_read_time']     = date('y-m-d H:i:s');
        $fread['last_date']           = date('y-m-d H:i:s');
        $fread['last_kind']           = UPDATE;
        $fread['last_ipadrs']         = $_SERVER['REMOTE_ADDR'];
        $fread['last_user']           = !empty(Auth::user()->id) ? Auth::user()->id : '';
        $clsForumRead->read($id, $fread);

        $data                   = array();
        $clsForum               = new ForumModel();
        $data['comment']        = $clsForum->get_by_id($id);

        //update count view comment
        $clsForum->view($id);
        return view('backend.ortho.forums.forum_detail', $data);
    }

    public function detail2($id)
    {
        $data                   = array();
        $clsForum               = new ForumModel();
        $data['comment']        = $clsForum->get_by_id($id);
        $data['commentrs']      = $clsForum->getAllForum(null, $id);

        $clsForumRead                 = new ForumReadModel();
        $fread                        = array();
        $fread['forum_read_user_id']  = !empty(Auth::user()->id) ? Auth::user()->id : '';
        $fread['forum_read_time']     = date('y-m-d H:i:s');
        $fread['last_date']           = date('y-m-d H:i:s');
        $fread['last_kind']           = UPDATE;
        $fread['last_ipadrs']         = $_SERVER['REMOTE_ADDR'];
        $fread['last_user']           = !empty(Auth::user()->id) ? Auth::user()->id : '';
        $clsForumRead->read($id, $fread);

        //update count view comment
        $clsForum->view($id);
        return view('backend.ortho.forums.forum_detail2', $data);
    }

     public function deleteCnf($id)
    {
        $data                   = array();
        $clsForum               = new ForumModel();
        $data['comment']        = $clsForum->get_by_id($id);
        return view('backend.ortho.forums.forum_delete_cnf', $data);
    }

    public function delete($id)
    {
        $clsForum                      = new ForumModel();
        $dataDel['last_date']          = date('y-m-d H:i:s');
        $dataDel['last_kind']          = DELETE;
        $dataDel['last_ipadrs']        = $_SERVER['REMOTE_ADDR'];
        $dataDel['last_user']          = !empty(Auth::user()->id) ? Auth::user()->id : '';

        if ( $clsForum->update($id, $dataDel) ) {
            Session::flash('success', trans('common.message_delete_success'));
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
        }
        return redirect()->route('ortho.forums.forum_list');
    }

    public function getEditComment($id)
    {
        $data                   = array();
        $clsForum               = new ForumModel();
        $data['comment']        = $clsForum->get_by_id($id);
        return view('backend.ortho.forums.forum_edit', $data);
    }

    public function postEditComment($id)
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
        if(!empty(Input::get('forum_file_name')))
            $dataInput['forum_file_name']           = Input::get('forum_file_name');

        if (Input::hasFile('forum_file_path')){
            $forum_file = Input::file('forum_file_path');
            $extFile  = $forum_file->getClientOriginalExtension();
            if(!empty(Input::get('forum_file_name'))){
                $flag  = $clsForum->checkFileValid(trim(Input::get('forum_file_name')));
                if($flag == true){
                    $fn = Input::get('forum_file_name').'.'.$extFile;
                }else{
                    $fn = Input::get('forum_file_name').'_'.rand(time(),time()).'.'.$extFile;
                }
            }else{
                $flag  = $clsForum->checkFileValid(trim($forum_file->getClientOriginalName()));
                if($flag == true)
                    $fn       = $forum_file->getClientOriginalName().'.'.$extFile;
                $fn       = $forum_file->getClientOriginalName().'_'.rand(time(),time()).'.'.$extFile;
            }

            $path = '/backend/ortho/forums/comments/detail/files/';
            $forum_file->move(public_path().$path, $fn);
            $dataInput['forum_file_path'] = '/public'.$path.$fn;
        }

        $dataInput['forum_user_id']       = !empty(Auth::user()->id) ? Auth::user()->id : '';
        $dataInput['forum_time']          = date('y-m-d H:i:s');
        $dataInput['last_date']           = date('y-m-d H:i:s');
        $dataInput['last_kind']           = UPDATE;
        $dataInput['last_ipadrs']         = $_SERVER['REMOTE_ADDR'];
        $dataInput['last_user']           = !empty(Auth::user()->id) ? Auth::user()->id : '';

        if ( $clsForum->update($id, $dataInput) ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }
        return redirect()->route('ortho.forums.forum_list');

    }

    public function getReplyComment($id)
    {
        $data                   = array();
        $clsForum               = new ForumModel();
        $data['comment']        = $clsForum->get_by_id($id);
        return view('backend.ortho.forums.forum_reply', $data);
    }

    public function postReplyComment($id)
    {
        $dataInput              = array();
        $clsForum               = new ForumModel();
        $inputs                 = Input::all();
        $rules                  = $clsForum->Rules();
        if(!Input::hasFile('forum_file_path')){
            unset($rules['forum_file_path']);
//            unset($rules['forum_file_name']);
        }

        $validator              = Validator::make($inputs, $rules, $clsForum->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.forums.forum_reply', $id)->withErrors($validator)->withInput();
        }
        $dataInput['forum_user_id']             = !empty(Auth::user()->id) ? Auth::user()->id : '';
        $dataInput['forum_title']               = Input::get('forum_title');
        $dataInput['forum_contents']            = Input::get('forum_contents');
        $dataInput['forum_file_name']           = Input::get('forum_file_name');
        $dataInput['forum_parent_id']           = Input::get('forum_id');

        if (Input::hasFile('forum_file_path')){
            $forum_file = Input::file('forum_file_path');
            $extFile  = $forum_file->getClientOriginalExtension();
            if(!empty(Input::get('forum_file_name'))){
                $flag  = $clsForum->checkFileValid(trim(Input::get('forum_file_name')));
                if($flag == true){
                    $fn = Input::get('forum_file_name').'.'.$extFile;
                }else{
                    $fn = Input::get('forum_file_name').'_'.rand(time(),time()).'.'.$extFile;
                }
            }else{
                $flag  = $clsForum->checkFileValid(trim($forum_file->getClientOriginalName()));
                if($flag == true)
                    $fn       = $forum_file->getClientOriginalName().'.'.$extFile;
                $fn       = $forum_file->getClientOriginalName().'_'.rand(time(),time()).'.'.$extFile;
            }

            $path = '/backend/ortho/forums/comments/detail/files/';
            $forum_file->move(public_path().$path, $fn);
            $dataInput['forum_file_path'] = '/public'.$path.$fn;
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
        return redirect()->route('ortho.forums.forum_detail2',$id);
    }

    public function getSearch()
    {
        return view('backend.ortho.forums.forum_search');
    }

    public function postSearch()
    {
        $data                 = array();
        $keyword              = trim(Input::get('keyword'));
        $clsForumModel        = new ForumModel();
        $data['forums']       = $clsForumModel->getAllForum($keyword, null);
        return view('backend.ortho.forums.forum_list', $data);
    }

    public static function checkOwnValid($user_id, $forum_id)
    {
        $clsForumModel        = new ForumModel();
        return $clsForumModel->checkOwn($user_id, $forum_id);
    }

}
