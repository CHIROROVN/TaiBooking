<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\ClinicAreaModel;
use Form;
use Html;
use Input;
use Validator;
use URL;

class MenuController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function index()
    {
        $data = array();
        $clsClinic  = new ClinicModel();
        $clinic     = $clsClinic->get_id_by_name('たい矯正歯科');
        $clsClinicArea = new ClinicAreaModel();
        if ( !empty($clinic) ) {
            $area_clinic = $clsClinicArea->get_clinic_area($clinic->clinic_id);
            $data['ca_id']      = $area_clinic->ca_id;
            $data['area_id']    = $area_clinic->area_id;
            $data['clinic_id']  = $area_clinic->clinic_id;
        }
        
        return view('backend.ortho.menus.index', $data);
    }
}
