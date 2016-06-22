<?php namespace App\Http\Models\Ortho;

use DB;

class X3dctModel
{
    protected $table = 't_3dct';
    protected $primaryKey = '3dct_id';
    public $timestamps  = false;

    public function Rules()
    {
        return array(
            '' => 'required',
        );
    }

    public function Messages()
    {
        return array(
            '.required' => trans('validation.error_service_name_required'),
        );
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('3dct_id', 'asc')->get();
        return $results;
    }

    public function insert($data)
    {
        return DB::table($this->table)->insert($data);
    }

    public function insert_get_id($data)
    {
        $results = DB::table($this->table)->insertGetId($data);
        return $results;
    }

    public function get_by_id($id)
    {
        $results = DB::table($this->table)->where('3dct_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
        return DB::table($this->table)->where('3dct_id', $id)->update($data);
    }

}