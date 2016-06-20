<?php namespace App\Http\Models;

use DB;

class ContactModel
{
    protected $table = 't_contact';

    public function Rules()
    {
        return array(
            'contact_title'                      => 'required',
            'contact_main'                       => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'contact_title.required'             => 'required',
            'contact_main.required'              => 'required',
        );
    }

    public function get_all($stu_id=null){
        $query = DB::table($this->table)
                        ->where('last_kind', '<>', DELETE)
                        ->where('stu_id', '=', $stu_id)
                        ->orderBy('contact_id', 'asc');
        return  $query->simplePaginate(PAGINATION);
    }

    public function get_contact_by_id($stu_id=null, $contact_id=null){

        $query = DB::table($this->table)
                        ->where('last_kind', '<>', DELETE)
                        ->where('stu_id', '=', $stu_id)
                        ->where('contact_id', '=', $contact_id)
                        ->orderBy('contact_id', 'asc');
        return  $query->get();
    }
}