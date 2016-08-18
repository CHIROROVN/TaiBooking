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
        );
    }

    public function Messages()
    {
        return array(
        );
    }

    public function getAllForum()
    {
        $query = DB::table($this->table)->leftJoin('t_forum_read as fr', 't_forum.forum_id', '=', 'fr.forum_id')
                                        ->leftJoin('m_users as us', 't_forum.forum_user_id', '=', 'us.id')
                                        ->select('t_forum.*', 'fr.forum_read_id', 'fr.forum_read_user_id', 'fr.forum_read_time', 'fr.last_user', 'us.u_name_display')
                                        ->where('t_forum.last_kind', '<>', DELETE)
                                        ->whereNull('t_forum.forum_parent_id');
                                        //->where('fr.last_kind', '<>', DELETE);
        return $query->orderBy('forum_time', 'asc')->simplePaginate(PAGINATION);
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
                                        ->where('t_forum.forum_file_name', '=', $forum_file_name);
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
}