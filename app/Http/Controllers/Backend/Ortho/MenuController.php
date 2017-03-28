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
        $clsClinic     = new ClinicModel();
        $clinic_id     = Auth::user()->u_power_booking;
        $clsClinicArea = new ClinicAreaModel();
        $data          = array();
        $area_clinic   = $clsClinicArea->get_clinic_area($clinic_id);
        if(!empty($area_clinic)){
            $data['area_id']    = $area_clinic->area_id;
            $data['clinic_id']  = $area_clinic->clinic_id;
        }else{
            $data['area_id']    = null;
            $data['clinic_id']  = null;
        }
        return view('backend.ortho.menus.index', $data);
    }
}
