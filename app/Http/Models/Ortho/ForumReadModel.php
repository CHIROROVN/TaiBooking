<?php namespace App\Http\Models\Ortho;

use DB;

class ForumReadModel
{
    protected $table = 't_forum_read';
    protected $primaryKey = 'forum_read_id';
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

    public function insert($data)
    {
        return DB::table($this->table)->insert($data);
    }

    public function update($id, $data)
    {
        return DB::table($this->table)->where('forum_read_id', $id)->update($data);
    }

    public function read($forum_id, $data)
    {
        return DB::table($this->table)->where('forum_id', $forum_id)->update($data);
    }

    public function read_comment($forum_id)
    {
        $flag =  DB::table($this->table)->where('forum_id', $forum_id)
                                        ->whereNotNull('forum_read_time')->first();
        if(!empty($flag))
            return false;
        return true;
    }
}