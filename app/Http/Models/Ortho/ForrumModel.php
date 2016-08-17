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

}