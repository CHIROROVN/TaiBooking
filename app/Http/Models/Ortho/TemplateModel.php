<?php namespace App\Http\Models\Ortho;
use DB;

class TemplateModel
{
    protected $table = 't_template';
    protected $primaryKey = 'template_id';
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

    public function get_all($mbt_id = null)
    {
        $db = DB::table($this->table)
                    ->leftJoin('m_booking_template as t1', 't_template.mbt_id', '=', 't1.mbt_id')
                    ->select('t_template.*', 't1.mbt_name', 't1.mbt_sort_no')
                    ->where('t_template.last_kind', '<>', DELETE);

        if ( !empty($mbt_id) ) {
            $db = $db->where('t_template.mbt_id', $mbt_id);
        }
                                
        $db = $db->orderBy('t1.mbt_sort_no', 'asc')->get();
        return $db;
    }

    public function get_template_name($template_group_id = null)
    {
        $db = DB::table($this->table)
                    ->leftJoin('m_booking_template as t1', 't_template.mbt_id', '=', 't1.mbt_id')
                    ->select('t_template.mbt_id', 't1.mbt_name')
                    ->where('t_template.last_kind', '<>', DELETE);

        if ( !empty($template_group_id) ) {
            $db = $db->where('t_template.template_group_id', $template_group_id);
        }
        
        $db = $db->first();
        return $db;
    }

    public function insert($data)
    {
        return DB::table($this->table)->insert($data);
    }

    public function insert_get_id($data)
    {
        return DB::table($this->table)->insertGetId($data);
    }

    public function get_by_id($id)
    {
        return DB::table($this->table)->where('template_id', $id)->first();
    }

    public function get_by_mbtId($mbtId)
    {
        return DB::table($this->table)->where('mbt_id', $mbtId)->groupBy('template_group_id')->where('t_template.last_kind', '<>', DELETE)->get();
    }

    public function get_by_templateGroupId($templateGroupId)
    {
        return DB::table($this->table)->where('template_group_id', $templateGroupId)->orderBy('template_time')->where('t_template.last_kind', '<>', DELETE)->get();
    }

    public function get_by_mbtId_templateTime($mbtId, $templateTime)
    {
        return DB::table($this->table)->where('mbt_id', $mbtId)->where('template_time', $templateTime)->orderBy('template_time')->where('t_template.last_kind', '<>', DELETE)->first();
    }

    public function update($id, $data)
    {
        return DB::table($this->table)->where('template_id', $id)->update($data);
    }

    public function updateByMbtId($mbt_id, $data)
    {
        return DB::table($this->table)->where('mbt_id', $mbt_id)->update($data);
    }

}