<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\ClinicServiceModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\FacilityModel;
use Auth;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class ClinicServiceController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function index($clinic_id)
    {
        $clsClinicService  = new ClinicServiceModel();
        $data['clinic_services']        = $clsClinicService->get_clinic_service($clinic_id);
        $data['clinic_id']              = $clinic_id;
        $clsService                     = new ServiceModel();
        $data['services']               = $clsService->get_all();
        $clsFacility                    = new FacilityModel();
        $data['facilities']             = $clsFacility->get_list($clinic_id);

       // echo "<pre>";print_r($data['clinic_services']);die;
        return view('backend.ortho.clinics.services.index', $data);
    }

}
