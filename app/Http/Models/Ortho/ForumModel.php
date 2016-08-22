<?php namespace App\Http\Models\Ortho;

use DB;

class ForumModel
{
    protected $table = 't_forum';
    protected $primaryKey = 'forum_id';
    public $timestamps  = false;

    public function Rules()
    {
        return array(
                'forum_title'                       => 'required',
                'forum_contents'                    => 'required',
                'forum_file_path'                   => 'max:10000|mimes:jpeg,bmp,png,gif,doc,docx,pdf,dxf,xlsx',
                'forum_file_name'                   => 'required',
        );
    }

    public function Messages()
    {
        return array(
                'forum_title.required'              => trans('validation.error_forum_title_required'),
                'forum_contents.required'           => trans('validation.error_forum_contents_required'),
                'forum_file_path.max'               => trans('validation.error_forum_file_path_max'),
                'forum_file_path.mimes'             => trans('validation.error_forum_file_path_mimes'),
                'forum_file_name.required'          => trans('validation.error_forum_file_name_required'),
        );
    }

    public function getAllForum($keyword=null, $forum_parent_id=null)
    {
        if(!empty($forum_parent_id)){
            $query = DB::table($this->table)->leftJoin('t_forum_read as fr', 't_forum.forum_id', '=', 'fr.forum_id')
                                            ->leftJoin('m_users as us', 't_forum.forum_user_id', '=', 'us.id')
                                            ->select('t_forum.*', 'fr.forum_read_id', 'fr.forum_read_user_id', 'fr.forum_read_time', 'fr.last_user', 'us.u_name_display')
                                            ->where('t_forum.last_kind', '<>', DELETE)
                                            ->where('t_forum.forum_parent_id', '=', $forum_parent_id);
            return $query->orderBy('forum_time', 'asc')->get();
        }else if(!empty($keyword)){
            $query = DB::table($this->table)->leftJoin('t_forum_read as fr', 't_forum.forum_id', '=', 'fr.forum_id')
                                            ->leftJoin('m_users as us', 't_forum.forum_user_id', '=', 'us.id')
                                            ->select('t_forum.*', 'fr.forum_read_id', 'fr.forum_read_user_id', 'fr.forum_read_time', 'fr.last_user', 'us.u_name_display')
                                            ->where('t_forum.last_kind', '<>', DELETE)
                                            ->whereNull('t_forum.forum_parent_id')
                                            ->where('t_forum.forum_title', 'LIKE', '%'.$keyword.'%')
                                            ->orWhere('t_forum.forum_contents', 'LIKE', '%'.$keyword.'%')
                                            ->orWhere('t_forum.forum_contents', 'LIKE', '%'.$keyword.'%');
            return $query->orderBy('forum_time', 'asc')->simplePaginate(PAGINATION);
        }else{
            $query = DB::table($this->table)->leftJoin('t_forum_read as fr', 't_forum.forum_id', '=', 'fr.forum_id')
                                            ->leftJoin('m_users as us', 't_forum.forum_user_id', '=', 'us.id')
                                            ->select('t_forum.*', 'fr.forum_read_id', 'fr.forum_read_user_id', 'fr.forum_read_time', 'fr.last_user', 'us.u_name_display')
                                            ->where('t_forum.last_kind', '<>', DELETE)
                                            ->whereNull('t_forum.forum_parent_id');
            return $query->orderBy('forum_time', 'asc')->simplePaginate(PAGINATION);
        }
    }

    public function countComments($forum_id=null)
    {
        $query = DB::table($this->table)->where('t_forum.last_kind', '<>', DELETE)
                                        ->where('t_forum.forum_parent_id', '=', $forum_id);
                                        //->whereNotNull('t_forum.forum_parent_id');
        return $query->count();
    }

    public function checkFileValid($forum_file_name=null)
    {
        $query = DB::table($this->table)->where('t_forum.last_kind', '<>', DELETE)
                                        ->where('t_forum.forum_file_name', '=', $forum_file_name)
                                        ->get();
        if(empty($query)){
            return true;
        }else{
            return false;
        }
    }

    public function insert($data)
    {
        return DB::table($this->table)->insert($data);
    }

    public function update($id, $data)
    {
        return DB::table($this->table)->where('forum_id', $id)->update($data);
    }

    public function get_by_id($id)
    {
        return DB::table($this->table)->leftJoin('t_forum_read as fr', 't_forum.forum_id', '=', 'fr.forum_id')
                                    ->leftJoin('m_users as us', 't_forum.forum_user_id', '=', 'us.id')
                                    ->select('t_forum.*', 'fr.forum_read_id', 'fr.forum_read_user_id', 'fr.forum_read_time', 'fr.last_user', 'us.u_name_display')
                                    ->where('t_forum.forum_id', $id)->first();
    }

    public function get_max()
    {
        return DB::table($this->table)->max('forum_id');
    }

    public function view($forum_id)
    {
        $view       = DB::table($this->table)->select('forum_view')->where('forum_id', '=', $forum_id)->first();
        $cv         = $view->forum_view;
        $forum_view = (int)$cv + 1;
        return DB::table($this->table)->where('forum_id', '=', $forum_id)->update(array('forum_view'=>$forum_view));
    }
}