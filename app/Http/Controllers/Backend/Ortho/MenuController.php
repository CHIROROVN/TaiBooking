<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use Session;
// use App\User;
use App\Http\Models\Ortho\ClinicModel;
// use App\Http\Models\Ortho\BelongModel;

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
        $clsClinic = new ClinicModel();
        $clinics = $clsClinic->get_all();

        $data['clinic_id'] = '';
        foreach ( $clinics as $value ) {
            if ( $value->clinic_name == 'たい矯正歯科' ) {
                $data['clinic_id'] = $value->clinic_id;
            }
        }

        return view('backend.ortho.menus.index', $data);
    }
}
