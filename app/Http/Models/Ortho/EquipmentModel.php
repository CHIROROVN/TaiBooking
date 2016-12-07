<?php namespace App\Http\Models\Ortho;
use DB;

class EquipmentModel
{
    protected $table = 'm_equipment';
    protected $primaryKey = 'equipment_id';
    public $timestamps  = false;
    
    public function Rules()
    {
        return array(
            'equipment_name' => 'required',
        );
    }

    public function Messages()
    {
        return array(
            'equipment_name.required' => trans('validation.error_equipment_name_required'),
        );
    }

    public function get_all()
    {
        $results = DB::table($this->table)->where('last_kind', '<>', DELETE)->orderBy('equipment_sort_no', 'asc')->get();
        return $results;
    }

    public function insert($data)
    {
        $results = DB::table($this->table)->insert($data);
        return $results;
    }

    public function insert_get_id($data)
    {
        $results = DB::table($this->table)->insertGetId($data);
        return $results;
    }

    public function get_by_id($id)
    {
        $results = DB::table($this->table)->where('equipment_id', $id)->first();
        return $results;
    }

    public function update($id, $data)
    {
        $results = DB::table($this->table)->where('equipment_id', $id)->update($data);
        return $results;
    }

    public function get_min()
    {
        $results = DB::table($this->table)->min('equipment_sort_no');
        return $results;
    }

    public function get_max()
    {
        $results = DB::table($this->table)->max('equipment_sort_no');
        return $results;
    }

    public function get_list(){
        return DB::table($this->table)
                                ->where('last_kind', '<>', DELETE)
                                ->orderBy('equipment_id', 'asc')
                                ->lists('equipment_name', 'equipment_id');
    }
}