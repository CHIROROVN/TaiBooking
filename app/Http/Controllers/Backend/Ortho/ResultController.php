<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\PatientModel;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\InterviewModel;

use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;

class PatientController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }
}
