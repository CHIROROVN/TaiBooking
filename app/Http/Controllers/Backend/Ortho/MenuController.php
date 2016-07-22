<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Http\Models\Ortho\ClinicModel;
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
        return view('backend.ortho.menus.index');
    }
}
