<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\ClinicServiceModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\FacilityModel;
use App\Http\Models\Ortho\ClinicModel;

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
        $clsClinicService               = new ClinicServiceModel();
        $clsClinic                      = new ClinicModel();
        $clsFacility                    = new FacilityModel();
        $data['clinic_services']        = $clsClinicService->getAll();
        $data['clinic']                 = $clsClinic->get_by_id($clinic_id);
        $data['facilities']             = $clsFacility->get_list($clinic_id);

        return view('backend.ortho.clinics.services.index', $data);
    }

}
