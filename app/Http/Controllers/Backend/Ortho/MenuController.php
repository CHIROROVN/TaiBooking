<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use Session;
// use App\User;
// use App\Http\Models\Ortho\UserModel;
// use App\Http\Models\Ortho\BelongModel;

use Form;
use Html;
use Input;
use Validator;
use URL;

class MenuController extends Controller
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
