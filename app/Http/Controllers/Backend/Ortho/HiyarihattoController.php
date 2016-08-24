<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Models\Ortho\HiyarihattoModel;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Mail;
use Response;

class HiyarihattoController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['except' => ['getInput', 'postInput', 'confirm', 'sent']]);
    }

    /**
     * get form input
     */
    public function getInput()
    {
        return view('backend.ortho.hiyarihatto.input');
    }

    public function postInput()
    {
        $clsHiyarihatto = new HiyarihattoModel();
        $validator      = Validator::make(Input::all(), $clsHiyarihatto->Rules(), $clsHiyarihatto->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.hiyarihatto.input')->withErrors($validator)->withInput();
        }

        
    }

    public function confirm()
    {
        return view('backend.ortho.hiyarihatto.confirm');
    }

    public function sent()
    {
        return view('backend.ortho.hiyarihatto.sent');
    }

}
