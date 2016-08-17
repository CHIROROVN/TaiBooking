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


}