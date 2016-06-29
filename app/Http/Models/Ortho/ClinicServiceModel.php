<?php namespace App\Http\Models\Ortho;

use DB;
use App\Http\Models\Ortho\ServiceModel;
class ClinicServiceModel
{
    protected $table = 't_clinic_service';
    protected $primaryKey = 'clinic_service_id';
    public $timestamps  = false;

    public function get_clinic_service($clinic_id)
    {
        return DB::table($this->table)
                    ->where('last_kind', '<>', DELETE)
                    ->where('clinic_id', '=', $clinic_id)
                    ->orderBy('last_date', 'desc')
                    ->get();
    }

    // public function clinicService(){
    //     return $this->hasMany(ServiceModel::class,'service_id','service_id');
    // }
}